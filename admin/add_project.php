<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

// fetch categories
$cats = $pdo->query('SELECT id,nombre FROM categoria ORDER BY nombre')->fetchAll();

$msg = '';
$newId = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria_id = (int)($_POST['categoria_id'] ?? 0);
    $titulo       = trim($_POST['titulo'] ?? '');
    $slug         = trim($_POST['slug'] ?? '');
    $descripcion  = trim($_POST['descripcion'] ?? '');
    $repo_url     = trim($_POST['repo_url'] ?? '');
    $precio       = $_POST['precio'] !== '' ? number_format((float)$_POST['precio'],2,'.','') : null;
    $paypal_btn   = trim($_POST['paypal_button_id'] ?? '');
    $destacado    = isset($_POST['destacado']) ? 1 : 0;

    if(!$categoria_id || $titulo==='' || $slug===''){
        $msg = 'Rellena los campos obligatorios';
    } else {
        try{
            $stmt=$pdo->prepare('INSERT INTO proyecto (categoria_id,titulo,slug,descripcion,repo_url,precio,paypal_button_id,destacado) VALUES (?,?,?,?,?,?,?,?)');
            $stmt->execute([$categoria_id,$titulo,$slug,$descripcion,$repo_url,$precio,($paypal_btn?:null),$destacado]);
            $newId = $pdo->lastInsertId();
            header('Location: upload_media.php?proyecto='.$newId);
            exit;
        }catch(PDOException $e){
            $msg='Error: '.$e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Añadir proyecto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="<?= $base ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body class="bg-light">
  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-dark shadow-sm mb-4">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h1">
        <i class="bi bi-plus-circle me-2"></i>Añadir Nuevo Proyecto
      </span>
      <a href="index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left"></i> Volver al panel</a>
    </div>
  </nav>

  <div class="container py-4">
    <?php if($msg): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($msg) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <form method="post" class="card p-4 form-card bg-white border-0 shadow-sm">
      <h5 class="card-title mb-4"><i class="bi bi-info-circle me-2"></i>Información del Proyecto</h5>
      
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold"><i class="bi bi-tags me-1"></i>Categoría <span class="text-danger">*</span></label>
          <select name="categoria_id" class="form-select" required>
            <option value="">Selecciona una categoría...</option>
            <?php foreach($cats as $c): ?>
              <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold"><i class="bi bi-pencil me-1"></i>Título <span class="text-danger">*</span></label>
          <input type="text" name="titulo" class="form-control" placeholder="Ej: Sistema de Gestión de Inventarios" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold"><i class="bi bi-link-45deg me-1"></i>Slug (URL amigable) <span class="text-danger">*</span></label>
          <input type="text" name="slug" class="form-control" placeholder="ej: gestion-inventarios" required>
          <div class="form-text">Sin espacios, minúsculas, guiones permitidos</div>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold"><i class="bi bi-github me-1"></i>Repositorio / Demo URL</label>
          <input type="url" name="repo_url" class="form-control" placeholder="https://github.com/usuario/proyecto">
        </div>
        <div class="col-12">
          <label class="form-label fw-semibold"><i class="bi bi-text-paragraph me-1"></i>Descripción</label>
          <textarea name="descripcion" class="form-control" rows="4" placeholder="Describe brevemente las características principales del proyecto..."></textarea>
        </div>
      </div>

      <hr class="my-4">
      <h5 class="card-title mb-4"><i class="bi bi-cash-coin me-2"></i>Monetización</h5>
      
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label fw-semibold"><i class="bi bi-currency-dollar me-1"></i>Precio (COP)</label>
          <input type="number" step="0.01" name="precio" class="form-control" placeholder="Ej: 50000">
          <div class="form-text">Dejar vacío si es gratuito</div>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold"><i class="bi bi-paypal me-1"></i>PayPal Button ID</label>
          <input type="text" name="paypal_button_id" class="form-control" placeholder="Ej: 4N593H9E8YGLC">
          <div class="form-text">ID del botón alojado en PayPal</div>
        </div>
        <div class="col-md-4 d-flex align-items-center">
          <div class="form-check form-switch mt-3">
            <input class="form-check-input" type="checkbox" name="destacado" id="destacado" role="switch">
            <label class="form-check-label fw-semibold" for="destacado">
              <i class="bi bi-star-fill text-warning me-1"></i>Proyecto Destacado
            </label>
          </div>
        </div>
      </div>

      <hr class="my-4">
      
      <div class="d-flex gap-2 justify-content-end">
        <a href="index.php" class="btn btn-secondary">
          <i class="bi bi-x-circle me-1"></i>Cancelar
        </a>
        <button type="submit" class="btn btn-primary btn-lg">
          <i class="bi bi-save me-1"></i>Guardar y Subir Media
        </button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
