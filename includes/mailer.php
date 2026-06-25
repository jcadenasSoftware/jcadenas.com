<?php
// Cargar PHPMailer directamente
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMailWithAttachment($to, $subject, $html, $from = null, $attachment = null) {
    try {
        error_log("DEBUG: Iniciando envío de correo a {$to}");
        $mail = new PHPMailer(true);
        
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Forzar SSL
        $mail->Port = 465;  // Puerto SSL fijo
        $mail->CharSet = 'UTF-8';
        
        // Opciones adicionales de seguridad
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        error_log("DEBUG: Configuración SMTP:\nHost: {$mail->Host}\nUser: {$mail->Username}\nPort: {$mail->Port}");
        
        // Habilitar debug
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function($str, $level) {
            error_log("DEBUG SMTP: {$str}");
        };
        
        // Remitente y destinatario
        $mail->setFrom($from ?: SITE_EMAIL_FROM, SITE_EMAIL_FROM_NAME);
        $mail->addAddress($to);
        
        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $html;
        
        // Adjunto si existe
        if ($attachment && is_array($attachment)) {
            error_log("DEBUG: Añadiendo adjunto: " . print_r($attachment, true));
            if (isset($attachment['path']) && file_exists($attachment['path'])) {
                $mail->addAttachment(
                    $attachment['path'],
                    $attachment['name'] ?? basename($attachment['path']),
                    'base64',
                    $attachment['type'] ?? 'application/octet-stream'
                );
                error_log("DEBUG: Adjunto añadido correctamente");
            } else {
                error_log("ERROR: No se pudo encontrar el archivo adjunto: " . ($attachment['path'] ?? 'no path'));
            }
        }
        
        // Enviar
        $result = $mail->send();
        error_log("DEBUG: Correo enviado correctamente");
        return $result;
        
    } catch (Exception $e) {
        error_log("ERROR al enviar correo: " . $e->getMessage());
        error_log("DEBUG: Stack trace: " . $e->getTraceAsString());
        throw $e; // Re-lanzar la excepción para que purchase_create.php pueda manejarla
    }
}
