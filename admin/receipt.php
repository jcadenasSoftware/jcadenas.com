<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

// TODO: protect this page with admin auth

try {
    $id = (int)($_GET['id'] ?? 0);
    if(!$id){ http_response_code(400); throw new RuntimeException('ID inválido'); }

    // Obtener compra y ruta del recibo
    $stmt = $pdo->prepare('SELECT id, nombre, email, referencia, created_at, recibo_path FROM purchase WHERE id=?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if(!$row){ http_response_code(404); throw new RuntimeException('Compra no encontrada'); }

    $stored = (string)($row['recibo_path'] ?? '');
    if(!$stored){ http_response_code(404); throw new RuntimeException('No hay recibo adjunto'); }

    // Resolver ruta absoluta si viene relativa
    $path = $stored;
    $isWindowsAbs = preg_match('~^[A-Za-z]:\\\\~', $stored) === 1; // C:\...
    $isUnixAbs = str_starts_with($stored, '/');
    if(!$isWindowsAbs && !$isUnixAbs){
        // Para comprobantes, usar el directorio web principal
        $webRoot = dirname(__DIR__); // Directorio raíz del sitio web
        $path = $webRoot . DIRECTORY_SEPARATOR . ltrim($stored, '/\\');
    }

    if(!is_file($path)){
        http_response_code(404);
        throw new RuntimeException('Archivo de recibo no disponible');
    }

    // Detectar MIME
    $mime = 'application/octet-stream';
    if(function_exists('finfo_open')){
        $fi = finfo_open(FILEINFO_MIME_TYPE);
        if($fi){
            $det = finfo_file($fi, $path);
            if($det){ $mime = $det; }
            finfo_close($fi);
        }
    } else {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg','jpeg'])) $mime='image/jpeg';
        elseif($ext==='png') $mime='image/png';
        elseif($ext==='pdf') $mime='application/pdf';
    }

    // Forzar vista en navegador si es visualizable
    $filename = basename($path);
    header('Content-Type: '.$mime);
    $inlineTypes = ['image/jpeg','image/png','application/pdf'];
    $disp = in_array($mime, $inlineTypes, true) ? 'inline' : 'attachment';
    header('Content-Disposition: '.$disp.'; filename="'.$filename.'"');
    header('Content-Length: '.filesize($path));
    header('Cache-Control: private, max-age=0, must-revalidate');
    readfile($path);
    exit;
} catch (Throwable $e) {
    echo '<!doctype html><html lang="es"><head><meta charset="utf-8"><title>Recibo</title><meta name="viewport" content="width=device-width,initial-scale=1"></head><body style="font-family:system-ui;padding:2rem">';
    echo '<h3>Error</h3>';
    echo '<p style="color:#c00">'.htmlspecialchars($e->getMessage()).'</p>';
    echo '<p><a href="purchases.php">&larr; Volver</a></p>';
    echo '</body></html>';
}
