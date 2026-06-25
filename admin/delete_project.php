<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

// Cargar lista de proyectos
try {
    $proyectos = $pdo->query('SELECT id, titulo FROM proyecto ORDER BY id DESC')->fetchAll();
} catch(Exception $e) {
    $proyectos = [];
    $error = 'Error al cargar proyectos: ' . $e->getMessage();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = '';
$info = '';
$proj = null;
$mediaCount = 0;
$comprasCount = 0;

// Procesar eliminación
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['confirm_delete'])){
    $id = (int)($_POST['id'] ?? 0);
    if(!$id){
        $error='ID de proyecto inválido';
    }else{
        try{
            $pdo->beginTransaction();
            
            // Verificar que el proyecto existe
            $stmt=$pdo->prepare('SELECT titulo FROM proyecto WHERE id=?');
            $stmt->execute([$id]);
            $titulo = $stmt->fetchColumn();
            
            if(!$titulo){
                throw new Exception('El proyecto no existe');
            }
            
            // Eliminar en orden: primero las dependencias, luego el proyecto
            
            // 1. Eliminar compras/purchases asociadas
            try {
                $pdo->prepare('DELETE FROM purchase WHERE proyecto_id=?')->execute([$id]);
            } catch(Exception $e) {
                // Intentar también con la tabla 'compra' por compatibilidad
                try {
                    $pdo->prepare('DELETE FROM compra WHERE proyecto_id=?')->execute([$id]);
                } catch(Exception $e2) {
                    // Ninguna de las dos tablas existe o no hay registros
                }
            }
            
            // 2. Eliminar media asociada
            try {
                $pdo->prepare('DELETE FROM media WHERE proyecto_id=?')->execute([$id]);
            } catch(Exception $e) {
                // Tabla media puede no existir o no tener registros
            }
            
            // 3. Eliminar el proyecto
            $pdo->prepare('DELETE FROM proyecto WHERE id=?')->execute([$id]);
            
            $pdo->commit();
            $info = "Proyecto '{$titulo}' eliminado correctamente junto con toda su información asociada.";
            $id = 0; // Reset para que no se muestre el formulario
            
            // Recargar la lista de proyectos
            $proyectos = $pdo->query('SELECT id, titulo FROM proyecto ORDER BY id DESC')->fetchAll();
        }catch(Throwable $e){
            if($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $error='Error al eliminar: '.$e->getMessage();
        }
    }
}

// Cargar datos del proyecto seleccionado
if($id > 0 && !$error && !$info){
    try {
        $stmt=$pdo->prepare('SELECT p.*, c.nombre as categoria_nombre FROM proyecto p LEFT JOIN categoria c ON c.id=p.categoria_id WHERE p.id=?');
        $stmt->execute([$id]);
        $proj=$stmt->fetch();
        
        if($proj){
            // Contar media asociada
            $stmt=$pdo->prepare('SELECT COUNT(*) FROM media WHERE proyecto_id=?');
            $stmt->execute([$id]);
            $mediaCount = $stmt->fetchColumn();
            
            // Contar compras asociadas
            try {
                $stmt=$pdo->prepare('SELECT COUNT(*) FROM purchase WHERE proyecto_id=?');
                $stmt->execute([$id]);
                $comprasCount = $stmt->fetchColumn();
            } catch(Exception $e) {
                // Intentar con tabla 'compra' por compatibilidad
                try {
                    $stmt=$pdo->prepare('SELECT COUNT(*) FROM compra WHERE proyecto_id=?');
                    $stmt->execute([$id]);
                    $comprasCount = $stmt->fetchColumn();
                } catch(Exception $e2) {
                    $comprasCount = 0;
                }
            }
        } else {
            $error = 'Proyecto no encontrado';
        }
    } catch(Exception $e) {
        $error = 'Error al cargar el proyecto: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Eliminar proyecto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="<?= $base ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-dark shadow-sm mb-4">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h1">
        <i class="bi bi-trash me-2"></i>Eliminar Proyecto
      </span>
      <a href="index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left"></i> Volver</a>
    </div>
  </nav>

  <div class="container py-4">
    <?php if($error): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    
    <?php if($info): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($info) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Selector de proyecto -->
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title mb-3"><i class="bi bi-search me-2"></i>Selecciona el proyecto a eliminar</h5>
        <form method="get">
          <div class="row g-3">
            <div class="col-md-10">
              <select name="id" class="form-select" required onchange="this.form.submit()">
                <option value="">Selecciona un proyecto...</option>
                <?php foreach($proyectos as $p): ?>
                  <option value="<?= $p['id'] ?>" <?= $id===$p['id']?'selected':'' ?>><?= htmlspecialchars($p['titulo']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Confirmación de eliminación -->
    <?php if($proj): ?>
    <div class="card border-danger border-2 shadow-sm">
      <div class="card-header bg-danger bg-opacity-10 border-danger">
        <h5 class="mb-0 text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>⚠️ Confirmación de Eliminación</h5>
      </div>
      <div class="card-body">
        <div class="alert alert-warning mb-4">
          <strong>¡Atención!</strong> Esta acción es <strong>IRREVERSIBLE</strong>. Se eliminará:
          <ul class="mb-0 mt-2">
            <li>El proyecto completo</li>
            <li><strong><?= $mediaCount ?></strong> archivo(s) multimedia asociados</li>
            <li><strong><?= $comprasCount ?></strong> compra(s) registrada(s)</li>
          </ul>
        </div>

        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <strong>Título:</strong>
            <p class="text-muted"><?= htmlspecialchars($proj['titulo']) ?></p>
          </div>
          <div class="col-md-6">
            <strong>Categoría:</strong>
            <p class="text-muted"><?= htmlspecialchars($proj['categoria_nombre'] ?? 'Sin categoría') ?></p>
          </div>
          <div class="col-12">
            <strong>Descripción:</strong>
            <p class="text-muted"><?= nl2br(htmlspecialchars(mb_strimwidth($proj['descripcion'] ?? '', 0, 200, '...'))) ?></p>
          </div>
          <?php if($proj['precio']): ?>
          <div class="col-md-6">
            <strong>Precio:</strong>
            <p class="text-muted"><?= formatCOP($proj['precio']) ?></p>
          </div>
          <?php endif; ?>
        </div>

        <form method="post" id="deleteForm">
          <input type="hidden" name="id" value="<?= $proj['id'] ?>">
          <input type="hidden" name="confirm_delete" value="1">
          <div class="d-flex gap-2 justify-content-end">
            <a href="delete_project.php" class="btn btn-secondary">
              <i class="bi bi-x-circle me-1"></i>Cancelar
            </a>
            <button type="submit" class="btn btn-danger btn-lg">
              <i class="bi bi-trash-fill me-1"></i>Sí, eliminar permanentemente
            </button>
          </div>
        </form>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Confirmación de eliminación
    document.addEventListener('DOMContentLoaded', function() {
      const deleteForm = document.getElementById('deleteForm');
      if(deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
          e.preventDefault();
          
          const projectTitle = '<?= htmlspecialchars($proj['titulo'] ?? '', ENT_QUOTES) ?>';
          const confirmMessage = `⚠️ CONFIRMACIÓN FINAL\n\n` +
            `Estás a punto de eliminar el proyecto:\n"${projectTitle}"\n\n` +
            `Esta acción es IRREVERSIBLE y eliminará:\n` +
            `• El proyecto completo\n` +
            `• Todos los archivos multimedia asociados\n` +
            `• Todas las compras registradas\n\n` +
            `¿Estás COMPLETAMENTE SEGURO?`;
          
          if(confirm(confirmMessage)) {
            deleteForm.submit();
          }
        });
      }
    });
  </script>
</body>
</html>
