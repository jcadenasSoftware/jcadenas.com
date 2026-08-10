<?php
require_once __DIR__ . '/config.php';

$pageTitle = 'Privacidad y seguridad de Xpendz | Entiende por qué puedes usarla con confianza';
$pageDescription = 'Descubre cómo Xpendz protege tu información financiera, cómo funcionan el almacenamiento local, la sincronización, la autenticación, los respaldos y el control del usuario.';
$pageCssFile = 'assets/css/xpendz.css';
$pageBodyClass = 'xpendz-trust-page';
$pageMainId = 'xpendz-trust-main';
$pageSkipTarget = '#xpendz-trust-hero';
$showXpendzNav = true;
$xpendzNavLinks = [
  [ 'label' => 'Inicio', 'href' => siteUrl('xpendz') ],
  [ 'label' => 'Funciones', 'href' => siteUrl('xpendz/funciones') ],
  [ 'label' => 'Privacidad y seguridad', 'href' => siteUrl('xpendz/privacidad-y-seguridad'), 'primary' => true ],
  [ 'label' => 'Descargar', 'href' => siteUrl('xpendz/descargar') ],
];

$trustPrinciples = [
  [
    'icon' => 'bi bi-shield-check',
    'title' => 'La privacidad influye en decisiones reales',
    'description' => 'En Xpendz la confianza no vive solo en una política. Influye en cómo se autentica la cuenta, cómo se sincroniza la información y qué control conserva siempre el usuario.',
  ],
  [
    'icon' => 'bi bi-person-lock',
    'title' => 'Tus datos no cambian de dueño',
    'description' => 'La información financiera que registras pertenece a tu historia y a tus decisiones. Xpendz la trata como algo que debe mantenerse bajo tu control, con límites claros y explicaciones comprensibles.',
  ],
  [
    'icon' => 'bi bi-eye',
    'title' => 'Claridad antes que exageración',
    'description' => 'Preferimos explicar comportamientos reales del producto en lugar de hacer promesas difíciles de verificar. La confianza crece mejor cuando entiendes qué ocurre y qué no ocurre con tu información.',
  ],
];

