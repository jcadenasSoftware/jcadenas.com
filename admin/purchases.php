<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

// TODO: protect this page with admin auth

// Status filter
$status_filter = $_GET['status'] ?? 'all';
$valid_statuses = ['all', 'pending', 'approved', 'rejected'];
if (!in_array($status_filter, $valid_statuses)) {
    $status_filter = 'all';
}

// Build query based on filter
$query = 'SELECT p.id, p.proyecto_id, p.nombre, p.email, p.metodo, p.monto, p.moneda, 
                 p.status, p.referencia, p.created_at, p.recibo_path, p.documento, p.direccion, pr.titulo
          FROM purchase p
          LEFT JOIN proyecto pr ON pr.id = p.proyecto_id';

if ($status_filter !== 'all') {
    $query .= ' WHERE p.status = :status';
}
$query .= ' ORDER BY p.id DESC';

$stmt = $pdo->prepare($query);
if ($status_filter !== 'all') {
    $stmt->execute(['status' => $status_filter]);
} else {
    $stmt->execute();
}
$purchases = $stmt->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Compras - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="<?= $base ?>/assets/css/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= $base ?>/assets/css/admin.css" rel="stylesheet">
  <style>
    .table-responsive {
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .table th {
      font-size: 0.85rem;
      font-weight: 600;
      white-space: nowrap;
      vertical-align: middle;
    }
    .table td {
      vertical-align: middle;
      padding: 0.5rem 0.3rem;
    }
    .btn-group-vertical .btn {
      border-radius: 4px !important;
      margin-bottom: 2px;
      font-size: 0.75rem;
      padding: 0.25rem 0.5rem;
      white-space: nowrap;
    }
    .badge {
      font-size: 0.7rem;
    }
    .table tbody tr:hover {
      background-color: rgba(0,123,255,0.05);
    }
    .text-truncate-custom {
      max-width: 150px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
  </style>
</head>
<body class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-0">Compras</h1>
      <div class="btn-group mt-2">
        <a href="?status=all" class="btn btn-sm <?= $status_filter === 'all' ? 'btn-secondary' : 'btn-outline-secondary' ?>">Todas</a>
        <a href="?status=pending" class="btn btn-sm <?= $status_filter === 'pending' ? 'btn-warning' : 'btn-outline-warning' ?>">Pendientes</a>
        <a href="?status=approved" class="btn btn-sm <?= $status_filter === 'approved' ? 'btn-success' : 'btn-outline-success' ?>">Aprobadas</a>
        <a href="?status=rejected" class="btn btn-sm <?= $status_filter === 'rejected' ? 'btn-danger' : 'btn-outline-danger' ?>">Rechazadas</a>
      </div>
    </div>
    <div>
      <a class="btn btn-primary btn-sm" href="index.php">
        <i class="bi bi-speedometer2 me-1"></i>Dashboard
      </a>
      <a class="btn btn-danger btn-sm" href="check_dns.php">
        <i class="bi bi-shield-check me-1"></i>Estado DNS
      </a>
      <a class="btn btn-warning btn-sm" href="check_paths.php">
        <i class="bi bi-folder-check me-1"></i>Ver Rutas
      </a>
      <a class="btn btn-info btn-sm" href="diagnose.php">
        <i class="bi bi-clipboard-check me-1"></i>Diagnóstico
      </a>
      <a class="btn btn-success btn-sm" href="upload_zip.php">
        <i class="bi bi-file-zip me-1"></i>Subir ZIP
      </a>
    </div>
  </div>
  
  <?php if(($_GET['ok'] ?? '')==='sent'): ?>
    <div class="alert alert-success d-flex align-items-center" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>
      <div>
        Enlace <?php echo isset($_GET['resend']) && $_GET['resend'] ? 'reenviado' : 'enviado'; ?> correctamente para la orden #<?php echo (int)($_GET['id'] ?? 0); ?>.
      </div>
    </div>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table table-sm align-middle">
      <thead class="table-dark">
        <tr>
          <th style="width: 60px;">ID</th>
          <th style="width: 200px;">Proyecto</th>
          <th style="width: 140px;">Cliente</th>
          <th style="width: 200px;">Email</th>
          <th style="width: 150px;">Dirección</th>
          <th style="width: 100px;">Método</th>
          <th style="width: 120px;">Monto</th>
          <th style="width: 100px;">Estado</th>
          <th style="width: 120px;">Referencia</th>
          <th style="width: 100px;">Creado</th>
          <th style="width: 220px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($purchases as $row): ?>
          <tr>
            <td>
              <a href="check_order.php?id=<?= (int)$row['id'] ?>" class="text-decoration-none">
                #<?= (int)$row['id']; ?>
              </a>
            </td>
            <td class="small" title="<?= htmlspecialchars($row['titulo'] ?? '') ?>">
              <?= $row['titulo'] ? (strlen($row['titulo']) > 30 ? htmlspecialchars(substr($row['titulo'], 0, 30)) . '...' : htmlspecialchars($row['titulo'])) : 'Proyecto #' . $row['proyecto_id'] ?>
            </td>
            <td class="small"><?= htmlspecialchars($row['nombre']) ?></td>
            <td class="small">
              <a href="mailto:<?= htmlspecialchars($row['email']) ?>" class="text-decoration-none" title="<?= htmlspecialchars($row['email']) ?>">
                <?= strlen($row['email']) > 25 ? htmlspecialchars(substr($row['email'], 0, 25)) . '...' : htmlspecialchars($row['email']) ?>
              </a>
            </td>
            <td class="small text-muted" title="<?= htmlspecialchars($row['direccion'] ?? '') ?>">
              <?= $row['direccion'] ? (strlen($row['direccion']) > 20 ? htmlspecialchars(substr($row['direccion'], 0, 20)) . '...' : htmlspecialchars($row['direccion'])) : '-' ?>
            </td>
            <td class="small">
              <span class="badge bg-secondary"><?= htmlspecialchars(ucfirst($row['metodo'])) ?></span>
            </td>
            <td class="small">
              <?php if($row['monto'] === null || $row['monto'] === '0' || $row['monto'] === 0): ?>
                <span class="badge bg-success">Gratis</span>
              <?php else: ?>
                <strong><?= number_format($row['monto'], 0, ',', '.') ?></strong><br>
                <small class="text-muted"><?= htmlspecialchars($row['moneda'] ?? 'COP') ?></small>
              <?php endif; ?>
            </td>
            <td>
              <?php if($row['status']==='approved'): ?>
                <span class="badge bg-success">Aprobado</span>
              <?php elseif($row['status']==='pending'): ?>
                <span class="badge bg-warning text-dark">Pendiente</span>
              <?php elseif($row['status']==='rejected'): ?>
                <span class="badge bg-danger">Rechazado</span>
              <?php else: ?>
                <span class="badge bg-secondary"><?= htmlspecialchars($row['status'] ?? 'N/A') ?></span>
              <?php endif; ?>
            </td>
            <td class="small text-muted" title="<?= htmlspecialchars($row['referencia'] ?? '') ?>">
              <?= $row['referencia'] ? (strlen($row['referencia']) > 15 ? htmlspecialchars(substr($row['referencia'], 0, 15)) . '...' : htmlspecialchars($row['referencia'])) : '-' ?>
            </td>
            <td class="small text-muted"><?= date('d/m/y', strtotime($row['created_at'] ?? 'now')) ?><br><small><?= date('H:i', strtotime($row['created_at'] ?? 'now')) ?></small></td>
            <td>
              <div class="btn-group-vertical btn-group-sm" role="group">
                <?php if($row['status']==='pending'): ?>
                  <a class="btn btn-success btn-sm mb-1" href="purchases_approve.php?id=<?= (int)$row['id'] ?>" onclick="return confirm('¿Aprobar y enviar enlace de descarga?');">
                    <i class="bi bi-check-lg me-1"></i>Aprobar
                  </a>
                  <a class="btn btn-danger btn-sm mb-1" href="purchases_reject.php?id=<?= (int)$row['id'] ?>" onclick="return confirm('¿Estás seguro de rechazar esta compra?');">
                    <i class="bi bi-x-lg me-1"></i>Rechazar
                  </a>
                <?php elseif($row['status']==='approved'): ?>
                  <a class="btn btn-outline-secondary btn-sm mb-1" href="purchases_approve.php?id=<?= (int)$row['id'] ?>&resend=1">
                    <i class="bi bi-envelope me-1"></i>Reenviar
                  </a>
                <?php endif; ?>
                <?php if(!empty($row['recibo_path'])): ?>
                  <a class="btn btn-outline-primary btn-sm" href="receipt.php?id=<?= (int)$row['id'] ?>" target="_blank">
                    <i class="bi bi-file-earmark-image me-1"></i>Comprobante
                  </a>
                <?php else: ?>
                  <span class="btn btn-outline-secondary btn-sm disabled">
                    <i class="bi bi-file-earmark-x me-1"></i>Sin comprobante
                  </span>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
