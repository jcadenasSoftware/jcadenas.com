<?php
require_once __DIR__ . '/includes/electricista-data.php';

$pageTitle = 'Electricista en Bogotá | Joel Cadenas';
$pageDescription = 'Servicios eléctricos y técnicos en Bogotá con atención comercial por WhatsApp.';
$pageCanonicalPath = 'electricista';
$pageBodyClass = 'electricista-landing';
$pageSchema = electricistaLandingSchema();
$pageNavLinks = electricistaNavigation('home');
$pageOgImage = electricistaData('default_og_image');
if (!$pageOgImage || !electricistaAssetExists($pageOgImage)) {
    $pageOgImage = electricistaData('hero_image');
}
if (!$pageOgImage || !electricistaAssetExists($pageOgImage)) {
    $pageOgImage = 'assets/img/logo.webp';
}

$services = electricistaData('services') ?? [];
$serviceMap = [];
foreach ($services as $service) {
    if (!empty($service['slug'])) {
        $serviceMap[$service['slug']] = $service;
    }
}

$serviceCategories = [
    [
        'slug' => 'soluciones-electricas',
        'title' => 'Instalaciones y soluciones eléctricas',
        'icon' => '⚡',
        'description' => 'Instalaciones, adecuaciones, reparaciones, mantenimiento, iluminación y apoyo eléctrico para hogares, negocios y proyectos.',
        'service_slugs' => [
            'instalaciones-electricas',
            'reparaciones-electricas',
            'iluminacion',
            'obras-proyectos',
        ],
    ],
    [
        'slug' => 'seguridad-electronica-videovigilancia',
        'title' => 'Seguridad electrónica y videovigilancia',
        'icon' => '📹',
        'description' => 'Sistemas de videovigilancia y detección de incendios para protección, supervisión y control de tus espacios.',
        'service_slugs' => [
            'videovigilancia',
            'deteccion-incendios',
        ],
    ],
    [
        'slug' => 'redes-cableado-estructurado',
        'title' => 'Redes y cableado estructurado',
        'icon' => '🌐',
        'description' => 'Cableado estructurado y organización de puntos de red para una conectividad estable y funcional.',
        'service_slugs' => [
            'redes-cableado-estructurado',
        ],
    ],
    [
        'slug' => 'mantenimiento-ups-respaldo',
        'title' => 'Mantenimiento de UPS y respaldo eléctrico',
        'icon' => '🔋',
        'description' => 'Revisión, mantenimiento y soporte de sistemas UPS y respaldo eléctrico para mantener la continuidad operativa.',
        'service_slugs' => [
            'mantenimiento-ups',
        ],
    ],
];

foreach ($serviceCategories as $index => $category) {
    $includedServices = [];
    foreach ($category['service_slugs'] as $slug) {
        if (!empty($serviceMap[$slug])) {
            $includedServices[] = $serviceMap[$slug];
        }
    }

    $firstService = $includedServices[0] ?? null;
    $serviceCategories[$index]['services'] = $includedServices;
    $serviceCategories[$index]['cta_slug'] = $firstService['slug'] ?? null;
    $serviceCategories[$index]['visual_image'] = $firstService['image'] ?? null;
    $serviceCategories[$index]['visual_alt'] = $firstService['name'] ?? $category['title'];
    $serviceCategories[$index]['has_accordion'] = count($includedServices) > 1;
}

$heroImage = electricistaData('hero_image') ?: 'assets/img/electricista/hero/hero-electricista.webp';
$heroExists = electricistaAssetExists($heroImage);
$showWorkGallery = false;
$whyChooseItems = [
    [
        'title' => 'Atención directa',
        'copy' => 'Comunicación clara para entender lo que necesitas y responderte por WhatsApp.',
    ],
    [
        'title' => 'Soluciones integrales',
        'copy' => 'Electricidad, redes, seguridad electrónica y respaldo eléctrico en un mismo servicio.',
    ],
    [
        'title' => 'Servicio en Bogotá',
        'copy' => 'Atención orientada a hogares, negocios y espacios técnicos en Bogotá.',
    ],
    [
        'title' => 'Contacto rápido',
        'copy' => 'Solicitud de información y seguimiento directo por WhatsApp.',
    ],
];

