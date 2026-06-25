<?php
require_once 'config.php';
require_once 'db.php';

// Validar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php?error=1');
    exit;
}

// Obtener y limpiar datos del formulario
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$asunto = trim($_POST['asunto'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

// Validación básica
if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
    header('Location: contact.php?error=1');
    exit;
}

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: contact.php?error=1');
    exit;
}

try {
    // Crear tabla de contactos si no existe
    $pdo->prepare('CREATE TABLE IF NOT EXISTS contactos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(120) NOT NULL,
        email VARCHAR(120) NOT NULL,
        telefono VARCHAR(60),
        asunto VARCHAR(255) NOT NULL,
        mensaje TEXT NOT NULL,
        creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_email (email),
        INDEX idx_creado (creado_en)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4')->execute();

    // Insertar el mensaje en la base de datos
    $stmt = $pdo->prepare('INSERT INTO contactos (nombre, email, telefono, asunto, mensaje) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$nombre, $email, $telefono, $asunto, $mensaje]);

    // Preparar el email
    $emailSubject = "Nuevo mensaje de contacto: " . $asunto;
    $emailBody = "
    <h2>Nuevo mensaje de contacto desde jcadenas.com</h2>
    <p><strong>Nombre:</strong> " . htmlspecialchars($nombre) . "</p>
    <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
    <p><strong>Teléfono:</strong> " . htmlspecialchars($telefono ?: 'No proporcionado') . "</p>
    <p><strong>Asunto:</strong> " . htmlspecialchars($asunto) . "</p>
    <p><strong>Mensaje:</strong></p>
    <div style='background: #f8f9fa; padding: 15px; border-left: 4px solid #0d6efd; margin: 10px 0;'>
        " . nl2br(htmlspecialchars($mensaje)) . "
    </div>
    <hr>
    <p><small>Mensaje enviado el " . date('d/m/Y H:i:s') . " desde el formulario de contacto.</small></p>
    ";

    // Enviar email usando la función configurada
    $emailSent = sendSiteEmail('servicios@jcadenas.com', $emailSubject, $emailBody, $email);

    if ($emailSent) {
        // Éxito: redirigir con mensaje de confirmación
        header('Location: contact.php?sent=1');
    } else {
        // Email falló pero se guardó en BD
        header('Location: contact.php?sent=1&email_warning=1');
    }

} catch (PDOException $e) {
    // Error de base de datos
    error_log("Error en contact_submit.php: " . $e->getMessage());
    header('Location: contact.php?error=1');
} catch (Exception $e) {
    // Otros errores
    error_log("Error general en contact_submit.php: " . $e->getMessage());
    header('Location: contact.php?error=1');
}

exit;
?>
