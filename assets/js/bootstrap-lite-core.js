/* Bootstrap-lite CORE (Collapse + Modal only). No Carousel. */
(()=>{
  const q = (s, c=document)=>c.querySelector(s);
  const qa = (s, c=document)=>Array.from(c.querySelectorAll(s));
  function emit(el, name, detail={}){ el.dispatchEvent(new CustomEvent(name,{bubbles:true,cancelable:false,detail})); }

  // Collapse
  function initCollapse(){
    qa('[data-bs-toggle="collapse"]').forEach(btn=>{
      if(btn.__lc) return; btn.__lc=true;
      btn.addEventListener('click',()=>{
        const sel=btn.getAttribute('data-bs-target'); const t=q(sel);
        if(!t) return; const show=!t.classList.contains('show');
        t.classList.toggle('show', show); t.hidden=!show; btn.setAttribute('aria-expanded', show?'true':'false');
      });
    });
  }

  // Modal
  class ModalLite{
    constructor(el){ this.el=el; this._onKey=this._onKey.bind(this); this._onDismiss=this._onDismiss.bind(this); }
    show(){ if(this._shown) return; this._shown=true;
      this.backdrop=document.createElement('div'); this.backdrop.className='modal-backdrop fade show'; document.body.appendChild(this.backdrop);
      document.body.classList.add('modal-open'); this.el.style.display='block'; this.el.removeAttribute('aria-hidden'); this.el.classList.add('show');
      document.addEventListener('keydown', this._onKey); qa('[data-bs-dismiss="modal"]', this.el).forEach(b=>b.addEventListener('click', this._onDismiss));
      emit(this.el,'shown.bs.modal');
      const f=qa('button,[href],input,select,textarea,[tabindex]:not([tabindex="-1"])', this.el).find(x=>!x.disabled); if(f) f.focus();
    }
    hide(){ if(!this._shown) return; this._shown=false;
      this.el.classList.remove('show'); this.el.setAttribute('aria-hidden','true'); this.el.style.display='none';
      document.removeEventListener('keydown', this._onKey); qa('[data-bs-dismiss="modal"]', this.el).forEach(b=>b.removeEventListener('click', this._onDismiss));
      if(this.backdrop){ this.backdrop.remove(); this.backdrop=null; } document.body.classList.remove('modal-open'); emit(this.el,'hidden.bs.modal');
    }
    toggle(){ this._shown?this.hide():this.show(); }
    _onKey(e){ if(e.key==='Escape') this.hide(); }
    _onDismiss(){ this.hide(); }
    static getOrCreateInstance(el){ return el.__ml || (el.__ml=new ModalLite(el)); }
  }
  function initModal(){
    qa('[data-bs-toggle="modal"]').forEach(t=>{ if(t.__lm) return; t.__lm=true; t.addEventListener('click',()=>{ const sel=t.getAttribute('data-bs-target'); const el=q(sel); if(!el) return; ModalLite.getOrCreateInstance(el).show(); }); });
  }

  window.bootstrap = { Modal: ModalLite };
  document.addEventListener('DOMContentLoaded', ()=>{ initCollapse(); initModal(); });
})();