include __DIR__ . '/includes/header-electricista.php';
?>
<section class="electricista-hero" id="hero">
    <div class="electricista-shell electricista-hero-grid">
        <div class="electricista-hero-copy">
            <p class="electricista-eyebrow">Servicios eléctricos y técnicos · Bogotá</p>
            <p class="electricista-hero-name">Joel Cadenas</p>
            <h1 class="electricista-hero-title"><span>Soluciones eléctricas</span><span>para tu hogar, negocio o proyecto.</span></h1>
            <p class="electricista-hero-subtitle">Instalaciones eléctricas, mantenimiento, iluminación, redes, videovigilancia, detección de incendios y respaldo eléctrico para hogares, negocios y proyectos en Bogotá.</p>
            <div class="electricista-hero-actions">
                <a class="electricista-button electricista-button--primary" href="<?= htmlspecialchars(electricistaWhatsappUrl(), ENT_QUOTES) ?>" target="_blank" rel="noopener">
                    <i class="bi bi-whatsapp"></i>
                    <span>Solicitar servicio por WhatsApp</span>
                </a>
                <a class="electricista-button electricista-button--secondary" href="#servicios">Ver servicios</a>
            </div>
            <ul class="electricista-hero-highlights" aria-label="Resumen rápido">
                <li>Atención directa</li>
                <li>Bogotá y zonas cercanas</li>
                <li>Respuesta por WhatsApp</li>
            </ul>
        </div>
        <div class="electricista-hero-visual">
            <div class="electricista-hero-frame">
                <?php if ($heroExists): ?>
                <img class="electricista-hero-image" src="<?= htmlspecialchars(electricistaAbsoluteUrl($heroImage), ENT_QUOTES) ?>" alt="Infraestructura técnica para servicios eléctricos" loading="eager" decoding="async">
                <?php else: ?>
                <div class="electricista-hero-placeholder" role="img" aria-label="Imagen principal de servicios eléctricos en Bogotá">
                    <span class="electricista-hero-placeholder-icon">⚡</span>
                    <strong>Imagen principal</strong>
                    <p>Servicios eléctricos y técnicos en Bogotá.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="electricista-section" id="servicios">
    <div class="electricista-shell">
        <div class="electricista-section-heading">
            <p class="electricista-eyebrow">Servicios</p>
            <h2 class="electricista-section-title">¿Qué servicio necesitas?</h2>
            <p class="electricista-section-copy">Soluciones técnicas para hogares, negocios y espacios profesionales.</p>
        </div>
        <div class="electricista-services-grid">
            <?php foreach ($serviceCategories as $category): ?>
            <?php $categoryImageExists = !empty($category['visual_image']) && electricistaAssetExists($category['visual_image']); ?>
            <?php $serviceMediaClass = 'electricista-service-media'; ?>
            <?php if ($category['slug'] === 'soluciones-electricas'): ?>
            <?php $serviceMediaClass .= ' electricista-service-media--panel'; ?>
            <?php elseif ($category['slug'] === 'seguridad-electronica-videovigilancia'): ?>
            <?php $serviceMediaClass .= ' electricista-service-media--security'; ?>
            <?php elseif ($category['slug'] === 'redes-cableado-estructurado'): ?>
            <?php $serviceMediaClass .= ' electricista-service-media--network'; ?>
            <?php elseif ($category['slug'] === 'mantenimiento-ups-respaldo'): ?>
            <?php $serviceMediaClass .= ' electricista-service-media--ups'; ?>
            <?php endif; ?>
            <article class="electricista-service-card">
                <div class="<?= htmlspecialchars($serviceMediaClass, ENT_QUOTES) ?>">
                    <?php if ($categoryImageExists): ?>
                    <img src="<?= htmlspecialchars(electricistaAbsoluteUrl($category['visual_image']), ENT_QUOTES) ?>" alt="<?= htmlspecialchars($category['visual_alt'], ENT_QUOTES) ?>" loading="lazy" decoding="async">
                    <?php else: ?>
                    <div class="electricista-service-placeholder" aria-hidden="true">
                        <span><?= htmlspecialchars($category['icon'], ENT_QUOTES) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="electricista-service-body">
                    <h3 class="electricista-service-title"><?= htmlspecialchars($category['title'], ENT_QUOTES) ?></h3>
                    <p class="electricista-service-copy"><?= htmlspecialchars($category['description'], ENT_QUOTES) ?></p>
                    <div class="electricista-service-actions">
                        <a class="electricista-button electricista-button--service" href="<?= htmlspecialchars(electricistaWhatsappUrl($category['cta_slug'] ?: null), ENT_QUOTES) ?>" target="_blank" rel="noopener">Solicitar servicio →</a>
                    </div>
                    <?php if ($category['has_accordion']): ?>
                    <div class="electricista-service-included">
                        <button class="electricista-service-included-toggle" type="button" aria-expanded="false" aria-controls="included-<?= htmlspecialchars($category['slug'], ENT_QUOTES) ?>">
                            <span>Servicios incluidos</span>
                            <span class="electricista-service-included-icon" aria-hidden="true">+</span>
                        </button>
                        <div class="electricista-service-included-panel" id="included-<?= htmlspecialchars($category['slug'], ENT_QUOTES) ?>">
                            <div class="electricista-service-included-panel-inner">
                                <ul class="electricista-service-included-list">
                                    <?php foreach ($category['services'] as $includedService): ?>
                                    <li><?= htmlspecialchars($includedService['name'], ENT_QUOTES) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="electricista-section electricista-section--alt" id="porque-elegir">
    <div class="electricista-shell">
        <div class="electricista-section-heading">
            <p class="electricista-eyebrow">¿Por qué elegir este servicio?</p>
            <h2 class="electricista-section-title">Soluciones claras, directas y orientadas a tu necesidad</h2>
        </div>
        <div class="electricista-benefits-grid">
            <?php foreach ($whyChooseItems as $item): ?>
            <article class="electricista-benefit-card">
                <h3><?= htmlspecialchars($item['title'], ENT_QUOTES) ?></h3>
                <p><?= htmlspecialchars($item['copy'], ENT_QUOTES) ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if ($showWorkGallery): ?>
