<?php
require_once __DIR__ . '/config.php';

$pageTitle = 'Funciones de Xpendz | Entiende cómo te ayuda a administrar tu dinero';
$pageDescription = 'Descubre cómo Xpendz te ayuda a entender tu panorama financiero, organizar cuentas, registrar movimientos, planificar presupuestos, seguir metas, controlar préstamos y tomar mejores decisiones.';
$pageCssFile = 'assets/css/xpendz.css';
$pageBodyClass = 'xpendz-features-page';
$pageMainId = 'xpendz-features-main';
$pageSkipTarget = '#xpendz-features-hero';
$showXpendzNav = true;
$xpendzNavLinks = [
  [ 'label' => 'Inicio', 'href' => siteUrl('xpendz') ],
  [ 'label' => 'Funciones', 'href' => siteUrl('xpendz/funciones'), 'primary' => true ],
  [ 'label' => 'Privacidad y seguridad', 'href' => siteUrl('xpendz/privacidad-y-seguridad') ],
  [ 'label' => 'Descargar', 'href' => siteUrl('xpendz/descargar') ],
];

$productExplorerItems = [
  [
    'id' => 'dashboard',
    'label' => 'Panorama',
    'stage' => 'Entender tu dinero',
    'icon' => 'bi bi-speedometer2',
    'title' => 'Entiende tu situación financiera en segundos',
    'description' => 'Xpendz reúne saldos, ingresos, gastos y movimientos para darte una foto clara y accionable sin navegar por varias vistas. Empiezas por contexto, no por complejidad.',
    'image' => 'assets/img/showcase/dashboard.webp',
    'imageAlt' => 'Dashboard financiero de Xpendz con resumen general de cuentas y movimientos',
    'benefits' => [
      'Resúmenes listos para decidir: balance, flujo y actividad reciente en un solo lugar.',
      'Menos tiempo buscando datos dispersos; más tiempo tomando decisiones.',
      'Punto de partida antes de registrar, organizar o planificar.',
    ],
    'cta' => [
      'type' => 'feature',
      'target' => 'accounts',
      'label' => 'Siguiente: Cuentas',
    ],
  ],
  [
    'id' => 'accounts',
    'label' => 'Cuentas',
    'stage' => 'Organizar la información',
    'icon' => 'bi bi-wallet2',
    'title' => 'Ordena tu dinero como lo administras en la vida real',
    'description' => 'Crea cuentas que reflejen tus espacios reales —banco, efectivo, billeteras— para leer disponibilidad y responsabilidades sin mezclar.',
    'image' => 'assets/img/showcase/accounts.webp',
    'imageAlt' => 'Vista de cuentas y saldos organizados dentro de Xpendz',
    'benefits' => [
      'Separa saldos por contexto y evita confusión entre fondos.',
      'Ubica movimientos y compromisos por cuenta sin perder trazabilidad.',
      'Aclara qué puedes usar hoy y qué debes reservar.',
    ],
    'cta' => [
      'type' => 'feature',
      'target' => 'transactions',
      'label' => 'Siguiente: Transacciones',
    ],
  ],
  [
    'id' => 'transactions',
    'label' => 'Transacciones',
    'stage' => 'Registrar actividad',
    'icon' => 'bi bi-receipt',
    'title' => 'Registra ingresos y gastos sin perder contexto',
    'description' => 'Convierte cada movimiento en historia útil con notas, categorías y cuentas, sin fricción. Toma decisiones respaldadas por hechos, no por memoria.',
    'image' => 'assets/img/showcase/transactions.webp',
    'imageAlt' => 'Pantalla de registro de transacciones en Xpendz',
    'benefits' => [
      'Construye trazabilidad diaria que permanece en el tiempo.',
      'Recupera el detalle de qué pasó con tu dinero cuando lo necesites.',
      'Prepara la base para análisis, presupuestos y metas.',
    ],
    'cta' => [
      'type' => 'feature',
      'target' => 'categories',
      'label' => 'Siguiente: Categorías',
    ],
  ],
  [
    'id' => 'categories',
    'label' => 'Categorías',
    'stage' => 'Organizar la información',
    'icon' => 'bi bi-tags',
    'title' => 'Clasifica tu actividad para revelar patrones',
    'description' => 'Etiquetas simples que transforman listados en señales sobre hábitos, prioridades y oportunidades concretas de mejora.',
    'image' => 'assets/img/showcase/categories.webp',
    'imageAlt' => 'Pantalla de transacciones categorizadas dentro de Xpendz',
    'benefits' => [
      'Entiende en qué se va el dinero con claridad inmediata.',
      'Detecta tendencias de consumo y áreas de mejora.',
      'Agrupa información para reportes y control.',
    ],
    'cta' => [
      'type' => 'feature',
      'target' => 'budgets',
      'label' => 'Siguiente: Presupuestos',
    ],
  ],
  [
    'id' => 'budgets',
    'label' => 'Presupuestos',
    'stage' => 'Planificar',
    'icon' => 'bi bi-sliders',
    'title' => 'Define límites claros y recibe señales tempranas',
    'description' => 'Fija referencias por categoría o cuenta para actuar antes de que el gasto se descontrole. Planificar es convertir intención en control medible.',
    'image' => 'assets/img/showcase/budgets.webp',
    'imageAlt' => 'Vista de planificación financiera y control de presupuestos en Xpendz',
    'benefits' => [
      'Controla desvíos a tiempo, no al final del mes.',
      'Conecta intención con acción medible.',
      'Sostiene hábitos financieros saludables.',
    ],
    'cta' => [
      'type' => 'feature',
      'target' => 'goals',
      'label' => 'Siguiente: Metas',
    ],
  ],
  [
    'id' => 'goals',
    'label' => 'Metas',
    'stage' => 'Planificar',
    'icon' => 'bi bi-bullseye',
    'title' => 'Convierte objetivos en avances medibles',
    'description' => 'Asigna montos y fechas para ver progreso visible y mantener foco. Cada aporte cuenta y te muestra cuánto falta.',
    'image' => 'assets/img/showcase/goals.webp',
    'imageAlt' => 'Pantalla de metas financieras en Xpendz',
    'benefits' => [
      'Aterriza aspiraciones en metas con seguimiento.',
      'Visualiza cuánto falta y qué impacto tiene cada aporte.',
      'Mantén motivación con evidencia del avance.',
    ],
    'cta' => [
      'type' => 'feature',
      'target' => 'loans',
      'label' => 'Siguiente: Préstamos',
    ],
  ],
  [
    'id' => 'loans',
    'label' => 'Préstamos',
    'stage' => 'Tomar decisiones',
    'icon' => 'bi bi-arrow-left-right',
    'title' => 'Controla lo que debes o te deben sin confusión',
    'description' => 'Registra préstamos, abonos y cierres para tener compromisos siempre visibles y actualizados.',
    'image' => 'assets/img/showcase/loans.webp',
    'imageAlt' => 'Pantalla de control de préstamos en Xpendz',
    'benefits' => [
      'Evita cálculos por fuera o conversaciones sueltas.',
      'Sabe exactamente cuánto debes o te deben y por qué.',
      'Actúa con previsión y responsabilidad.',
    ],
    'cta' => [
      'type' => 'feature',
      'target' => 'reports',
      'label' => 'Siguiente: Reportes',
    ],
  ],
  [
    'id' => 'reports',
    'label' => 'Reportes',
    'stage' => 'Tomar decisiones',
    'icon' => 'bi bi-bar-chart-line',
    'title' => 'Detecta tendencias y compara periodos en minutos',
    'description' => 'Transforma tu registro en resúmenes, comparaciones y hallazgos accionables para evaluar resultados con criterio.',
    'image' => 'assets/img/showcase/reports.webp',
    'imageAlt' => 'Vista de reportes y resumen financiero en Xpendz',
    'benefits' => [
      'Identifica patrones y cambios con menos esfuerzo.',
      'Conecta actividad con resultados concretos.',
      'Toma decisiones con criterio, no intuición.',
    ],
    'cta' => [
      'type' => 'feature',
      'target' => 'sync',
      'label' => 'Siguiente: Sincronización',
    ],
  ],
  [
    'id' => 'sync',
    'label' => 'Sincronización',
    'stage' => 'Mantener continuidad',
    'icon' => 'bi bi-arrow-repeat',
    'title' => 'Tu información te acompaña donde la necesitas',
    'description' => 'Continúa tu trabajo entre dispositivos compatibles sin perder contexto ni tiempo.',
    'image' => 'assets/img/showcase/sync.webp',
    'imageAlt' => 'Pantalla relacionada con sincronización y continuidad de datos en Xpendz',
    'benefits' => [
      'Disponibilidad cuando cambias de entorno.',
      'Menos fricción en tu rutina diaria.',
      'La aplicación sigue tu ritmo, no al revés.',
    ],
    'cta' => [
      'type' => 'feature',
      'target' => 'backups',
      'label' => 'Siguiente: Respaldos',
    ],
  ],
  [
    'id' => 'backups',
    'label' => 'Respaldos',
    'stage' => 'Mantener continuidad',
    'icon' => 'bi bi-cloud-check',
    'title' => 'Respalda y recupera cuando lo necesitas',
    'description' => 'Opciones de continuidad y restauración para preservar lo importante sin perder el hilo de tu trabajo.',
    'image' => 'assets/img/showcase/backups.webp',
    'imageAlt' => 'Pantalla relacionada con continuidad y resguardo de información en Xpendz',
    'benefits' => [
      'Tranquilidad frente a imprevistos.',
      'Conserva el historial que sustenta tus decisiones.',
      'Refuerza la confianza en el sistema.',
    ],
    'cta' => [
      'type' => 'link',
      'href' => siteUrl('xpendz/privacidad-y-seguridad'),
      'label' => 'Ver cómo protege tu información',
      'ariaLabel' => 'Ir a la página de Privacidad y seguridad de Xpendz',
    ],
  ],
];

