<?php
require_once __DIR__ . '/config.php';

$pageTitle = 'Xpendz | Finanzas personales, cuentas, préstamos y metas';
$pageDescription = 'Xpendz te ayuda a registrar gastos, ingresos, cuentas, préstamos y metas financieras desde una experiencia simple, segura y sincronizada.';
$pageCssFile = 'assets/css/xpendz.css';
$pageBodyClass = 'xpendz-landing-page';
$pageMainId = 'xpendz-main';
$pageSkipTarget = '#hero';
$showXpendzNav = true;
$xpendzNavLinks = [
  [ 'label' => 'Inicio', 'href' => siteUrl('xpendz'), 'primary' => true ],
  [ 'label' => 'Funciones', 'href' => siteUrl('xpendz/funciones') ],
  [ 'label' => 'Privacidad y seguridad', 'href' => siteUrl('xpendz/privacidad-y-seguridad') ],
  [ 'label' => 'Descargar', 'href' => siteUrl('xpendz/descargar') ],
];
$xpendzShowCta = true;
include 'includes/header-xpendz.php';
?>
<!-- Hero Section -->
<section class="xpendz-hero" id="hero">
  <div class="container">
    <div class="xpendz-hero-grid">

      <!-- Columna izquierda: Contenido de texto -->
      <div class="xpendz-hero-content">
        <div class="xpendz-hero-badge">
          <i class="bi bi-stars" aria-hidden="true"></i>
          <span>Claridad financiera para tu día a día</span>
        </div>
        <h1 class="xpendz-title">
          Toma el control de tus finanzas.
        </h1>
        <p class="xpendz-description">
          Registra tus ingresos y gastos, visualiza tus cuentas y comprende cómo se mueve tu dinero desde una sola aplicación.
        </p>
        <div class="xpendz-hero-ctas">
          <a href="<?= htmlspecialchars(XPENDZ_GOOGLE_PLAY_URL, ENT_QUOTES) ?>" class="xpendz-cta-primary" aria-label="Comenzar a usar Xpendz: descargar">
            <i class="bi bi-google-play" aria-hidden="true"></i>
            <span class="xpendz-cta-primary-text">
              <small>Descargar</small>
              <strong>Gratis</strong>
            </span>
          </a>
          <a href="<?= htmlspecialchars(siteUrl('xpendz/funciones'), ENT_QUOTES) ?>" class="xpendz-cta-secondary">
            Conocer cómo funciona
            <i class="bi bi-arrow-down" aria-hidden="true"></i>
          </a>
        </div>
        <div class="xpendz-benefits-row" aria-label="Beneficios principales">
          <div class="xpendz-benefit-item">
            <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
            <span>Comprende en qué gastas tu dinero</span>
          </div>
          <div class="xpendz-benefit-item">
            <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
            <span>Organiza tus finanzas sin complicaciones</span>
          </div>
          <div class="xpendz-benefit-item">
            <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
            <span>Toma decisiones con mayor confianza</span>
          </div>
        </div>
      </div>

      <!-- Columna derecha: Captura de la aplicación -->
      <div class="xpendz-hero-visual" aria-hidden="true">
        <div class="xpendz-mockup-placeholder">
          <img src="<?= $base ?>/assets/img/xpendz-screenshot.webp" alt="Pantalla principal del dashboard financiero de Xpendz" class="xpendz-mockup-image" width="220" height="475" loading="eager" fetchpriority="high">
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Features Section -->
<section class="xpendz-features" id="features">
  <div class="container">
    <h2 class="xpendz-features-title">¿Por qué elegir Xpendz?</h2>
    <p class="xpendz-features-subtitle">Todo lo que necesitas para administrar tus finanzas personales de forma simple, segura y organizada.</p>
    <div class="xpendz-features-grid">
      
      <div class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-graph-up"></i>
        </div>
        <h3 class="xpendz-feature-title">Control financiero completo</h3>
        <p class="xpendz-feature-desc">Visualiza ingresos, gastos, cuentas, préstamos y metas desde una única aplicación.</p>
      </div>

      <div class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-bullseye"></i>
        </div>
        <h3 class="xpendz-feature-title">Metas que motivan</h3>
        <p class="xpendz-feature-desc">Planifica objetivos financieros y sigue tu progreso mediante indicadores claros.</p>
      </div>

      <div class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-bar-chart"></i>
        </div>
        <h3 class="xpendz-feature-title">Información para decidir</h3>
        <p class="xpendz-feature-desc">Consulta balances, tendencias y resúmenes que te ayudan a comprender tus finanzas.</p>
      </div>

      <div class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-lightning"></i>
        </div>
        <h3 class="xpendz-feature-title">Diseñada para el día a día</h3>
        <p class="xpendz-feature-desc">Interfaz moderna, rápida e intuitiva para registrar movimientos en pocos segundos.</p>
      </div>

    </div>
    <div class="xpendz-cta-final-buttons">
      <a href="<?= htmlspecialchars(siteUrl('xpendz/funciones'), ENT_QUOTES) ?>" class="xpendz-cta-final-secondary" aria-label="Ir a la página de Funciones de Xpendz">
        Explorar la página de Funciones
        <i class="bi bi-arrow-right" aria-hidden="true"></i>
      </a>
    </div>
  </div>
