<?php
require_once __DIR__ . '/../../includes/electricista-admin-layout.php';

electricistaAdminRequireLogin();

if (!function_exists('electricistaNormalizeUploadList')) {
    function electricistaNormalizeUploadList(array $files): array {
        $normalized = [];
        $names = $files['name'] ?? [];
        if (!is_array($names)) {
            return $normalized;
        }

        foreach (array_keys($names) as $index) {
            $normalized[] = [
                'name' => $files['name'][$index] ?? '',
                'type' => $files['type'][$index] ?? '',
                'tmp_name' => $files['tmp_name'][$index] ?? '',
                'error' => $files['error'][$index] ?? UPLOAD_ERR_NO_FILE,
                'size' => $files['size'][$index] ?? 0,
            ];
        }

        return $normalized;
    }
}

$pdo = null;
$bootError = '';

try {
    $pdo = electricistaWorksPdo();
    if (!electricistaTablesReady($pdo)) {
        $bootError = 'La base de datos está configurada, pero faltan las tablas de Electricista.';
    }
} catch (Throwable $exception) {
    $bootError = 'No fue posible conectar con la base de datos de Electricista.';
}

$currentUser = electricistaAdminCurrentUser();
$workId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$isEdit = $workId > 0;
$categories = $pdo && $bootError === '' ? electricistaFetchCategories($pdo) : [];
$existingWork = $pdo && $bootError === '' && $isEdit ? electricistaFetchAdminWorkById($pdo, $workId) : null;

if ($bootError !== '') {
    electricistaAdminRenderHeader('Configuración pendiente | Admin Electricista', 'works');
    echo '<div class="alert alert-warning electricista-admin-alert" role="alert">' . electricistaHtml($bootError) . '</div>';
    echo '<div class="electricista-admin-empty"><p class="electricista-admin-subtitle">Completa primero la configuración local y ejecuta la migración SQL antes de crear trabajos.</p></div>';
    electricistaAdminRenderFooter();
    return;
}

if ($isEdit && !$existingWork) {
    http_response_code(404);
    electricistaAdminRenderHeader('Trabajo no encontrado | Admin Electricista', 'works');
    echo '<div class="electricista-admin-empty"><h1 class="h4">Trabajo no encontrado</h1><p class="electricista-admin-subtitle">El registro solicitado no existe.</p></div>';
    electricistaAdminRenderFooter();
    return;
}

