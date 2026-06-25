    </main>
    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-dark text-light">
        <div class="container py-5">
            <div class="row gy-4 text-light">
                <div class="col-md-4">
                    <h5 class="fw-bold mb-2 text-nowrap">Joel Cadenas</h5>
                    <p class="small mb-0 text-nowrap">Ingeniería y Software</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold mb-2">Contacto</h5>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-1 text-nowrap"><i class="bi bi-whatsapp me-2"></i>+57 317 756 4861</li>
                        <li class="mb-1 text-nowrap"><i class="bi bi-envelope me-2"></i><a href="mailto:servicios@jcadenas.com" class="text-light text-decoration-none">servicios@jcadenas.com</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold mb-2">Sígueme</h5>
                    <div class="d-flex gap-3 fs-4">
                        <a href="https://facebook.com/" class="text-light" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com/" class="text-light" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.linkedin.com/" class="text-light" target="_blank" rel="noopener"><i class="bi bi-linkedin"></i></a>
                        <a href="https://wa.me/573177564861" class="text-light" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        <hr class="border-secondary my-4">
            <p class="text-center small mb-0">&copy; 2025 Joel Cadenas. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Bootstrap-lite JS: choose minimal build per page -->
    <?php $current = basename($_SERVER['SCRIPT_NAME']); ?>
    <?php if ($current==='portfolio.php'): ?>
      <script src="<?= $base ?>/assets/js/bootstrap-lite.js" defer></script>
    <?php elseif ($current==='store.php'): ?>
      <script src="<?= $base ?>/assets/js/bootstrap-lite-core.js" defer></script>
    <?php endif; ?>
    <!-- Custom JS -->
    <script src="<?= $base ?>/assets/js/scripts.js" defer></script>
<script>
  document.addEventListener('DOMContentLoaded',()=>{
    // Minimal navbar collapse fallback if Bootstrap JS isn't loaded
    if(!window.bootstrap){
      document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(btn=>{
        btn.addEventListener('click',()=>{
          const sel=btn.getAttribute('data-bs-target');
          const target=document.querySelector(sel);
          if(!target) return;
          const willShow = !target.classList.contains('show');
          target.classList.toggle('show');
          btn.setAttribute('aria-expanded', willShow? 'true':'false');
        });
      });
    }
    const observer=new IntersectionObserver(entries=>{
      entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('show');observer.unobserve(e.target);}});
    },{threshold:.2});
    document.querySelectorAll('.fade-slide').forEach(el=>observer.observe(el));

    // Lite video embeds (YouTube/Vimeo): replace placeholder on click
    document.querySelectorAll('.lite-embed').forEach(wrapper=>{
      wrapper.addEventListener('click',()=>{
        const src = wrapper.getAttribute('data-src');
        if(!src) return;
        const iframe=document.createElement('iframe');
        iframe.setAttribute('src', src);
        iframe.setAttribute('allow', 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture');
        iframe.setAttribute('loading','lazy');
        iframe.setAttribute('allowfullscreen','');
        iframe.style.width='100%';
        iframe.style.height='100%';
        wrapper.replaceWith(iframe);
      },{once:true});
    });
  });
</script>
</body>
</html>