</section>

<!-- Showcase Section -->
<section class="xpendz-showcase" id="showcase">
  <div class="container">
    <div class="xpendz-showcase-header">
      <h2 class="xpendz-showcase-title">Todo lo que necesitas para controlar tus finanzas</h2>
      <p class="xpendz-showcase-subtitle">Descubre cómo Xpendz te ayuda a tomar mejores decisiones financieras con herramientas simples y poderosas.</p>
    </div>

    <div class="xpendz-showcase-block">
      <div class="xpendz-showcase-content">
        <h3 class="xpendz-showcase-block-title">Visualiza tu panorama financiero completo</h3>
        <p class="xpendz-showcase-block-desc">Accede a un dashboard intuitivo que te muestra tu balance actual, ingresos, gastos y el estado de tus cuentas en tiempo real. Todo lo que necesitas saber, de un vistazo.</p>
      </div>
      <div class="xpendz-showcase-visual">
        <img src="<?= $base ?>/assets/img/showcase/dashboard.webp" alt="Dashboard financiero de Xpendz" class="xpendz-showcase-image" width="310" height="650" loading="lazy">
      </div>
    </div>

    <div class="xpendz-showcase-block xpendz-showcase-block-reverse">
      <div class="xpendz-showcase-content">
        <h3 class="xpendz-showcase-block-title">Registra cada movimiento en segundos</h3>
        <p class="xpendz-showcase-block-desc">Añade gastos e ingresos de forma rápida y sencilla. Categoriza tus transacciones, adjunta notas y mantén un historial completo de tu actividad financiera.</p>
      </div>
      <div class="xpendz-showcase-visual">
        <img src="<?= $base ?>/assets/img/showcase/transactions.webp" alt="Registro de transacciones en Xpendz" class="xpendz-showcase-image" width="310" height="650" loading="lazy">
      </div>
    </div>

    <div class="xpendz-showcase-block">
      <div class="xpendz-showcase-content">
        <h3 class="xpendz-showcase-block-title">Alcanza tus objetivos financieros</h3>
        <p class="xpendz-showcase-block-desc">Define metas de ahorro personalizadas y monitorea tu progreso. Xpendz te motiva a cumplir tus objetivos con visualizaciones claras y recordatorios inteligentes.</p>
      </div>
      <div class="xpendz-showcase-visual">
        <img src="<?= $base ?>/assets/img/showcase/goals.webp" alt="Metas de ahorro en Xpendz" class="xpendz-showcase-image" width="310" height="650" loading="lazy">
      </div>
    </div>

  </div>
</section>

<!-- Trust Section -->
<section class="xpendz-trust-section" id="confianza">
  <div class="container">
    <div class="xpendz-trust-section-header">
      <h2 class="xpendz-trust-section-title">Tu información, siempre bajo tu control</h2>
      <p class="xpendz-trust-section-subtitle">Xpendz ha sido diseñada para ayudarte a administrar tus finanzas con privacidad, seguridad y transparencia.</p>
    </div>

    <div class="xpendz-trust-cards-grid">

      <div class="xpendz-trust-card">
        <div class="xpendz-trust-card-icon">
          <i class="bi bi-shield-check" aria-hidden="true"></i>
        </div>
        <div class="xpendz-trust-card-content">
          <h3 class="xpendz-trust-card-title">Privacidad primero</h3>
          <p class="xpendz-trust-card-desc">Tus datos permanecen bajo tu control. Xpendz prioriza la protección de tu información personal y financiera.</p>
        </div>
      </div>

      <div class="xpendz-trust-card">
        <div class="xpendz-trust-card-icon">
          <i class="bi bi-lock-fill" aria-hidden="true"></i>
        </div>
        <div class="xpendz-trust-card-content">
          <h3 class="xpendz-trust-card-title">Respaldos bajo tu control</h3>
          <p class="xpendz-trust-card-desc">Crea y restaura respaldos manuales para conservar una copia independiente de tu información y mantenerla disponible cuando la necesites.</p>
        </div>
      </div>

      <div class="xpendz-trust-card">
        <div class="xpendz-trust-card-icon">
          <i class="bi bi-arrow-repeat" aria-hidden="true"></i>
        </div>
        <div class="xpendz-trust-card-content">
          <h3 class="xpendz-trust-card-title">Sincronización segura</h3>
          <p class="xpendz-trust-card-desc">Mantén tus datos sincronizados entre dispositivos compatibles mediante una infraestructura confiable.</p>
        </div>
      </div>

    </div>

    <div class="xpendz-trust-band">
      <div class="xpendz-trust-band-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Datos protegidos</span>
      </div>
      <div class="xpendz-trust-band-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Respaldos manuales</span>
      </div>
      <div class="xpendz-trust-band-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Sincronización segura</span>
      </div>
    </div>

    <div class="xpendz-cta-final-buttons">
      <a href="<?= htmlspecialchars(siteUrl('xpendz/privacidad-y-seguridad'), ENT_QUOTES) ?>" class="xpendz-cta-final-secondary" aria-label="Ir a la página de Privacidad y seguridad de Xpendz">
        Conocer Privacidad y seguridad
        <i class="bi bi-arrow-right" aria-hidden="true"></i>
      </a>
    </div>

  </div>
