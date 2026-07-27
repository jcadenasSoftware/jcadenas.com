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
  [ 'label' => 'Inicio', 'href' => siteUrl('xpendz') . '#hero', 'primary' => true ],
  [ 'label' => 'Privacidad', 'href' => siteUrl('xpendz/privacidad') ],
  [ 'label' => 'Eliminar cuenta', 'href' => siteUrl('xpendz/eliminar-cuenta') ],
];
include 'includes/header-xpendz.php';
?>
<!-- Hero Section -->
<section class="xpendz-hero" id="hero">
  <div class="container">
    <div class="xpendz-hero-brand" aria-label="Xpendz">
      <img src="<?= $base ?>/assets/img/xpendz.png" alt="Xpendz" class="xpendz-hero-logo" width="48" height="48" loading="eager">
      <span class="xpendz-hero-brand-name">Xpendz</span>
    </div>

    <div class="xpendz-hero-grid">

      <!-- Columna izquierda: Contenido de texto -->
      <div class="xpendz-hero-content">
        <div class="xpendz-hero-badge">
          <i class="bi bi-stars" aria-hidden="true"></i>
          <span>Finanzas personales, simplificadas</span>
        </div>
        <h1 class="xpendz-title">
          Toma el control<br>de tu <span class="xpendz-title-accent">dinero</span>
        </h1>
        <p class="xpendz-description">
          Registra gastos, ingresos, préstamos y metas desde un solo lugar. Simple, seguro y siempre en tu bolsillo.
        </p>
        <div class="xpendz-hero-ctas">
          <a href="#" class="xpendz-cta-primary" aria-label="Próximamente disponible en Google Play">
            <i class="bi bi-google-play" aria-hidden="true"></i>
            <span class="xpendz-cta-primary-text">
              <small>Próximamente en</small>
              <strong>Google Play</strong>
            </span>
          </a>
          <a href="#features" class="xpendz-cta-secondary">
            Conocer funciones
            <i class="bi bi-arrow-down" aria-hidden="true"></i>
          </a>
        </div>
        <div class="xpendz-trust-row" aria-label="Características de seguridad">
          <div class="xpendz-trust-item">
            <i class="bi bi-shield-lock-fill" aria-hidden="true"></i>
            <span>Datos cifrados</span>
          </div>
          <div class="xpendz-trust-item">
            <i class="bi bi-cloud-check-fill" aria-hidden="true"></i>
            <span>Sync segura</span>
          </div>
          <div class="xpendz-trust-item">
            <i class="bi bi-graph-up-arrow" aria-hidden="true"></i>
            <span>Estadísticas inteligentes</span>
          </div>
        </div>
      </div>

      <!-- Columna derecha: Espacio reservado para mockup -->
      <div class="xpendz-hero-visual" aria-hidden="true">
        <div class="xpendz-mockup-placeholder">
          <img src="<?= $base ?>/assets/img/xpendz-screenshot.webp" alt="Pantalla principal del dashboard financiero de Xpendz" class="xpendz-mockup-image" width="220" height="475" loading="eager" fetchpriority="high">
        </div>
      </div>

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

    <!-- Bloque 1: Dashboard financiero -->
    <div class="xpendz-showcase-block">
      <div class="xpendz-showcase-content">
        <h3 class="xpendz-showcase-block-title">Visualiza tu panorama financiero completo</h3>
        <p class="xpendz-showcase-block-desc">Accede a un dashboard intuitivo que te muestra tu balance actual, ingresos, gastos y el estado de tus cuentas en tiempo real. Todo lo que necesitas saber, de un vistazo.</p>
      </div>
      <div class="xpendz-showcase-visual">
        <img src="<?= $base ?>/assets/img/showcase/dashboard.webp" alt="Dashboard financiero de Xpendz" class="xpendz-showcase-image" width="310" height="650" loading="lazy">
      </div>
    </div>

    <!-- Bloque 2: Registro de gastos e ingresos -->
    <div class="xpendz-showcase-block xpendz-showcase-block-reverse">
      <div class="xpendz-showcase-content">
        <h3 class="xpendz-showcase-block-title">Registra cada movimiento en segundos</h3>
        <p class="xpendz-showcase-block-desc">Añade gastos e ingresos de forma rápida y sencilla. Categoriza tus transacciones, adjunta notas y mantén un historial completo de tu actividad financiera.</p>
      </div>
      <div class="xpendz-showcase-visual">
        <img src="<?= $base ?>/assets/img/showcase/transactions.webp" alt="Registro de transacciones en Xpendz" class="xpendz-showcase-image" width="310" height="650" loading="lazy">
      </div>
    </div>

    <!-- Bloque 3: Metas de ahorro -->
    <div class="xpendz-showcase-block">
      <div class="xpendz-showcase-content">
        <h3 class="xpendz-showcase-block-title">Alcanza tus objetivos financieros</h3>
        <p class="xpendz-showcase-block-desc">Define metas de ahorro personalizadas y monitorea tu progreso. Xpendz te motiva a cumplir tus objetivos con visualizaciones claras y recordatorios inteligentes.</p>
      </div>
      <div class="xpendz-showcase-visual">
        <img src="<?= $base ?>/assets/img/showcase/goals.webp" alt="Metas de ahorro en Xpendz" class="xpendz-showcase-image" width="310" height="650" loading="lazy">
      </div>
    </div>

    <!-- Bloque 4: Préstamos y abonos -->
    <div class="xpendz-showcase-block xpendz-showcase-block-reverse">
      <div class="xpendz-showcase-content">
        <h3 class="xpendz-showcase-block-title">Gestiona préstamos sin complicaciones</h3>
        <p class="xpendz-showcase-block-desc">Lleva un control detallado de los préstamos que otorgas o recibes. Registra abonos, consulta saldos pendientes y mantén tus finanzas organizadas.</p>
      </div>
      <div class="xpendz-showcase-visual">
        <img src="<?= $base ?>/assets/img/showcase/loans.webp" alt="Gestión de préstamos en Xpendz" class="xpendz-showcase-image" width="310" height="650" loading="lazy">
      </div>
    </div>

    <!-- Bloque 5: Seguridad y respaldos -->
    <div class="xpendz-showcase-block">
      <div class="xpendz-showcase-content">
        <h3 class="xpendz-showcase-block-title">Tus datos, siempre protegidos</h3>
        <p class="xpendz-showcase-block-desc">Protege tu información con PIN y disfruta de respaldos automáticos en la nube. Tus datos financieros están cifrados y seguros, disponibles cuando los necesites.</p>
      </div>
      <div class="xpendz-showcase-visual">
        <img src="<?= $base ?>/assets/img/showcase/security.webp" alt="Seguridad y respaldos en Xpendz" class="xpendz-showcase-image" width="310" height="650" loading="lazy">
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
          <i class="bi bi-shield-check"></i>
        </div>
        <h3 class="xpendz-feature-title">Privacidad primero</h3>
        <p class="xpendz-feature-desc">Protege tu información mediante PIN, cifrado local y respaldos seguros.</p>
      </div>

      <div class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-cloud-check"></i>
        </div>
        <h3 class="xpendz-feature-title">Tus datos siempre contigo</h3>
        <p class="xpendz-feature-desc">Crea respaldos cifrados y recupera tu información cuando la necesites.</p>
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
  </div>
