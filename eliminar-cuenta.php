<?php
require_once __DIR__ . '/config.php';

$pageTitle = 'Eliminar tu cuenta de Xpendz | Guía oficial';
$pageDescription = 'Guía oficial de eliminación de cuenta de Xpendz para Google Play: pasos desde la app, solicitud por soporte y detalle de datos eliminados.';
$pageCssFile = 'assets/css/xpendz.css';
$pageBodyClass = 'xpendz-delete-page';
$pageMainId = 'delete-account-main';
$pageSkipTarget = '#delete-account-hero';
$showXpendzNav = true;
$xpendzNavLinks = [
  [ 'label' => 'Inicio', 'href' => siteUrl('xpendz') . '#hero' ],
  [ 'label' => 'Privacidad', 'href' => siteUrl('xpendz/privacidad') ],
  [ 'label' => 'Eliminar cuenta', 'href' => siteUrl('xpendz/eliminar-cuenta'), 'primary' => true ],
];

$deleteFlowSteps = [
  [
    'title' => 'Abrir Xpendz',
    'description' => 'Abre la aplicación Xpendz desde tu dispositivo.',
    'image' => '01-abrir-xpendz.webp',
    'fallback' => 'assets/img/showcase/dashboard.webp',
    'alt' => 'Pantalla inicial al abrir la aplicación Xpendz',
  ],
  [
    'title' => 'Iniciar sesión',
    'description' => 'Inicia sesión con la cuenta que deseas eliminar.',
    'image' => '02-iniciar-sesion.webp',
    'fallback' => 'assets/img/showcase/transactions.webp',
    'alt' => 'Pantalla de inicio de sesión con cuenta activa en Xpendz',
  ],
  [
    'title' => 'Ir a Configuración',
    'description' => 'Desde el menú principal, entra a Configuración.',
    'image' => '03-configuracion.webp',
    'fallback' => 'assets/img/showcase/security.webp',
    'alt' => 'Pantalla de configuración dentro de Xpendz',
  ],
  [
    'title' => 'Ir a Privacidad y datos',
    'description' => 'Dentro de Configuración, abre la sección Privacidad y datos.',
    'image' => '04-privacidad-y-datos.webp',
    'fallback' => 'assets/img/showcase/security.webp',
    'alt' => 'Sección Privacidad y datos en Xpendz',
  ],
  [
    'title' => 'Seleccionar "Eliminar cuenta"',
    'description' => 'Toca la opción "Eliminar cuenta" para iniciar inmediatamente la eliminación de la cuenta, borrar los datos asociados según la política y cerrar tu sesión automáticamente.',
    'image' => '05-eliminar-cuenta.webp',
    'fallback' => 'assets/img/showcase/security.webp',
    'alt' => 'Opción Eliminar cuenta seleccionada en Xpendz',
  ],
];

include 'includes/header-xpendz.php';
?>

<section class="xpendz-delete-hero" id="delete-account-hero">
  <div class="xpendz-delete-hero-inner">
    <nav class="xpendz-delete-breadcrumb" aria-label="Breadcrumb">
      <a href="<?= htmlspecialchars(siteUrl('xpendz'), ENT_QUOTES) ?>">Inicio</a>
      <span aria-hidden="true">/</span>
      <a href="<?= htmlspecialchars(siteUrl('xpendz/privacidad'), ENT_QUOTES) ?>">Política de privacidad</a>
      <span aria-hidden="true">/</span>
      <span aria-current="page">Eliminar tu cuenta</span>
    </nav>

    <div class="xpendz-delete-hero-grid">
      <div>
        <h1 class="xpendz-delete-title">Eliminar tu cuenta de Xpendz</h1>
        <p class="xpendz-delete-subtitle">
          Puedes eliminar tu cuenta directamente desde la aplicación Xpendz o solicitar la eliminación mediante correo electrónico.
          En esta página encontrarás el procedimiento y conocerás qué ocurre con tu información después del proceso.
        </p>
      </div>
      <div class="xpendz-delete-hero-icon" aria-hidden="true">
        <i class="bi bi-trash3-fill"></i>
      </div>
    </div>
  </div>
