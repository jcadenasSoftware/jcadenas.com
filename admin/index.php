<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

// Obtener estadísticas de proyectos
try {
    $stmt = $pdo->query("
        SELECT 
            p.id,
            p.titulo,
            p.precio,
            p.destacado,
            c.nombre as categoria_nombre,
            (SELECT COUNT(*) FROM media WHERE proyecto_id = p.id) as total_media,
            (SELECT COUNT(*) FROM purchase WHERE proyecto_id = p.id) as total_compras
        FROM proyecto p
        LEFT JOIN categoria c ON c.id = p.categoria_id
        ORDER BY p.id DESC
    ");
    $proyectos_stats = $stmt->fetchAll();
    
    // Estadísticas generales
    $total_proyectos = count($proyectos_stats);
    $total_ventas = array_sum(array_column($proyectos_stats, 'total_compras'));
} catch(Exception $e) {
    $proyectos_stats = [];
    $total_proyectos = 0;
    $total_ventas = 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Portafolio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="<?= $base ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body class="bg-light">
  <!-- Header moderno -->
  <nav class="navbar navbar-dark bg-dark shadow-sm mb-4">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h1">
        <i class="bi bi-gear-fill me-2"></i>Panel de Administración
      </span>
      <div>
        <span class="text-white-50 me-3"><i class="bi bi-person-circle"></i> Admin</span>
        <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Salir</a>
      </div>
    </div>
  </nav>

  <div class="container py-4">
    <div class="row g-4">
      <!-- Card: Media -->
      <div class="col-sm-6 col-lg-3">
        <div class="card admin-card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <div class="icon-box bg-success bg-opacity-10 text-success me-3">
                <i class="bi bi-image-fill"></i>
              </div>
              <h5 class="card-title mb-0">Multimedia</h5>
            </div>
            <p class="card-text text-muted small">Sube imágenes y videos a tus proyectos</p>
            <div class="d-grid gap-2">
              <a href="upload_media.php" class="btn btn-outline-success btn-sm"><i class="bi bi-cloud-upload"></i> Subir imágenes/videos</a>
              <a href="upload_zip.php" class="btn btn-outline-success btn-sm"><i class="bi bi-file-zip"></i> Subir ZIP descargable</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Card: Ventas -->
      <div class="col-sm-6 col-lg-3">
        <div class="card admin-card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <div class="icon-box bg-warning bg-opacity-10 text-warning me-3">
                <i class="bi bi-cart-fill"></i>
              </div>
              <h5 class="card-title mb-0">Ventas</h5>
            </div>
            <p class="card-text text-muted small">Revisa y aprueba compras de clientes</p>
            <div class="d-grid gap-2">
              <a href="purchases.php" class="btn btn-outline-warning btn-sm"><i class="bi bi-receipt"></i> Compras / Aprobar descargas</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Card: Categorías -->
      <div class="col-sm-6 col-lg-3">
        <div class="card admin-card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <div class="icon-box bg-info bg-opacity-10 text-info me-3">
                <i class="bi bi-tags-fill"></i>
              </div>
              <h5 class="card-title mb-0">Categorías</h5>
            </div>
            <p class="card-text text-muted small">Organiza tus proyectos por tecnología</p>
            <div class="d-grid gap-2">
              <a href="add_category.php" class="btn btn-outline-info btn-sm"><i class="bi bi-plus-circle"></i> Añadir categoría</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Card: Configuración -->
      <div class="col-sm-6 col-lg-3">
        <div class="card admin-card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <div class="icon-box bg-secondary bg-opacity-10 text-secondary me-3">
                <i class="bi bi-gear-fill"></i>
              </div>
              <h5 class="card-title mb-0">Configuración</h5>
            </div>
            <p class="card-text text-muted small">Ajustes de cuenta y seguridad</p>
            <div class="d-grid gap-2">
              <a href="change_password.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-key"></i> Cambiar contraseña</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sección de Estadísticas -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
              <div>
                <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Estadísticas de Proyectos</h5>
                <p class="text-muted small mb-0 mt-1">Vista general de todos tus proyectos</p>
              </div>
              <div class="d-flex gap-3 align-items-center flex-wrap">
                <div class="text-center">
                  <div class="text-muted small">Total Proyectos</div>
                  <div class="h4 mb-0 text-primary"><?= $total_proyectos ?></div>
                </div>
                <div class="text-center">
                  <div class="text-muted small">Total Ventas</div>
                  <div class="h4 mb-0 text-success"><?= $total_ventas ?></div>
                </div>
                <a href="add_project.php" class="btn btn-primary">
                  <i class="bi bi-plus-circle me-1"></i>Añadir Proyecto
                </a>
              </div>
            </div>
          </div>
          <div class="card-body p-0">
            <?php if(empty($proyectos_stats)): ?>
              <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox display-1 d-block mb-3"></i>
                <p>No hay proyectos registrados aún</p>
                <a href="add_project.php" class="btn btn-primary">
                  <i class="bi bi-plus-circle me-1"></i>Crear primer proyecto
                </a>
              </div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th class="px-4">ID</th>
                      <th>Proyecto</th>
                      <th>Categoría</th>
                      <th class="text-center">Multimedia</th>
                      <th class="text-center">Compras</th>
                      <th class="text-end">Precio</th>
                      <th class="text-center">Estado</th>
                      <th class="text-end px-4">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($proyectos_stats as $proyecto): ?>
                      <tr>
                        <td class="px-4">
                          <span class="badge bg-secondary">#<?= $proyecto['id'] ?></span>
                        </td>
                        <td>
                          <strong><?= htmlspecialchars($proyecto['titulo']) ?></strong>
                        </td>
                        <td>
                          <span class="badge bg-info bg-opacity-10 text-info">
                            <?= htmlspecialchars($proyecto['categoria_nombre'] ?? 'Sin categoría') ?>
                          </span>
                        </td>
                        <td class="text-center">
                          <span class="badge bg-success bg-opacity-10 text-success">
                            <i class="bi bi-images me-1"></i><?= $proyecto['total_media'] ?>
                          </span>
                        </td>
                        <td class="text-center">
                          <?php if($proyecto['total_compras'] > 0): ?>
                            <span class="badge bg-warning bg-opacity-10 text-warning">
                              <i class="bi bi-cart-check me-1"></i><?= $proyecto['total_compras'] ?>
                            </span>
                          <?php else: ?>
                            <span class="text-muted small">0</span>
                          <?php endif; ?>
                        </td>
                        <td class="text-end">
                          <?php if($proyecto['precio']): ?>
                            <strong class="text-success"><?= formatCOP($proyecto['precio']) ?></strong>
                          <?php else: ?>
                            <span class="badge bg-secondary">Gratis</span>
                          <?php endif; ?>
                        </td>
                        <td class="text-center">
                          <?php if($proyecto['destacado']): ?>
                            <i class="bi bi-star-fill text-warning" title="Destacado"></i>
                          <?php else: ?>
                            <i class="bi bi-star text-muted opacity-25" title="No destacado"></i>
                          <?php endif; ?>
                        </td>
                        <td class="text-end px-4">
                          <div class="btn-group btn-group-sm" role="group">
                            <a href="edit_project.php?id=<?= $proyecto['id'] ?>" 
                               class="btn btn-outline-primary" 
                               title="Editar">
                              <i class="bi bi-pencil"></i>
                            </a>
                            <a href="upload_media.php?proyecto_id=<?= $proyecto['id'] ?>" 
                               class="btn btn-outline-success" 
                               title="Gestionar media">
                              <i class="bi bi-images"></i>
                            </a>
                            <a href="delete_project.php?id=<?= $proyecto['id'] ?>" 
                               class="btn btn-outline-danger" 
                               title="Eliminar">
                              <i class="bi bi-trash"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