</section>

<!-- Checklist Section -->
<section class="xpendz-checklist" id="todo-incluye">
  <div class="container">
    <div class="xpendz-checklist-header">
      <h2 class="xpendz-checklist-title">Todo lo que incluye Xpendz</h2>
      <p class="xpendz-checklist-subtitle">Una aplicación diseñada para ayudarte a administrar tus finanzas personales de principio a fin.</p>
    </div>
    <div class="xpendz-checklist-grid">

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-receipt" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Registro de gastos</h4>
          <p class="xpendz-checklist-item-desc">Controla cada gasto de forma rápida y organizada.</p>
        </div>
      </div>

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-cash-coin" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Registro de ingresos</h4>
          <p class="xpendz-checklist-item-desc">Mantén un historial completo de todo tu dinero recibido.</p>
        </div>
      </div>

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-wallet2" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Gestión de cuentas</h4>
          <p class="xpendz-checklist-item-desc">Administra efectivo, bancos, billeteras y más.</p>
        </div>
      </div>

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-tags" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Categorías personalizadas</h4>
          <p class="xpendz-checklist-item-desc">Organiza tus movimientos según tus necesidades.</p>
        </div>
      </div>

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-sliders" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Presupuestos</h4>
          <p class="xpendz-checklist-item-desc">Define límites mensuales para controlar tus gastos.</p>
        </div>
      </div>

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-bullseye" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Metas de ahorro</h4>
          <p class="xpendz-checklist-item-desc">Haz seguimiento al progreso de tus objetivos financieros.</p>
        </div>
      </div>

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-arrow-left-right" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Préstamos</h4>
          <p class="xpendz-checklist-item-desc">Controla dinero prestado y dinero por cobrar.</p>
        </div>
      </div>

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-bar-chart-line" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Estadísticas inteligentes</h4>
          <p class="xpendz-checklist-item-desc">Consulta balances, tendencias y resúmenes financieros.</p>
        </div>
      </div>

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-shield-lock" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Respaldo cifrado</h4>
          <p class="xpendz-checklist-item-desc">Protege tus datos mediante respaldos seguros.</p>
        </div>
      </div>

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-cloud-check" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Sincronización</h4>
          <p class="xpendz-checklist-item-desc">Mantén tu información disponible entre dispositivos compatibles.</p>
        </div>
      </div>

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-lock" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Protección mediante PIN</h4>
          <p class="xpendz-checklist-item-desc">Evita accesos no autorizados a tu información.</p>
        </div>
      </div>

      <div class="xpendz-checklist-item">
        <div class="xpendz-checklist-icon">
          <i class="bi bi-box-arrow-up" aria-hidden="true"></i>
        </div>
        <div class="xpendz-checklist-text">
          <h4 class="xpendz-checklist-item-title">Exportación</h4>
          <p class="xpendz-checklist-item-desc">Genera respaldos y comparte tu información cuando lo necesites.</p>
        </div>
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
          <h3 class="xpendz-trust-card-title">Respaldos protegidos</h3>
          <p class="xpendz-trust-card-desc">Crea y restaura respaldos cifrados para mantener tu información segura y disponible cuando la necesites.</p>
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

      <div class="xpendz-trust-card">
        <div class="xpendz-trust-card-icon">
          <i class="bi bi-phone" aria-hidden="true"></i>
        </div>
        <div class="xpendz-trust-card-content">
          <h3 class="xpendz-trust-card-title">Diseñada para el uso diario</h3>
          <p class="xpendz-trust-card-desc">Una experiencia rápida, intuitiva y enfocada en ayudarte a mantener el control de tus finanzas.</p>
        </div>
      </div>

    </div>

    <div class="xpendz-trust-band">
      <div class="xpendz-trust-band-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Sin publicidad invasiva</span>
      </div>
      <div class="xpendz-trust-band-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Datos protegidos</span>
      </div>
      <div class="xpendz-trust-band-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Respaldos cifrados</span>
      </div>
      <div class="xpendz-trust-band-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Actualizaciones continuas</span>
      </div>
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
          <p>Si necesitas ampliar los límites de uso, disfrutar de una experiencia sin publicidad o acceder a futuras funciones exclusivas, podrás actualizar a Xpendz Premium cuando lo desees.</p>
          <p>Además, podrás probar Xpendz Premium durante <strong>7 días sin costo</strong> antes de decidir si deseas suscribirte.</p>
        </div>
      </div>

      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="faq-btn-2" aria-expanded="false" aria-controls="faq-answer-2">
          <span>¿Mis datos financieros están seguros?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="faq-answer-2" role="region" aria-labelledby="faq-btn-2">
          <p>Sí. Xpendz protege tu información con almacenamiento seguro, cifrado de respaldos y controles diseñados para mantener tus datos privados.</p>
          <p>Tu información sigue siendo tuya, independientemente del plan que utilices.</p>
        </div>
      </div>

      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="faq-btn-3" aria-expanded="false" aria-controls="faq-answer-3">
          <span>¿Necesito conexión a Internet para usar Xpendz?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="faq-answer-3" role="region" aria-labelledby="faq-btn-3">
          <p>Sí. Actualmente Xpendz requiere una conexión a Internet para iniciar sesión y sincronizar tu información de forma segura entre dispositivos.</p>
          <p>Una vez que hayas iniciado sesión, puedes seguir registrando gastos, ingresos y otras operaciones aunque pierdas temporalmente la conexión. Los cambios se guardarán en tu dispositivo y se sincronizarán automáticamente cuando vuelvas a estar conectado.</p>
        </div>
      </div>

      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="faq-btn-4" aria-expanded="false" aria-controls="faq-answer-4">
          <span>¿Puedo usar Xpendz en varios dispositivos?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="faq-answer-4" role="region" aria-labelledby="faq-btn-4">
          <p>Sí. Xpendz permite sincronizar tu información para que puedas mantener tus datos disponibles entre dispositivos compatibles.</p>
        </div>
      </div>

      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="faq-btn-5" aria-expanded="false" aria-controls="faq-answer-5">
          <span>¿Qué pasa si cambio de teléfono o pierdo mi dispositivo?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="faq-answer-5" role="region" aria-labelledby="faq-btn-5">
          <p>Tus datos pueden recuperarse mediante los mecanismos de respaldo disponibles. Te recomendamos mantener tus respaldos actualizados para evitar pérdidas de información.</p>
        </div>
      </div>

      <div class="xpendz-faq-item">
        <button class="xpendz-faq-question" id="faq-btn-6" aria-expanded="false" aria-controls="faq-answer-6">
          <span>¿Qué puedo registrar en Xpendz?</span>
          <i class="bi bi-chevron-down xpendz-faq-chevron" aria-hidden="true"></i>
        </button>
        <div class="xpendz-faq-answer" id="faq-answer-6" role="region" aria-labelledby="faq-btn-6">
          <p>Puedes registrar gastos, ingresos, transferencias, cuentas, categorías, presupuestos, metas de ahorro y préstamos, además de consultar tu resumen financiero desde una sola aplicación.</p>
          <p>El plan gratuito incluye todas las funciones esenciales. Si en el futuro necesitas ampliar los límites de uso, podrás hacerlo con Xpendz Premium.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- CTA Final Section -->
