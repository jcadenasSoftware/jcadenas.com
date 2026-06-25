<?php
require_once dirname(__DIR__).'/config.php';
/*---------------------------------------------
  Shared site header
  Includes <head>, navigation bar, and opening <body>
  Uses Bootstrap 5 from CDN for quick styling
----------------------------------------------*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
      $current = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
      $seoTitle = 'JCadenas | Desarrollo de Software';
      $seoDesc  = 'Aplicaciones web, móviles y soluciones digitales personalizadas. Mira mi trabajo y contáctame.';

      if (!empty($pageTitle)) { $seoTitle = $pageTitle; }
      if (!empty($pageDescription)) { $seoDesc = $pageDescription; }

      switch ($current) {
        case 'index.php':
          $seoTitle = $seoTitle ?: 'JCadenas | Desarrollo de Software';
          break;
        case 'about.php':
          $seoTitle = $pageTitle ?? 'Sobre mí | JCadenas';
          $seoDesc  = $pageDescription ?? 'Conoce mi experiencia, habilidades y formación como desarrollador de software.';
          break;
        case 'services.php':
          $seoTitle = $pageTitle ?? 'Servicios | JCadenas';
          $seoDesc  = $pageDescription ?? 'Desarrollo web, aplicaciones móviles y soluciones a medida. Solicita tu proyecto.';
          break;
        case 'portfolio.php':
          $seoTitle = $pageTitle ?? 'Portafolio | JCadenas';
          $seoDesc  = $pageDescription ?? 'Proyectos y soluciones desarrolladas: web, móvil y escritorio.';
          break;
        case 'store.php':
          $seoTitle = $pageTitle ?? 'Tienda | JCadenas';
          $seoDesc  = $pageDescription ?? 'Proyectos y código fuente disponibles para compra y descarga.';
          break;
        case 'contact.php':
          $seoTitle = $pageTitle ?? 'Contacto | JCadenas';
          $seoDesc  = $pageDescription ?? 'Contáctame para cotizaciones, soporte o propuestas de trabajo.';
          break;
        case 'cv.php':
          $seoTitle = $pageTitle ?? 'Currículum | JCadenas';
          $seoDesc  = $pageDescription ?? 'Currículum corto listo para imprimir y descargar.';
          break;
        case 'resume.php':
          $seoTitle = $pageTitle ?? 'Resume (EN) | JCadenas';
          $seoDesc  = $pageDescription ?? 'English resume, ready to print and download.';
          break;
      }

      $reqPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
      if ($reqPath === '/index.php') { $reqPath = '/'; }
      if (preg_match('~\.php/+$~i', $reqPath)) { $reqPath = preg_replace('~/+$~', '', $reqPath); }
      $canonical = siteUrl(ltrim($reqPath, '/'));
      $ogImage = !empty($pageOgImage) ? siteUrl(ltrim($pageOgImage, '/')) : siteUrl('assets/img/logo.webp');
    ?>
    <title><?= htmlspecialchars($seoTitle, ENT_QUOTES) ?></title>
    <meta name="description" content="<?= htmlspecialchars($seoDesc, ENT_QUOTES) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical, ENT_QUOTES) ?>">
    <meta property="og:site_name" content="JCadenas">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($seoTitle, ENT_QUOTES) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($seoDesc, ENT_QUOTES) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical, ENT_QUOTES) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= htmlspecialchars($seoTitle, ENT_QUOTES) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($seoDesc, ENT_QUOTES) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImage, ENT_QUOTES) ?>">
    <!-- SEO basics -->
    <meta name="keywords" content="joel cadenas, desarrollador freelance, software, java, python, php, web, mobile">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= $base ?>/assets/img/favicon.png?v=2" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= $base ?>/assets/img/favicon.png?v=2" sizes="16x16">
    <link rel="icon" type="image/webp" href="<?= $base ?>/assets/img/favicon.webp?v=2" sizes="any">
    <link rel="icon" href="<?= $base ?>/favicon.ico?v=2">
    <link rel="shortcut icon" href="<?= $base ?>/assets/img/favicon.png?v=2">

    <!-- Preconnects for faster font/CDN resolution -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    <!-- Bootstrap 5 CSS (local-first): only on pages that need full framework -->
    <?php $needsBsCss = in_array($current, ['portfolio.php','store.php']); ?>
    <?php if ($needsBsCss): ?>
      <link rel="preload" as="style" href="<?= $base ?>/assets/css/bootstrap.min.css">
      <link href="<?= $base ?>/assets/css/bootstrap.min.css" rel="stylesheet" media="print" onload="this.media='all'">
      <noscript><link href="<?= $base ?>/assets/css/bootstrap.min.css" rel="stylesheet"></noscript>
      <script>
        // Fallback to CDN if local Bootstrap CSS failed to apply
        (function(){
          var checkApplied=function(){
            var probe=document.createElement('div');
            probe.className='container';
            probe.style.position='absolute';probe.style.visibility='hidden';
            document.documentElement.appendChild(probe);
            var mw = parseFloat(getComputedStyle(probe).maxWidth||'0');
            probe.remove();
            return mw>0; // Bootstrap sets .container max-width at breakpoints
          };
          if(!checkApplied()){
            var cdn=document.createElement('link');
            cdn.rel='stylesheet';
            cdn.href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css';
            document.head.appendChild(cdn);
          }
        })();
      </script>
    <?php endif; ?>
    <!-- Bootstrap Icons (CDN to guarantee rendering) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css">
    <!-- Self-hosted fonts preload (WOFF2) -->
    <link rel="preload" as="font" href="<?= $base ?>/assets/fonts/Inter-Variable.woff2" type="font/woff2" crossorigin>
    <link rel="preload" as="font" href="<?= $base ?>/assets/fonts/FiraCode-Regular.woff2" type="font/woff2" crossorigin>
    <!-- Preload hero images only where used -->
    <?php if ($current === 'index.php'): ?>
      <link rel="preload" as="image" href="<?= $base ?>/assets/img/hero-bg.webp" type="image/webp" imagesrcset="<?= $base ?>/assets/img/hero-bg.webp" imagesizes="100vw" fetchpriority="high" />
    <?php endif; ?>
    <?php if ($current === 'portfolio.php'): ?>
      <link rel="preload" as="image" href="<?= $base ?>/assets/img/hero_portfolio.webp" imagesrcset="<?= $base ?>/assets/img/hero_portfolio.webp" fetchpriority="high" />
    <?php endif; ?>
    <!-- Inline critical site CSS (in place of assets/css/styles.css) -->
    <style>
@font-face{font-family:'Inter';src:url('<?= $base ?>/assets/fonts/Inter-Variable.woff2') format('woff2');font-weight:100 900;font-style:normal;font-display:swap}
@font-face{font-family:'Fira Code';src:url('<?= $base ?>/assets/fonts/FiraCode-Regular.woff2') format('woff2');font-weight:400;font-style:normal;font-display:swap}
html{scroll-behavior:smooth;}
html,body{margin:0;}
html,body{max-width:100%;overflow-x:hidden;}
*,*::before,*::after{box-sizing:border-box;}
img,video,canvas,svg{max-width:100%;height:auto;}

/* -------------------------------------------
   Custom styles for JCadenas site
   Color palette: blue/gray with orange accents
-------------------------------------------- */
:root { --primary:#0d6efd; --dark:#212529; --accent:#fd7e14; }
body{font-family:'Inter',Arial,sans-serif;color:var(--dark);} 
pre,code,.code-font{font-family:'Fira Code',monospace;}
h1,h2,h3,h4,h5{font-weight:700;}
/* Critical typography to minimize CLS before Bootstrap loads */
.display-4{font-size:clamp(2.25rem,4vw + 1rem,3.5rem);line-height:1.2;margin-bottom:1rem;}
.display-5{font-size:clamp(1.75rem,3.2vw + .5rem,2.5rem);line-height:1.2;font-weight:700;}
.lead{font-size:1.25rem;font-weight:300;}
/* Minimal critical utilities to stabilize layout before Bootstrap */
.mb-3{margin-bottom:1rem;}
.d-grid{display:grid;}
.gap-2{gap:.5rem;}
.px-4{padding-left:1.5rem;padding-right:1.5rem;}
.mt-4{margin-top:1.5rem;}
.mt-5{margin-top:3rem;}
.mt-3{margin-top:1rem;}
.btn{display:inline-block;padding:.375rem .75rem;line-height:1.5;border-radius:.375rem;text-align:center;text-decoration:none;}
.btn:link,.btn:visited,.btn:hover,.btn:focus{ text-decoration:none; }
.btn-lg{padding:.5rem 1rem;font-size:1.25rem;}
.btn-sm{padding:.25rem .5rem;font-size:.875rem;}
.btn-outline-light{color:#f8f9fa;border:1px solid rgba(248,249,250,.5);background:transparent;}
 /* Additional minimal utilities to avoid loading full Bootstrap on simple pages */
.flex-column{flex-direction:column;}
.gap-3{gap:1rem;}
.shadow-lg{box-shadow:0 1rem 3rem rgba(0,0,0,.175);}
  .container{width:100%;max-width:1140px;margin-inline:auto;padding-left:1rem;padding-right:1rem;}
  .text-center{text-align:center;}
  .mb-0{margin-bottom:0;}
 .mb-2{margin-bottom:.5rem;}
 .mb-4{margin-bottom:1.5rem;}
 .mb-5{margin-bottom:3rem;}
 .me-1{margin-right:.25rem;}
 .me-2{margin-right:.5rem;}
 .w-100{width:100%;}
 .h-100{height:100%;}
 .shadow-sm{box-shadow:0 .125rem .25rem rgba(0,0,0,.075);} 
 .shadow-lg{box-shadow:0 1rem 3rem rgba(0,0,0,.175);} 
 .border-0{border:0;}
 /* Limit custom grid to services section on home to avoid overriding Bootstrap grid elsewhere */
 #services-tech .row.g-4{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;}
 .card{background:#fff;border:1px solid rgba(0,0,0,.125);border-radius:.5rem;overflow:hidden;}
 .card-body{padding:1rem;}
 .card-title{font-size:1.125rem;margin-bottom:.5rem;font-weight:600;}
 .card-text{color:#555;}
 .text-muted{color:#6c757d !important;}
 .btn-primary{background-color:#0d6efd;border:1px solid #0d6efd;color:#fff;}
 .btn-primary:hover{background-color:#0b5ed7;border-color:#0a58ca;color:#fff;}
 .btn-success{background-color:#198754;border:1px solid #198754;color:#fff;}
 .btn-success:hover{background-color:#157347;border-color:#146c43;color:#fff;}
 .btn-outline-primary{color:#0d6efd;border:1px solid #0d6efd;background:transparent;}
 .btn-outline-primary:hover{background:#0d6efd;color:#fff;}
 .btn-outline-primary{border-width:2px;}
 .btn-outline-success{color:#198754;border:1px solid #198754;background:transparent;}
 .btn-outline-success:hover{background:#198754;color:#fff;}
 .btn-outline-secondary{color:#6c757d;border:1px solid #6c757d;background:transparent;}
 .btn-outline-secondary:hover{background:#6c757d;color:#fff;}
 .btn-icon{display:inline-flex;align-items:center;gap:.5rem;}
 /* Minimal navbar + utilities (for pages without full Bootstrap CSS) */
 .d-flex{display:flex;}
 .flex-column{flex-direction:column;}
 .align-items-center{align-items:center;}
 .align-self-start{align-self:flex-start;}
 .ms-auto{margin-left:auto;}
 .text-md-start{text-align:center;}
 .bg-dark{background-color:#212529 !important;color:#fff;}
 .navbar{position:fixed;top:0;left:0;right:0;z-index:1030;width:100%;padding:.5rem 0;}
 body{padding-top:72px;}
 .navbar-dark .navbar-brand,.navbar-dark .nav-link{color:rgba(255,255,255,.85);} 
 .navbar-dark .nav-link:hover{color:#fff;}
 .navbar-dark .nav-link.active{color:#fff;background:rgba(255,255,255,.10);box-shadow:inset 0 0 0 1px rgba(255,255,255,.14);}
 .navbar .container{display:flex;align-items:center;min-height:64px;}
 .navbar-collapse{flex:1;display:flex;justify-content:flex-end;align-items:center;}
 .navbar-nav{display:flex;gap:.25rem;list-style:none;margin:0;padding:0;}
 .nav-link{display:block;padding:.5rem .75rem;text-decoration:none;border-radius:.25rem;font-size:1rem;}
 /* Push brand left and menu right on desktop */
 @media (min-width: 992px){
   .navbar-brand{margin-right:auto;}
 }
 .navbar-brand{display:inline-flex;align-items:center;text-decoration:none;color:inherit;margin-right:1rem;}
 .navbar-toggler{display:inline-flex;align-items:center;justify-content:center;padding:.25rem .5rem;border:1px solid rgba(255,255,255,.25);background:transparent;color:#fff;border-radius:.25rem;}
 .navbar-toggler{line-height:1;}
 .navbar-toggler:focus{outline:2px solid rgba(255,255,255,.5);outline-offset:2px;}
 .navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;background-repeat:no-repeat;background-position:center;background-size:100% 100%;
   background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,0.85)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");}
 .collapse{transition:height .2s ease;}
 @media (max-width: 991.98px){
   .navbar .collapse{display:none;}
   .navbar .collapse.show{display:block;}
   .navbar-nav{flex-direction:column;gap:.15rem;padding:.5rem 0;align-items:stretch;}
   .navbar .container{position:relative;}
   .navbar-collapse{justify-content:initial;align-items:stretch;}
   .navbar .collapse.show{position:absolute;left:0;right:0;top:100%;background:#212529;color:#fff;border-top:1px solid rgba(255,255,255,.08);box-shadow:0 .75rem 2rem rgba(0,0,0,.35);padding:.65rem .85rem;border-bottom-left-radius:1rem;border-bottom-right-radius:1rem;max-height:calc(100vh - 72px);overflow:auto;}
   .navbar-nav{padding:.15rem 0;margin:0;}
   .nav-link{font-size:1.05rem;padding:.8rem .9rem;border-radius:.75rem;text-align:left;}
   .nav-link:hover{background:rgba(255,255,255,.08);}
   .nav-link.active{background:rgba(255,255,255,.14);box-shadow:inset 0 0 0 1px rgba(255,255,255,.16);}
 }
 @media (max-width: 575.98px){
   .navbar{padding:calc(.55rem + env(safe-area-inset-top)) 0 .55rem;}
   .navbar .container{min-height:72px;gap:.5rem;}
   .logo-img{width:132px;height:auto;}
   .navbar-toggler{width:44px;height:44px;padding:0;display:grid;place-items:center;box-sizing:border-box;flex:0 0 auto;align-self:center;}
   .navbar-toggler-icon{width:1.25em;height:1.25em;}
   .nav-link{padding:.55rem .75rem;}

   .navbar-brand{max-width:calc(100% - 56px);}
 
   .container,.container-narrow{max-width:100%;}
   .lead{font-size:1.1rem;}
   #about-intro p{text-align:left;}
   .profile-img{width:min(180px, 62vw) !important;height:auto !important;}
   .hero.hero-compact{min-height:22vh;}
   .hero picture{display:block;max-width:100%;}
 }
 @media (min-width: 992px){
   .navbar-toggler{display:none;}
   .navbar .collapse{display:block !important;}
   /* Ensure menu aligns to the right on desktop */
   .navbar-nav{margin-left:auto;justify-content:flex-end;}
  }

 /* Minimal responsive utilities used by About hero when Bootstrap is not loaded */
 @media (min-width:768px){
   .flex-md-row{flex-direction:row;}
   .text-md-start{text-align:left;}
   .ms-md-4{margin-left:1.5rem;}
   .me-md-4{margin-right:1.5rem;}
   .mb-md-0{margin-bottom:0;}
 }
 /* Responsive utilities needed by hero buttons */
 @media (min-width: 576px){
   .d-sm-flex{display:flex;}
   .justify-content-sm-center{justify-content:center;}
   .me-sm-3{margin-right:1rem;}
 }
 /* Home: About section two-column layout without Bootstrap */
 #about-intro .row{display:grid;grid-template-columns:1fr;gap:1.5rem;}
 @media (min-width:768px){
   #about-intro .row{grid-template-columns:1fr 2fr;align-items:center;}
 }
 /* About page: two-column layout (Experiencia / Educación) */
 #about-page .row{display:grid;grid-template-columns:1fr;gap:2rem;}
 @media(min-width:992px){#about-page .row{grid-template-columns:1fr 1fr;}}
 #about-page .timeline{position:relative;padding-left:1rem;border-left:3px solid #e9ecef;}
 #about-page .timeline li{list-style:none;}
 #about-page .timeline h5{margin:0;}
 /* Footer minimal styling and utilities (scoped) */
 .footer{color:#f8f9fa;}
 .footer h5{font-size:1.25rem;}
 .text-light{color:#f8f9fa !important;}
 .py-3{padding-top:1rem;padding-bottom:1rem;}
 .py-5{padding-top:1rem;padding-bottom:1rem;}
 .my-4{margin-top:1.5rem;margin-bottom:1.5rem;}
 .gap-3{gap:1rem;}
 .fs-4{font-size:1.5rem;}
 .list-unstyled{list-style:none;margin:0;padding:0;}
 .text-decoration-none{text-decoration:none;}
 .border-secondary{border-color:#6c757d !important;}
 .small{font-size:1rem;}
 .fw-bold{font-weight:700;}
 .gy-4{row-gap:1.5rem;}
 .footer a{color:#f8f9fa;text-decoration:none;}
 .footer a:hover{opacity:.85;}
 /* Footer grid scoped to footer only to avoid conflicts with portfolio */
 .footer .row{display:grid;grid-template-columns:1fr;column-gap:1.5rem;}
  @media (min-width:768px){
    .footer .row{grid-template-columns:repeat(3,1fr);} 
  }
 /* Services grid: 3 per row on desktop */
 #services .row.g-4{display:grid;gap:1.5rem;grid-template-columns:repeat(1,minmax(0,1fr));}
 @media(min-width:768px){#services .row.g-4{grid-template-columns:repeat(2,1fr);}}
 @media(min-width:992px){#services .row.g-4{grid-template-columns:repeat(3,1fr);}}
 /* Contact page cards grid */
 #contact-page .row.g-4{display:grid;gap:1.25rem;grid-template-columns:repeat(1,minmax(0,1fr));margin-bottom:2rem;}
 @media(min-width:992px){#contact-page .row.g-4{grid-template-columns:repeat(3,1fr);margin-bottom:2.5rem;}}
 /* Contact page card polish */
 #contact-page .card{position:relative;border-radius:.75rem;border-color:rgba(0,0,0,.08);background:linear-gradient(180deg,#ffffff, #fcfcfd);} 
 #contact-page .card::before{content:"";position:absolute;inset:0 0 auto 0;height:4px;border-top-left-radius:.75rem;border-top-right-radius:.75rem;background:#e9ecef;}
 #contact-page .card:hover{box-shadow:0 .5rem 1.25rem rgba(0,0,0,.08);transform:translateY(-2px);transition:box-shadow .2s ease, transform .2s ease;}
 #contact-page .card-body{display:flex;flex-direction:column;gap:.5rem;}
 #contact-page .card-title{display:flex;align-items:center;gap:.5rem;}
 #contact-page .card-title i.bi{display:inline-grid;place-items:center;width:2rem;height:2rem;font-size:1.1rem;background:#f1f3f5;border-radius:50%;}
 #contact-page .card .btn{margin-top:auto;align-self:flex-start;}
 /* Accents por tipo (orden en la grilla) */
 #contact-page .row.g-4 > *:nth-child(1) .card::before{background:#198754;} /* WhatsApp */
 #contact-page .row.g-4 > *:nth-child(2) .card::before{background:#0d6efd;} /* Correo */
 #contact-page .row.g-4 > *:nth-child(3) .card::before{background:#6c757d;} /* Redes */
 /* Contact page form grid */
 #contact-page .form-grid{display:grid;gap:1rem;grid-template-columns:1fr;}
 @media(min-width:768px){#contact-page .form-grid{grid-template-columns:1fr 1fr;}}
 #contact-page .form-grid .full{grid-column:1 / -1;}
 /* Modal video presentation */
 .modal .ratio{background:#000;border-radius:.5rem;overflow:hidden;}
 .modal .lite-embed{outline:0;}
 /* Technology badge colors */
 .tech-badge{display:inline-flex;align-items:center;gap:.25rem;padding:.25rem .5rem;border-radius:999px;font-weight:600;border:1px solid rgba(0,0,0,.15);}
 .tech-badge img{display:inline-block;}
 .tech-java{background:#fff3e0;color:#d35400;border-color:#f5cba7;}
 .tech-android{background:#eaf7ea;color:#2e7d32;border-color:#c5e1c5;}
 .tech-python{background:#e8f0fe;color:#1a73e8;border-color:#c6dafc;}
 .tech-web{background:#fff1e6;color:#e34f26;border-color:#f7c9b8;} /* HTML5 */
 .tech-php{background:#efeaff;color:#6f42c1;border-color:#d8c8ff;}
 .tech-dotnet{background:#f2e8ff;color:#5c2d91;border-color:#dcc7ff;}
 .tech-react{background:#e6f7fb;color:#00bcd4;border-color:#c3ecf6;}
 .tech-angular{background:#ffebee;color:#d32f2f;border-color:#f8c6cc;}
 /* Portfolio tech filter buttons */
 .filter-tech .btn{border:1px solid rgba(0,0,0,.2); background:transparent; font-weight:600;}
 .filter-tech .btn + .btn{margin-left:.25rem}
 .filter-tech .btn.active{box-shadow:0 0 0 .15rem rgba(0,0,0,.05)}
 .filter-tech .btn.tech-java{color:#d35400;border-color:#d35400}
 .filter-tech .btn.tech-java:hover,
 .filter-tech .btn.tech-java.active{background:#fff3e0;color:#d35400;border-color:#f5cba7}
 .filter-tech .btn.tech-android{color:#2e7d32;border-color:#2e7d32}
 .filter-tech .btn.tech-android:hover,
 .filter-tech .btn.tech-android.active{background:#eaf7ea;color:#2e7d32;border-color:#c5e1c5}
 .filter-tech .btn.tech-python{color:#1a73e8;border-color:#1a73e8}
 .filter-tech .btn.tech-python:hover,
 .filter-tech .btn.tech-python.active{background:#e8f0fe;color:#1a73e8;border-color:#c6dafc}
 .filter-tech .btn.tech-web{color:#e34f26;border-color:#e34f26}
 .filter-tech .btn.tech-web:hover,
 .filter-tech .btn.tech-web.active{background:#fff1e6;color:#e34f26;border-color:#f7c9b8}
 .filter-tech .btn.tech-php{color:#6f42c1;border-color:#6f42c1}
 .filter-tech .btn.tech-php:hover,
 .filter-tech .btn.tech-php.active{background:#efeaff;color:#6f42c1;border-color:#d8c8ff}
 .filter-tech .btn.tech-dotnet{color:#5c2d91;border-color:#5c2d91}
 .filter-tech .btn.tech-dotnet:hover,
 .filter-tech .btn.tech-dotnet.active{background:#f2e8ff;color:#5c2d91;border-color:#dcc7ff}
 .filter-tech .btn.tech-react{color:#00bcd4;border-color:#00bcd4}
 .filter-tech .btn.tech-react:hover,
 .filter-tech .btn.tech-react.active{background:#e6f7fb;color:#00bcd4;border-color:#c3ecf6}
 .filter-tech .btn.tech-angular{color:#d32f2f;border-color:#d32f2f}
 .filter-tech .btn.tech-angular:hover,
 .filter-tech .btn.tech-angular.active{background:#ffebee;color:#d32f2f;border-color:#f8c6cc}
 /* Services page form grid (Solicitar presupuesto) */
 #solicitud .form-grid{display:grid;gap:1rem;grid-template-columns:1fr;}
 @media(min-width:768px){#solicitud .form-grid{grid-template-columns:1fr 1fr;}}
 #solicitud .form-grid .full{grid-column:1 / -1;}
 /* Minimal form controls and alerts (for pages sin Bootstrap) */
 .form-label{display:block;margin-bottom:.25rem;font-weight:600;}
 .form-control,.form-select{display:block;width:100%;padding:.625rem .875rem;border:1px solid #ced4da;border-radius:.5rem;line-height:1.5;background:#fff;color:#212529;}
 .form-select{appearance:auto}
 .form-control:focus,.form-select:focus{outline:none;border-color:#86b7fe;box-shadow:0 0 0 .2rem rgba(13,110,253,.15);} 
 .form-control.is-invalid,.form-select.is-invalid{border-color:#dc3545;}
 .form-control.is-invalid:focus,.form-select.is-invalid:focus{box-shadow:0 0 0 .2rem rgba(220,53,69,.15);} 
 .input-group{display:flex;align-items:stretch;width:100%;}
 .input-group-text{display:inline-flex;align-items:center;padding:.625rem .875rem;background:#fff;border:1px solid #ced4da;border-right:0;border-radius:.5rem 0 0 .5rem;color:#6c757d}
 .input-group .form-control{border-left:0;border-radius:0 .5rem .5rem 0}
 .alert{padding:.75rem 1rem;border-radius:.375rem;margin-bottom:1rem;}
 .alert-success{background:#d1e7dd;color:#0f5132;border:1px solid #badbcc;}
 .alert-danger{background:#f8d7da;color:#842029;border:1px solid #f5c2c7;}
 .invalid-feedback{display:none;color:#dc3545;font-size:.875rem;margin-top:.25rem;}
 .input-group.invalid + .invalid-feedback{display:block;}
.btn-accent{background-color:var(--accent);color:#fff;}
.btn-accent:hover{background-color:#e76d04;color:#fff;}
:root{--spacing-section:5rem;--max-width:1140px;}
.section{padding:var(--spacing-section) 0;}
.section-light{background:#f8f9fa;}
.section-dark{background:var(--dark);color:#fff;}
.section-accent{background:var(--accent);color:#fff;}
.section h2{margin-bottom:2rem;}
.container-narrow{max-width:var(--max-width);margin-inline:auto;}
.card-soft{border:none;box-shadow:0 2px 8px rgba(0,0,0,.05);transition:box-shadow .3s;}
.card-soft:hover{box-shadow:0 4px 16px rgba(0,0,0,.08);} 
/* Hero section */
.hero{position:relative;overflow:hidden;}
.hero .hero-bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:0;}
.hero .hero-content{position:relative;z-index:1;text-align:center;}
.hero{position:relative;display:flex;align-items:flex-start;justify-content:center;min-height:60vh;padding:2rem 0 3rem;background-position:center;background-size:cover;background-repeat:no-repeat;color:#fff;text-align:center;}
.hero.hero-compact{min-height:34vh;}
.hero::before{content:"";position:absolute;inset:0;background:rgba(0,0,0,.45);} 
.hero .hero-content{position:relative;z-index:1;max-width:900px;margin-inline:auto;padding:0 1rem;}
.hero .site-desc{font-size:1.1rem;color:#ddd;}
/* Logo brand */
.logo-img{width:149px;height:42px;display:block;border-radius:.5rem;}
/* Profile image */
.profile-img{width:220px !important;height:361px !important;display:block;border-radius:.5rem;object-fit:cover;box-shadow:0 4px 12px rgba(0,0,0,.15);} 
/* Visual differentiation */
#services-tech{background:#ffffff;background-image:radial-gradient(circle at 1px 1px,#e0e4ec 1px,transparent 0);background-size:24px 24px;}
#services-tech .card{border:none;box-shadow:0 2px 8px rgba(0,0,0,.05);transition:transform .3s, box-shadow .3s;}
#services-tech .card:hover{transform:translateY(-6px);box-shadow:0 6px 20px rgba(0,0,0,.1);} 
/* Defer below-the-fold rendering to improve LCP */
#about-intro, #services-tech, #portfolio-preview{content-visibility:auto;contain-intrinsic-size:1px 1000px;}
/* Animations */
.fade-slide{opacity:0;transform:translateY(40px);transition:opacity .6s ease-out,transform .6s ease-out;}
.fade-slide.show{opacity:1;transform:none;}
/* Brighter overlay for portfolio hero */
.portfolio-hero::before{background:rgba(0,0,0,0.35);backdrop-filter:brightness(0.8);} 
/* Services section cards */
#services .service-card{position:relative;border:none;border-radius:14px;box-shadow:0 6px 18px rgba(16,24,40,.08);transition:transform .25s ease, box-shadow .25s ease;background:#ffffff;}
#services .service-card::before{content:"";position:absolute;inset:0 0 auto 0;height:4px;border-top-left-radius:14px;border-top-right-radius:14px;background:linear-gradient(90deg,#0d6efd,#6f42c1,#20c997);background-size:200% 100%;animation:barShift 6s linear infinite;}
@keyframes barShift{0%{background-position:0 0}100%{background-position:200% 0}}
#services .service-card .card-body{padding:1.25rem 1.25rem 1.5rem}
#services .service-card .card-title{display:flex;align-items:center;gap:.5rem;font-weight:700;}
#services .service-card .card-title i{display:inline-flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:999px;color:#fff;background:linear-gradient(135deg,#0d6efd,#6f42c1);box-shadow:0 6px 14px rgba(13,110,253,.25);} 
#services .service-card .card-text{color:#5f6b7a}
#services .service-card:hover{transform:translateY(-8px);box-shadow:0 14px 30px rgba(16,24,40,.16);} 
/* Background for services section */
#services{position:relative;background:url('<?= $base ?>/assets/img/services_bg.webp') center/cover no-repeat,radial-gradient(800px 400px at 10% -10%, rgba(13,110,253,0.10), transparent 60%),radial-gradient(700px 380px at 110% 0%, rgba(111,66,193,0.10), transparent 60%),radial-gradient(600px 320px at 90% 120%, rgba(32,201,151,0.12), transparent 60%),linear-gradient(180deg,#f8f9fb 0%, #eef1f7 100%);} 
#services::after{content:"";position:absolute;inset:0;pointer-events:none;background:radial-gradient(1px 1px at 8% 20%, rgba(16,24,40,.06) 50%, transparent 51%),radial-gradient(1px 1px at 18% 40%, rgba(16,24,40,.04) 50%, transparent 51%),radial-gradient(1px 1px at 78% 30%, rgba(16,24,40,.05) 50%, transparent 51%);opacity:.7;}
/* Request form section background (same image, stronger overlay) */
#solicitud{position:relative;background:url('<?= $base ?>/assets/img/services_bg.webp') center/cover no-repeat,linear-gradient(180deg,#f8f9fb 0%, #eef1f7 100%);} 
#solicitud::before{content:"";position:absolute;inset:0;background:rgba(255,255,255,0.82);pointer-events:none;}
#solicitud .container{position:relative;z-index:1;}
/* Light background for intro section */
#about-intro{position:relative;background:url('<?= $base ?>/assets/img/services_bg.webp') center/cover no-repeat,linear-gradient(180deg,#f8f9fb 0%, #eef1f7 100%);color:#fff;}
#about-intro::before{content:"";position:absolute;inset:0;background:rgba(0,0,0,0.5);backdrop-filter:brightness(0.85);pointer-events:none;}
#about-intro .container{position:relative;z-index:1;}
#about-intro p{text-align:left;}
.hero .hero-content{position:relative;z-index:1;text-align:center;}
/* Bootstrap Icons font-face is provided by assets/css/bootstrap-icons.css */
/* Payment logos styling */
.payments-logos{--paylogo-h:32px}
/* chip container for both imgs and fallback badges */
.payments-logos>img,
.payments-logos>.badge{
  display:inline-flex;align-items:center;justify-content:center;
  height:calc(var(--paylogo-h) + 12px);
  padding:6px 10px;
  border:1px solid #dee2e6;border-radius:.5rem;background:#fff;
}
/* image inside chip: keep original colors */
.payments-logos img{height:var(--paylogo-h)!important;width:auto;object-fit:contain;max-width:140px}
/* Slight boost for smaller-looking logos */
.payments-logos img[src*="daviplata"],
.payments-logos img[src*="movii"]{height:calc(var(--paylogo-h) + 6px)!important}
/* fallback badge text/icon */
.payments-logos .badge{gap:.4rem;line-height:1;font-size:.9rem;background:#fff!important;border-color:#dee2e6!important;color:#212529!important}
.payments-logos .badge i{font-size:1rem;line-height:1}
/* Grid de habilidades técnicas - 5 columnas en desktop */
.tech-skills-grid {
  display: grid;
  gap: 1.25rem;
  grid-template-columns: repeat(2, 1fr); /* 2 columnas en móvil */
}
@media (min-width: 768px) {
  .tech-skills-grid {
    grid-template-columns: repeat(3, 1fr); /* 3 columnas en tablet */
  }
}
@media (min-width: 992px) {
  .tech-skills-grid {
    grid-template-columns: repeat(5, 1fr); /* 5 columnas en desktop */
    gap: 1.5rem;
  }
}
    </style>
    <!-- Google Analytics placeholder -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);} gtag('js', new Date());
      gtag('config', 'G-XXXXXXXXXX');
    </script> -->
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= $base ?>/index.php" aria-label="Joel Cadenas">
                <picture>
                  <source srcset="<?= $base ?>/assets/img/logo.webp" type="image/webp">
                  <img src="<?= $base ?>/assets/img/logo.png" alt="" class="logo-img me-2" width="149" height="42" loading="lazy" decoding="async">
                </picture>
              </a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php $current = basename($_SERVER['SCRIPT_NAME']); ?>
                    <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link <?= $current==='index.php'?'active':'' ?>" href="<?= $base ?>/index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link <?= $current==='about.php'?'active':'' ?>" href="<?= $base ?>/about.php">Sobre mí</a></li>
                    <li class="nav-item"><a class="nav-link <?= $current==='cv.php'?'active':'' ?>" href="<?= $base ?>/cv.php">Currículum</a></li>
                    <li class="nav-item"><a class="nav-link <?= $current==='resume.php'?'active':'' ?>" href="<?= $base ?>/resume.php">Resume</a></li>
                    <li class="nav-item"><a class="nav-link <?= $current==='portfolio.php'?'active':'' ?>" href="<?= $base ?>/portfolio.php">Portafolio</a></li>
                    <li class="nav-item"><a class="nav-link <?= $current==='services.php'?'active':'' ?>" href="<?= $base ?>/services.php">Servicios</a></li>
                                        <li class="nav-item"><a class="nav-link <?= $current==='contact.php'?'active':'' ?>" href="<?= $base ?>/contact.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="flex-shrink-0">
