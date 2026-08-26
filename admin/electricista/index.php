<?php
require_once __DIR__ . '/../../includes/electricista-admin-layout.php';

electricistaAdminRequireLogin();

$stats = [
    'total' => 0,
    'published' => 0,
    'draft' => 0,
    'featured' => 0,
    'images' => 0,
];
$recentWorks = [];
$error = '';

try {
    $pdo = electricistaWorksPdo();
    if (!electricistaTablesReady($pdo)) {
        $error = 'La base de datos está configurada, pero faltan las tablas de Electricista.';
    } else {
        $stats['total'] = (int) $pdo->query('SELECT COUNT(*) FROM electricista_works')->fetchColumn();
        $stats['published'] = (int) $pdo->query("SELECT COUNT(*) FROM electricista_works WHERE status = 'published'")->fetchColumn();
        $stats['draft'] = (int) $pdo->query("SELECT COUNT(*) FROM electricista_works WHERE status = 'draft'")->fetchColumn();
        $stats['featured'] = (int) $pdo->query('SELECT COUNT(*) FROM electricista_works WHERE is_featured = 1')->fetchColumn();
        $stats['images'] = (int) $pdo->query('SELECT COUNT(*) FROM electricista_work_images')->fetchColumn();

        $stmt = $pdo->query('SELECT w.id, w.title, w.slug, w.status, w.is_featured, w.created_at, c.name AS category_name
                             FROM electricista_works w
                             INNER JOIN electricista_categories c ON c.id = w.category_id
                             ORDER BY w.created_at DESC, w.id DESC
                             LIMIT 6');
        $recentWorks = $stmt->fetchAll();
    }
} catch (Throwable $exception) {
    $error = 'No fue posible cargar el dashboard de Electricista.';
}

electricistaAdminRenderHeader('Dashboard | Admin Electricista', 'dashboard');
?>
<div class="electricista-admin-header">
    <div>
        <p class="electricista-eyebrow">Dashboard</p>
        <h1 class="electricista-admin-title">Panel de trabajos realizados</h1>
        <p class="electricista-admin-subtitle">Administra publicaciones reales, su estado, portada, galería y visibilidad pública desde un solo flujo.</p>
    </div>
    <div class="electricista-admin-actions">
        <a class="btn btn-primary" href="<?= electricistaHtml(electricistaAdminUrl('work-form.php')) ?>"><i class="bi bi-plus-circle me-1"></i>Nuevo trabajo</a>
        <a class="btn btn-outline-light" href="<?= electricistaHtml(electricistaAdminUrl('works.php')) ?>">Ver lista completa</a>
    </div>
</div>

<?php if ($error !== ''): ?>
<div class="alert alert-warning electricista-admin-alert" role="alert"><?= electricistaHtml($error) ?></div>
<?php endif; ?>

<div class="electricista-admin-stats">
    <article class="electricista-admin-card">
        <div class="electricista-admin-card-label">Trabajos registrados</div>
        <div class="electricista-admin-card-value"><?= $stats['total'] ?></div>
    </article>
    <article class="electricista-admin-card">
        <div class="electricista-admin-card-label">Publicados</div>
        <div class="electricista-admin-card-value"><?= $stats['published'] ?></div>
    </article>
    <article class="electricista-admin-card">
        <div class="electricista-admin-card-label">Borradores</div>
        <div class="electricista-admin-card-value"><?= $stats['draft'] ?></div>
    </article>
    <article class="electricista-admin-card">
        <div class="electricista-admin-card-label">Imágenes cargadas</div>
        <div class="electricista-admin-card-value"><?= $stats['images'] ?></div>
    </article>
</div>

<section class="electricista-admin-panel">
    <div class="electricista-admin-header">
        <div>
            <h2 class="h4 mb-1">Actividad reciente</h2>
            <p class="electricista-admin-subtitle">Últimos trabajos creados o actualizados en el sistema.</p>
        </div>
    </div>

    <?php if (empty($recentWorks)): ?>
    <div class="electricista-admin-empty">
        <h3 class="h5">Aún no hay trabajos registrados</h3>
        <p class="electricista-admin-subtitle">Crea el primer trabajo desde el formulario administrativo y publícalo cuando esté listo.</p>
        <a class="btn btn-primary" href="<?= electricistaHtml(electricistaAdminUrl('work-form.php')) ?>">Crear primer trabajo</a>
    </div>
    <?php else: ?>
    <div class="electricista-admin-table-wrap">
        <table class="electricista-admin-table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Destacado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentWorks as $work): ?>
                <tr>
                    <td data-label="Título">
                        <strong><?= electricistaHtml($work['title']) ?></strong><br>
                        <small class="electricista-admin-muted"><?= electricistaHtml($work['slug']) ?></small>
                    </td>
                    <td data-label="Categoría"><span class="electricista-admin-badge electricista-admin-badge--category"><?= electricistaHtml($work['category_name']) ?></span></td>
                    <td data-label="Estado">
                        <span class="electricista-admin-badge <?= $work['status'] === 'published' ? 'electricista-admin-badge--published' : 'electricista-admin-badge--draft' ?>">
                            <?= electricistaHtml(electricistaWorkStatusLabel($work['status'])) ?>
                        </span>
                    </td>
                    <td data-label="Destacado">
                        <?= !empty($work['is_featured']) ? '<span class="electricista-admin-badge electricista-admin-badge--featured">Sí</span>' : '<span class="electricista-admin-muted">No</span>' ?>
                    </td>
                    <td data-label="Acciones">
                        <div class="electricista-admin-actions">
                            <a class="btn btn-sm btn-outline-light" href="<?= electricistaHtml(electricistaAdminUrl('work-form.php?id=' . (int) $work['id'])) ?>">Editar</a>
                            <?php if ($work['status'] === 'published'): ?>
                            <a class="btn btn-sm btn-outline-primary" href="<?= electricistaHtml(electricistaWorksUrl($work['slug'])) ?>" target="_blank" rel="noopener">Ver</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</section>
<?php electricistaAdminRenderFooter(); ?>
