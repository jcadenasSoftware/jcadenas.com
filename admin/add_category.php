<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $slug   = trim($_POST['slug'] ?? '');
    if ($nombre === '' || $slug === '') {
        $msg = 'Todos los campos son obligatorios';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO categoria (nombre, slug) VALUES (?, ?)');
            $stmt->execute([$nombre, $slug]);
            $msg = 'Categoría creada correctamente';
        } catch (PDOException $e) {
            $msg = 'Error: '.$e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Añadir categoría</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= $base ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="mb-4">Añadir categoría</h1>
    <?php if($msg): ?>
      <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <form method="post" class="card p-4 form-card bg-white border-0 shadow-sm" style="max-width:480px;">
      <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Slug (sin espacios, minúsculas)</label>
        <input type="text" name="slug" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="index.php" class="btn btn-secondary ms-2">Volver</a>
    </form>
  </div>
</body>
</html>
