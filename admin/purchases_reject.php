<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

try {
    $id = (int)($_GET['id'] ?? 0);
    if(!$id){ 
        http_response_code(400); 
        throw new RuntimeException('ID inválido'); 
    }

    // Load purchase
    $stmt = $pdo->prepare('SELECT p.*, pr.titulo FROM purchase p LEFT JOIN proyecto pr ON pr.id=p.proyecto_id WHERE p.id=?');
    $stmt->execute([$id]);
    $purchase = $stmt->fetch();
    if(!$purchase){ 
        http_response_code(404); 
        throw new RuntimeException('Compra no encontrada'); 
    }

    // Only allow rejecting pending purchases
    if($purchase['status'] !== 'pending'){
        throw new RuntimeException('Solo se pueden rechazar compras pendientes');
    }

    // Update status
    $up = $pdo->prepare('UPDATE purchase SET status=? WHERE id=?');
    $up->execute(['rejected', $purchase['id']]);

    // Notify customer
    $subject = 'Actualización de tu compra - ' . $purchase['titulo'];
    $body = '<p>Hola '.htmlspecialchars($purchase['nombre']).',</p>'
          . '<p>Lamentamos informarte que tu solicitud de compra para el proyecto "'.htmlspecialchars($purchase['titulo']).'" ha sido rechazada.</p>'
          . '<p>Esto puede deberse a:</p>'
          . '<ul>'
          . '<li>No se pudo verificar el pago</li>'
          . '<li>El comprobante no coincide con el monto</li>'
          . '<li>La referencia proporcionada no es válida</li>'
          . '</ul>'
          . '<p>Si crees que esto es un error o deseas más información, por favor responde a este correo.</p>'
          . '<p>Saludos,<br>Ing. Joel Cadenas</p>';

    @sendSiteEmail($purchase['email'], $subject, $body);

    header('Location: purchases.php?status=rejected');
    exit;

} catch (Throwable $e) {
    http_response_code(http_response_code() >= 400 ? http_response_code() : 500);
    echo '<!doctype html><html><head><meta charset="utf-8"><title>Error</title></head><body style="font-family:system-ui;padding:2rem">';
    echo '<h3>Error al rechazar compra</h3>';
    echo '<p style="color:#c00">'.htmlspecialchars($e->getMessage()).'</p>';
    echo '<p><a href="purchases.php">&larr; Volver</a></p>';
    echo '</body></html>';
}
