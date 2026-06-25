<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

function columnExists(PDO $pdo, string $table, string $column): bool {
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?");
  $stmt->execute([$table, $column]);
  return (int)$stmt->fetchColumn() > 0;
}

$changes = [];
$errors = [];

try {
  $needs = [
    'download_path', 'download_mime', 'download_size',
    'password_encrypted', 'password_hint', 'updated_at'
  ];
  $missing = [];
  foreach($needs as $col){
    if(!columnExists($pdo, 'proyecto', $col)) { $missing[] = $col; }
  }

  if ($missing) {
    $sql = "ALTER TABLE proyecto\n      "
      .(in_array('download_path',$missing)?"ADD COLUMN download_path VARCHAR(255) NULL,\n":"")
      .(in_array('download_mime',$missing)?"ADD COLUMN download_mime VARCHAR(60) NULL,\n":"")
      .(in_array('download_size',$missing)?"ADD COLUMN download_size INT NULL,\n":"")
      .(in_array('password_encrypted',$missing)?"ADD COLUMN password_encrypted TEXT NULL,\n":"")
      .(in_array('password_hint',$missing)?"ADD COLUMN password_hint VARCHAR(120) NULL,\n":"")
      .(in_array('updated_at',$missing)?"ADD COLUMN updated_at DATETIME NULL,\n":"");
    $sql = rtrim($sql, ",\n").";";
    $pdo->exec($sql);
    $changes[] = "ALTER aplicado: ".$sql;
  } else {
    $changes[] = "No hay cambios: todas las columnas existen.";
  }
} catch (Throwable $e) {
  $errors[] = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Migración DB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h1 class="mb-4">Migración de base de datos</h1>
    <?php if($errors): ?>
      <div class="alert alert-danger"><strong>Error:</strong><br><?php foreach($errors as $e){ echo htmlspecialchars($e)."<br>"; } ?></div>
    <?php else: ?>
      <div class="alert alert-success"><strong>OK</strong><br><?php foreach($changes as $c){ echo htmlspecialchars($c)."<br>"; } ?></div>
    <?php endif; ?>
    <a href="index.php" class="btn btn-secondary mt-3">Volver al panel</a>
  </div>
</body>
</html>