</section>

<section class="xpendz-delete-section" id="delete-method-app" aria-labelledby="delete-method-app-title">
  <div class="xpendz-delete-section-inner">
    <h2 class="xpendz-delete-section-title" id="delete-method-app-title">1. Eliminar la cuenta desde la aplicación (Método recomendado)</h2>
    <p class="xpendz-delete-section-desc">Sigue esta secuencia exacta dentro de Xpendz. Al seleccionar <strong>Eliminar cuenta</strong>, la app inicia de inmediato el proceso de eliminación, aplica el borrado de datos asociados según la política y cierra automáticamente tu sesión.</p>

    <ol class="xpendz-delete-steps-grid" aria-label="Pasos para eliminar una cuenta desde Xpendz">
      <?php foreach ($deleteFlowSteps as $index => $step): ?>
        <?php
          $preferredRelativePath = 'assets/images/account-deletion/' . $step['image'];
          $preferredAbsolutePath = __DIR__ . '/assets/images/account-deletion/' . $step['image'];
          $stepImagePath = file_exists($preferredAbsolutePath) ? $preferredRelativePath : $step['fallback'];
        ?>
        <li class="xpendz-delete-step-card">
          <p class="xpendz-delete-step-number">Paso <?= $index + 1 ?></p>
          <h3 class="xpendz-delete-step-title"><?= htmlspecialchars($step['title'], ENT_QUOTES) ?></h3>
          <p class="xpendz-delete-step-text"><?= htmlspecialchars($step['description'], ENT_QUOTES) ?></p>
          <div class="xpendz-delete-phone-frame" aria-hidden="true">
            <span class="xpendz-delete-phone-notch"></span>
            <span class="xpendz-delete-phone-button"></span>
            <div class="xpendz-delete-phone-screen">
              <img src="<?= htmlspecialchars($base . '/' . ltrim($stepImagePath, '/'), ENT_QUOTES) ?>" alt="<?= htmlspecialchars($step['alt'], ENT_QUOTES) ?>" loading="lazy" width="288" height="624">
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="xpendz-delete-section xpendz-delete-section--alt" id="delete-method-support" aria-labelledby="delete-method-support-title">
  <div class="xpendz-delete-section-inner">
    <div class="xpendz-delete-grid-two">
      <article class="xpendz-delete-card">
        <h2 class="xpendz-delete-section-title" id="delete-method-support-title">2. Solicitar eliminación mediante soporte</h2>
        <p class="xpendz-delete-section-desc">Si no puedes acceder a la aplicación, puedes solicitar la eliminación escribiendo a:</p>
        <p class="xpendz-delete-support-mail">
          <a href="mailto:servicios@jcadenas.com?subject=Eliminar%20cuenta%20Xpendz">servicios@jcadenas.com</a>
        </p>
        <p class="xpendz-delete-card-text">Incluye en tu correo:</p>
        <ul class="xpendz-delete-list">
          <li>Correo asociado a la cuenta.</li>
          <li>Solicitud explícita de eliminación.</li>
        </ul>
      </article>

      <article class="xpendz-delete-card" id="delete-data-table" aria-labelledby="delete-data-table-title">
        <h2 class="xpendz-delete-section-title" id="delete-data-table-title">3. ¿Qué datos se eliminan?</h2>
        <div class="xpendz-delete-table-wrap" role="region" aria-label="Tabla de eliminación de datos" tabindex="0">
          <table class="xpendz-delete-table">
            <thead>
              <tr>
                <th scope="col">Información</th>
                <th scope="col">¿Se elimina?</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Cuenta de Firebase Authentication.</td>
                <td><span class="xpendz-delete-status xpendz-delete-status--yes"><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Sí</span></td>
              </tr>
              <tr>
                <td>Datos sincronizados en Firebase Firestore.</td>
                <td><span class="xpendz-delete-status xpendz-delete-status--yes"><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Sí</span></td>
              </tr>
              <tr>
                <td>Información almacenada localmente en el dispositivo.</td>
                <td><span class="xpendz-delete-status xpendz-delete-status--no"><i class="bi bi-x-circle-fill" aria-hidden="true"></i> No automático</span></td>
              </tr>
              <tr>
                <td>Respaldos manuales creados por el usuario.</td>
                <td><span class="xpendz-delete-status xpendz-delete-status--no"><i class="bi bi-x-circle-fill" aria-hidden="true"></i> No automático</span></td>
              </tr>
            </tbody>
          </table>
        </div>
        <p class="xpendz-delete-card-note">La información local permanece en el dispositivo hasta que el usuario elimine los datos de la app o la desinstale. Los respaldos manuales permanecen bajo el control del usuario.</p>
      </article>
    </div>
  </div>
