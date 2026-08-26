<?php
require_once __DIR__ . '/electricista-data.php';

$seoTitle = $pageTitle ?? 'Electricista en Bogotá | Joel Cadenas';
$seoDesc = $pageDescription ?? 'Servicios eléctricos y técnicos en Bogotá con contacto directo por WhatsApp.';
$pageCanonicalPath = $pageCanonicalPath ?? 'electricista';
$canonical = electricistaAbsoluteUrl($pageCanonicalPath);
$pageOgImage = $pageOgImage ?? electricistaData('default_og_image');
if (!$pageOgImage || !electricistaAssetExists($pageOgImage)) {
    $pageOgImage = electricistaData('hero_image');
}
if (!$pageOgImage || !electricistaAssetExists($pageOgImage)) {
    $pageOgImage = 'assets/img/logo.webp';
}
$ogImage = electricistaAbsoluteUrl($pageOgImage);
$pageSchema = $pageSchema ?? electricistaLandingSchema();
$pageBodyClass = trim('electricista-page ' . ($pageBodyClass ?? ''));
$pageMainId = $pageMainId ?? 'electricista-main';
$navLinks = $pageNavLinks ?? electricistaNavigation();
$brandLabel = electricistaData('section_name') ?: 'Electricista Bogotá';
$brandName = electricistaData('brand_name') ?: 'Joel Cadenas';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($seoTitle, ENT_QUOTES) ?></title>
    <meta name="description" content="<?= htmlspecialchars($seoDesc, ENT_QUOTES) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical, ENT_QUOTES) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($brandLabel, ENT_QUOTES) ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($seoTitle, ENT_QUOTES) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($seoDesc, ENT_QUOTES) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical, ENT_QUOTES) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($seoTitle, ENT_QUOTES) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($seoDesc, ENT_QUOTES) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(electricistaAbsoluteUrl('assets/img/electricista/favicon-16x16.png'), ENT_QUOTES) ?>" sizes="16x16">
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(electricistaAbsoluteUrl('assets/img/electricista/favicon-32x32.png'), ENT_QUOTES) ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(electricistaAbsoluteUrl('assets/img/electricista/android-chrome-192x192.png'), ENT_QUOTES) ?>" sizes="192x192">
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(electricistaAbsoluteUrl('assets/img/electricista/android-chrome-512x512.png'), ENT_QUOTES) ?>" sizes="512x512">
    <link rel="apple-touch-icon" sizes="192x192" href="<?= htmlspecialchars(electricistaAbsoluteUrl('assets/img/electricista/apple-touch-icon.png'), ENT_QUOTES) ?>">
    <link rel="icon" href="<?= htmlspecialchars(electricistaAbsoluteUrl('assets/img/electricista/favicon.ico'), ENT_QUOTES) ?>">
    <meta name="theme-color" content="#0b1220">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preload" as="font" href="<?= $base ?>/assets/fonts/Inter-Variable.woff2" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= $base ?>/assets/css/electricista.css?v=<?= htmlspecialchars(electricistaAssetVersion(), ENT_QUOTES) ?>">
    <?php if (!empty($pageSchema)): ?>
    <script type="application/ld+json"><?= json_encode($pageSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?></script>
    <?php endif; ?>
</head>
<body class="<?= htmlspecialchars($pageBodyClass, ENT_QUOTES) ?>">
<!-- <a href="#<?= htmlspecialchars($pageMainId, ENT_QUOTES) ?>" class="electricista-skip-link">Saltar al contenido principal</a> -->
<header class="electricista-header" id="electricista-header">
    <div class="electricista-shell electricista-header-inner">
        <a class="electricista-brand" href="<?= htmlspecialchars(electricistaPageUrl(), ENT_QUOTES) ?>" aria-label="<?= htmlspecialchars($brandName, ENT_QUOTES) ?> - inicio">
            <picture class="electricista-brand-picture">
                <source media="(max-width: 900px)" srcset="<?= htmlspecialchars(electricistaAbsoluteUrl('assets/img/electricista/ui/monograma-jc.png'), ENT_QUOTES) ?>">
                <img class="electricista-brand-image" src="<?= htmlspecialchars(electricistaAbsoluteUrl('assets/img/electricista/ui/logo-header-dark.png'), ENT_QUOTES) ?>" alt="<?= htmlspecialchars($brandName . ' · ' . $brandLabel, ENT_QUOTES) ?>" loading="eager" decoding="async" fetchpriority="high">
            </picture>
        </a>
        <button class="electricista-menu-toggle" id="electricista-menu-toggle" type="button" aria-label="Abrir menú" aria-controls="electricista-mobile-menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="electricista-nav electricista-nav--desktop" aria-label="Navegación principal">
            <ul class="electricista-nav-list">
                <?php foreach ($navLinks as $navLink): ?>
                <li class="electricista-nav-item">
                    <a class="electricista-nav-link<?= !empty($navLink['primary']) ? ' electricista-nav-link--cta' : '' ?><?= !empty($navLink['active']) ? ' is-active' : '' ?>" href="<?= htmlspecialchars($navLink['href'], ENT_QUOTES) ?>"<?= !empty($navLink['external']) ? ' target="_blank" rel="noopener"' : '' ?>><?= htmlspecialchars($navLink['label'], ENT_QUOTES) ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
    <div class="electricista-mobile-menu" id="electricista-mobile-menu" aria-hidden="true">
        <nav class="electricista-mobile-nav" aria-label="Navegación móvil">
            <ul class="electricista-mobile-nav-list">
                <?php foreach ($navLinks as $navLink): ?>
                <li class="electricista-mobile-nav-item">
                    <a class="electricista-mobile-nav-link<?= !empty($navLink['primary']) ? ' electricista-mobile-nav-link--cta' : '' ?><?= !empty($navLink['active']) ? ' is-active' : '' ?>" href="<?= htmlspecialchars($navLink['href'], ENT_QUOTES) ?>"<?= !empty($navLink['external']) ? ' target="_blank" rel="noopener"' : '' ?>><?= htmlspecialchars($navLink['label'], ENT_QUOTES) ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</header>
<main id="<?= htmlspecialchars($pageMainId, ENT_QUOTES) ?>">
