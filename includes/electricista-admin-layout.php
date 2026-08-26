<?php
require_once __DIR__ . '/electricista-works.php';

if (!function_exists('electricistaAdminRenderHeader')) {
    function electricistaAdminRenderHeader(string $title, string $activeNav = 'dashboard'): void {
        $currentUser = electricistaAdminCurrentUser();
        $flash = electricistaConsumeFlash();
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= electricistaHtml($title) ?></title>
    <link rel="icon" type="image/png" href="<?= electricistaHtml(electricistaAbsoluteUrl('assets/img/electricista/favicon-32x32.png')) ?>" sizes="32x32">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= electricistaHtml(siteUrl('assets/css/electricista-admin.css')) ?>">
</head>
<body class="electricista-admin-body">
<header class="electricista-admin-topbar">
    <div class="electricista-admin-shell electricista-admin-topbar-inner">
        <a class="electricista-admin-brand" href="<?= electricistaHtml(electricistaAdminUrl()) ?>">
            <img src="<?= electricistaHtml(electricistaAbsoluteUrl('assets/img/electricista/ui/monograma-jc.png')) ?>" alt="Panel Electricista">
            <span>
                <strong>Admin Electricista</strong>
                <small>Gestión de trabajos</small>
            </span>
        </a>
        <div class="electricista-admin-topbar-actions">
            <a class="electricista-admin-site-link" href="<?= electricistaHtml(electricistaPageUrl()) ?>" target="_blank" rel="noopener">Ver sitio</a>
            <?php if ($currentUser): ?>
            <span class="electricista-admin-user"><i class="bi bi-person-circle"></i><?= electricistaHtml($currentUser['username'] ?? '') ?></span>
            <a class="btn btn-sm btn-outline-light" href="<?= electricistaHtml(electricistaAdminUrl('logout.php')) ?>">Salir</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<div class="electricista-admin-shell electricista-admin-layout">
    <?php if ($currentUser): ?>
    <aside class="electricista-admin-sidebar">
        <nav class="electricista-admin-nav" aria-label="Navegación administrativa">
            <a class="electricista-admin-nav-link<?= $activeNav === 'dashboard' ? ' is-active' : '' ?>" href="<?= electricistaHtml(electricistaAdminUrl()) ?>">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            <a class="electricista-admin-nav-link<?= $activeNav === 'works' ? ' is-active' : '' ?>" href="<?= electricistaHtml(electricistaAdminUrl('works.php')) ?>">
                <i class="bi bi-briefcase"></i>
                <span>Trabajos</span>
            </a>
            <a class="electricista-admin-nav-link<?= $activeNav === 'new-work' ? ' is-active' : '' ?>" href="<?= electricistaHtml(electricistaAdminUrl('work-form.php')) ?>">
                <i class="bi bi-plus-circle"></i>
                <span>Nuevo trabajo</span>
            </a>
            <a class="electricista-admin-nav-link" href="<?= electricistaHtml(electricistaWorksUrl()) ?>" target="_blank" rel="noopener">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Página pública</span>
            </a>
        </nav>
    </aside>
    <?php endif; ?>
    <main class="electricista-admin-main">
        <?php if ($flash): ?>
        <div class="alert alert-<?= electricistaHtml($flash['type']) ?> electricista-admin-alert" role="alert">
            <?= electricistaHtml($flash['message']) ?>
        </div>
        <?php endif; ?>
<?php
    }
}

if (!function_exists('electricistaAdminRenderFooter')) {
    function electricistaAdminRenderFooter(): void {
        ?>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="<?= electricistaHtml(siteUrl('assets/js/electricista-admin.js')) ?>" defer></script>
</body>
</html>
<?php
    }
}