<section class="xpendz-cta-final" id="cta-final">
  <div class="container">
    <div class="xpendz-cta-final-content">
      <h2 class="xpendz-cta-final-title">Comienza gratis con Xpendz</h2>
      <p class="xpendz-cta-final-text">
        Organiza tus ingresos, gastos, presupuestos, préstamos y metas de ahorro desde una sola aplicación.
        Empieza con el plan gratuito y, cuando necesites ampliar los límites de uso o disfrutar de una experiencia sin publicidad, podrás actualizar a Xpendz Premium.
      </p>
      <div class="xpendz-cta-final-buttons">
        <a href="#" class="xpendz-cta-final-primary" aria-label="Descargar gratis para Android">
          <i class="bi bi-google-play" aria-hidden="true"></i>
          <span>Descargar gratis para Android</span>
        </a>
        <a href="#planes" class="xpendz-cta-final-secondary">
          Conocer más
          <i class="bi bi-arrow-down" aria-hidden="true"></i>
        </a>
      </div>
      <div class="xpendz-cta-final-trust">
        <div class="xpendz-cta-final-trust-item">
          <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
          <span>Plan gratuito disponible</span>
        </div>
        <div class="xpendz-cta-final-trust-item">
          <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
          <span>Prueba Premium durante 7 días</span>
        </div>
        <div class="xpendz-cta-final-trust-item">
          <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
          <span>Cancela cuando quieras</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Plans Section -->
