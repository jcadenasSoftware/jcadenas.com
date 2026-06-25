<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

// TODO: protect this page with admin authentication

$errors = [];
$success = '';

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectId = (int)($_POST['proyecto_id'] ?? 0);

    // Validate project
    $stmt = $pdo->prepare('SELECT id, titulo FROM proyecto WHERE id=?');
    $stmt->execute([$projectId]);
    $proj = $stmt->fetch();
    if (!$proj) {
        $errors[] = 'Proyecto no encontrado.';
    }

    // Validate file
        if (!isset($_FILES['zip_file']) || $_FILES['zip_file']['error'] !== UPLOAD_ERR_OK) {
        $err = $_FILES['zip_file']['error'] ?? UPLOAD_ERR_NO_FILE;
        $map = [
            UPLOAD_ERR_INI_SIZE   => 'El archivo excede el tamaño permitido por el servidor (upload_max_filesize).',
            UPLOAD_ERR_FORM_SIZE  => 'El archivo excede el tamaño permitido por el formulario (MAX_FILE_SIZE).',
            UPLOAD_ERR_PARTIAL    => 'El archivo se subió parcialmente. Intenta de nuevo.',
            UPLOAD_ERR_NO_FILE    => 'No se envió ningún archivo.',
            UPLOAD_ERR_NO_TMP_DIR => 'Falta el directorio temporal en el servidor.',
            UPLOAD_ERR_CANT_WRITE => 'No se pudo escribir el archivo en disco.',
            UPLOAD_ERR_EXTENSION  => 'Una extensión de PHP detuvo la subida.'
        ];
        $errors[] = $map[$err] ?? 'Error subiendo el archivo.';
    } else {
        $file = $_FILES['zip_file'];
        if (strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) !== 'zip') {
            $errors[] = 'Solo se permiten archivos .zip';
        } elseif ($file['size'] > 150 * 1024 * 1024) { // 150 MB límite
            $errors[] = 'El archivo excede el tamaño permitido (150 MB).';
        }
    }

    if (!$errors) {
        // Directorio destino seguro: SECURE_DOWNLOAD_BASE/<projectId>/
        $destDir = rtrim(SECURE_DOWNLOAD_BASE, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $projectId;
        if (!is_dir($destDir)) {
            if (!mkdir($destDir, 0775, true)) {
                $errors[] = 'No se pudo crear el directorio destino.';
            }
        }

        // Nombre destino: mismo nombre de archivo (limpio)
        $filename = preg_replace('/[^A-Za-z0-9_\-\.]+/', '_', basename($file['name']));
        $destPath = $destDir . DIRECTORY_SEPARATOR . $filename;
        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            // Ruta relativa guardada en la BD
            $relativePath = $projectId . '/' . $filename;
            $upd = $pdo->prepare('UPDATE proyecto SET download_path=? WHERE id=?');
            $upd->execute([$relativePath, $projectId]);
            // PRG: redirigir para evitar reenvío/loops
            header('Location: upload_zip.php?ok=1&pid='.(int)$projectId.'&file='.rawurlencode($filename));
            exit;
        } else {
            $errors[] = 'No se pudo mover el archivo al destino.';
        }
    }
}

// Load projects for dropdown
$projects = $pdo->query('SELECT id, titulo FROM proyecto ORDER BY titulo')->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir ZIP - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Subir archivo ZIP a proyecto</h1>
        <a href="purchases.php" class="btn btn-secondary btn-sm">Ver compras</a>
    </div>

    <?php if (isset($_GET['ok']) && $_GET['ok']=='1'): ?>
        <div class="alert alert-success">Archivo subido y ruta actualizada correctamente. <?= isset($_GET['file']) ? 'Archivo: '.htmlspecialchars($_GET['file']) : '' ?></div>
    <?php elseif ($errors): ?>
        <div class="alert alert-danger"><ul class="mb-0">
            <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
        </ul></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="card p-4" style="max-width:480px;">
        <div class="mb-3">
            <label class="form-label">Proyecto</label>
            <select name="proyecto_id" class="form-select" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($projects as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= isset($projectId) && $projectId == $p['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['titulo']) ?> (ID <?= $p['id'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Archivo ZIP</label>
            <input type="file" name="zip_file" accept=".zip,application/zip" class="form-control" required>
            <div class="form-text">
                Límite servidor: upload_max_filesize=<?= htmlspecialchars(ini_get('upload_max_filesize')) ?>,
                post_max_size=<?= htmlspecialchars(ini_get('post_max_size')) ?>.
            </div>
        </div>
        <button class="btn btn-primary">Subir</button>
    </form>
</body>
</html>
