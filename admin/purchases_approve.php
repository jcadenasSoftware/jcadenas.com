<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../includes/purchase_approval.php';

// TODO: protect this action with admin auth

try {
  $id = (int)($_GET['id'] ?? 0);
  $resend = isset($_GET['resend']);
  if(!$id){ http_response_code(400); throw new RuntimeException('ID inválido'); }

  // Ensure token table exists
  $pdo->exec("CREATE TABLE IF NOT EXISTS purchase_token (
    id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_id INT NOT NULL,
    proyecto_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL,
    created_at DATETIME NOT NULL,
    expires_at DATETIME NOT NULL,
    used TINYINT(1) NOT NULL DEFAULT 0,
    requester_ip VARCHAR(64) DEFAULT NULL,
    KEY(purchase_id), KEY(token)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

  // Load purchase
  $stmt=$pdo->prepare('SELECT p.*, pr.titulo, pr.download_path, pr.password_encrypted FROM purchase p LEFT JOIN proyecto pr ON pr.id=p.proyecto_id WHERE p.id=?');
  $stmt->execute([$id]);
  $purchase=$stmt->fetch();
  if(!$purchase){ http_response_code(404); throw new RuntimeException('Compra no encontrada'); }

  // Resolve download path (relative -> SECURE_DOWNLOAD_BASE) and validate
  $storedPath = (string)($purchase['download_path'] ?? '');
  $resolvedPath = $storedPath;
  if ($storedPath) {
    $isWindowsAbs = preg_match('~^[A-Za-z]:\\\\~', $storedPath) === 1; // C:\\...
    $isUnixAbs = str_starts_with($storedPath, '/');
    if (!$isWindowsAbs && !$isUnixAbs) {
      $baseDir = rtrim(SECURE_DOWNLOAD_BASE, DIRECTORY_SEPARATOR);
      $resolvedPath = $baseDir . DIRECTORY_SEPARATOR . ltrim($storedPath, '/\\');
    }
  }
  if(empty($resolvedPath) || !is_file($resolvedPath)){
    throw new RuntimeException('El archivo de descarga no está configurado o no existe en el servidor.');
  }

  // If not resend, ensure pending
  if(!$resend && strtolower((string)$purchase['status'])==='approved'){
    // already approved, fallthrough to resend
    $resend = true;
  }

  // Aprobar compra primero (evita inconsistencias)
  try {
    $up=$pdo->prepare('UPDATE purchase SET status="approved" WHERE id=?');
    $up->execute([$purchase['id']]);
    $purchase['status'] = 'approved';
  } catch(Exception $e) {
    throw new RuntimeException('No se pudo actualizar el estado de la compra a "approved".');
  }

  // Usar la nueva función que envía cuenta de cobro + enlace de descarga
  $sent = sendApprovalNotification($purchase['id']);
  
  if(!$sent){ 
    throw new RuntimeException('No se pudo enviar el correo con la cuenta de cobro y enlace de descarga.');
  }

  $qs = http_build_query(['ok'=>'sent','id'=>(int)$purchase['id'],'resend'=>$resend?1:0]);
  header('Location: purchases.php?'.$qs);
  exit;
} catch (Throwable $e) {
  // Simple error page for admin
  http_response_code(http_response_code() >= 400 ? http_response_code() : 500);
  echo '<!doctype html><html><head><meta charset="utf-8"><title>Error</title></head><body style="font-family:system-ui;padding:2rem">';
  echo '<h3>Error en aprobación</h3>';
  echo '<p style="color:#c00">'.htmlspecialchars($e->getMessage()).'</p>';
  echo '<p><a href="purchases.php">&larr; Volver</a></p>';
  echo '</body></html>';
}