$trustStorySections = [
  [
    'sectionClass' => 'xpendz-showcase',
    'blockClass' => 'xpendz-showcase-block',
    'kicker' => 'Almacenamiento local',
    'title' => 'Tu información puede seguir disponible en tu propio dispositivo',
    'description' => 'Xpendz puede guardar tus registros y preferencias directamente en el dispositivo para que la app siga siendo útil incluso sin conexión. Eso convierte la continuidad en algo práctico y no en una dependencia total de la nube.',
    'image' => 'assets/img/showcase/dashboard.webp',
    'imageAlt' => 'Vista general de Xpendz utilizada como referencia de información financiera disponible en la aplicación',
    'cards' => [
      [
        'icon' => 'bi bi-phone',
        'title' => 'Uso cotidiano con soporte local',
        'description' => 'Cuentas, movimientos, metas y otras configuraciones pueden mantenerse localmente para que tu experiencia no dependa por completo de estar conectado en todo momento.',
      ],
      [
        'icon' => 'bi bi-hdd-stack',
        'title' => 'Permanencia bajo tu dispositivo',
        'description' => 'La información almacenada localmente permanece en tu dispositivo hasta que borres los datos de la app o la desinstales, lo que hace más comprensible dónde sigue existiendo esa información.',
      ],
    ],
  ],
  [
    'sectionClass' => 'xpendz-showcase xpendz-trust-page-section--alt',
    'blockClass' => 'xpendz-showcase-block xpendz-showcase-block-reverse',
    'kicker' => 'Sincronización en la nube',
    'title' => 'Cuando sincronizas, la continuidad sigue vinculada a tu cuenta',
    'description' => 'Si inicias sesión, parte de la información puede sincronizarse con Firebase Firestore para mantenerla disponible entre dispositivos asociados a la misma cuenta. La sincronización no se presenta como una caja negra, sino como una forma comprensible de continuidad.',
    'image' => 'assets/img/showcase/security.webp',
    'imageAlt' => 'Pantalla de Xpendz relacionada con seguridad y continuidad de la información',
    'cards' => [
      [
        'icon' => 'bi bi-arrow-repeat',
        'title' => 'Disponibilidad entre dispositivos compatibles',
        'description' => 'La nube permite que tus datos sigan contigo cuando cambias de dispositivo o retomas el uso en otro contexto autorizado de la misma cuenta.',
      ],
      [
        'icon' => 'bi bi-person-badge',
        'title' => 'Sincronización asociada a identidad',
        'description' => 'La información sincronizada queda vinculada a la cuenta autenticada, no a una promesa ambigua de acceso universal. Eso hace más claro qué cuenta protege y organiza tus datos.',
      ],
    ],
  ],
  [
    'sectionClass' => 'xpendz-showcase',
    'blockClass' => 'xpendz-showcase-block',
    'kicker' => 'Autenticación',
    'title' => 'La protección empieza antes del uso diario de la aplicación',
    'description' => 'El acceso a la cuenta forma parte de la protección general de tu información. Xpendz utiliza Firebase Authentication para gestionar el inicio de sesión y hacer visible que la identidad del usuario no se trata de forma improvisada.',
    'image' => 'assets/img/showcase/transactions.webp',
    'imageAlt' => 'Interfaz de Xpendz utilizada como apoyo visual para la gestión protegida de la cuenta',
    'cards' => [
      [
        'icon' => 'bi bi-box-arrow-in-right',
        'title' => 'Inicio de sesión gestionado',
        'description' => 'Según la configuración de tu cuenta, el acceso puede realizarse con Google o con correo y contraseña mediante Firebase Authentication, que administra los identificadores y tokens de sesión.',
      ],
      [
        'icon' => 'bi bi-key',
        'title' => 'Xpendz no guarda tu contraseña en texto legible',
        'description' => 'Las credenciales se gestionan a través del proveedor de autenticación y Xpendz no almacena tu contraseña de forma legible dentro del producto.',
      ],
    ],
  ],
  [
    'sectionClass' => 'xpendz-showcase xpendz-trust-page-section--alt',
    'blockClass' => 'xpendz-showcase-block xpendz-showcase-block-reverse',
    'kicker' => 'Protección y transmisión',
    'title' => 'La seguridad se apoya en prácticas comprensibles, no en promesas absolutas',
    'description' => 'Xpendz utiliza HTTPS para la comunicación web y Firebase utiliza conexiones cifradas para autenticación y sincronización. Además, se aplican medidas razonables para reducir riesgos sin afirmar una seguridad imposible de garantizar.',
    'image' => 'assets/img/showcase/security.webp',
    'imageAlt' => 'Visual de seguridad de Xpendz como apoyo a las prácticas de protección de la información',
    'cards' => [
      [
        'icon' => 'bi bi-lock',
        'title' => 'Conexiones seguras cuando la información viaja',
        'description' => 'La comunicación entre la app y los servicios web usa canales seguros cuando están disponibles, y la autenticación y sincronización con Firebase se apoyan en transporte cifrado.',
      ],
      [
        'icon' => 'bi bi-shield-lock',
        'title' => 'Medidas razonables en lugar de marketing exagerado',
        'description' => 'La protección se explica como una responsabilidad práctica del producto. Por honestidad, Xpendz no presenta la seguridad como algo absoluto ni como una promesa vacía.',
      ],
    ],
  ],
  [
    'sectionClass' => 'xpendz-showcase',
    'blockClass' => 'xpendz-showcase-block',
    'kicker' => 'Respaldos',
    'title' => 'Tus respaldos existen para preservar continuidad sin quitarte control',
    'description' => 'Xpendz permite crear respaldos manuales como archivos independientes. Eso refuerza la tranquilidad porque la preservación y la recuperación de la información pueden seguir una ruta clara controlada por el usuario.',
    'image' => 'assets/img/showcase/goals.webp',
    'imageAlt' => 'Pantalla de Xpendz utilizada como referencia visual para continuidad y recuperación de información',
    'cards' => [
      [
        'icon' => 'bi bi-cloud-arrow-down',
        'title' => 'Respaldos creados desde la app',
        'description' => 'Los respaldos manuales pueden crearse desde Xpendz para conservar una copia independiente de tu información financiera bajo la decisión del usuario.',
      ],
      [
        'icon' => 'bi bi-folder2-open',
        'title' => 'Archivos independientes bajo tu control',
        'description' => 'Esos respaldos permanecen donde tú decidas guardarlos, pueden restaurarse manualmente y no se eliminan automáticamente al borrar la cuenta porque siguen siendo archivos separados.',
      ],
    ],
  ],
];

