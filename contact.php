<?php include 'includes/header.php'; ?>

<!-- Hero Contacto -->
<section class="hero hero-compact section d-flex align-items-center" style="background:url('<?= $base ?>/assets/img/hero-bg.webp') center/cover no-repeat;">
  <div class="hero-content text-center">
    <h1 class="display-4 fw-bold mb-2">Contacto</h1>
    <p class="lead mb-0">Hablemos sobre tu proyecto. Respondo rápido.</p>
  </div>
</section>

<section id="contact-page" class="section section-contact py-5">
  <div class="container">
    <?php if(isset($_GET['sent'])): ?>
      <?php if(isset($_GET['email_warning'])): ?>
        <div class="alert alert-warning fade-slide show" role="alert">
          <strong>Mensaje recibido:</strong> Tu mensaje fue guardado correctamente, pero hubo un problem al enviar la notificación por email. Te contactaré pronto.
        </div>
      <?php else: ?>
        <div class="alert alert-success fade-slide show" role="alert">Tu mensaje fue enviado. Te contactaré pronto.</div>
      <?php endif; ?>
    <?php elseif(isset($_GET['error'])): ?>
      <div class="alert alert-danger fade-slide show" role="alert">No se pudo enviar. Revisa los datos e inténtalo nuevamente.</div>
    <?php endif; ?>

    <div class="row g-4 align-items-stretch">
      <!-- Tarjetas de contacto directo -->
      <div class="col-lg-4">
        <div class="card h-100 shadow-sm fade-slide">
          <div class="card-body">
            <h5 class="card-title mb-3"><i class="bi bi-whatsapp me-2 text-success"></i>WhatsApp</h5>
            <p class="small text-muted">Atención preferente por WhatsApp.</p>
            <a class="btn btn-success btn-sm btn-icon" target="_blank" href="https://wa.me/573177564861?text=Hola%2C%20me%20gustar%C3%ADa%20hablar%20sobre%20un%20proyecto"><i class="bi bi-whatsapp"></i> Escríbeme</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card h-100 shadow-sm fade-slide">
          <div class="card-body">
            <h5 class="card-title mb-3"><i class="bi bi-envelope-at me-2"></i>Correo</h5>
            <p class="small text-muted">Prefieres email: servicios@jcadenas.com</p>
            <a class="btn btn-outline-primary btn-sm btn-icon" href="mailto:servicios@jcadenas.com?subject=Consulta%20desde%20jcadenas.com"><i class="bi bi-envelope"></i> Enviar correo</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card h-100 shadow-sm fade-slide">
          <div class="card-body">
            <h5 class="card-title mb-3"><i class="bi bi-share me-2"></i>Redes sociales</h5>
            <div class="d-flex gap-2" style="flex-wrap:wrap">
              <a href="https://facebook.com/" class="btn btn-outline-secondary btn-sm btn-icon" target="_blank" rel="noopener"><i class="bi bi-facebook"></i> Facebook</a>
              <a href="https://instagram.com/" class="btn btn-outline-secondary btn-sm btn-icon" target="_blank" rel="noopener"><i class="bi bi-instagram"></i> Instagram</a>
              <a href="https://www.linkedin.com/" class="btn btn-outline-secondary btn-sm btn-icon" target="_blank" rel="noopener"><i class="bi bi-linkedin"></i> LinkedIn</a>
              <a href="https://wa.me/573177564861" class="btn btn-outline-success btn-sm btn-icon" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i> WhatsApp</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Formulario de contacto -->
    <div class="row mt-5">
      <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm fade-slide">
          <div class="card-body p-4">
            <h2 class="display-6 fw-bold mb-4 text-center">Envíame un mensaje</h2>
            <form action="contact_submit.php" method="post" class="needs-validation form-grid" novalidate>
              <div>
                <label class="form-label">Nombre</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person"></i></span>
                  <input type="text" name="nombre" class="form-control" placeholder="Tu nombre" required>
                </div>
                <div class="invalid-feedback">Ingresa tu nombre.</div>
              </div>
              <div>
                <label class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                  <input type="email" name="email" class="form-control" placeholder="tucorreo@ejemplo.com" required>
                </div>
                <div class="invalid-feedback">Email inválido.</div>
              </div>
              <div>
                <label class="form-label">Teléfono / WhatsApp</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                  <input type="text" name="telefono" class="form-control" placeholder="Opcional">
                </div>
              </div>
              <div>
                <label class="form-label">Asunto</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                  <input type="text" name="asunto" class="form-control" placeholder="Motivo del mensaje" required>
                </div>
                <div class="invalid-feedback">Ingresa un asunto.</div>
              </div>
              <div class="full">
                <label class="form-label">Mensaje</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
                  <textarea name="mensaje" rows="5" class="form-control" placeholder="Cuéntame brevemente tu proyecto" required></textarea>
                </div>
                <div class="invalid-feedback">Mensaje requerido.</div>
              </div>
              <div class="text-center">
                <button class="btn btn-primary btn-lg px-5" type="submit">Enviar mensaje</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
// Lightweight form validation (Bootstrap-like) with input-group highlighting
(function(){
  const form = document.querySelector('#contact-page form.needs-validation');
  if(!form) return;

  const flagGroupValidity = (field)=>{
    const group = field.closest('.input-group');
    if(!group) return;
    if(!field.checkValidity()) group.classList.add('invalid');
    else group.classList.remove('invalid');
  };

  form.querySelectorAll('.form-control, .form-select').forEach(el=>{
    ['input','change','blur'].forEach(evt=>{
      el.addEventListener(evt,()=>flagGroupValidity(el));
    });
  });

  form.addEventListener('submit', function(e){
    if(!form.checkValidity()){
      e.preventDefault();
      e.stopPropagation();
    }
    form.classList.add('was-validated');
    form.querySelectorAll('.form-control, .form-select').forEach(flagGroupValidity);
  }, false);
})();
</script>

<script>
// Bootstrap validation
(()=>{
  'use strict';
  const forms=document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form=>{
    form.addEventListener('submit',e=>{
      if(!form.checkValidity()){e.preventDefault();e.stopPropagation();}
      form.classList.add('was-validated');
    },false);
  });
})();
</script>

<style>
/* Estilos específicos para contact.php */

/* Sección contacto con fondo claro */
#contact-page {
  background: #f8f9fa !important;
  background-image: none !important;
}

/* Tarjetas de contacto directo mejoradas */
#contact-page .card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background-color: #ffffff !important;
  border: 1px solid #e9ecef !important;
}

#contact-page .card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15) !important;
}

/* Tarjeta de formulario con fondo distinto */
#contact-page .row.mt-5 .card {
  background-color: #ffffff !important;
}

#contact-page h2 {
  color: #1a202c !important;
}

/* Botones de contacto mejorados */
#contact-page .btn-icon {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s ease;
}

#contact-page .btn-icon:hover {
  transform: translateX(4px);
}
</style>

<?php include 'includes/footer.php'; ?>
