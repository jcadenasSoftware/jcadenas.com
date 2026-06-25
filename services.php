<?php include 'includes/header.php'; ?>
<?php
$type = $_GET['type'] ?? '';
$project = $_GET['ref'] ?? '';
?>
<!-- Hero -->
<section class="hero hero-compact section hero-services d-flex align-items-center text-white" style="background:url('<?= $base ?>/assets/img/hero_service.webp') center/cover no-repeat;">
  <div class="hero-content text-center">
    <h1 class="display-4 fw-bold mb-3">Servicios de Desarrollo</h1>
    <p class="lead mb-4">Transforma tus ideas en soluciones digitales profesionales.</p>
    <div class="mt-5">
      <a href="#solicitud" class="btn btn-accent btn-lg px-5">Solicitar presupuesto</a>
    </div>
  </div>
</section>

<!-- Servicios -->
<section id="services" class="section section-services py-5">
  <div class="container">
    <h2 class="display-5 fw-bold mb-5 text-center">¿Qué puedo hacer por ti?</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card h-100 shadow-sm fade-slide service-card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-globe2 me-2"></i>Sitios Web Responsivos</h5>
            <p class="card-text small">Landing pages, portales corporativos y tiendas en línea optimizadas para SEO y todos los dispositivos.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm fade-slide service-card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-phone me-2"></i>Aplicaciones Móviles</h5>
            <p class="card-text small">Apps nativas o híbridas para Android &amp; iOS utilizando Flutter o React Native.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm fade-slide service-card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-display me-2"></i>Aplicaciones de Escritorio</h5>
            <p class="card-text small">Software multiplataforma en Java, .NET o Electron para automatizar procesos de negocio.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm fade-slide service-card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-wrench-adjustable-circle me-2"></i>Mantenimiento &amp; Soporte</h5>
            <p class="card-text small">Actualización, optimización de rendimiento y corrección de bugs en sistemas existentes.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm fade-slide service-card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-shield-lock me-2"></i>Integraciones &amp; APIs</h5>
            <p class="card-text small">Conecta tu plataforma con pasarelas de pago, servicios externos o sistemas internos.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm fade-slide service-card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-chat-dots me-2"></i>Consultoría Tecnológica</h5>
            <p class="card-text small">Te asesoro para elegir la mejor arquitectura, stack y estrategia de desarrollo.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Formulario de solicitud -->
<section id="solicitud" class="section section-solicitud py-5 border-top">
  <div class="container">
    <h2 class="display-5 fw-bold mb-5 text-center">Solicitar un Presupuesto</h2>
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="card shadow-sm fade-slide">
          <div class="card-body p-4">
            <form action="submit_service.php" method="post" class="needs-validation form-grid" novalidate>
              <input type="hidden" name="referencia" value="<?= htmlspecialchars($project) ?>">

              <div>
                <label class="form-label">Nombre completo</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person"></i></span>
                  <input type="text" name="nombre" class="form-control" placeholder="Tu nombre y apellido" required>
                </div>
                <div class="invalid-feedback">Ingresa tu nombre completo.</div>
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
                <label class="form-label">Tipo de servicio</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-list-task"></i></span>
                  <select name="servicio" class="form-select" required>
                    <option value="" disabled selected>Selecciona…</option>
                    <option value="Web" <?= $type==='web'?'selected':'' ?>>Sitio / Aplicación Web</option>
                    <option value="Movil" <?= $type==='movil'?'selected':'' ?>>Aplicación Móvil</option>
                    <option value="Escritorio" <?= $type==='desktop'?'selected':'' ?>>Aplicación de Escritorio</option>
                    <option value="Mantenimiento">Mantenimiento / Soporte</option>
                    <option value="Consultoria">Consultoría</option>
                  </select>
                </div>
                <div class="invalid-feedback">Selecciona un tipo de servicio.</div>
              </div>

              <div>
                <label class="form-label">Presupuesto estimado (USD)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                  <input type="number" name="presupuesto" class="form-control" min="100" placeholder="Ej: 1500">
                </div>
              </div>

              <div>
                <label class="form-label">Plazo deseado (semanas)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-alarm"></i></span>
                  <input type="number" name="plazo" class="form-control" min="1" placeholder="Ej: 4">
                </div>
              </div>

              <div class="full">
                <label class="form-label">Descripción del proyecto / requerimientos iniciales</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
                  <textarea name="descripcion" rows="5" class="form-control" placeholder="Cuéntame brevemente tu idea" required><?= htmlspecialchars($project) ? 'Estoy interesado en el proyecto '.$project.'. ' : '' ?></textarea>
                </div>
                <div class="invalid-feedback">Describe brevemente tu proyecto.</div>
              </div>

              <div class="full text-center">
                <button type="submit" class="btn btn-primary btn-lg px-5">Enviar solicitud</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function(){
    const form = document.querySelector('#solicitud form.needs-validation');
    if(!form) return;
    const groups = form.querySelectorAll('.input-group');
    function syncGroupState(el){
      const ig = el.closest('.input-group');
      if(!ig) return;
      ig.classList.toggle('invalid', !el.checkValidity());
    }
    form.addEventListener('submit', function(e){
      if(!form.checkValidity()){
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add('was-validated');
      groups.forEach(g => {
        const ctl = g.querySelector('input,select,textarea');
        if(ctl) syncGroupState(ctl);
      });
    });
    form.addEventListener('input', e => {
      const t = e.target;
      if(['INPUT','SELECT','TEXTAREA'].includes(t.tagName)) syncGroupState(t);
    });
    form.addEventListener('blur', e => {
      const t = e.target; if(['INPUT','SELECT','TEXTAREA'].includes(t.tagName)) syncGroupState(t);
    }, true);
  })();
</script>

<style>
/* Estilos específicos para services.php */

/* Sección Servicios con fondo claro */
#services {
  background: #f8f9fa !important;
  background-image: none !important;
}

#services::before {
  display: none !important;
}

#services h2 {
  color: #1a202c !important;
  font-size: 2.5rem !important;
}

/* Tarjetas de servicios mejoradas */
#services .service-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background-color: #ffffff !important;
  border: 1px solid #e9ecef !important;
}

#services .service-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15) !important;
}

/* Hero de servicios con menos altura */
.hero-services {
  min-height: 50vh !important;
}

/* Sección Solicitud con fondo oscuro (igual que Habilidades Técnicas) */
#solicitud {
  background: #1a202c !important;
  background-image: none !important;
}

#solicitud::before {
  display: none !important;
}

#solicitud h2 {
  color: #ffffff !important;
  font-size: 2.5rem !important;
}

/* Formulario con fondo claro para contraste */
#solicitud .card {
  background-color: #f8f9fa !important;
  border: 1px solid #dee2e6 !important;
}

#solicitud .form-label {
  color: #1a202c !important;
  font-weight: 500;
}

#solicitud .form-control,
#solicitud .form-select {
  background-color: #ffffff !important;
  border-color: #ced4da !important;
  color: #1a202c !important;
}

#solicitud .input-group-text {
  background-color: #e9ecef !important;
  border-color: #ced4da !important;
  color: #495057 !important;
}

#solicitud .btn-primary {
  background-color: #0d6efd !important;
  border-color: #0d6efd !important;
}

#solicitud .btn-primary:hover {
  background-color: #0b5ed7 !important;
  border-color: #0a58ca !important;
}
</style>
    
<?php include 'includes/footer.php'; ?>