$userControlCards = [
  [
    'icon' => 'bi bi-megaphone',
    'title' => 'Sin publicidad ni venta de datos',
    'description' => 'Xpendz no usa tu información para publicidad, no la vende a terceros y no la convierte en un producto comercial ajeno a la función principal de la app.',
  ],
  [
    'icon' => 'bi bi-slash-circle',
    'title' => 'Sin acceso innecesario a tu dispositivo',
    'description' => 'La app no necesita ubicación precisa, contactos, SMS, historial de llamadas, micrófono, cámara o biometría para cumplir su propósito principal de finanzas personales.',
  ],
  [
    'icon' => 'bi bi-trash3',
    'title' => 'Salida clara cuando la necesites',
    'description' => 'Si en algún momento quieres terminar la relación con el producto, existe una guía oficial para eliminar la cuenta y entender qué datos se borran y cuáles siguen bajo tu control como archivos locales o respaldos manuales.',
    'link' => siteUrl('xpendz/eliminar-cuenta'),
    'linkLabel' => 'Consultar la guía oficial para eliminar la cuenta',
  ],
];

include 'includes/header-xpendz.php';
?>
<section class="xpendz-trust-page-hero" id="xpendz-trust-hero">
  <div class="xpendz-trust-page-hero-inner">
    <span class="xpendz-trust-page-eyebrow">Privacidad y seguridad explicadas con claridad</span>
    <h1 class="xpendz-trust-page-title">Por qué puedes usar Xpendz con confianza</h1>
    <p class="xpendz-trust-page-subtitle">
      Esta página existe para explicar cómo Xpendz protege tu información, cómo funciona la continuidad entre almacenamiento local, sincronización y respaldos, y por qué el control del usuario sigue siendo una parte real del producto.
    </p>
    <div class="xpendz-benefits-row" aria-label="Resumen de confianza en Xpendz">
      <div class="xpendz-benefit-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Tus datos siguen bajo tu control</span>
      </div>
      <div class="xpendz-benefit-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>La sincronización se explica en lenguaje claro</span>
      </div>
      <div class="xpendz-benefit-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Existe una salida verificable para tu cuenta</span>
      </div>
    </div>
  </div>
</section>

<section class="xpendz-features" id="trust-philosophy">
  <div class="container">
    <h2 class="xpendz-features-title">La confianza no se pide: se construye paso a paso</h2>
    <p class="xpendz-features-subtitle">
      Antes de hablar de nube, autenticación o respaldos, Xpendz necesita dejar claro que la privacidad no es un adorno del producto. Es una forma de tomar decisiones con más responsabilidad sobre información sensible.
    </p>
    <div class="xpendz-features-grid xpendz-trust-page-grid">
      <?php foreach ($trustPrinciples as $principle): ?>
      <article class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="<?= htmlspecialchars($principle['icon'], ENT_QUOTES) ?>" aria-hidden="true"></i>
        </div>
        <h3 class="xpendz-feature-title"><?= htmlspecialchars($principle['title'], ENT_QUOTES) ?></h3>
        <p class="xpendz-feature-desc"><?= htmlspecialchars($principle['description'], ENT_QUOTES) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php foreach ($trustStorySections as $section): ?>
<section class="<?= htmlspecialchars($section['sectionClass'], ENT_QUOTES) ?>">
  <div class="container">
    <div class="<?= htmlspecialchars($section['blockClass'], ENT_QUOTES) ?>">
      <div class="xpendz-showcase-content">
        <p class="xpendz-trust-page-kicker"><?= htmlspecialchars($section['kicker'], ENT_QUOTES) ?></p>
        <h2 class="xpendz-showcase-block-title"><?= htmlspecialchars($section['title'], ENT_QUOTES) ?></h2>
        <p class="xpendz-showcase-block-desc"><?= htmlspecialchars($section['description'], ENT_QUOTES) ?></p>
      </div>
      <div class="xpendz-showcase-visual">
        <img src="<?= $base ?>/<?= htmlspecialchars($section['image'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($section['imageAlt'], ENT_QUOTES) ?>" class="xpendz-showcase-image" width="310" height="650" loading="lazy">
      </div>
    </div>
    <div class="xpendz-features-grid xpendz-trust-page-grid">
      <?php foreach ($section['cards'] as $card): ?>
      <article class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="<?= htmlspecialchars($card['icon'], ENT_QUOTES) ?>" aria-hidden="true"></i>
        </div>
        <h3 class="xpendz-feature-title"><?= htmlspecialchars($card['title'], ENT_QUOTES) ?></h3>
        <p class="xpendz-feature-desc"><?= htmlspecialchars($card['description'], ENT_QUOTES) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endforeach; ?>

