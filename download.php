<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/db.php';

// Ensure token table exists (first run safeguard)
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

$token = $_GET['t'] ?? ($_GET['token'] ?? '');
if(!$token){ http_response_code(400); echo 'Token requerido'; exit; }

// Load token + purchase + project
$stmt=$pdo->prepare('SELECT pt.*, p.nombre, p.email, p.status, pr.titulo, pr.download_path, pr.download_mime, pr.password_encrypted
                     FROM purchase_token pt
                     JOIN purchase p ON p.id=pt.purchase_id
                     JOIN proyecto pr ON pr.id=pt.proyecto_id
                     WHERE pt.token=?');
$stmt->execute([$token]);
$row=$stmt->fetch();
if(!$row){ http_response_code(404); echo 'Enlace no válido'; exit; }

// Normalizar estado: si hay token válido, la emisión de token implica aprobación.
if(strtolower((string)$row['status'])!=='approved'){
  try {
    $up=$pdo->prepare('UPDATE purchase SET status="approved" WHERE id=?');
    $up->execute([$row['purchase_id']]);
    $row['status']='approved';
  } catch (Throwable $_e) { /* continuar */ }
}

$nowTs = time();
$expTs = strtotime($row['expires_at']);
if($expTs !== false && $expTs < $nowTs){
  // Show expired page with option to request new link
  $reqUrl = siteUrl('request_download.php?purchase='.(int)$row['purchase_id']);
  echo '<!doctype html><html><head><meta charset="utf-8"><title>Enlace expirado</title>';
  echo '<meta name="viewport" content="width=device-width,initial-scale=1">';
  echo '</head><body style="font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Helvetica,Arial,sans-serif;padding:2rem">';
  echo '<h3>Enlace expirado</h3>';
  echo '<p>Tu enlace de descarga ha expirado por seguridad. Puedes solicitar un nuevo enlace a tu correo.</p>';
  echo '<p><a href="'.htmlspecialchars($reqUrl).'" style="display:inline-block;padding:.6rem 1rem;background:#0d6efd;color:#fff;text-decoration:none;border-radius:.25rem">Solicitar nuevo enlace</a></p>';
  echo '</body></html>';
  exit; }

// Resolve project file path (relative paths are resolved against SECURE_DOWNLOAD_BASE)
$storedPath = (string)$row['download_path'];
$path = $storedPath;
if ($storedPath) {
  $isWindowsAbs = preg_match('~^[A-Za-z]:\\\\~', $storedPath) === 1; // C:\...
  $isUnixAbs = str_starts_with($storedPath, '/');
  if (!$isWindowsAbs && !$isUnixAbs) {
    // treat as relative to SECURE_DOWNLOAD_BASE
    $baseDir = rtrim(SECURE_DOWNLOAD_BASE, DIRECTORY_SEPARATOR);
    $path = $baseDir . DIRECTORY_SEPARATOR . ltrim($storedPath, '/\\');
  }
}
if(!$path || !is_file($path)){ http_response_code(404); echo 'Archivo no disponible'; exit; }
$mime = $row['download_mime'] ?: 'application/octet-stream';

// Show password and confirm before download
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
  // Obtener la contraseña del proyecto
  $pwd = '';
  if (!empty($row['password_encrypted'])) {
    try {
      $pwd = decryptSecret($row['password_encrypted']);
    } catch (Exception $e) {
      error_log("Error al descifrar contraseña: " . $e->getMessage());
      $pwd = '';
    }
  }
  
  $home = siteUrl('index.php');
  $portfolio = siteUrl('portfolio.php#proyectos');
  $expirationDate = date('d/m/Y \a \l\a\s H:i', strtotime($row['expires_at']));
  
  echo '<!doctype html><html lang="es"><head>';
  echo '<meta charset="utf-8">';
  echo '<meta name="viewport" content="width=device-width,initial-scale=1">';
  echo '<title>Descarga tu Proyecto: '.htmlspecialchars($row['titulo']).' | JCadenas</title>';
  echo '<meta name="description" content="Descarga segura de tu proyecto '.htmlspecialchars($row['titulo']).'. Enlace de descarga con contraseña incluida.">';
  echo '<meta name="robots" content="noindex, nofollow">';
  echo '<link rel="icon" type="image/x-icon" href="'.siteUrl('favicon.ico').'">';
  
  // Preload fonts
  echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
  echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'; 
  echo '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">';
  
  // Bootstrap and icons
  echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">';
  echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">';
  
  echo '<style>';
  echo ':root {';
  echo '  --primary-color: #0066cc;';
  echo '  --success-color: #28a745;';
  echo '  --warning-color: #ffc107;';
  echo '  --danger-color: #dc3545;';
  echo '  --dark-color: #2c3e50;';
  echo '  --light-bg: #f8f9fa;';
  echo '  --shadow: 0 10px 30px rgba(0,0,0,0.1);';
  echo '  --border-radius: 12px;';
  echo '}';
  echo 'body {';
  echo '  font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;';
  echo '  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);';
  echo '  min-height: 100vh;';
  echo '  margin: 0;';
  echo '  padding: 20px 0;';
  echo '}';
  echo '.download-container {';
  echo '  max-width: 800px;';
  echo '  margin: 0 auto;';
  echo '  padding: 20px;';
  echo '}';
  echo '.download-card {';
  echo '  background: white;';
  echo '  border-radius: var(--border-radius);';
  echo '  box-shadow: var(--shadow);';
  echo '  overflow: hidden;';
  echo '  margin-bottom: 20px;';
  echo '}';
  echo '.card-header {';
  echo '  background: linear-gradient(135deg, var(--primary-color), #0052a3);';
  echo '  color: white;';
  echo '  padding: 30px;';
  echo '  text-align: center;';
  echo '  position: relative;';
  echo '}';
  echo '.card-header::before {';
  echo '  content: "";';
  echo '  position: absolute;';
  echo '  top: 0;';
  echo '  left: 0;';
  echo '  right: 0;';
  echo '  bottom: 0;';
  echo '  background: url("data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");';
  echo '}';
  echo '.success-icon {';
  echo '  width: 80px;';
  echo '  height: 80px;';
  echo '  background: rgba(255,255,255,0.2);';
  echo '  border-radius: 50%;';
  echo '  display: flex;';
  echo '  align-items: center;';
  echo '  justify-content: center;';
  echo '  margin: 0 auto 20px;';
  echo '  position: relative;';
  echo '  z-index: 1;';
  echo '}';
  echo '.project-title {';
  echo '  font-size: 2rem;';
  echo '  font-weight: 700;';
  echo '  margin: 0 0 10px;';
  echo '  position: relative;';
  echo '  z-index: 1;';
  echo '}';
  echo '.project-subtitle {';
  echo '  font-size: 1.1rem;';
  echo '  opacity: 0.9;';
  echo '  margin: 0;';
  echo '  position: relative;';
  echo '  z-index: 1;';
  echo '}';
  echo '.card-body {';
  echo '  padding: 40px;';
  echo '}';
  echo '.expiration-info {';
  echo '  background: #e3f2fd;';
  echo '  border: 1px solid #bbdefb;';
  echo '  border-radius: 8px;';
  echo '  padding: 15px;';
  echo '  margin-bottom: 30px;';
  echo '  text-align: center;';
  echo '}';
  echo '.password-section {';
  echo '  margin: 30px 0;';
  echo '}';
  echo '.password-box {';
  echo '  background: #fff3cd;';
  echo '  border: 2px solid #ffc107;';
  echo '  border-radius: 10px;';
  echo '  padding: 25px;';
  echo '  text-align: center;';
  echo '  position: relative;';
  echo '}';
  echo '.password-display {';
  echo '  background: #ffffff;';
  echo '  border: 2px dashed #ffc107;';
  echo '  border-radius: 8px;';
  echo '  padding: 20px;';
  echo '  margin: 20px 0;';
  echo '  font-family: "Courier New", monospace;';
  echo '  font-size: 1.5rem;';
  echo '  font-weight: bold;';
  echo '  color: #856404;';
  echo '  letter-spacing: 2px;';
  echo '  word-break: break-all;';
  echo '  cursor: pointer;';
  echo '  transition: all 0.3s ease;';
  echo '}';
  echo '.password-display:hover {';
  echo '  background: #f8f9fa;';
  echo '  transform: scale(1.02);';
  echo '}';
  echo '.copy-btn {';
  echo '  position: absolute;';
  echo '  top: 15px;';
  echo '  right: 15px;';
  echo '  background: #ffc107;';
  echo '  border: none;';
  echo '  border-radius: 6px;';
  echo '  padding: 8px 12px;';
  echo '  color: #856404;';
  echo '  cursor: pointer;';
  echo '  transition: all 0.3s ease;';
  echo '}';
  echo '.copy-btn:hover {';
  echo '  background: #e0a800;';
  echo '}';
  echo '.download-section {';
  echo '  text-align: center;';
  echo '  margin: 40px 0;';
  echo '}';
  echo '.download-btn {';
  echo '  background: linear-gradient(135deg, var(--success-color), #1e7e34);';
  echo '  border: none;';
  echo '  color: white;';
  echo '  padding: 18px 40px;';
  echo '  font-size: 1.2rem;';
  echo '  font-weight: 600;';
  echo '  border-radius: 50px;';
  echo '  cursor: pointer;';
  echo '  transition: all 0.3s ease;';
  echo '  box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);';
  echo '  text-decoration: none;';
  echo '  display: inline-flex;';
  echo '  align-items: center;';
  echo '  gap: 10px;';
  echo '}';
  echo '.download-btn:hover {';
  echo '  transform: translateY(-2px);';
  echo '  box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);';
  echo '  color: white;';
  echo '}';
  echo '.secondary-actions {';
  echo '  display: flex;';
  echo '  gap: 15px;';
  echo '  justify-content: center;';
  echo '  flex-wrap: wrap;';
  echo '  margin-top: 30px;';
  echo '}';
  echo '.secondary-btn {';
  echo '  background: #f8f9fa;';
  echo '  border: 2px solid #dee2e6;';
  echo '  color: #495057;';
  echo '  padding: 12px 24px;';
  echo '  border-radius: 25px;';
  echo '  text-decoration: none;';
  echo '  font-weight: 500;';
  echo '  transition: all 0.3s ease;';
  echo '  display: inline-flex;';
  echo '  align-items: center;';
  echo '  gap: 8px;';
  echo '}';
  echo '.secondary-btn:hover {';
  echo '  background: #e9ecef;';
  echo '  border-color: #adb5bd;';
  echo '  color: #495057;';
  echo '  transform: translateY(-1px);';
  echo '}';
  echo '.footer-info {';
  echo '  background: #f8f9fa;';
  echo '  border-radius: var(--border-radius);';
  echo '  padding: 25px;';
  echo '  text-align: center;';
  echo '  color: #6c757d;';
  echo '  line-height: 1.6;';
  echo '}';
  echo '.no-password-info {';
  echo '  background: #d1ecf1;';
  echo '  border: 2px solid #bee5eb;';
  echo '  border-radius: 10px;';
  echo '  padding: 25px;';
  echo '  text-align: center;';
  echo '  color: #0c5460;';
  echo '}';
  echo '@media (max-width: 768px) {';
  echo '  .download-container { padding: 10px; }';
  echo '  .card-body { padding: 25px; }';
  echo '  .project-title { font-size: 1.5rem; }';
  echo '  .password-display { font-size: 1.2rem; padding: 15px; }';
  echo '  .secondary-actions { flex-direction: column; align-items: center; }';
  echo '}';
  echo '</style>';
  echo '</head>';
  echo '<body>';
  echo '<div class="download-container">';
  echo '<div class="download-card">';
  
  // Header with project info
  echo '<div class="card-header">';
  echo '<div class="success-icon">';
  echo '<i class="bi bi-check-circle-fill" style="font-size: 2.5rem;"></i>';
  echo '</div>';
  echo '<h1 class="project-title">'.htmlspecialchars($row['titulo']).'</h1>';
  echo '<p class="project-subtitle">Tu descarga está lista y verificada</p>';
  echo '</div>';
  
  echo '<div class="card-body">';
  
  // Expiration info
  echo '<div class="expiration-info">';
  echo '<i class="bi bi-clock text-primary me-2"></i>';
  echo '<strong>Enlace válido hasta:</strong> '.$expirationDate;
  echo '</div>';
  
  // Password section
  echo '<div class="password-section">';
  if (!empty($pwd)) {
    echo '<div class="password-box">';
    echo '<button class="copy-btn" onclick="copyPassword()" title="Copiar contraseña">';
    echo '<i class="bi bi-clipboard"></i>';
    echo '</button>';
    echo '<h4 style="margin: 0 0 15px; color: #856404;">';
    echo '<i class="bi bi-key-fill me-2"></i>Contraseña del Archivo ZIP';
    echo '</h4>';
    echo '<p style="margin: 0 0 20px; color: #856404;">Necesitarás esta contraseña para descomprimir el archivo:</p>';
    echo '<div class="password-display" onclick="selectPassword()" id="passwordDisplay">'.htmlspecialchars($pwd).'</div>';
    echo '<div style="display: flex; align-items: center; justify-content: center; gap: 10px; color: #856404; font-size: 0.9rem;">';
    echo '<i class="bi bi-info-circle"></i>';
    echo '<span>Haz clic en la contraseña para seleccionarla</span>';
    echo '</div>';
    echo '</div>';
  } else {
    echo '<div class="no-password-info">';
    echo '<h4 style="margin: 0 0 15px;">';
    echo '<i class="bi bi-unlock-fill me-2"></i>Archivo sin Protección';
    echo '</h4>';
    echo '<p style="margin: 0;">Este archivo no requiere contraseña para su extracción. Puedes descomprimirlo directamente.</p>';
    echo '</div>';
  }
  echo '</div>';
  
  // Download section
  echo '<div class="download-section">';
  echo '<form method="post" style="margin: 0;">';
  echo '<button type="submit" class="download-btn">';
  echo '<i class="bi bi-download"></i>';
  echo 'Descargar Proyecto';
  echo '</button>';
  echo '</form>';
  echo '</div>';
  
  // Secondary actions
  echo '<div class="secondary-actions">';
  echo '<a href="'.htmlspecialchars($portfolio).'" class="secondary-btn">';
  echo '<i class="bi bi-grid-3x3-gap"></i>';
  echo 'Ver Más Proyectos';
  echo '</a>';
  echo '<a href="'.htmlspecialchars($home).'" class="secondary-btn">';
  echo '<i class="bi bi-house"></i>';
  echo 'Ir al Inicio';
  echo '</a>';
  echo '<a href="https://wa.me/573012345678?text=Hola,%20necesito%20ayuda%20con%20mi%20descarga" class="secondary-btn" target="_blank">';
  echo '<i class="bi bi-whatsapp"></i>';
  echo 'Soporte WhatsApp';
  echo '</a>';
  echo '</div>';
  
  echo '</div>'; // End card-body
  echo '</div>'; // End download-card
  
  // Footer info
  echo '<div class="footer-info">';
  echo '<h5 style="margin: 0 0 15px; color: #495057;">';
  echo '<i class="bi bi-lightbulb me-2"></i>¿Necesitas un Sistema Personalizado?';
  echo '</h5>';
  echo '<p style="margin: 0 0 15px;">Si requieres un desarrollo a la medida, estaré encantado de ayudarte. ';
  echo 'Especializado en aplicaciones web, móviles y sistemas empresariales.</p>';
  echo '<div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">';
  echo '<a href="mailto:servicios@jcadenas.com" style="color: #0066cc; text-decoration: none;">';
  echo '<i class="bi bi-envelope me-1"></i>servicios@jcadenas.com';
  echo '</a>';
  echo '<a href="https://wa.me/573012345678" style="color: #25d366; text-decoration: none;" target="_blank">';
  echo '<i class="bi bi-whatsapp me-1"></i>WhatsApp';
  echo '</a>';
  echo '<a href="'.htmlspecialchars($portfolio).'" style="color: #6f42c1; text-decoration: none;">';
  echo '<i class="bi bi-briefcase me-1"></i>Portafolio';
  echo '</a>';
  echo '</div>';
  echo '</div>';
  
  echo '</div>'; // End download-container
  
  // JavaScript for copy functionality
  echo '<script>';
  echo 'function copyPassword() {';
  echo '  const passwordText = document.getElementById("passwordDisplay").textContent;';
  echo '  navigator.clipboard.writeText(passwordText).then(function() {';
  echo '    const btn = document.querySelector(".copy-btn");';
  echo '    const originalHTML = btn.innerHTML;';
  echo '    btn.innerHTML = "<i class=\\"bi bi-check\\"></i>";';
  echo '    btn.style.background = "#28a745";';
  echo '    setTimeout(function() {';
  echo '      btn.innerHTML = originalHTML;';
  echo '      btn.style.background = "#ffc107";';
  echo '    }, 2000);';
  echo '  });';
  echo '}';
  echo 'function selectPassword() {';
  echo '  const passwordDiv = document.getElementById("passwordDisplay");';
  echo '  const range = document.createRange();';
  echo '  range.selectNodeContents(passwordDiv);';
  echo '  const selection = window.getSelection();';
  echo '  selection.removeAllRanges();';
  echo '  selection.addRange(range);';
  echo '}';
  echo '</script>';
  
  echo '</body></html>';
  exit;
}

// Force download (do not expose file path)
$filename = basename($path);
header('Content-Description: File Transfer');
header('Content-Type: '.$mime);
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Content-Length: '.filesize($path));
header('Cache-Control: no-cache, must-revalidate');
readfile($path);
exit;
