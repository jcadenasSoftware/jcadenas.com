<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/db.php';

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

$purchaseId = (int)($_GET['purchase'] ?? 0);
if(!$purchaseId){ http_response_code(400); echo 'Solicitud inválida'; exit; }

// Load purchase
$stmt=$pdo->prepare('SELECT p.*, pr.titulo, pr.password_encrypted FROM purchase p JOIN proyecto pr ON pr.id=p.proyecto_id WHERE p.id=?');
$stmt->execute([$purchaseId]);
$p=$stmt->fetch();
if(!$p){ http_response_code(404); echo 'Compra no encontrada'; exit; }
if(strtolower((string)$p['status'])!=='approved'){
  http_response_code(403); echo 'La compra aún no está aprobada'; exit; }

// Simple rate-limit: max 1 per 15 min and 3 per día
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$now = new DateTime('now');
$ago15 = (clone $now)->modify('-15 minutes')->format('Y-m-d H:i:s');
$today = (new DateTime('today'))->format('Y-m-d 00:00:00');

$cnt15=$pdo->prepare('SELECT COUNT(*) FROM purchase_token WHERE purchase_id=? AND created_at>=?');
$cnt15->execute([$purchaseId,$ago15]);
$cntDay=$pdo->prepare('SELECT COUNT(*) FROM purchase_token WHERE purchase_id=? AND created_at>=?');
$cntDay->execute([$purchaseId,$today]);

if((int)$cnt15->fetchColumn()>=1){ echo 'Ya solicitaste un enlace recientemente. Intenta nuevamente en unos minutos.'; exit; }
if((int)$cntDay->fetchColumn()>=3){ echo 'Has alcanzado el límite de solicitudes por hoy.'; exit; }

// Issue new token (72h)
$token = bin2hex(random_bytes(16));
$exp = (clone $now)->modify('+72 hours');
$ins=$pdo->prepare('INSERT INTO purchase_token (purchase_id, proyecto_id, email, token, created_at, expires_at, requester_ip) VALUES (?,?,?,?,?,?,?)');
$ins->execute([$p['id'], $p['proyecto_id'], $p['email'], $token, $now->format('Y-m-d H:i:s'), $exp->format('Y-m-d H:i:s'), $ip]);

$downloadLink = siteUrl('download.php?t=' . urlencode($token));
$password = !empty($p['password_encrypted']) ? decryptSecret($p['password_encrypted']) : '';

$body = '<p>Hola '.htmlspecialchars($p['nombre']).',</p>'
      . '<p>Te enviamos un nuevo enlace de descarga para "'.htmlspecialchars($p['titulo']).'" (vigencia 72 horas):<br>'
      . '<a href="'.htmlspecialchars($downloadLink).'">'.htmlspecialchars($downloadLink).'</a></p>'
      . '<p><strong>Contraseña del ZIP:</strong> '.htmlspecialchars($password ?: 'Sin contraseña').'</p>'
      . '<p>Si necesitas ayuda, responde a este correo.</p>'
      . '<p>Saludos,<br>Ing. Joel Cadenas</p>';

sendSiteEmail($p['email'], 'Nuevo enlace de descarga - ' . ($p['titulo'] ?? ('Proyecto #'.$p['proyecto_id'])), $body);

echo 'Hemos enviado un nuevo enlace de descarga a tu correo.';