</section>

<!-- FAQ Section -->
<section class="xpendz-faq" id="faq">
  <div class="container">
    <div class="xpendz-faq-header">
      <h2 class="xpendz-faq-title">Preguntas frecuentes</h2>
      <p class="xpendz-faq-subtitle">Resuelve tus dudas sobre Xpendz, seguridad y uso diario.</p>
    </div>

    <div class="xpendz-faq-list">

      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="faq-btn-1" aria-expanded="false" aria-controls="faq-answer-1">
          <span>¿Xpendz es gratis?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="faq-answer-1" role="region" aria-labelledby="faq-btn-1">
          <p>Sí. Xpendz ofrece un plan gratuito con todas las funciones esenciales para administrar tus finanzas personales.</p>
        </div>
      </div>

      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="faq-btn-2" aria-expanded="false" aria-controls="faq-answer-2">
          <span>¿Mis datos financieros están seguros?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="faq-answer-2" role="region" aria-labelledby="faq-btn-2">
          <p>Sí. Xpendz protege tu información con almacenamiento local, autenticación gestionada, conexiones seguras para sincronización y controles diseñados para mantener tus datos privados.</p>
          <p>Tu información sigue siendo tuya, independientemente del plan que utilices.</p>
        </div>
      </div>

      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="faq-btn-3" aria-expanded="false" aria-controls="faq-answer-3">
          <span>¿Puedo usar Xpendz en varios dispositivos?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="faq-answer-3" role="region" aria-labelledby="faq-btn-3">
          <p>Sí. Xpendz permite sincronizar tu información para que puedas mantener tus datos disponibles entre dispositivos compatibles.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- CTA Final Section -->
<section class="xpendz-cta-final" id="descargar">
  <div class="container">
    <div class="xpendz-cta-final-content">
      <h2 class="xpendz-cta-final-title">Comienza con Xpendz</h2>
      <p class="xpendz-cta-final-text">
        Empieza hoy a organizar tu dinero de una forma más clara, sencilla y organizada.
        Descarga Xpendz y comienza a construir mejores hábitos financieros.
      </p>
      <div class="xpendz-cta-final-buttons">
        <a href="<?= htmlspecialchars(XPENDZ_GOOGLE_PLAY_URL, ENT_QUOTES) ?>" class="xpendz-cta-final-primary" aria-label="Descargar Xpendz">
          <i class="bi bi-google-play" aria-hidden="true"></i>
          <span>Ir a Descargar</span>
        </a>
      </div>
    </div>
  </div>
</section>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "Xpendz",
  "description": "Controla tus gastos, ingresos, préstamos y metas financieras de forma simple y segura.",
  "url": "https://jcadenas.com/xpendz",
  "operatingSystem": "Android",
  "applicationCategory": "FinanceApplication",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "USD",
    "name": "Xpendz Gratis"
  },
  "author": {
    "@type": "Person",
    "name": "Joel Cadenas",
    "url": "https://jcadenas.com"
  }
}
</script>

<script>
(function () {
  var questions = document.querySelectorAll('.xpendz-faq-question');
  questions.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var item = btn.closest('.xpendz-faq-item');
      var answer = item.querySelector('.xpendz-faq-answer');
      var isOpen = item.classList.contains('xpendz-faq-item--open');

      // Cerrar todos los demás
      document.querySelectorAll('.xpendz-faq-item--open').forEach(function (openItem) {
        if (openItem !== item) {
          openItem.classList.remove('xpendz-faq-item--open');
          openItem.querySelector('.xpendz-faq-answer').style.maxHeight = null;
          openItem.querySelector('.xpendz-faq-question').setAttribute('aria-expanded', 'false');
        }
      });

      if (isOpen) {
        item.classList.remove('xpendz-faq-item--open');
        answer.style.maxHeight = null;
        btn.setAttribute('aria-expanded', 'false');
      } else {
        item.classList.add('xpendz-faq-item--open');
        answer.style.maxHeight = answer.scrollHeight + 'px';
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });
}());
</script>

<?php include 'includes/footer-xpendz.php'; ?>
