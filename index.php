<?php include 'includes/header.php'; ?>
<!-- Hero Section -->
<section class="hero section">
  <img class="hero-bg" src="<?= $base ?>/assets/img/hero_service.webp" alt="" fetchpriority="high" loading="eager" sizes="100vw" width="1920" height="700" />
  <div class="container hero-content">
    <h1 class="display-4 fw-bold mb-3">Ingeniería y Desarrollo de Software</h1>
    <p class="lead mb-2">Java · Python · PHP · Mobile · Web</p>
      <p class="mb-4 site-desc">Aplicaciones web, móviles y soluciones digitales personalizadas.</p>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
      <a href="<?= $base ?>/contact.php" class="btn btn-accent btn-lg px-4 me-sm-3">Contáctame</a>
      <a href="<?= $base ?>/portfolio.php" class="btn btn-outline-light btn-lg px-4 smooth-link">Ver portafolio</a>
    </div>
  </div>
</section>

<!-- Intro Section -->
<section class="section section-intro" id="about-intro">
  <div class="container container-narrow">
    <div class="row align-items-center g-4">
      <div class="col-md-4 text-center">
        <picture>
          <source srcset="<?= $base ?>/assets/img/profile.webp" type="image/webp">
          <img src="<?= $base ?>/assets/img/profile.jpg" alt="Foto de Joel Cadenas" class="profile-img shadow-sm" width="220" height="361" loading="lazy" decoding="async">
        </picture>
      </div>
      <div class="col-md-8">
        <h2 class="mb-3">JCadenas, Ingeniería y Software</h2>
        <p class="lead">Hola, soy <strong>Joel Cadenas</strong>, Software Developer con experiencia en desarrollo <strong>Android (Kotlin)</strong>, aplicaciones de escritorio en <strong>Java</strong> y plataformas web con backend propio.</p>
        <p>Especializado en construir soluciones end-to-end (frontend, backend y base de datos), integrando servicios cloud, autenticación segura, geolocalización y sincronización en tiempo real. Trabajo bajo buenas prácticas modernas como MVVM, Clean Architecture y principios SOLID, priorizando código mantenible, escalable y orientado a resultados.</p>
        <p>Me apasiona crear herramientas útiles, resolver problemas reales con código y mantenerme en constante aprendizaje.</p>
        <p>En este sitio encontrarás una muestra de mi trabajo, tecnologías que domino y formas de contacto para colaborar en tu próximo proyecto.</p>
        <div class="mt-3">
          <a href="<?= $base ?>/cv.php" class="btn btn-outline-primary">Ver currículum (1 página)</a>
          <a href="<?= $base ?>/resume.php" class="btn btn-outline-secondary">Resume (EN)</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Servicios & Tecnologías Section -->
<section class="section section-services-tech" id="services-tech">
  <div class="container container-narrow">
    <h2 class="text-center mb-5">Servicios & Tecnologías</h2>

    <!-- Servicios -->
    <div class="row g-4 text-center mb-5">
      <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm service-card">
          <div class="card-body">
            <img src="<?= $base ?>/assets/tech/html5.png" alt="HTML5" height="48" class="mb-3" loading="lazy" decoding="async">
            <h5 class="card-title">Desarrollo Web</h5>
            <p class="card-text small">Sitios y aplicaciones web rápidos, accesibles y SEO-friendly.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm service-card">
          <div class="card-body">
            <img src="<?= $base ?>/assets/tech/androide.png" alt="Android" height="48" class="mb-3" loading="lazy" decoding="async">
            <h5 class="card-title">Apps Móviles</h5>
            <p class="card-text">Aplicaciones iOS y Android nativas o híbridas.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm service-card">
          <div class="card-body">
            <img src="<?= $base ?>/assets/tech/java.png" alt="Java" height="48" class="mb-3" loading="lazy" decoding="async">
            <h5 class="card-title">Software a Medida</h5>
            <p class="card-text">Soluciones personalizadas que se adaptan a tu empresa.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm service-card">
          <div class="card-body">
            <img src="<?= $base ?>/assets/tech/piton.png" alt="Python" height="48" class="mb-3" loading="lazy" decoding="async">
            <h5 class="card-title">Consultoría</h5>
            <p class="card-text">Asesoría técnica para mejorar tus procesos y arquitectura de software.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Placeholder for portfolio preview to anchor -->
<section id="portfolio-preview"></section>

<style>
/* Estilos específicos para index.php */

/* Sección Intro con fondo gris claro (igual que Mi Perfil en about.php) */
#about-intro {
  background: #f8f9fa !important;
  background-image: none !important;
  color: #212529 !important;
}

#about-intro::before {
  display: none !important;
}

.section-intro {
  background-color: #f8f9fa !important;
  background-image: none !important;
  background: #f8f9fa !important;
}

/* Sección Servicios con fondo oscuro (igual que Habilidades Técnicas en about.php) */
#services-tech {
  background: #1a202c !important;
  background-image: none !important;
}

.section-services-tech {
  background-color: #1a202c !important;
  background-image: none !important;
  background: #1a202c !important;
}

.section-services-tech h2 {
  color: #ffffff !important;
  font-size: 2.5rem !important;
}

/* Tarjetas de servicios con fondo gris claro */
.service-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background-color: #f8f9fa !important;
  border: 1px solid #e9ecef !important;
}

.service-card h5 {
  color: #1a202c !important;
}

.service-card p {
  color: #4a5568 !important;
}

.service-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4) !important;
  background-color: #ffffff !important;
}
</style>

<?php include 'includes/footer.php'; ?>
