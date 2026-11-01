<?php
require_once __DIR__ . '/../../includes/electricista-admin-layout.php';

header('Content-Type: application/json; charset=utf-8');

if (!function_exists('electricistaUploadJson')) {
    function electricistaUploadJson(int $status, array $payload): void {
        http_response_code($status);
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }
}

if (!electricistaAdminIsLoggedIn()) {
    electricistaUploadJson(401, ['ok' => false, 'error' => 'La sesión expiró. Recarga la página e inicia sesión nuevamente.']);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    electricistaUploadJson(405, ['ok' => false, 'error' => 'Método no permitido.']);
}

if (!electricistaVerifyCsrf($_POST['csrf_token'] ?? null)) {
    electricistaUploadJson(403, ['ok' => false, 'error' => 'Token de seguridad inválido. Recarga la página.']);
}

$workId = (int) ($_POST['work_id'] ?? 0);
$type = (string) ($_POST['type'] ?? 'gallery');

try {
    $pdo = electricistaWorksPdo();
    $work = $workId > 0 ? electricistaFetchAdminWorkById($pdo, $workId) : null;
    if (!$work) {
        electricistaUploadJson(404, ['ok' => false, 'error' => 'Trabajo no encontrado.']);
    }

    $file = $_FILES['image'] ?? null;
    if (!is_array($file)) {
        electricistaUploadJson(422, ['ok' => false, 'error' => 'No se recibió ninguna imagen.']);
    }

    if ($type === 'cover') {
        $stored = electricistaStoreUploadedImage($file, $workId, (string) $work['slug'], 'cover');
        if (!empty($work['cover_image'])) {
            electricistaDeleteUploadedFile((string) $work['cover_image']);
        }
        $update = $pdo->prepare('UPDATE electricista_works SET cover_image = ?, cover_image_alt = ?, updated_at = NOW() WHERE id = ?');
        $update->execute([$stored['relative_path'], $work['title'], $workId]);
        electricistaUploadJson(200, ['ok' => true, 'path' => $stored['relative_path']]);
    }

    $maxSort = $pdo->prepare('SELECT COALESCE(MAX(sort_order), 0) FROM electricista_work_images WHERE work_id = ?');
    $maxSort->execute([$workId]);
    $sortOrder = (int) $maxSort->fetchColumn() + 1;

    $stored = electricistaStoreUploadedImage($file, $workId, (string) $work['slug'], 'galeria');
    $insert = $pdo->prepare('INSERT INTO electricista_work_images (work_id, image_path, alt_text, sort_order) VALUES (?, ?, ?, ?)');
    $insert->execute([$workId, $stored['relative_path'], $work['title'], $sortOrder]);

    electricistaUploadJson(200, ['ok' => true, 'path' => $stored['relative_path']]);
} catch (Throwable $exception) {
    electricistaUploadJson(422, ['ok' => false, 'error' => $exception->getMessage() !== '' ? $exception->getMessage() : 'No se pudo subir la imagen.']);
}
