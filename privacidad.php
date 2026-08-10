<?php
require_once __DIR__ . '/config.php';

$pageTitle = 'Política de Privacidad | Xpendz';
$pageDescription = 'Política de privacidad oficial de Xpendz para Google Play en la ruta xpendz/privacidad: datos recopilados y no recopilados, autenticación, almacenamiento local, sincronización con Firebase, seguridad, cambios de política y eliminación de cuenta.';
$pageCssFile = 'assets/css/xpendz.css';
$pageBodyClass = 'xpendz-privacy-page';
$pageMainId = 'privacy-main';
$pageSkipTarget = '#privacy-hero';
$showXpendzNav = true;
$xpendzNavLinks = [
  [ 'label' => 'Inicio', 'href' => siteUrl('xpendz') ],
  [ 'label' => 'Funciones', 'href' => siteUrl('xpendz/funciones') ],
  [ 'label' => 'Privacidad y seguridad', 'href' => siteUrl('xpendz/privacidad-y-seguridad') ],
  [ 'label' => 'Descargar', 'href' => siteUrl('xpendz') . '#descargar' ],
];

include 'includes/header-xpendz.php';
?>
<section class="xpendz-privacy-hero" id="privacy-hero">
  <div class="xpendz-privacy-hero-inner">
    <span class="xpendz-privacy-eyebrow"><i class="bi bi-shield-lock-fill" aria-hidden="true"></i> Política pública oficial para Google Play</span>
    <h1 class="xpendz-privacy-title">Política de Privacidad de Xpendz</h1>
    <p class="xpendz-privacy-subtitle">
      Esta página explica cómo Xpendz trata tus datos personales y financieros. Está preparada como referencia pública permanente para la publicación en Google Play y tiene como finalidad informar de manera clara cómo Xpendz recopila, utiliza, almacena y protege la información de sus usuarios.
    </p>

    <div class="xpendz-privacy-meta" aria-label="Información principal de la app">
      <span class="xpendz-privacy-meta-pill"><i class="bi bi-app-indicator" aria-hidden="true"></i> Aplicación: Xpendz</span>
      <span class="xpendz-privacy-meta-pill"><i class="bi bi-code-slash" aria-hidden="true"></i> Package: com.jcadenas.xpendz</span>
      <span class="xpendz-privacy-meta-pill"><i class="bi bi-person-badge" aria-hidden="true"></i> Desarrollador: Joel Cadenas</span>
      <span class="xpendz-privacy-meta-pill"><i class="bi bi-calendar-event" aria-hidden="true"></i> Última actualización: 26 de julio de 2026</span>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">1. Información del desarrollador y de la aplicación</h2>
    <p class="xpendz-privacy-section-desc">
      Xpendz es una aplicación de finanzas personales desarrollada por <strong>Joel Cadenas</strong> bajo el sitio oficial <strong>jcadenas.com</strong>. Su objetivo es permitirte registrar, organizar y sincronizar información financiera propia como cuentas, ingresos, gastos, presupuestos, préstamos y metas.
    </p>

    <div class="xpendz-privacy-grid xpendz-privacy-grid--two">
      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Datos de contacto</h3>
        <p class="xpendz-privacy-card-text">
          Para consultas de privacidad, soporte o solicitudes de eliminación de cuenta, puedes escribir a:
        </p>
        <div class="xpendz-privacy-contact-box">
          <a class="xpendz-privacy-contact-link" href="mailto:servicios@jcadenas.com?subject=Privacidad%20Xpendz">
            <i class="bi bi-envelope" aria-hidden="true"></i>
            servicios@jcadenas.com
          </a>
          <p class="xpendz-privacy-card-text">
            Sitio oficial: <a href="<?= htmlspecialchars(siteUrl('xpendz'), ENT_QUOTES) ?>">https://jcadenas.com/xpendz</a>
          </p>
        </div>
      </article>

      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Alcance de esta política</h3>
        <p class="xpendz-privacy-card-text">
          Esta política aplica a la app Android Xpendz y a los servicios relacionados con su autenticación, sincronización y soporte. No aplica a sitios de terceros enlazados desde la app o desde jcadenas.com.
        </p>
        <div class="xpendz-privacy-note">
          <p class="xpendz-privacy-card-text" style="margin:0;">
            Parte de la información puede almacenarse localmente en tu dispositivo y, si inicias sesión, sincronizarse con Firebase para mantener tu cuenta disponible entre dispositivos.
          </p>
        </div>
      </article>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section xpendz-privacy-section--alt">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">2. Base legal del tratamiento</h2>
    <p class="xpendz-privacy-section-desc">
      Tratamos los datos personales únicamente para prestar el servicio de Xpendz, autenticar al usuario, sincronizar información entre dispositivos, permitir la recuperación de la cuenta y responder solicitudes de soporte.
    </p>

    <div class="xpendz-privacy-card">
      <ul class="xpendz-privacy-list">
        <li>El tratamiento se limita a las funciones necesarias para operar la aplicación y mantener tu cuenta disponible.</li>
        <li>No usamos tus datos para publicidad, venta de información ni analítica comercial.</li>
        <li>Si una finalidad cambia en el futuro, la política se actualizará antes de aplicar el nuevo uso.</li>
      </ul>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">3. Menores de edad</h2>
    <p class="xpendz-privacy-section-desc">
      Xpendz no está dirigida a menores de 13 años, o a la edad mínima aplicable según la legislación de tu país. La aplicación está pensada para personas que administran sus propias finanzas personales.
    </p>

    <div class="xpendz-privacy-card">
      <ul class="xpendz-privacy-list">
        <li>Si detectamos la recopilación involuntaria de información de un menor, tomaremos las medidas razonables para eliminar esos datos.</li>
        <li>Si eres padre, madre o tutor y consideras que un menor nos ha facilitado información, puedes escribirnos a servicios@jcadenas.com.</li>
      </ul>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section xpendz-privacy-section--alt">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">4. Datos que recopilamos</h2>
    <p class="xpendz-privacy-section-desc">
      Xpendz solo recopila la información necesaria para que la app funcione, sincronice tus datos y permita recuperar tu cuenta.
    </p>

    <div class="xpendz-privacy-grid xpendz-privacy-grid--two">
      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Datos de cuenta y autenticación</h3>
        <ul class="xpendz-privacy-list">
          <li>Dirección de correo electrónico asociada a tu cuenta.</li>
          <li>Nombre de perfil o nombre visible, cuando esté disponible.</li>
          <li>Identificadores técnicos de autenticación y sesión generados por Firebase Authentication.</li>
          <li>Identificador interno del dispositivo o de la instalación, cuando se use para mantener la sesión o la sincronización.</li>
        </ul>
      </article>

      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Datos financieros y de uso que introduces tú</h3>
        <ul class="xpendz-privacy-list">
          <li>Cuentas financieras, categorías, subcategorías y saldos.</li>
          <li>Transacciones, transferencias, presupuestos y metas de ahorro.</li>
          <li>Datos de préstamos, abonos, notas y referencias que agregues manualmente.</li>
          <li>Preferencias de la app y configuraciones locales necesarias para tu experiencia.</li>
        </ul>
      </article>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">5. Datos que no recopilamos</h2>
    <p class="xpendz-privacy-section-desc">
      No recopilamos ni vendemos datos para publicidad ni realizamos perfiles de comportamiento con fines comerciales.
    </p>

    <div class="xpendz-privacy-card">
      <ul class="xpendz-privacy-list">
        <li>No recopilamos números de tarjeta, credenciales bancarias ni contraseñas en texto plano.</li>
        <li>No recopilamos contactos, SMS, historial de llamadas ni contenido de otras aplicaciones del dispositivo.</li>
        <li>No recopilamos ubicación precisa, micrófono, cámara ni biometría.</li>
        <li>No usamos publicidad comportamental ni compartimos tus datos con anunciantes.</li>
        <li>No vendemos tu información personal a terceros.</li>
      </ul>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section xpendz-privacy-section--alt">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">6. Autenticación</h2>
    <p class="xpendz-privacy-section-desc">
      Xpendz utiliza <strong>Firebase Authentication</strong> para gestionar el inicio de sesión. Según la configuración de la cuenta, la autenticación puede realizarse mediante Google o mediante correo y contraseña.
    </p>

    <div class="xpendz-privacy-grid xpendz-privacy-grid--two">
      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Cómo usamos la autenticación</h3>
        <ul class="xpendz-privacy-list">
          <li>Verificar que eres tú al entrar en la app.</li>
          <li>Proteger tu información financiera con una cuenta asociada.</li>
          <li>Permitir la sincronización de tus datos entre dispositivos autorizados.</li>
        </ul>
      </article>

      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Qué sucede con tus credenciales</h3>
        <ul class="xpendz-privacy-list">
          <li>Las credenciales y tokens de acceso son administrados por Firebase.</li>
          <li>Xpendz no almacena tu contraseña en texto legible.</li>
          <li>La sesión se usa únicamente para mantener el acceso y la sincronización.</li>
        </ul>
      </article>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">7. Almacenamiento local</h2>
    <p class="xpendz-privacy-section-desc">
      La app puede almacenar información en el dispositivo para ofrecer uso offline, guardar preferencias y mantener tus registros disponibles incluso sin conexión. Xpendz no depende del sistema de copia de seguridad automática de Android para funcionar ni para conservar tus datos principales.
    </p>

    <div class="xpendz-privacy-card">
      <ul class="xpendz-privacy-list">
        <li>La base de datos local se usa para tus cuentas, movimientos, metas y demás información registrada en la app.</li>
        <li>Las preferencias y ajustes pueden guardarse localmente para preservar tu experiencia.</li>
        <li>El almacenamiento local permanece en tu dispositivo hasta que desinstales la app o borres sus datos.</li>
        <li>La sincronización en la nube es independiente del almacenamiento local: los datos locales permiten usar Xpendz sin conexión y la nube sirve para mantener la cuenta disponible entre dispositivos.</li>
        <li>Los respaldos manuales los crea el usuario desde la app como archivos independientes de Firebase. Permanecen donde el usuario decida guardarlos, pueden restaurarse manualmente desde la aplicación y no se eliminan automáticamente al eliminar la cuenta.</li>
      </ul>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section xpendz-privacy-section--alt">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">8. Sincronización con Firebase</h2>
    <p class="xpendz-privacy-section-desc">
      Cuando inicias sesión y usas la sincronización, parte de la información puede enviarse a Firebase Firestore para mantenerla disponible en otros dispositivos asociados a la misma cuenta.
    </p>

    <div class="xpendz-privacy-grid xpendz-privacy-grid--two">
      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Datos que pueden sincronizarse</h3>
        <ul class="xpendz-privacy-list">
          <li>Cuentas, categorías, transacciones, presupuestos, metas y préstamos.</li>
          <li>Movimientos relacionados con tu historial financiero y configuración de sincronización.</li>
          <li>Metadatos técnicos necesarios para reconciliar cambios entre dispositivos.</li>
        </ul>
      </article>

      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Tratamiento por terceros</h3>
        <ul class="xpendz-privacy-list">
          <li>Firebase actúa como proveedor tecnológico de autenticación y almacenamiento en la nube.</li>
          <li>La transferencia de datos se realiza a través de conexiones seguras.</li>
          <li>El tratamiento realizado por Firebase está sujeto a las políticas oficiales de Google.</li>
        </ul>
      </article>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">9. Eliminación de cuenta y de datos</h2>
    <p class="xpendz-privacy-section-desc">
      Puedes eliminar tu cuenta directamente desde la sección de Configuración dentro de Xpendz o solicitar la eliminación por correo. En ambos casos el proceso puede requerir verificación para proteger tu información.
    </p>
    <p class="xpendz-privacy-section-desc" style="margin-top:0.8rem;">
      Consulta la guía oficial paso a paso en:
      <a href="<?= htmlspecialchars(siteUrl('xpendz/eliminar-cuenta'), ENT_QUOTES) ?>">https://jcadenas.com/xpendz/eliminar-cuenta</a>
    </p>

    <div class="xpendz-privacy-grid xpendz-privacy-grid--two">
      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Cómo eliminar la cuenta</h3>
        <ol class="xpendz-privacy-list">
          <li>Desde Xpendz: abre <strong>Configuración</strong> y usa la opción de eliminación de cuenta disponible en la app.</li>
          <li>Por correo: escribe a <a href="mailto:servicios@jcadenas.com?subject=Eliminar%20cuenta%20Xpendz">servicios@jcadenas.com</a>.</li>
          <li>Indica el correo de la cuenta de Xpendz que deseas eliminar.</li>
          <li>Si hace falta, responderemos para validar la solicitud antes de ejecutar el borrado.</li>
        </ol>
      </article>

      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Qué se elimina</h3>
        <ul class="xpendz-privacy-list">
          <li>La cuenta de autenticación vinculada a Xpendz en Firebase Authentication.</li>
          <li>Los datos sincronizados con Firebase Firestore asociados a esa cuenta, salvo retención obligatoria por ley.</li>
          <li>La información local del dispositivo no se borra de forma remota; debe eliminarse borrando los datos de la app o desinstalándola en el dispositivo correspondiente.</li>
          <li>Los respaldos manuales creados previamente por el usuario no se eliminan automáticamente, porque son archivos independientes que quedan bajo su control.</li>
        </ul>
        <div class="xpendz-privacy-note">
          <p class="xpendz-privacy-card-text" style="margin:0;">
            Conservaremos únicamente la información mínima necesaria si existe una obligación legal, de prevención de fraude o de seguridad que nos impida borrarla de inmediato.
          </p>
        </div>
      </article>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section xpendz-privacy-section--alt">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">10. Seguridad</h2>
    <p class="xpendz-privacy-section-desc">
      Xpendz utiliza HTTPS para la comunicación web y Firebase utiliza conexiones cifradas para la autenticación y la sincronización. Aplicamos medidas razonables de protección para reducir el riesgo de acceso no autorizado, alteración o pérdida de datos, aunque ningún sistema conectado a Internet puede garantizar seguridad absoluta.
    </p>

    <div class="xpendz-privacy-card">
      <ul class="xpendz-privacy-list">
        <li>La comunicación entre la app y los servicios web se realiza por canales seguros cuando están disponibles.</li>
        <li>Firebase Authentication y Firestore emplean transporte cifrado para la transmisión de datos.</li>
        <li>Las medidas de seguridad se revisan de forma razonable para proteger la información del usuario.</li>
      </ul>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">11. Cambios en esta política</h2>
    <p class="xpendz-privacy-section-desc">
      Esta política puede actualizarse cuando cambie la aplicación, sus funciones, los servicios de terceros utilizados o exista un cambio legal o regulatorio relevante. Siempre publicaremos la fecha de última actualización al inicio y al final de esta página.
    </p>

    <div class="xpendz-privacy-card">
      <ul class="xpendz-privacy-list">
        <li>Las actualizaciones se publicarán en esta misma URL permanente.</li>
        <li>La fecha de última actualización se mantendrá visible para que puedas comprobar la versión vigente.</li>
      </ul>
    </div>
  </div>