$formData = [
    'title' => $existingWork['title'] ?? '',
    'slug' => $existingWork['slug'] ?? '',
    'category_id' => (string) ($existingWork['category_id'] ?? ''),
    'location' => $existingWork['location'] ?? '',
    'work_date' => $existingWork['work_date'] ?? '',
    'short_description' => $existingWork['short_description'] ?? '',
    'description' => $existingWork['description'] ?? '',
    'status' => $existingWork['status'] ?? 'draft',
    'is_featured' => !empty($existingWork['is_featured']) ? '1' : '',
];
$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['title'] = trim((string) ($_POST['title'] ?? ''));
    $formData['slug'] = trim((string) ($_POST['slug'] ?? ''));
    $formData['category_id'] = trim((string) ($_POST['category_id'] ?? ''));
    $formData['location'] = trim((string) ($_POST['location'] ?? ''));
    $formData['work_date'] = trim((string) ($_POST['work_date'] ?? ''));
    $formData['short_description'] = trim((string) ($_POST['short_description'] ?? ''));
    $formData['description'] = trim((string) ($_POST['description'] ?? ''));
    $formData['status'] = trim((string) ($_POST['status'] ?? 'draft'));
    $formData['is_featured'] = !empty($_POST['is_featured']) ? '1' : '';

    if (!electricistaVerifyCsrf($_POST['csrf_token'] ?? null)) {
        $errorMessages[] = 'La sesión expiró. Intenta nuevamente.';
    }

    $categoryIds = array_map(static fn(array $category): string => (string) $category['id'], $categories);
    if ($formData['title'] === '') {
        $errorMessages[] = 'El título es obligatorio.';
    }
    if ($formData['short_description'] === '') {
        $errorMessages[] = 'La descripción corta es obligatoria.';
    }
    if ($formData['description'] === '') {
        $errorMessages[] = 'La descripción completa es obligatoria.';
    }
    if ($formData['category_id'] === '' || !in_array($formData['category_id'], $categoryIds, true)) {
        $errorMessages[] = 'Selecciona una categoría válida.';
    }
    if (!in_array($formData['status'], ['draft', 'published'], true)) {
        $errorMessages[] = 'Selecciona un estado válido.';
    }
    if ($formData['work_date'] !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $formData['work_date'])) {
        $errorMessages[] = 'La fecha del trabajo debe usar el formato YYYY-MM-DD.';
    }

    $coverUpload = $_FILES['cover_image'] ?? null;
    $hasNewCover = $coverUpload && isset($coverUpload['error']) && (int) $coverUpload['error'] !== UPLOAD_ERR_NO_FILE;
    if (!$isEdit && !$hasNewCover) {
        $errorMessages[] = 'La imagen de portada es obligatoria.';
    }

    $galleryUploads = isset($_FILES['gallery_images']) ? electricistaNormalizeUploadList($_FILES['gallery_images']) : [];
    $baseSlug = $formData['slug'] !== '' ? $formData['slug'] : $formData['title'];
    $resolvedSlug = electricistaUniqueWorkSlug($pdo, $baseSlug, $isEdit ? $workId : null);
    $formData['slug'] = $resolvedSlug;

    if (empty($errorMessages)) {
        $newFiles = [];

        try {
            $pdo->beginTransaction();

            $publishedAt = null;
            if ($formData['status'] === 'published') {
                if ($existingWork && $existingWork['status'] === 'published' && !empty($existingWork['published_at'])) {
                    $publishedAt = $existingWork['published_at'];
                } else {
                    $publishedAt = date('Y-m-d H:i:s');
                }
            }

            if ($isEdit) {
                $coverImagePath = (string) ($existingWork['cover_image'] ?? '');
                $coverAlt = (string) ($existingWork['cover_image_alt'] ?? $formData['title']);
            } else {
                $insert = $pdo->prepare('INSERT INTO electricista_works (category_id, title, slug, short_description, description, location, work_date, cover_image, cover_image_alt, is_featured, status, published_at, created_by, updated_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                $insert->execute([
                    (int) $formData['category_id'],
                    $formData['title'],
                    $resolvedSlug,
                    $formData['short_description'],
                    $formData['description'],
                    $formData['location'] !== '' ? $formData['location'] : null,
                    $formData['work_date'] !== '' ? $formData['work_date'] : null,
                    '',
                    $formData['title'],
                    !empty($formData['is_featured']) ? 1 : 0,
                    $formData['status'],
                    $publishedAt,
                    $currentUser['id'] ?? null,
                    $currentUser['id'] ?? null,
                ]);
                $workId = (int) $pdo->lastInsertId();
                $isEdit = true;
                $coverImagePath = '';
                $coverAlt = $formData['title'];
            }

            if ($hasNewCover && $coverUpload && (int) $coverUpload['error'] === UPLOAD_ERR_OK) {
                $storedCover = electricistaStoreUploadedImage($coverUpload, $workId, $resolvedSlug, 'cover');
                $newFiles[] = $storedCover['relative_path'];
                if ($coverImagePath !== '') {
                    electricistaDeleteUploadedFile($coverImagePath);
                }
                $coverImagePath = $storedCover['relative_path'];
                $coverAlt = $formData['title'];
            }

            if ($coverImagePath === '') {
                throw new RuntimeException('La portada es obligatoria para guardar el trabajo.');
            }

            $removeImageIds = $_POST['remove_image_ids'] ?? [];
            if (!is_array($removeImageIds)) {
                $removeImageIds = [];
            }
            $removeImageIds = array_map('intval', $removeImageIds);

            foreach ($removeImageIds as $imageId) {
                if ($imageId <= 0) {
                    continue;
                }
                $stmt = $pdo->prepare('SELECT image_path FROM electricista_work_images WHERE id = ? AND work_id = ? LIMIT 1');
                $stmt->execute([$imageId, $workId]);
                $imagePath = $stmt->fetchColumn();
                if ($imagePath) {
                    electricistaDeleteUploadedFile((string) $imagePath);
                    $deleteImage = $pdo->prepare('DELETE FROM electricista_work_images WHERE id = ? AND work_id = ?');
                    $deleteImage->execute([$imageId, $workId]);
                }
            }

            $sortOrders = $_POST['image_sort_order'] ?? [];
            $altTexts = $_POST['image_alt_text'] ?? [];
            if (is_array($sortOrders)) {
                foreach ($sortOrders as $imageId => $sortOrder) {
                    $imageId = (int) $imageId;
                    if ($imageId <= 0 || in_array($imageId, $removeImageIds, true)) {
                        continue;
                    }
                    $altText = is_array($altTexts) ? trim((string) ($altTexts[$imageId] ?? '')) : '';
                    $updateImage = $pdo->prepare('UPDATE electricista_work_images SET sort_order = ?, alt_text = ? WHERE id = ? AND work_id = ?');
                    $updateImage->execute([(int) $sortOrder, $altText !== '' ? $altText : null, $imageId, $workId]);
                }
            }

            $maxSortOrderStmt = $pdo->prepare('SELECT COALESCE(MAX(sort_order), 0) FROM electricista_work_images WHERE work_id = ?');
            $maxSortOrderStmt->execute([$workId]);
            $sortOrderBase = (int) $maxSortOrderStmt->fetchColumn();

            $galleryErrors = [];
            foreach ($galleryUploads as $upload) {
                if ((int) ($upload['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                try {
                    $storedImage = electricistaStoreUploadedImage($upload, $workId, $resolvedSlug, 'galeria');
                } catch (Throwable $exception) {
                    $galleryErrors[] = $exception->getMessage();
                    continue;
                }
                $sortOrderBase++;
                $newFiles[] = $storedImage['relative_path'];
                $insertImage = $pdo->prepare('INSERT INTO electricista_work_images (work_id, image_path, alt_text, sort_order) VALUES (?, ?, ?, ?)');
                $insertImage->execute([$workId, $storedImage['relative_path'], $formData['title'], $sortOrderBase]);
            }

            if ($galleryErrors !== []) {
                throw new RuntimeException(implode(' ', $galleryErrors));
            }

            $updateWork = $pdo->prepare('UPDATE electricista_works SET category_id = ?, title = ?, slug = ?, short_description = ?, description = ?, location = ?, work_date = ?, cover_image = ?, cover_image_alt = ?, is_featured = ?, status = ?, published_at = ?, updated_by = ?, updated_at = NOW() WHERE id = ?');
            $updateWork->execute([
                (int) $formData['category_id'],
                $formData['title'],
                $resolvedSlug,
                $formData['short_description'],
                $formData['description'],
                $formData['location'] !== '' ? $formData['location'] : null,
                $formData['work_date'] !== '' ? $formData['work_date'] : null,
                $coverImagePath,
                $coverAlt,
                !empty($formData['is_featured']) ? 1 : 0,
                $formData['status'],
                $publishedAt,
                $currentUser['id'] ?? null,
                $workId,
            ]);

            $pdo->commit();
            electricistaSetFlash('success', $existingWork ? 'Trabajo actualizado correctamente.' : 'Trabajo creado correctamente.');
            header('Location: ' . electricistaAdminUrl('work-form.php?id=' . $workId));
            exit;
        } catch (Throwable $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            foreach ($newFiles as $newFile) {
                electricistaDeleteUploadedFile($newFile);
            }
            $errorMessages[] = $exception->getMessage() !== '' ? $exception->getMessage() : 'No fue posible guardar el trabajo.';
        }
    }
}