</section>

<section class="xpendz-delete-section" id="delete-extra-info">
  <div class="xpendz-delete-section-inner">
    <div class="xpendz-delete-grid-three">
      <article class="xpendz-delete-card">
        <h2 class="xpendz-delete-section-title">4. Información importante</h2>
        <p class="xpendz-delete-card-text">Los respaldos manuales son archivos independientes. Si posteriormente se restauran en una cuenta nueva, volverán a formar parte de la información disponible dentro de Xpendz.</p>
      </article>

      <article class="xpendz-delete-card">
        <h2 class="xpendz-delete-section-title">5. Tiempo de procesamiento</h2>
        <ul class="xpendz-delete-list">
          <li><strong>Eliminación desde la aplicación:</strong> inmediata al seleccionar <strong>Eliminar cuenta</strong>, con cierre automático de sesión.</li>
          <li><strong>Solicitudes por correo:</strong> se procesan tras verificar la identidad del solicitante.</li>
        </ul>
      </article>

      <article class="xpendz-delete-card" id="delete-faq">
        <h2 class="xpendz-delete-section-title">6. Preguntas frecuentes</h2>
        <div class="xpendz-delete-faq-list">
          <details>
            <summary>¿Puedo recuperar mi cuenta?</summary>
            <p>No. Una vez eliminada la cuenta, no puede recuperarse.</p>
          </details>
          <details>
            <summary>¿Qué ocurre con mis respaldos?</summary>
            <p>Los respaldos manuales permanecen donde el usuario los guardó y no se eliminan automáticamente.</p>
          </details>
          <details>
            <summary>¿Puedo crear una cuenta nueva?</summary>
            <p>Sí. Puedes crear una cuenta nueva en cualquier momento.</p>
          </details>
        </div>
      </article>
    </div>
  </div>
</section>

<section class="xpendz-delete-contact" aria-labelledby="delete-contact-title">
  <div class="xpendz-delete-contact-inner">
    <h2 class="xpendz-delete-contact-title" id="delete-contact-title">¿Necesitas ayuda con tu cuenta?</h2>
    <p class="xpendz-delete-contact-text">Nuestro equipo puede orientarte en el proceso de eliminación y verificación.</p>
    <p class="xpendz-delete-contact-mail"><a href="mailto:servicios@jcadenas.com">servicios@jcadenas.com</a></p>
    <a class="xpendz-delete-contact-btn" href="mailto:servicios@jcadenas.com?subject=Soporte%20eliminaci%C3%B3n%20de%20cuenta%20Xpendz">Contactar soporte</a>
  </div>
</section>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "¿Puedo recuperar mi cuenta?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "No. Una vez eliminada la cuenta, no puede recuperarse."
      }
    },
    {
      "@type": "Question",
      "name": "¿Qué ocurre con mis respaldos?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Los respaldos manuales permanecen donde el usuario los guardó y no se eliminan automáticamente."
      }
    },
    {
      "@type": "Question",
      "name": "¿Puedo crear una cuenta nueva?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Sí. Puedes crear una cuenta nueva en cualquier momento."
      }
    }
  ]
}
</script>

<?php include 'includes/footer-xpendz.php'; ?>