</section>

<section class="xpendz-privacy-section xpendz-privacy-section--alt">
  <div class="xpendz-privacy-section-inner">
    <h2 class="xpendz-privacy-section-title">12. Contacto y soporte</h2>
    <p class="xpendz-privacy-section-desc">
      Si tienes preguntas sobre esta política, sobre tus datos o sobre la eliminación de la cuenta, usa cualquiera de los siguientes canales oficiales.
    </p>

    <div class="xpendz-privacy-grid xpendz-privacy-grid--two">
      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Correo directo</h3>
        <p class="xpendz-privacy-card-text">
          <a href="mailto:servicios@jcadenas.com?subject=Consulta%20sobre%20privacidad%20Xpendz">servicios@jcadenas.com</a>
        </p>
        <p class="xpendz-privacy-card-text">
          También puedes usar el formulario general del sitio oficial:
          <a href="<?= htmlspecialchars(siteUrl('contact.php'), ENT_QUOTES) ?>">jcadenas.com/contact.php</a>
        </p>
      </article>

      <article class="xpendz-privacy-card">
        <h3 class="xpendz-privacy-card-title">Resumen de cumplimiento</h3>
        <ul class="xpendz-privacy-list">
          <li>La política está disponible públicamente en una URL permanente.</li>
          <li>Incluye datos recopilados y no recopilados.</li>
          <li>Explica base legal, menores de edad, autenticación, almacenamiento local, sincronización, seguridad y eliminación de cuenta.</li>
        </ul>
      </article>
    </div>

    <div class="xpendz-privacy-divider"></div>
    <p class="xpendz-privacy-card-text" style="margin:0;">
      Vigente desde: 26 de julio de 2026.
    </p>
  </div>
</section>

<?php include 'includes/footer-xpendz.php'; ?>
