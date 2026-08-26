<?php
require_once __DIR__ . '/../../includes/electricista-admin-layout.php';

electricistaAdminRequireLogin();

$error = '';
$works = [];

try {
    $pdo = electricistaWorksPdo();
    if (!electricistaTablesReady($pdo)) {
        $error = 'La base de datos está configurada, pero faltan las tablas de Electricista.';
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!electricistaVerifyCsrf($_POST['csrf_token'] ?? null)) {
                electricistaSetFlash('danger', 'La sesión expiró. Intenta nuevamente.');
                header('Location: ' . electricistaAdminUrl('works.php'));
                exit;
            }

            $action = (string) ($_POST['action'] ?? '');
            $workId = (int) ($_POST['work_id'] ?? 0);

            if ($workId > 0 && $action === 'toggle_status') {
                $stmt = $pdo->prepare('SELECT status FROM electricista_works WHERE id = ? LIMIT 1');
                $stmt->execute([$workId]);
                $currentStatus = $stmt->fetchColumn();
                if ($currentStatus) {
                    $newStatus = $currentStatus === 'published' ? 'draft' : 'published';
                    $publishedAt = $newStatus === 'published' ? date('Y-m-d H:i:s') : null;
                    $update = $pdo->prepare('UPDATE electricista_works SET status = ?, published_at = ?, updated_by = ?, updated_at = NOW() WHERE id = ?');
                    $update->execute([$newStatus, $publishedAt, electricistaAdminCurrentUser()['id'] ?? null, $workId]);
                    electricistaSetFlash('success', $newStatus === 'published' ? 'Trabajo publicado correctamente.' : 'Trabajo enviado a borrador.');
                }
            }

            if ($workId > 0 && $action === 'delete') {
                $work = electricistaFetchAdminWorkById($pdo, $workId);
                if ($work) {
                    electricistaDeleteUploadedFile($work['cover_image'] ?? null);
                    foreach ($work['images'] as $image) {
                        electricistaDeleteUploadedFile($image['image_path'] ?? null);
                    }
                    $delete = $pdo->prepare('DELETE FROM electricista_works WHERE id = ?');
                    $delete->execute([$workId]);
                    electricistaEmptyUploadDirectory($workId);
                    electricistaSetFlash('success', 'Trabajo eliminado correctamente.');
                }
            }

            header('Location: ' . electricistaAdminUrl('works.php'));
            exit;
        }

        $works = electricistaFetchAdminWorks($pdo);
    }
} catch (Throwable $exception) {
    $error = 'No fue posible cargar la lista de trabajos.';
}

electricistaAdminRenderHeader('Trabajos | Admin Electricista', 'works');
?>
<div class="electricista-admin-header">
    <div>
        <p class="electricista-eyebrow">Administración</p>
        <h1 class="electricista-admin-title">Trabajos realizados</h1>
        <p class="electricista-admin-subtitle">Publica nuevos trabajos, edítalos, cambia su estado y administra sus imágenes sin tocar el código.</p>
    </div>
    <div class="electricista-admin-actions">
        <a class="btn btn-primary" href="<?= electricistaHtml(electricistaAdminUrl('work-form.php')) ?>"><i class="bi bi-plus-circle me-1"></i>Nuevo trabajo</a>
    </div>
</div>

<?php if ($error !== ''): ?>
<div class="alert alert-warning electricista-admin-alert" role="alert"><?= electricistaHtml($error) ?></div>
<?php endif; ?>

<?php if (empty($works)): ?>
<div class="electricista-admin-empty">
    <h2 class="h4">Todavía no hay trabajos registrados</h2>
    <p class="electricista-admin-subtitle">Cuando crees el primero desde el panel, podrá quedar en borrador o publicarse automáticamente en la página pública.</p>
    <a class="btn btn-primary" href="<?= electricistaHtml(electricistaAdminUrl('work-form.php')) ?>">Crear primer trabajo</a>
</div>
<?php else: ?>
<div class="electricista-admin-table-wrap">
    <table class="electricista-admin-table">
        <thead>
            <tr>
                <th>Trabajo</th>
                <th>Categoría</th>
                <th>Ubicación</th>
                <th>Fecha</th>
                <th>Imágenes</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($works as $work): ?>
            <tr>
                <td data-label="Trabajo">
                    <strong><?= electricistaHtml($work['title']) ?></strong><br>
                    <small class="electricista-admin-muted"><?= electricistaHtml($work['slug']) ?></small>
                </td>
                <td data-label="Categoría"><span class="electricista-admin-badge electricista-admin-badge--category"><?= electricistaHtml($work['category_name']) ?></span></td>
                <td data-label="Ubicación"><?= electricistaHtml($work['location'] ?: '—') ?></td>
                <td data-label="Fecha"><?= electricistaHtml(electricistaFormatWorkDate($work['work_date'] ?: null) ?: '—') ?></td>
                <td data-label="Imágenes"><?= (int) $work['image_count'] ?></td>
                <td data-label="Estado">
                    <span class="electricista-admin-badge <?= $work['status'] === 'published' ? 'electricista-admin-badge--published' : 'electricista-admin-badge--draft' ?>">
                        <?= electricistaHtml(electricistaWorkStatusLabel($work['status'])) ?>
                    </span>
                    <?php if (!empty($work['is_featured'])): ?>
                    <div class="mt-2"><span class="electricista-admin-badge electricista-admin-badge--featured">Destacado</span></div>
                    <?php endif; ?>
                </td>
                <td data-label="Acciones">
                    <div class="electricista-admin-actions mb-2">
                        <a class="btn btn-sm btn-outline-light" href="<?= electricistaHtml(electricistaAdminUrl('work-form.php?id=' . (int) $work['id'])) ?>">Editar</a>
                        <?php if ($work['status'] === 'published'): ?>
                        <a class="btn btn-sm btn-outline-primary" href="<?= electricistaHtml(electricistaWorksUrl($work['slug'])) ?>" target="_blank" rel="noopener">Ver</a>
                        <?php endif; ?>
                    </div>
                    <div class="electricista-admin-actions">
                        <form method="post">
                            <input type="hidden" name="csrf_token" value="<?= electricistaHtml(electricistaCsrfToken()) ?>">
                            <input type="hidden" name="action" value="toggle_status">
                            <input type="hidden" name="work_id" value="<?= (int) $work['id'] ?>">
                            <button class="btn btn-sm <?= $work['status'] === 'published' ? 'btn-outline-warning' : 'btn-outline-success' ?>" type="submit">
                                <?= $work['status'] === 'published' ? 'Enviar a borrador' : 'Publicar' ?>
                            </button>
                        </form>
                        <form method="post">
                            <input type="hidden" name="csrf_token" value="<?= electricistaHtml(electricistaCsrfToken()) ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="work_id" value="<?= (int) $work['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger" type="submit" data-confirm="¿Deseas eliminar este trabajo y sus imágenes?">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php electricistaAdminRenderFooter(); ?>
