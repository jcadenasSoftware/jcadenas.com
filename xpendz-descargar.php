<?php
require_once __DIR__ . '/config.php';

$pageTitle = 'Descargar Xpendz | Empieza en minutos';
$pageDescription = 'Descarga Xpendz y comienza a usarla en pocos minutos. Conoce los pasos de instalación, qué verás al iniciar por primera vez, compatibilidad y respuestas esenciales.';
$pageCssFile = 'assets/css/xpendz.css';
$pageBodyClass = 'xpendz-download-page';
$pageMainId = 'xpendz-download-main';
$pageSkipTarget = '#xpendz-download-hero';
$showXpendzNav = true;
$xpendzNavLinks = [
  [ 'label' => 'Inicio', 'href' => siteUrl('xpendz') ],
  [ 'label' => 'Funciones', 'href' => siteUrl('xpendz/funciones') ],
  [ 'label' => 'Privacidad y seguridad', 'href' => siteUrl('xpendz/privacidad-y-seguridad') ],
  [ 'label' => 'Descargar', 'href' => siteUrl('xpendz/descargar'), 'primary' => true ],
];

include 'includes/header-xpendz.php';
?>
<section class="xpendz-download-hero" id="xpendz-download-hero">
  <div class="xpendz-download-hero-inner">
    <span class="xpendz-download-eyebrow">Instalación simple</span>
    <h1 class="xpendz-download-title">Listo para empezar con Xpendz</h1>
    <p class="xpendz-download-subtitle">Ya entiendes qué es Xpendz, cómo funciona y por qué puedes confiar. Empezar toma solo unos minutos.</p>
    <div class="xpendz-hero-ctas">
      <a href="<?= htmlspecialchars(XPENDZ_GOOGLE_PLAY_URL, ENT_QUOTES) ?>" class="xpendz-cta-primary" aria-label="Descargar Xpendz">
        <i class="bi bi-google-play" aria-hidden="true"></i>
        <span>Descargar Xpendz</span>
      </a>
    </div>
    <div class="xpendz-benefits-row" aria-label="Mensajes de confianza antes de descargar">
      <div class="xpendz-benefit-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Empezar toma solo unos minutos</span>
      </div>
      <div class="xpendz-benefit-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Conserva el control desde el primer día</span>
      </div>
      <div class="xpendz-benefit-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Empieza con una sola cuenta y crece a tu ritmo</span>
      </div>
    </div>
  </div>
</section>

<section class="xpendz-features" id="installation-journey">
  <div class="container">
    <h2 class="xpendz-features-title">Tus primeros minutos</h2>
    <p class="xpendz-features-subtitle">Un vistazo guiado a lo que sucede después de instalar: instala, accede, crea tu primera cuenta y registra tu primer movimiento.</p>
    <div class="xpendz-features-grid xpendz-journey-grid">
      <article class="xpendz-feature-card" aria-label="Paso 1: Instalar Xpendz">
        <div class="xpendz-feature-icon"><i class="bi bi-download" aria-hidden="true"></i></div>
        <span class="xpendz-journey-step-badge" aria-hidden="true">1</span>
        <h3 class="xpendz-feature-title">Instalar Xpendz</h3>
        <p class="xpendz-feature-desc">Descarga la app desde Google Play y completa la instalación.</p>
      </article>
      <article class="xpendz-feature-card" aria-label="Paso 2: Acceder o crear cuenta">
        <div class="xpendz-feature-icon"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i></div>
        <span class="xpendz-journey-step-badge" aria-hidden="true">2</span>
        <h3 class="xpendz-feature-title">Acceder o crear cuenta</h3>
        <p class="xpendz-feature-desc">Accede con tu cuenta o crea una nueva para conservar continuidad cuando la necesites.</p>
      </article>
      <article class="xpendz-feature-card" aria-label="Paso 3: Crear tu primera cuenta de dinero">
        <div class="xpendz-feature-icon"><i class="bi bi-wallet2" aria-hidden="true"></i></div>
        <span class="xpendz-journey-step-badge" aria-hidden="true">3</span>
        <h3 class="xpendz-feature-title">Crear tu primera cuenta de dinero</h3>
        <p class="xpendz-feature-desc">Define dónde administras tu dinero: banco, efectivo o billetera.</p>
      </article>
      <article class="xpendz-feature-card" aria-label="Paso 4: Registrar tu primer movimiento">
        <div class="xpendz-feature-icon"><i class="bi bi-check2-circle" aria-hidden="true"></i></div>
        <span class="xpendz-journey-step-badge" aria-hidden="true">4</span>
        <h3 class="xpendz-feature-title">Registrar tu primer movimiento</h3>
        <p class="xpendz-feature-desc">Registra tu primer movimiento y verás tu panorama cobrar forma.</p>
      </article>
    </div>
  </div>
</section>

