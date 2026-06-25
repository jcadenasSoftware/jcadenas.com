<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/db.php';

$purchaseId = (int)($_GET['id'] ?? 0);
$type = $_GET['type'] ?? 'free'; // 'free' o 'payment'

if (!$purchaseId) {
    header('Location: ' . siteUrl());
    exit;
}

// Obtener datos de la compra
$stmt = $pdo->prepare('SELECT p.*, pr.titulo FROM purchase p JOIN proyecto pr ON pr.id=p.proyecto_id WHERE p.id=?');
$stmt->execute([$purchaseId]);
$purchase = $stmt->fetch();

if (!$purchase) {
    header('Location: ' . siteUrl());
    exit;
}

$baseUrl = siteUrl();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>¡Gracias por tu compra! | jcadenas.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .checkmark {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: #e8f5e9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .checkmark svg {
            color: #28a745;
            width: 36px;
            height: 36px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5 text-center">
                        <div class="checkmark">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M6.97 11.03 4.47 8.53a.75.75 0 1 0-1.06 1.06l2.8 2.8a.75.75 0 0 0 1.08-.02l5.8-6a.75.75 0 0 0-1.08-1.04z"/>
                            </svg>
                        </div>
                        <?php if ($type === 'payment'): ?>
                        <h1 class="h3 mb-3">¡Solicitud Recibida!</h1>
                        <p class="text-muted">
                            Hemos recibido tu solicitud de compra para "<?= htmlspecialchars($purchase['titulo']) ?>".
                        </p>
                        <p class="text-muted">
                            <strong>Número de orden:</strong> <?= htmlspecialchars($purchase['invoice_number'] ?? 'N/A') ?>
                        </p>
                        <div class="alert alert-info">
                            <h6 class="mb-2">📧 ¿Qué sigue?</h6>
                            <p class="mb-1">• Te hemos enviado un correo de confirmación</p>
                            <p class="mb-1">• Revisaremos tu pago en las próximas horas</p>
                            <p class="mb-1">• Te enviaremos la cuenta de cobro oficial una vez aprobado</p>
                            <p class="mb-0">• Recibirás el enlace de descarga junto con la cuenta de cobro</p>
                        </div>
                        <?php else: ?>
                        <h1 class="h3 mb-3">¡Gracias por tu descarga!</h1>
                        <p class="text-muted">
                            Te hemos enviado un correo con el enlace de descarga para "<?= htmlspecialchars($purchase['titulo']) ?>".
                        </p>
                        <div class="alert alert-success">
                            <h6 class="mb-2">📧 Revisa tu correo</h6>
                            <p class="mb-0">El enlace de descarga está en tu bandeja de entrada</p>
                        </div>
                        <?php endif; ?>
                        <p class="text-muted small">
                            Por favor revisa tu bandeja de entrada y la carpeta de spam.<br>
                            El remitente es: <strong>servicios@jcadenas.com</strong>
                        </p>
                        <div class="mt-4">
                            <a href="<?= htmlspecialchars($baseUrl) ?>" class="btn btn-primary">Volver al inicio</a>
                            <a href="<?= htmlspecialchars($baseUrl) ?>#portfolio" class="btn btn-outline-secondary ms-2">Ver más proyectos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
