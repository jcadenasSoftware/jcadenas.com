/* Minimal Bootstrap-compatible JS (Modal, Carousel, Collapse)
   Goal: replace Bootstrap bundle on selected pages with ~small local script.
   Exposes window.bootstrap with Modal API used in the site and fires Bootstrap-like events.
*/
(()=>{
  const q = (sel, ctx=document)=>ctx.querySelector(sel);
  const qa = (sel, ctx=document)=>Array.from(ctx.querySelectorAll(sel));

  // Utility: event dispatch
  function emit(el, name, detail={}){
    el.dispatchEvent(new CustomEvent(name, {bubbles:true, cancelable:false, detail}));
  }

  // Collapse (very small)
  function initCollapse(){
    qa('[data-bs-toggle="collapse"]').forEach(btn=>{
      if(btn.__liteCollapseBound) return; btn.__liteCollapseBound = true;
      btn.addEventListener('click', e=>{
        const sel = btn.getAttribute('data-bs-target');
        const target = q(sel);
        if(!target) return;
        const willShow = !target.classList.contains('show');
        target.classList.toggle('show', willShow);
        target.hidden = !willShow;
        btn.setAttribute('aria-expanded', willShow ? 'true':'false');
      });
    });
  }

  // Modal (backdrop + show/hide + events)
  class ModalLite {
    constructor(el){
      this.el = el;
      this._onKey = this._onKey.bind(this);
      this._onClickDismiss = this._onClickDismiss.bind(this);
    }
    show(){
      if(this._shown) return;
      this._shown = true;
      // Backdrop
      this.backdrop = document.createElement('div');
      this.backdrop.className = 'modal-backdrop fade show';
      document.body.appendChild(this.backdrop);
      document.body.classList.add('modal-open');
      // Show modal
      this.el.style.display = 'block';
      this.el.removeAttribute('aria-hidden');
      this.el.classList.add('show');
      // Bind
      document.addEventListener('keydown', this._onKey);
      qa('[data-bs-dismiss="modal"]', this.el).forEach(btn=>btn.addEventListener('click', this._onClickDismiss, {once:false}));
      emit(this.el, 'shown.bs.modal');
      // Focus first focusable
      const focusable = qa('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])', this.el).filter(el=>!el.hasAttribute('disabled'));
      if(focusable[0]) focusable[0].focus();
    }
    hide(){
      if(!this._shown) return;
      this._shown = false;
      this.el.classList.remove('show');
      this.el.setAttribute('aria-hidden','true');
      this.el.style.display='none';
      document.removeEventListener('keydown', this._onKey);
      qa('[data-bs-dismiss="modal"]', this.el).forEach(btn=>btn.removeEventListener('click', this._onClickDismiss));
      if(this.backdrop){ this.backdrop.remove(); this.backdrop=null; }
      document.body.classList.remove('modal-open');
      emit(this.el, 'hidden.bs.modal');
    }
    toggle(){ this._shown? this.hide(): this.show(); }
    _onKey(e){ if(e.key==='Escape') this.hide(); }
    _onClickDismiss(){ this.hide(); }
    static getOrCreateInstance(el){ return el.__liteModal || (el.__liteModal = new ModalLite(el)); }
  }

  // Wire data-api for modals
  function initModal(){
    qa('[data-bs-toggle="modal"]').forEach(trigger=>{
      if(trigger.__liteModalBound) return; trigger.__liteModalBound=true;
      trigger.addEventListener('click', e=>{
        const sel = trigger.getAttribute('data-bs-target');
        const el = q(sel);
        if(!el) return;
        ModalLite.getOrCreateInstance(el).show();
      });
    });
  }

  // Carousel (prev/next only, no auto ride)
  class CarouselLite{
    constructor(root){ this.root=root; this.items=qa('.carousel-item', root); this.index=this.items.findIndex(i=>i.classList.contains('active')); if(this.index<0) this.index=0; }
    go(n){
      if(!this.items.length) return;
      const old=this.index;
      this.index = (n+this.items.length)%this.items.length;
      this.items[old]?.classList.remove('active');
      this.items[this.index]?.classList.add('active');
      emit(this.root, 'slid.bs.carousel', {to:this.index, from:old});
    }
    next(){ this.go(this.index+1); }
    prev(){ this.go(this.index-1); }
    static byId(id){ const root=q(id); return root? (root.__liteCarousel || (root.__liteCarousel=new CarouselLite(root))) : null; }
  }
  function initCarousel(){
    qa('[data-bs-target][data-bs-slide]').forEach(btn=>{
      if(btn.__liteCarBound) return; btn.__liteCarBound=true;
      btn.addEventListener('click', e=>{
        const id = btn.getAttribute('data-bs-target');
        const dir = btn.getAttribute('data-bs-slide');
        const car = CarouselLite.byId(id);
        if(!car) return;
        dir==='next' ? car.next() : car.prev();
      });
    });
  }

  // Expose bootstrap-like API
  window.bootstrap = {
    Modal: ModalLite
    // Carousel API not required via constructor by current code
  };

  // Init on DOM ready
  document.addEventListener('DOMContentLoaded', ()=>{
    initCollapse();
    initModal();
    initCarousel();
  });
})();