<section class="xpendz-showcase" id="first-experience">
  <div class="container">
    <div class="xpendz-showcase-header">
      <h2 class="xpendz-showcase-title">Lo que verás primero</h2>
      <p class="xpendz-showcase-subtitle">Una vista previa real de los primeros minutos para que entres con seguridad.</p>
    </div>
    <div class="xpendz-first-experience-grid">
      <figure class="xpendz-showcase-visual">
        <img src="<?= $base ?>/assets/img/showcase/dashboard.webp" alt="Dashboard inicial de Xpendz" class="xpendz-showcase-image" width="310" height="650" loading="lazy" decoding="async">
      </figure>
      <figure class="xpendz-showcase-visual">
        <img src="<?= $base ?>/assets/img/showcase/accounts.webp" alt="Creación de primera cuenta en Xpendz" class="xpendz-showcase-image" width="310" height="650" loading="lazy" decoding="async">
      </figure>
      <figure class="xpendz-showcase-visual">
        <img src="<?= $base ?>/assets/img/showcase/transactions.webp" alt="Registro del primer movimiento en Xpendz" class="xpendz-showcase-image" width="310" height="650" loading="lazy" decoding="async">
      </figure>
    </div>
  </div>
</section>

<section class="xpendz-features" id="compatibility">
  <div class="container">
    <h2 class="xpendz-features-title">Compatibilidad</h2>
    <p class="xpendz-features-subtitle">Información esencial para instalar sin fricción.</p>
    <div class="xpendz-features-grid xpendz-compat-grid">
      <article class="xpendz-feature-card">
        <div class="xpendz-feature-icon"><i class="bi bi-android2" aria-hidden="true"></i></div>
        <h3 class="xpendz-feature-title">Android</h3>
        <p class="xpendz-feature-desc">Disponible para dispositivos Android compatibles.</p>
      </article>
      <article class="xpendz-feature-card">
        <div class="xpendz-feature-icon"><i class="bi bi-laptop" aria-hidden="true"></i></div>
        <h3 class="xpendz-feature-title">Escritorio</h3>
        <p class="xpendz-feature-desc">Si hay versión de escritorio disponible, aparecerá aquí como acción secundaria.</p>
      </article>
    </div>
  </div>
</section>

<section class="xpendz-faq" id="essential-questions">
  <div class="container">
    <div class="xpendz-faq-header">
      <h2 class="xpendz-faq-title">Preguntas esenciales</h2>
      <p class="xpendz-faq-subtitle">Respuestas breves y útiles antes de instalar.</p>
    </div>
    <div class="xpendz-faq-list">
      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="dq-1" aria-expanded="false" aria-controls="da-1">
          <span>¿Qué pasa después de instalar?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="da-1" role="region" aria-labelledby="dq-1">
          <p>Abrirás Xpendz y podrás crear tu primera cuenta para empezar a registrar.</p>
        </div>
      </div>
      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="dq-2" aria-expanded="false" aria-controls="da-2">
          <span>¿Cuánto tarda empezar?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="da-2" role="region" aria-labelledby="dq-2">
          <p>En minutos. Instalar, acceder y crear tu primera cuenta es rápido.</p>
        </div>
      </div>
      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="dq-3" aria-expanded="false" aria-controls="da-3">
          <span>¿Necesito una cuenta?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="da-3" role="region" aria-labelledby="dq-3">
          <p>Puedes usar identidad para sincronizar y mantener continuidad entre dispositivos compatibles.</p>
        </div>
      </div>
      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="dq-4" aria-expanded="false" aria-controls="da-4">
          <span>¿Es gratis?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="da-4" role="region" aria-labelledby="dq-4">
          <p>Sí. Puedes comenzar con el plan gratuito.</p>
        </div>
      </div>
      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="dq-5" aria-expanded="false" aria-controls="da-5">
          <span>¿Es compatible con mi dispositivo?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="da-5" role="region" aria-labelledby="dq-5">
          <p>Confirma la disponibilidad según tu plataforma en la sección de compatibilidad.</p>
        </div>
      </div>
      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="dq-6" aria-expanded="false" aria-controls="da-6">
          <span>¿Qué veré primero?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="da-6" role="region" aria-labelledby="dq-6">
          <p>Un dashboard inicial y los pasos para crear tu primera cuenta y tu primer movimiento.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="xpendz-cta-final" id="download-final-cta">
  <div class="container">
    <div class="xpendz-cta-final-content">
      <h2 class="xpendz-cta-final-title">Listo para instalar</h2>
      <p class="xpendz-cta-final-text">Descarga Xpendz ahora mismo y en minutos estarás registrando tu primer movimiento.</p>
      <div class="xpendz-cta-final-buttons">
        <a href="<?= htmlspecialchars(XPENDZ_GOOGLE_PLAY_URL, ENT_QUOTES) ?>" class="xpendz-cta-final-primary" aria-label="Descargar Xpendz">
          <i class="bi bi-google-play" aria-hidden="true"></i>
          <span>Descargar Xpendz</span>
        </a>
      </div>
    </div>
  </div>
</section>

<script>
(function () {
  var buttons = document.querySelectorAll('.xpendz-faq-question');
  buttons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var item = btn.closest('.xpendz-faq-item');
      var answer = item.querySelector('.xpendz-faq-answer');
      var isOpen = item.classList.contains('xpendz-faq-item--open');
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
