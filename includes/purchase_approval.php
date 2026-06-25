<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/invoice_generator.php';
require_once __DIR__ . '/mailer.php';

/**
 * Envía la cuenta de cobro y enlace de descarga cuando se aprueba una compra
 */
function sendApprovalNotification($purchaseId) {
    global $pdo;
    
    try {
        // Obtener datos de la compra y proyecto
        $stmt = $pdo->prepare('
            SELECT p.*, pr.titulo, pr.precio, pr.download_path, pr.password_encrypted 
            FROM purchase p 
            JOIN proyecto pr ON pr.id = p.proyecto_id 
            WHERE p.id = ?
        ');
        $stmt->execute([$purchaseId]);
        $purchase = $stmt->fetch();
        
        if (!$purchase) {
            throw new Exception("Compra no encontrada: {$purchaseId}");
        }
        
        // Generar token de descarga
        $token = bin2hex(random_bytes(16));
        $now = new DateTime('now');
        $exp = (clone $now)->modify('+72 hours');
        
        // Guardar token
        $tokenStmt = $pdo->prepare('INSERT INTO purchase_token (purchase_id, proyecto_id, email, token, created_at, expires_at, requester_ip) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $tokenStmt->execute([
            $purchaseId,
            $purchase['proyecto_id'],
            $purchase['email'],
            $token,
            $now->format('Y-m-d H:i:s'),
            $exp->format('Y-m-d H:i:s'),
            $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ]);
        
        // Generar cuenta de cobro (PDF)
        $generator = new InvoiceGenerator();
        $project = [
            'titulo' => $purchase['titulo'],
            'precio' => $purchase['precio']
        ];
        
        $invoicePath = $generator->generatePDF($project, $purchase);
        error_log("Cuenta de cobro generada para aprobación: {$invoicePath}");
        
        // Preparar email con cuenta de cobro y enlace de descarga
        $downloadUrl = siteUrl('download.php?token=' . $token);
        
        $clientBody = '<h2>¡Tu compra ha sido aprobada!</h2>';
        $clientBody .= '<p>Hola ' . htmlspecialchars($purchase['nombre']) . ',</p>';
        $clientBody .= '<p>Tu pago por "' . htmlspecialchars($purchase['titulo']) . '" ha sido aprobado.</p>';
        $clientBody .= '<p><strong>Número de orden:</strong> ' . htmlspecialchars($purchase['invoice_number']) . '</p>';
        
        $clientBody .= '<div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">';
        $clientBody .= '<h3 style="color: #28a745; margin-top: 0;">🎉 ¡Descarga tu proyecto ahora!</h3>';
        $clientBody .= '<p><a href="' . $downloadUrl . '" style="background: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">Descargar Proyecto</a></p>';
        $clientBody .= '<p><small>Este enlace expira en 72 horas</small></p>';
        $clientBody .= '</div>';
        
        $clientBody .= '<p>Adjuntamos tu cuenta de cobro oficial para tus registros.</p>';
        $clientBody .= '<p>¡Gracias por tu compra y confianza en nuestros servicios!</p>';
        $clientBody .= '<p>Si tienes alguna pregunta, no dudes en contactarnos.</p>';
        
        // Preparar adjunto
        $attachment = [
            'path' => $invoicePath,
            'name' => 'cuenta-cobro-' . $purchase['invoice_number'] . '.pdf',
            'type' => 'application/pdf'
        ];
        
        // Enviar email con cuenta de cobro y enlace
        $sent = sendMailWithAttachment(
            $purchase['email'],
            '✅ Compra Aprobada - ' . $purchase['titulo'],
            $clientBody,
            SITE_EMAIL_FROM,
            $attachment
        );
        
        // Limpiar archivo temporal
        if (file_exists($invoicePath)) {
            @unlink($invoicePath);
            error_log("Archivo temporal eliminado: {$invoicePath}");
        }
        
        if ($sent) {
            error_log("Notificación de aprobación enviada exitosamente para compra {$purchaseId}");
            return true;
        } else {
            throw new Exception("Error al enviar el correo de aprobación");
        }
        
    } catch (Exception $e) {
        error_log("Error en sendApprovalNotification: " . $e->getMessage());
        // Limpiar archivo temporal si existe
        if (isset($invoicePath) && file_exists($invoicePath)) {
            @unlink($invoicePath);
        }
        return false;
    }
}
?>
