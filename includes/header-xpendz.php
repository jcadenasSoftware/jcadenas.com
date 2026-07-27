<?php
require_once dirname(__DIR__).'/config.php';
/*---------------------------------------------
  Xpendz-specific header - standalone experience
  Shared public header for the Xpendz site
----------------------------------------------*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
      $seoTitle = $pageTitle ?? 'Xpendz | Control de Finanzas Personales';
      $seoDesc = $pageDescription ?? 'Controla tus gastos, ingresos, préstamos y metas financieras de forma simple y segura.';

      $reqPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
      if ($reqPath === '/xpendz.php') { $reqPath = '/xpendz'; }
      if ($reqPath === '/privacidad.php' || $reqPath === '/privacidad') { $reqPath = '/xpendz/privacidad'; }
      if (preg_match('~\.php/+$~i', $reqPath)) { $reqPath = preg_replace('~/+$~', '', $reqPath); }
      $canonical = siteUrl(ltrim($reqPath, '/'));
      $ogImage = siteUrl('assets/img/xpendz-og.png');
    ?>
    <title><?= htmlspecialchars($seoTitle, ENT_QUOTES) ?></title>
    <meta name="description" content="<?= htmlspecialchars($seoDesc, ENT_QUOTES) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical, ENT_QUOTES) ?>">
    <meta property="og:site_name" content="Xpendz">
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
    <meta name="keywords" content="Xpendz, finanzas personales, gastos, ingresos, préstamos, ahorro, control financiero">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= $base ?>/assets/img/favicon.png?v=2" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= $base ?>/assets/img/favicon.png?v=2" sizes="16x16">
    <link rel="icon" type="image/webp" href="<?= $base ?>/assets/img/favicon.webp?v=2" sizes="any">
    <link rel="icon" href="<?= $base ?>/favicon.ico?v=2">
    <link rel="shortcut icon" href="<?= $base ?>/assets/img/favicon.png?v=2">
    <meta name="theme-color" content="#1E6DFF">

    <!-- Preconnects -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css">
    
    <!-- Fonts -->
    <link rel="preload" as="font" href="<?= $base ?>/assets/fonts/Inter-Variable.woff2" type="font/woff2" crossorigin>
    
    <style>
@font-face{font-family:'Inter';src:url('<?= $base ?>/assets/fonts/Inter-Variable.woff2') format('woff2');font-weight:100 900;font-style:normal;font-display:swap}
html{scroll-behavior:smooth;}
html,body{margin:0;padding:0;}
html,body{max-width:100%;overflow-x:hidden;}
*,*::before,*::after{box-sizing:border-box;}
img,video,canvas,svg{max-width:100%;height:auto;}
body{font-family:'Inter',Arial,sans-serif;color:#1a202c;margin:0;padding:0;}
h1,h2,h3,h4,h5{font-weight:700;margin:0;}
.container{width:100%;max-width:1140px;margin-inline:auto;padding-left:1rem;padding-right:1rem;}
    </style>
    <?php if (!empty($pageCssFile)): ?>
    <link rel="stylesheet" href="<?= $base ?>/<?= htmlspecialchars($pageCssFile, ENT_QUOTES) ?>">
    <?php endif; ?>
</head>
<body class="<?= htmlspecialchars(trim('xpendz-page ' . ($pageBodyClass ?? '')), ENT_QUOTES) ?>">
<a href="<?= htmlspecialchars($pageSkipTarget ?? '#hero', ENT_QUOTES) ?>" class="skip-to-content">Saltar al contenido principal</a>
<?php if (!empty($showXpendzNav) && !empty($xpendzNavLinks) && is_array($xpendzNavLinks)): ?>
<header class="xpendz-site-header">
    <div class="container xpendz-site-header-inner">
        <a class="xpendz-site-brand" href="<?= htmlspecialchars($xpendzBrandHref ?? siteUrl('xpendz'), ENT_QUOTES) ?>" aria-label="Xpendz - inicio">
            <img src="<?= $base ?>/assets/img/xpendz.png" alt="Xpendz" class="xpendz-site-brand-logo" width="40" height="40" loading="eager" decoding="async">
            <span class="xpendz-site-brand-name">Xpendz</span>
        </a>
        <nav class="xpendz-site-nav" aria-label="Navegación principal">
            <ul class="xpendz-site-nav-list">
                <?php foreach ($xpendzNavLinks as $navLink): ?>
                    <li class="xpendz-site-nav-item">
                        <a class="xpendz-site-nav-link<?= !empty($navLink['primary']) ? ' xpendz-site-nav-link--primary' : '' ?>" href="<?= htmlspecialchars($navLink['href'], ENT_QUOTES) ?>"><?= htmlspecialchars($navLink['label'], ENT_QUOTES) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
</header>
<?php endif; ?>
    <main id="<?= htmlspecialchars($pageMainId ?? 'xpendz-main', ENT_QUOTES) ?>">