<section class="xpendz-plans" id="planes">
  <div class="container">
    <div class="xpendz-plans-header">
      <h2 class="xpendz-plans-title">Elige el plan que mejor se adapte a ti</h2>
      <p class="xpendz-plans-subtitle">Empieza gratis y actualiza a Premium solo cuando realmente lo necesites.</p>
    </div>

    <div class="xpendz-plans-grid">

      <!-- Plan Gratuito -->
      <div class="xpendz-plan-card">
        <div class="xpendz-plan-content">
          <h3 class="xpendz-plan-name">Xpendz Gratis</h3>
          <ul class="xpendz-plan-features">
            <li class="xpendz-plan-feature">
              <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
              <span>Todas las funciones esenciales</span>
            </li>
            <li class="xpendz-plan-feature">
              <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
              <span>Registro ilimitado de ingresos y gastos</span>
            </li>
            <li class="xpendz-plan-feature">
              <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
              <span>Dashboard y reportes</span>
            </li>
            <li class="xpendz-plan-feature">
              <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
              <span>Sincronización segura</span>
            </li>
            <li class="xpendz-plan-feature">
              <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
              <span>Publicidad discreta</span>
            </li>
          </ul>
          <a href="#" class="xpendz-plan-button xpendz-plan-button--primary">
            Comenzar gratis
          </a>
        </div>
      </div>

      <!-- Plan Premium -->
      <div class="xpendz-plan-card xpendz-plan-card--premium">
        <div class="xpendz-plan-badge">Recomendado</div>
        <div class="xpendz-plan-content">
          <h3 class="xpendz-plan-name">Xpendz Premium</h3>
          <ul class="xpendz-plan-features">
            <li class="xpendz-plan-feature">
              <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
              <span>Todo lo incluido en Gratis</span>
            </li>
            <li class="xpendz-plan-feature">
              <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
              <span>Sin límites de uso</span>
            </li>
            <li class="xpendz-plan-feature">
              <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
              <span>Sin publicidad</span>
            </li>
            <li class="xpendz-plan-feature">
              <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
              <span>Prueba gratuita durante 7 días</span>
            </li>
            <li class="xpendz-plan-feature">
              <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
              <span>Acceso prioritario a futuras funciones</span>
            </li>
          </ul>
          <a href="#" class="xpendz-plan-button xpendz-plan-button--premium">
            Conocer Premium
          </a>
        </div>
      </div>

    </div>

    <p class="xpendz-plans-footer-text">
      <i class="bi bi-shield-check" aria-hidden="true"></i>
      <span>Todos tus datos permanecen contigo incluso si decides volver al plan gratuito.</span>
    </p>

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