$activeNav = $existingWork ? 'works' : 'new-work';
$pageTitle = $existingWork ? 'Editar trabajo | Admin Electricista' : 'Nuevo trabajo | Admin Electricista';

electricistaAdminRenderHeader($pageTitle, $activeNav);
?>
<div class="electricista-admin-header">
    <div>
        <p class="electricista-eyebrow"><?= $existingWork ? 'Edición' : 'Nuevo registro' ?></p>
        <h1 class="electricista-admin-title"><?= $existingWork ? 'Editar trabajo realizado' : 'Crear nuevo trabajo' ?></h1>
        <p class="electricista-admin-subtitle">Completa la información del proyecto, sube la portada, agrega galería y define si queda en borrador o publicado.</p>
    </div>
    <div class="electricista-admin-actions">
        <a class="btn btn-outline-light" href="<?= electricistaHtml(electricistaAdminUrl('works.php')) ?>">Volver a trabajos</a>
        <?php if ($existingWork && $existingWork['status'] === 'published'): ?>
        <a class="btn btn-outline-primary" href="<?= electricistaHtml(electricistaWorksUrl($existingWork['slug'])) ?>" target="_blank" rel="noopener">Ver publicación</a>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($errorMessages)): ?>
<div class="alert alert-danger electricista-admin-alert" role="alert">
    <ul class="mb-0">
        <?php foreach ($errorMessages as $message): ?>
        <li><?= electricistaHtml($message) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<section class="electricista-admin-form-card">
    <form method="post" enctype="multipart/form-data" class="electricista-admin-form-grid">
        <input type="hidden" name="csrf_token" value="<?= electricistaHtml(electricistaCsrfToken()) ?>">

        <div class="is-full">
            <label class="form-label" for="title">Título *</label>
            <input class="form-control" type="text" id="title" name="title" value="<?= electricistaHtml($formData['title']) ?>" data-slug-source required>
        </div>

        <div>
            <label class="form-label" for="slug">Slug</label>
            <input class="form-control" type="text" id="slug" name="slug" value="<?= electricistaHtml($formData['slug']) ?>" data-slug-target>
            <div class="form-text">Si lo dejas vacío, se genera automáticamente desde el título.</div>
        </div>

        <div>
            <label class="form-label" for="category_id">Categoría *</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="">Selecciona una categoría</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= (int) $category['id'] ?>"<?= $formData['category_id'] === (string) $category['id'] ? ' selected' : '' ?>><?= electricistaHtml($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="form-label" for="location">Ubicación</label>
            <input class="form-control" type="text" id="location" name="location" value="<?= electricistaHtml($formData['location']) ?>">
        </div>

        <div>
            <label class="form-label" for="work_date">Fecha del trabajo</label>
            <input class="form-control" type="date" id="work_date" name="work_date" value="<?= electricistaHtml($formData['work_date']) ?>">
        </div>

        <div class="is-full">
            <label class="form-label" for="short_description">Descripción corta *</label>
            <textarea class="form-control" id="short_description" name="short_description" rows="3" required><?= electricistaHtml($formData['short_description']) ?></textarea>
        </div>

        <div class="is-full">
            <label class="form-label" for="description">Descripción completa *</label>
            <textarea class="form-control" id="description" name="description" rows="8" required><?= electricistaHtml($formData['description']) ?></textarea>
        </div>

        <div>
            <label class="form-label" for="status">Estado</label>
            <select class="form-select" id="status" name="status">
                <option value="draft"<?= $formData['status'] === 'draft' ? ' selected' : '' ?>>Borrador</option>
                <option value="published"<?= $formData['status'] === 'published' ? ' selected' : '' ?>>Publicado</option>
            </select>
        </div>

        <div class="d-flex align-items-center pt-4">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"<?= $formData['is_featured'] === '1' ? ' checked' : '' ?>>
                <label class="form-check-label" for="is_featured">Marcar como destacado</label>
            </div>
        </div>

        <div class="is-full">
            <span class="form-label">Imagen de portada<?= $existingWork ? '' : ' *' ?></span>
            <div class="electricista-admin-file-field">
                <input class="electricista-admin-file-input" type="file" id="cover_image" name="cover_image" accept="image/*"<?= $existingWork ? '' : ' required' ?>>
                <label class="electricista-admin-file-label" for="cover_image">Seleccionar o cambiar imagen</label>
                <span class="electricista-admin-file-status" data-default="Ninguna imagen seleccionada" aria-live="polite"></span>
            </div>
            <div class="form-text">Formatos: JPG, PNG, WEBP, GIF, HEIC y AVIF. Máximo 32 MB por imagen. Las fotos se optimizan y convierten a JPG automáticamente.</div>
        </div>

        <?php if ($existingWork && !empty($existingWork['cover_image'])): ?>
        <div class="is-full">
            <div class="electricista-admin-media-grid">
                <article class="electricista-admin-media-card">
                    <img src="<?= electricistaHtml(electricistaAbsoluteUrl($existingWork['cover_image'])) ?>" alt="<?= electricistaHtml($existingWork['cover_image_alt'] ?: $existingWork['title']) ?>">
                    <div class="electricista-admin-media-tools">
                        <strong>Portada actual</strong>
                        <span class="electricista-admin-muted"><?= electricistaHtml($existingWork['cover_image']) ?></span>
                    </div>
                </article>
            </div>
        </div>
        <?php endif; ?>

        <div class="is-full">
            <span class="form-label">Galería de imágenes</span>
            <div class="electricista-admin-file-field">
                <input class="electricista-admin-file-input" type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                <label class="electricista-admin-file-label" for="gallery_images">Elegir imágenes</label>
                <span class="electricista-admin-file-status" data-default="Ninguna imagen seleccionada" data-multiple="true" aria-live="polite"></span>
            </div>
            <div class="form-text">Puedes seleccionar varias fotografías en una sola acción. El sistema crea la carpeta del trabajo automáticamente.</div>
        </div>

        <?php if ($existingWork && !empty($existingWork['images'])): ?>
        <div class="is-full">
            <h2 class="h5 mb-3">Imágenes actuales de galería</h2>
            <div class="electricista-admin-media-grid">
                <?php foreach ($existingWork['images'] as $image): ?>
                <article class="electricista-admin-media-card">
                    <img src="<?= electricistaHtml(electricistaAbsoluteUrl($image['image_path'])) ?>" alt="<?= electricistaHtml($image['alt_text'] ?: $existingWork['title']) ?>">
                    <div class="electricista-admin-media-tools">
                        <div>
                            <label class="form-label" for="image_sort_order_<?= (int) $image['id'] ?>">Orden</label>
                            <input class="form-control" type="number" id="image_sort_order_<?= (int) $image['id'] ?>" name="image_sort_order[<?= (int) $image['id'] ?>]" value="<?= (int) $image['sort_order'] ?>" min="0">
                        </div>
                        <div>
                            <label class="form-label" for="image_alt_text_<?= (int) $image['id'] ?>">Texto alternativo</label>
                            <input class="form-control" type="text" id="image_alt_text_<?= (int) $image['id'] ?>" name="image_alt_text[<?= (int) $image['id'] ?>]" value="<?= electricistaHtml($image['alt_text']) ?>">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="<?= (int) $image['id'] ?>" id="remove_image_<?= (int) $image['id'] ?>" name="remove_image_ids[]">
                            <label class="form-check-label" for="remove_image_<?= (int) $image['id'] ?>">Eliminar esta imagen</label>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="is-full d-flex gap-2 flex-wrap">
            <button class="btn btn-primary" type="submit">Guardar trabajo</button>
            <a class="btn btn-outline-light" href="<?= electricistaHtml(electricistaAdminUrl('works.php')) ?>">Cancelar</a>
        </div>
    </form>
</section>
<?php electricistaAdminRenderFooter(); ?>