<section class="xpendz-features" id="user-control">
  <div class="container">
    <h2 class="xpendz-features-title">La privacidad también se nota en las decisiones que Xpendz evita</h2>
    <p class="xpendz-features-subtitle">
      La confianza no depende solo de proteger datos cuando existen. También depende de limitar el acceso, evitar usos innecesarios y mantener una salida clara cuando el usuario ya no quiere seguir usando la aplicación.
    </p>
    <div class="xpendz-features-grid xpendz-trust-page-grid">
      <?php foreach ($userControlCards as $card): ?>
      <article class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="<?= htmlspecialchars($card['icon'], ENT_QUOTES) ?>" aria-hidden="true"></i>
        </div>
        <h3 class="xpendz-feature-title"><?= htmlspecialchars($card['title'], ENT_QUOTES) ?></h3>
        <p class="xpendz-feature-desc"><?= htmlspecialchars($card['description'], ENT_QUOTES) ?></p>
        <?php if (!empty($card['link']) && !empty($card['linkLabel'])): ?>
        <p class="xpendz-trust-page-card-link">
          <a href="<?= htmlspecialchars($card['link'], ENT_QUOTES) ?>" class="xpendz-trust-page-link"><?= htmlspecialchars($card['linkLabel'], ENT_QUOTES) ?></a>
        </p>
        <?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="xpendz-features xpendz-trust-page-policy" id="privacy-policy-reference">
  <div class="container">
    <h2 class="xpendz-features-title">La política legal sigue siendo la referencia oficial</h2>
    <p class="xpendz-features-subtitle">
      Esta página explica principios y prácticas del producto en lenguaje claro. Si necesitas la referencia formal y permanente sobre tratamiento de datos, autenticación, almacenamiento local, sincronización, seguridad y eliminación de cuenta, la política oficial sigue disponible públicamente.
    </p>
    <div class="xpendz-features-grid xpendz-trust-page-grid xpendz-trust-page-grid--single">
      <article class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
        </div>
        <h3 class="xpendz-feature-title">Lee la Política de Privacidad completa</h3>
        <p class="xpendz-feature-desc">Cuando quieras revisar el detalle legal y documental, puedes ir directamente a la política oficial publicada por Xpendz.</p>
        <div class="xpendz-trust-page-card-link xpendz-trust-page-card-link--button">
          <a href="<?= htmlspecialchars(siteUrl('xpendz/privacidad'), ENT_QUOTES) ?>" class="xpendz-cta-final-secondary" aria-label="Leer la Política de Privacidad oficial de Xpendz">
            Leer la Política de Privacidad completa
            <i class="bi bi-arrow-right" aria-hidden="true"></i>
          </a>
        </div>
      </article>
    </div>
  </div>
</section>

<section class="xpendz-cta-final" id="trust-next-step">
  <div class="container">
    <div class="xpendz-cta-final-content">
      <h2 class="xpendz-cta-final-title">Cuando la confianza ya está clara, el siguiente paso es instalar Xpendz</h2>
      <p class="xpendz-cta-final-text">
        Si ya entiendes cómo Xpendz trata tu información y por qué puedes usarla con tranquilidad, continúa hacia la superficie de descarga para empezar a usar la app.
      </p>
      <div class="xpendz-cta-final-buttons">
        <a href="<?= htmlspecialchars(siteUrl('xpendz') . '#descargar', ENT_QUOTES) ?>" class="xpendz-cta-final-primary" aria-label="Ir a la sección de descarga de Xpendz">
          <i class="bi bi-google-play" aria-hidden="true"></i>
          <span>Continuar a Descargar</span>
        </a>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer-xpendz.php'; ?>
