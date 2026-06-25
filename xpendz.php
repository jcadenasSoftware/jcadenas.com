<?php
$pageTitle = 'Xpendz | Control de Finanzas Personales';
$pageDescription = 'Controla tus gastos, ingresos, préstamos y metas financieras de forma simple y segura.';
include 'includes/header.php';
?>
<link rel="stylesheet" href="<?= $base ?>/assets/css/xpendz.css">

<!-- Hero Section -->
<section class="xpendz-hero">
  <div class="container">
    <div class="xpendz-hero-content">
      <div class="xpendz-logo-container">
        <img src="<?= $base ?>/assets/img/logo.webp" alt="Xpendz Logo" class="xpendz-logo" width="120" height="120" loading="eager">
      </div>
      <h1 class="xpendz-title">Xpendz</h1>
      <p class="xpendz-subtitle">Controla tus gastos, ingresos, préstamos y metas financieras de forma simple y segura.</p>
      <p class="xpendz-description">Una aplicación diseñada para ayudarte a mantener el control de tus finanzas personales desde un solo lugar.</p>
      <a href="#" class="xpendz-cta-btn" aria-label="Próximamente en Google Play">
        <i class="bi bi-google-play me-2"></i>
        Próximamente en Google Play
      </a>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="xpendz-features">
  <div class="container">
    <h2 class="xpendz-features-title">Características principales</h2>
    <div class="xpendz-features-grid">
      
      <div class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-receipt"></i>
        </div>
        <h3 class="xpendz-feature-title">Registro de gastos</h3>
        <p class="xpendz-feature-desc">Lleva un control detallado de todos tus gastos diarios y categorízalos fácilmente.</p>
      </div>

      <div class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-cash-coin"></i>
        </div>
        <h3 class="xpendz-feature-title">Registro de ingresos</h3>
        <p class="xpendz-feature-desc">Registra tus ingresos y visualiza el balance de tus finanzas en tiempo real.</p>
      </div>

      <div class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-arrow-left-right"></i>
        </div>
        <h3 class="xpendz-feature-title">Gestión de préstamos</h3>
        <p class="xpendz-feature-desc">Administra préstamos otorgados y recibidos con seguimiento de pagos y saldos.</p>
      </div>

      <div class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-piggy-bank"></i>
        </div>
        <h3 class="xpendz-feature-title">Metas de ahorro</h3>
        <p class="xpendz-feature-desc">Define objetivos financieros y monitorea tu progreso hacia tus metas.</p>
      </div>

      <div class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-cloud-arrow-up"></i>
        </div>
        <h3 class="xpendz-feature-title">Respaldo de información</h3>
        <p class="xpendz-feature-desc">Sincroniza y respalda tu información de forma segura en la nube.</p>
      </div>

      <div class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-shield-lock"></i>
        </div>
        <h3 class="xpendz-feature-title">Protección mediante PIN</h3>
        <p class="xpendz-feature-desc">Protege tus datos financieros con autenticación segura mediante PIN.</p>
      </div>

    </div>
  </div>
</section>

<!-- Footer Section -->
<footer class="xpendz-footer">
  <div class="container">
    <div class="xpendz-footer-content">
      <p class="xpendz-footer-copyright">Xpendz © 2026</p>
      <p class="xpendz-footer-dev">Desarrollado por <strong>Joel Cadenas</strong></p>
      <p class="xpendz-footer-contact">
        <i class="bi bi-envelope me-2"></i>
        <a href="mailto:servicios@jcadenas.com">servicios@jcadenas.com</a>
      </p>
    </div>
  </div>
</footer>

<?php include 'includes/footer.php'; ?>