include 'includes/header-xpendz.php';
?>
<section class="xpendz-features-page-hero" id="xpendz-features-hero">
  <div class="xpendz-features-page-hero-inner">
    <span class="xpendz-features-page-eyebrow">Página pública del producto</span>
    <h1 class="xpendz-features-page-title">Cómo te ayuda Xpendz a administrar mejor tu dinero</h1>
    <p class="xpendz-features-page-subtitle">
      Esta página te permite explorar las funciones reales de Xpendz una a una. Descubre cómo te ayuda a entender tu situación financiera, organizar tu información y tomar decisiones con más claridad sin convertir la experiencia en una lectura larga.
    </p>
    <div class="xpendz-benefits-row" aria-label="Resumen del recorrido de funciones">
      <div class="xpendz-benefit-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Explorar una función real a la vez</span>
      </div>
      <div class="xpendz-benefit-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Ver evidencia concreta del producto</span>
      </div>
      <div class="xpendz-benefit-item">
        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
        <span>Descubrir beneficios prácticos sin redundancia</span>
      </div>
    </div>
  </div>
</section>

<section class="xpendz-product-explorer-section" id="xpendz-product-explorer" data-product-explorer>
  <div class="container">
    <div class="xpendz-showcase-header xpendz-product-explorer-header">
      <p class="xpendz-features-page-kicker">Explorador de producto</p>
      <h2 class="xpendz-showcase-title">Descubre una función real a la vez</h2>
      <p class="xpendz-showcase-subtitle">
        En lugar de recorrer una lista larga, elige la parte de Xpendz que quieres entender y mira evidencia real del producto, beneficios prácticos y el siguiente paso natural dentro del recorrido.
      </p>
    </div>

    <div class="xpendz-product-explorer-mobile-control">
      <label for="xpendz-feature-select" class="xpendz-product-explorer-mobile-label">Explora una función</label>
      <select id="xpendz-feature-select" class="xpendz-product-explorer-mobile-select" data-feature-select>
        <?php foreach ($productExplorerItems as $feature): ?>
        <option value="<?= htmlspecialchars($feature['id'], ENT_QUOTES) ?>"><?= htmlspecialchars($feature['label'], ENT_QUOTES) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="xpendz-product-explorer-layout">
      <aside class="xpendz-product-explorer-nav" aria-label="Selector de funciones de Xpendz">
        <p class="xpendz-product-explorer-nav-title">Explora una función a la vez</p>
        <div class="xpendz-product-explorer-tablist" role="tablist" aria-orientation="vertical">
          <?php foreach ($productExplorerItems as $index => $feature): ?>
          <?php $isActive = $index === 0; ?>
          <button
            type="button"
            class="xpendz-product-explorer-tab<?= $isActive ? ' is-active' : '' ?>"
            id="xpendz-feature-tab-<?= htmlspecialchars($feature['id'], ENT_QUOTES) ?>"
            role="tab"
            aria-selected="<?= $isActive ? 'true' : 'false' ?>"
            aria-controls="xpendz-feature-panel-<?= htmlspecialchars($feature['id'], ENT_QUOTES) ?>"
            tabindex="<?= $isActive ? '0' : '-1' ?>"
            data-feature-id="<?= htmlspecialchars($feature['id'], ENT_QUOTES) ?>"
          >
            <span class="xpendz-product-explorer-tab-icon" aria-hidden="true">
              <i class="<?= htmlspecialchars($feature['icon'], ENT_QUOTES) ?>"></i>
            </span>
            <span class="xpendz-product-explorer-tab-copy">
              <span class="xpendz-product-explorer-tab-label"><?= htmlspecialchars($feature['label'], ENT_QUOTES) ?></span>
              <span class="xpendz-product-explorer-tab-stage"><?= htmlspecialchars($feature['stage'], ENT_QUOTES) ?></span>
            </span>
          </button>
          <?php endforeach; ?>
        </div>
      </aside>

      <div class="xpendz-product-explorer-content" aria-live="polite" aria-atomic="true">
        <?php foreach ($productExplorerItems as $index => $feature): ?>
        <?php $isActive = $index === 0; ?>
        <section
          class="xpendz-product-explorer-panel<?= $isActive ? ' is-active' : '' ?>"
          id="xpendz-feature-panel-<?= htmlspecialchars($feature['id'], ENT_QUOTES) ?>"
          role="tabpanel"
          aria-labelledby="xpendz-feature-tab-<?= htmlspecialchars($feature['id'], ENT_QUOTES) ?>"
          aria-label="<?= htmlspecialchars($feature['label'], ENT_QUOTES) ?>"
          <?= $isActive ? '' : ' hidden' ?>
        >
          <div class="xpendz-product-explorer-panel-main">
            <div class="xpendz-showcase-content">
              <p class="xpendz-features-page-kicker"><?= htmlspecialchars($feature['stage'], ENT_QUOTES) ?></p>
              <h2 class="xpendz-showcase-block-title xpendz-product-explorer-panel-title" tabindex="-1" data-panel-heading>
                <?= htmlspecialchars($feature['title'], ENT_QUOTES) ?>
              </h2>
              <p class="xpendz-showcase-block-desc"><?= htmlspecialchars($feature['description'], ENT_QUOTES) ?></p>
            </div>
            <figure class="xpendz-product-explorer-visual">
              <img
                src="<?= $base ?>/<?= htmlspecialchars($feature['image'], ENT_QUOTES) ?>"
                alt="<?= htmlspecialchars($feature['imageAlt'], ENT_QUOTES) ?>"
                class="xpendz-showcase-image xpendz-product-explorer-image"
                width="310"
                height="650"
                loading="<?= $isActive ? 'eager' : 'lazy' ?>"
                decoding="async"
              >
            </figure>
          </div>

          <div class="xpendz-product-explorer-benefits" aria-label="Beneficios prácticos de <?= htmlspecialchars($feature['label'], ENT_QUOTES) ?>">
            <?php foreach ($feature['benefits'] as $benefit): ?>
            <article class="xpendz-feature-card xpendz-product-explorer-benefit-card">
              <div class="xpendz-product-explorer-benefit-mark" aria-hidden="true">
                <i class="bi bi-check2-circle"></i>
              </div>
              <p class="xpendz-feature-desc"><?= htmlspecialchars($benefit, ENT_QUOTES) ?></p>
            </article>
            <?php endforeach; ?>
          </div>

          <?php if (isset($feature['cta'])): ?>
          <div class="xpendz-product-explorer-panel-actions">
            <?php if ($feature['cta']['type'] === 'feature'): ?>
            <button
              type="button"
              class="xpendz-cta-final-secondary xpendz-product-explorer-next"
              data-next-feature="<?= htmlspecialchars($feature['cta']['target'], ENT_QUOTES) ?>"
              aria-label="Explorar la función <?= htmlspecialchars($feature['cta']['label'], ENT_QUOTES) ?>"
            >
              <i class="bi bi-arrow-right" aria-hidden="true"></i>
              <span><?= htmlspecialchars($feature['cta']['label'], ENT_QUOTES) ?></span>
            </button>
            <?php else: ?>
            <a
              href="<?= htmlspecialchars($feature['cta']['href'], ENT_QUOTES) ?>"
              class="xpendz-cta-final-secondary"
              aria-label="<?= htmlspecialchars($feature['cta']['ariaLabel'], ENT_QUOTES) ?>"
            >
              <i class="bi bi-shield-check" aria-hidden="true"></i>
              <span><?= htmlspecialchars($feature['cta']['label'], ENT_QUOTES) ?></span>
            </a>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </section>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="xpendz-features" id="future-evolution">
  <div class="container">
    <h2 class="xpendz-features-title">Evolución futura</h2>
    <p class="xpendz-features-subtitle">
      Xpendz seguirá evolucionando, pero esta página mantiene una estructura estable: explicar capacidades reales, integrarlas en una misma historia y dejar claro qué valor práctico aportan hoy.
    </p>
    <div class="xpendz-features-grid xpendz-features-page-grid xpendz-features-page-grid--single">
      <article class="xpendz-feature-card">
        <div class="xpendz-feature-icon">
          <i class="bi bi-stars" aria-hidden="true"></i>
        </div>
        <h3 class="xpendz-feature-title">Preparada para crecer sin perder claridad</h3>
        <p class="xpendz-feature-desc">A medida que el producto crezca, las nuevas capacidades deberán integrarse sin romper la historia principal: ayudarte a entender, organizar, planificar y decidir mejor en tu vida financiera diaria.</p>
      </article>
    </div>
  </div>