<section class="electricista-section" id="trabajos">
    <div class="electricista-shell">
        <div class="electricista-section-heading">
            <p class="electricista-eyebrow">Trabajos realizados</p>
            <h2 class="electricista-section-title">Galería de trabajos reales</h2>
            <p class="electricista-section-copy">Fotografías reales de instalaciones, mantenimientos y proyectos ejecutados.</p>
        </div>
        <div class="electricista-work-grid">
            <article class="electricista-work-card">
                <div class="electricista-work-placeholder">Trabajo 01</div>
                <p>Instalaciones y adecuaciones.</p>
            </article>
            <article class="electricista-work-card">
                <div class="electricista-work-placeholder">Trabajo 02</div>
                <p>Mantenimiento e iluminación.</p>
            </article>
            <article class="electricista-work-card">
                <div class="electricista-work-placeholder">Trabajo 03</div>
                <p>Proyectos, videovigilancia y respaldo.</p>
            </article>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="electricista-section electricista-section--conversion" id="cobertura">
    <div class="electricista-shell electricista-conversion-panel">
        <div class="electricista-conversion-copy">
            <p class="electricista-eyebrow">Cobertura y contacto</p>
            <h2 class="electricista-section-title">¿Necesitas una solución eléctrica o técnica?</h2>
            <p class="electricista-section-copy">Atiendo servicios eléctricos y técnicos en Bogotá y zonas cercanas, según disponibilidad. Cuéntame qué necesitas y conversemos sobre tu instalación, mantenimiento o proyecto.</p>
            <p class="electricista-conversion-badge"><?= htmlspecialchars(electricistaData('coverage') ?: 'Bogotá y zonas cercanas, según disponibilidad.', ENT_QUOTES) ?></p>
        </div>
        <div class="electricista-conversion-actions">
            <a class="electricista-button electricista-button--primary electricista-button--contact" href="<?= htmlspecialchars(electricistaWhatsappUrl(), ENT_QUOTES) ?>" target="_blank" rel="noopener">
                <i class="bi bi-whatsapp"></i>
                <span>Hablar por WhatsApp</span>
            </a>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer-electricista.php'; ?>
