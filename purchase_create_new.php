<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/db.php';

// Configurar log de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

if($_SERVER['REQUEST_METHOD']!=='POST'){
    http_response_code(405); 
    echo 'Method not allowed'; 
    exit;
}

$projectId = (int)($_POST['proyecto_id'] ?? 0);
$nombre    = trim($_POST['nombre'] ?? '');
$email     = trim($_POST['email'] ?? '');
$metodo    = trim($_POST['metodo'] ?? '');
$refer     = trim($_POST['referencia'] ?? '');

if(!$projectId || !$nombre || !$email || !$metodo){
    http_response_code(400); 
    echo 'Faltan campos requeridos'; 
    exit;
}

$stmt=$pdo->prepare('SELECT titulo, precio, download_path, password_encrypted FROM proyecto WHERE id=?');
$stmt->execute([$projectId]);
$proj=$stmt->fetch();
if(!$proj){ 
    http_response_code(404); 
    echo 'Proyecto no encontrado'; 
    exit; 
}

$reciboPath=null;
if(isset($_FILES['recibo']) && $_FILES['recibo']['error']===UPLOAD_ERR_OK){
    // Procesar recibo si existe
}

// Evitar duplicados recientes
$purchaseId = null;
try {
    $dup=$pdo->prepare('SELECT id FROM purchase WHERE proyecto_id=? AND email=? AND status="pending" AND created_at > (NOW() - INTERVAL 5 MINUTE) ORDER BY id DESC LIMIT 1');
    $dup->execute([$projectId,$email]);
    $purchaseId = (int)($dup->fetchColumn() ?: 0);
} catch (Throwable $_e) { /* ignorar */ }

if(!$purchaseId){
    try {
        // Verificar si el proyecto es gratuito
        $isGratis = ($proj['precio'] === null || $proj['precio'] === '0' || $proj['precio'] === 0);
        $initialStatus = $isGratis ? 'approved' : 'pending';
        
        error_log("Insertando compra: Proyecto={$projectId}, Gratis={$isGratis}, Status={$initialStatus}");
        
        // Generar número de orden
        require_once __DIR__ . '/includes/invoice_generator.php';
        $generator = new InvoiceGenerator();
        $invoiceNumber = $generator->generateInvoiceNumber();
        error_log("Número de orden generado: {$invoiceNumber}");
        
        // Insertar compra
        $ins=$pdo->prepare('INSERT INTO purchase (proyecto_id,nombre,email,metodo,monto,moneda,status,referencia,recibo_path,invoice_number) VALUES (?,?,?,?,?,?,?,?,?,?)');
        $ins->execute([
            $projectId,
            $nombre,
            $email,
            $metodo,
            $proj['precio']??null,
            'COP',
            $initialStatus,
            $refer,
            $reciboPath,
            $invoiceNumber
        ]);
        $purchaseId = (int)$pdo->lastInsertId();
        error_log("Compra insertada con ID: {$purchaseId}");
        
    } catch (Exception $e) {
        error_log("Error al insertar compra: " . $e->getMessage());
        http_response_code(500);
        echo "Error al procesar la compra: " . $e->getMessage();
        exit;
    }
}

// Notificación al comprador
if(isset($ins) && $isGratis) {
    try {
        // Generar token de descarga
        $token = bin2hex(random_bytes(16));
        $now = new DateTime('now');
        $exp = (clone $now)->modify('+72 hours');
        
        // Guardar token
        $ins=$pdo->prepare('INSERT INTO purchase_token (purchase_id,proyecto_id,email,token,created_at,expires_at,requester_ip) VALUES (?,?,?,?,?,?,?)');
        $ins->execute([
            $purchaseId,
            $projectId,
            $email,
            $token,
            $now->format('Y-m-d H:i:s'),
            $exp->format('Y-m-d H:i:s'),
            $_SERVER['REMOTE_ADDR'] ?? null
        ]);
        
        // Preparar enlace y contraseña
        $downloadLink = siteUrl('download.php?t=' . urlencode($token));
        $password = '';
        
        // Verificar contraseña
        if (!empty($proj['password_encrypted'])) {
            try {
                $password = decryptSecret($proj['password_encrypted']);
                error_log("Contraseña descifrada para proyecto {$projectId}");
            } catch (Exception $e) {
                error_log("Error al descifrar contraseña: " . $e->getMessage());
                $password = '';
            }
        }
        
        // Preparar correo
        $mailBody = '<p>Hola '.htmlspecialchars($nombre).',</p>'
                 . '<p>Tu descarga del proyecto "'.htmlspecialchars($proj['titulo']).'" está lista.</p>'
                 . '<p>Tu número de orden es: <strong>'.$invoiceNumber.'</strong></p>'
                 . '<p>Puedes descargar tu archivo en el siguiente enlace (vigencia 72 horas):<br>'
                 . '<a href="'.htmlspecialchars($downloadLink).'">'.htmlspecialchars($downloadLink).'</a></p>';
        
        // Añadir contraseña si existe
        if (!empty($password)) {
            $mailBody .= '<p><strong>IMPORTANTE - Contraseña del archivo ZIP:</strong> '.htmlspecialchars($password).'</p>'
                      . '<p>Necesitarás esta contraseña para extraer los archivos después de la descarga.</p>';
        }
        
        $mailBody .= '<p>Si el enlace expira, podrás solicitar uno nuevo desde la misma página.</p>'
                   . '<p>Saludos,<br>Ing. Joel Cadenas</p>';
        
        // Enviar correo
        @sendSiteEmail(
            $email,
            'Enlace de descarga - ' . $proj['titulo'],
            $mailBody
        );
        
    } catch (Exception $e) {
        error_log("Error al procesar descarga gratuita: " . $e->getMessage());
        http_response_code(500);
        echo "Error al procesar la descarga: " . $e->getMessage();
        exit;
    }
} elseif (isset($ins)) {
    // Para proyectos pagos
    @sendSiteEmail(
        $email,
        'Recibimos tu solicitud de pago',
        '<p>Hola '.htmlspecialchars($nombre).', recibimos tu pago por "'.htmlspecialchars($proj['titulo']).'". '
        . 'Te avisaremos por correo cuando esté aprobado y podrás descargar tu proyecto con un enlace seguro.</p>'
    );
}