</section>

<section class="xpendz-cta-final" id="features-next-step">
  <div class="container">
    <div class="xpendz-cta-final-content">
      <h2 class="xpendz-cta-final-title">Continúa hacia la capa de confianza</h2>
      <p class="xpendz-cta-final-text">
        Cuando ya entiendes cómo puede ayudarte Xpendz, el siguiente paso es conocer cómo protege tu información y por qué puedes usarla con confianza.
      </p>
      <div class="xpendz-cta-final-buttons">
        <a href="<?= htmlspecialchars(siteUrl('xpendz/privacidad-y-seguridad'), ENT_QUOTES) ?>" class="xpendz-cta-final-primary" aria-label="Ir a la página de Privacidad y seguridad de Xpendz">
          <i class="bi bi-shield-check" aria-hidden="true"></i>
          <span>Continuar a Privacidad y seguridad</span>
        </a>
      </div>
    </div>
  </div>
</section>

<script>
  (function () {
    const explorer = document.querySelector('[data-product-explorer]');

    if (!explorer) {
      return;
    }

    const tabs = Array.from(explorer.querySelectorAll('[role="tab"]'));
    const panels = Array.from(explorer.querySelectorAll('[role="tabpanel"]'));
    const nextButtons = Array.from(explorer.querySelectorAll('[data-next-feature]'));
    const mobileSelect = explorer.querySelector('[data-feature-select]');

    if (!tabs.length || !panels.length) {
      return;
    }

    const getFeatureIdFromHash = function () {
      const rawHash = window.location.hash.replace('#', '');

      if (!rawHash.startsWith('feature-')) {
        return '';
      }

      return rawHash.slice(8);
    };

    const getTabById = function (featureId) {
      return tabs.find(function (tab) {
        return tab.dataset.featureId === featureId;
      });
    };

    const getPanelById = function (featureId) {
      return panels.find(function (panel) {
        return panel.id === 'xpendz-feature-panel-' + featureId;
      });
    };

    const updateHash = function (featureId) {
      const nextHash = '#feature-' + featureId;

      if (window.history && typeof window.history.replaceState === 'function') {
        window.history.replaceState(null, '', nextHash);
        return;
      }

      window.location.hash = nextHash;
    };

    const activateFeature = function (featureId, options) {
      const settings = Object.assign({
        updateUrl: true,
        focusTarget: null,
        syncSelect: true,
      }, options || {});

      const targetTab = getTabById(featureId);
      const targetPanel = getPanelById(featureId);

      if (!targetTab || !targetPanel) {
        return;
      }

      tabs.forEach(function (tab) {
        const isActive = tab === targetTab;
        tab.classList.toggle('is-active', isActive);
        tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
        tab.setAttribute('tabindex', isActive ? '0' : '-1');
      });

      panels.forEach(function (panel) {
        const isActive = panel === targetPanel;
        panel.hidden = !isActive;
        panel.classList.toggle('is-active', isActive);
      });

      if (mobileSelect && settings.syncSelect) {
        mobileSelect.value = featureId;
      }

      if (settings.updateUrl) {
        updateHash(featureId);
      }

      if (settings.focusTarget === 'tab') {
        targetTab.focus();
      }

      if (settings.focusTarget === 'panel') {
        const panelHeading = targetPanel.querySelector('[data-panel-heading]');

        if (panelHeading) {
          panelHeading.focus();
        }
      }
    };

    const moveFocus = function (currentIndex, direction) {
      const nextIndex = (currentIndex + direction + tabs.length) % tabs.length;
      tabs[nextIndex].focus();
    };

    tabs.forEach(function (tab, index) {
      tab.addEventListener('click', function () {
        activateFeature(tab.dataset.featureId);
      });

      tab.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowDown' || event.key === 'ArrowRight') {
          event.preventDefault();
          moveFocus(index, 1);
          return;
        }

        if (event.key === 'ArrowUp' || event.key === 'ArrowLeft') {
          event.preventDefault();
          moveFocus(index, -1);
          return;
        }

        if (event.key === 'Home') {
          event.preventDefault();
          tabs[0].focus();
          return;
        }

        if (event.key === 'End') {
          event.preventDefault();
          tabs[tabs.length - 1].focus();
          return;
        }

        if (event.key === 'Enter' || event.key === ' ') {
          event.preventDefault();
          activateFeature(tab.dataset.featureId);
        }
      });
    });

    nextButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        activateFeature(button.dataset.nextFeature, { focusTarget: 'panel' });
      });
    });

    if (mobileSelect) {
      mobileSelect.addEventListener('change', function () {
        activateFeature(mobileSelect.value, { syncSelect: false });
      });
    }

    window.addEventListener('hashchange', function () {
      const featureId = getFeatureIdFromHash();

      if (featureId) {
        activateFeature(featureId, { updateUrl: false });
      }
    });

    const initialFeatureId = getFeatureIdFromHash() || tabs[0].dataset.featureId;
    activateFeature(initialFeatureId, { updateUrl: false });
  })();
</script>

<?php include 'includes/footer-xpendz.php'; ?>
