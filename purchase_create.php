<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/db.php';
require_once __DIR__.'/includes/mailer.php';

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
$documento = trim($_POST['documento'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');

if(!$projectId || !$nombre || !$email || !$metodo){
    http_response_code(400); 
    echo 'Faltan campos requeridos'; 
    exit;
}

$stmt=$pdo->prepare('SELECT titulo, precio, download_path, password_encrypted, password_hint FROM proyecto WHERE id=?');
error_log("DEBUG: Consultando proyecto ID: {$projectId}");
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
    $uploadedFile = $_FILES['recibo'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    // Validar tipo de archivo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $uploadedFile['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mimeType, $allowedTypes)) {
        throw new RuntimeException('Tipo de archivo no permitido. Solo se permiten imágenes (JPG, PNG, GIF, WEBP) y PDF.');
    }
    
    // Validar tamaño
    if ($uploadedFile['size'] > $maxSize) {
        throw new RuntimeException('El archivo es demasiado grande. Máximo 5MB.');
    }
    
    // Crear directorio de recibos si no existe
    $uploadDir = __DIR__ . '/uploads/recibos/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Generar nombre único para el archivo
    $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
    $fileName = 'recibo_' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.' . $extension;
    $reciboPath = 'uploads/recibos/' . $fileName; // Ruta relativa para la BD
    $fullPath = $uploadDir . $fileName; // Ruta completa para mover el archivo
    
    // Mover archivo
    if (!move_uploaded_file($uploadedFile['tmp_name'], $fullPath)) {
        throw new RuntimeException('Error al guardar el comprobante.');
    }
    
    error_log("Comprobante guardado: {$reciboPath}");
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
        $ins=$pdo->prepare('INSERT INTO purchase (proyecto_id,nombre,email,metodo,monto,moneda,status,referencia,recibo_path,invoice_number,documento,direccion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)');
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
            $invoiceNumber,
            $documento ?: null,
            $direccion ?: null
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
        
        // Obtener contraseña del proyecto
        if (!empty($proj['password_encrypted'])) {
            try {
                $password = decryptSecret($proj['password_encrypted']);
            } catch (Exception $e) {
                error_log("Error al descifrar contraseña del proyecto {$projectId}: " . $e->getMessage());
                $password = '';
            }
        }
        
        
        // Preparar correo
        $mailBody = '<p>Hola '.htmlspecialchars($nombre).',</p>'
                 . '<p>Tu descarga del proyecto "'.htmlspecialchars($proj['titulo']).'" está lista.</p>';

        // Añadir contraseña si existe
        if (!empty($password)) {
            $mailBody .= '<div style="margin:15px 0;padding:15px;background:#fff3cd;border:1px solid #ffeeba;border-radius:4px;color:#856404">';
            $mailBody .= '<strong style="display:block;margin-bottom:10px">IMPORTANTE - Contraseña del archivo ZIP:</strong>';
            $mailBody .= '<code style="display:block;background:#f8f9fa;padding:10px;margin:10px 0;font-family:monospace;border-radius:4px">'.htmlspecialchars($password).'</code>';
            $mailBody .= '<small style="display:block;color:#666">Necesitarás esta contraseña para extraer los archivos después de la descarga.</small>';
            $mailBody .= '</div>';
        }

        $mailBody .= '<p>Puedes descargar tu archivo en el siguiente enlace (vigencia 72 horas):<br>'
                  . '<a href="'.htmlspecialchars($downloadLink).'">'.htmlspecialchars($downloadLink).'</a></p>';
        
        $mailBody .= '<p>Si el enlace expira, podrás solicitar uno nuevo desde la misma página.</p>'
                   . '<p>Saludos,<br>Ing. Joel Cadenas</p>';
        
        // Enviar correo simple (sin adjuntos para proyectos gratuitos)
        $sent = sendSiteEmail(
            $email,
            'Enlace de descarga - ' . $proj['titulo'],
            $mailBody
        );
        
        if (!$sent) {
            error_log("Error al enviar correo de descarga gratuita a: {$email}");
        }
        
        // Redireccionar a página de éxito
        header('Location: ' . siteUrl('success.php?id=' . $purchaseId . '&type=free'));
        exit;
        
    } catch (Exception $e) {
        error_log("Error al procesar descarga gratuita: " . $e->getMessage());
        http_response_code(500);
        echo "Error al procesar la descarga: " . $e->getMessage();
        exit;
    }
} elseif (isset($ins)) {
    // Para proyectos pagos
    try {
        // Notificar al cliente (sin cuenta de cobro aún)
        $clientBody = '<p>Hola '.htmlspecialchars($nombre).', recibimos tu solicitud de pago por "'.htmlspecialchars($proj['titulo']).'".</p>';
        $clientBody .= '<p><strong>Número de orden:</strong> ' . htmlspecialchars($invoiceNumber) . '</p>';
        $clientBody .= '<p>Revisaremos tu pago y te enviaremos la cuenta de cobro una vez que sea aprobado.</p>';
        $clientBody .= '<p>Recibirás el enlace de descarga junto con la cuenta de cobro por correo electrónico.</p>';
        $clientBody .= '<p>Si tienes alguna pregunta, no dudes en contactarnos.</p>';
        
        // Notificar al cliente
        $clientSent = @sendSiteEmail(
            $email,
            'Solicitud de Pago Recibida - ' . $proj['titulo'],
            $clientBody
        );
        
        // Notificar al administrador
        $adminBody = '<h3>Nueva Solicitud de Compra</h3>';
        $adminBody .= '<p><strong>Proyecto:</strong> ' . htmlspecialchars($proj['titulo']) . '</p>';
        $adminBody .= '<p><strong>Cliente:</strong> ' . htmlspecialchars($nombre) . '</p>';
        $adminBody .= '<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>';
        $adminBody .= '<p><strong>Método:</strong> ' . htmlspecialchars($metodo) . '</p>';
        $adminBody .= '<p><strong>Referencia:</strong> ' . htmlspecialchars($refer) . '</p>';
        $adminBody .= '<p><strong>Monto:</strong> ' . formatCOP($proj['precio'] ?? 0) . '</p>';
        
        if (!empty($documento)) {
            $adminBody .= '<p><strong>Documento:</strong> ' . htmlspecialchars($documento) . '</p>';
        }
        if (!empty($direccion)) {
            $adminBody .= '<p><strong>Dirección:</strong> ' . htmlspecialchars($direccion) . '</p>';
        }
        
        $adminBody .= '<p><strong>Orden:</strong> ' . htmlspecialchars($invoiceNumber) . '</p>';
        $adminBody .= '<p><a href="' . siteUrl('admin/') . '">Ver en el panel de administración</a></p>';
        
        $adminSent = @sendSiteEmail(
            'servicios@jcadenas.com',
            'Nueva Solicitud de Compra - ' . $proj['titulo'],
            $adminBody
        );
        
        error_log("Notificaciones enviadas - Cliente: " . ($clientSent ? 'OK' : 'FALLO') . ", Admin: " . ($adminSent ? 'OK' : 'FALLO'));
        
        // Redireccionar a página de éxito
        header('Location: ' . siteUrl('success.php?id=' . $purchaseId . '&type=payment'));
        exit;
        
    } catch (Exception $e) {
        error_log("Error al enviar notificaciones: " . $e->getMessage());
        // Aún así redirigir para no mostrar pantalla negra
        header('Location: ' . siteUrl('success.php?id=' . $purchaseId . '&type=payment'));
        exit;
    }
}
