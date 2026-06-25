<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

$orderId = (int)($_GET['id'] ?? 10);

// Obtener la orden
$stmt = $pdo->prepare('
    SELECT p.*, pr.titulo, pr.download_path, pr.download_mime, pr.password_encrypted
    FROM purchase p
    LEFT JOIN proyecto pr ON pr.id = p.proyecto_id
    WHERE p.id = ?
');
$stmt->execute([$orderId]);
$order = $stmt->fetch();

// Obtener tokens generados para esta orden
$tokens = $pdo->prepare('SELECT * FROM purchase_token WHERE purchase_id = ? ORDER BY created_at DESC');
$tokens->execute([$orderId]);
$tokenList = $tokens->fetchAll();

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Análisis Orden #<?= $orderId ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .code-block { background: #f8f9fa; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #0d6efd; margin: 1rem 0; }
        .success { color: #198754; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #0dcaf0; }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <h1 class="h3 mb-4">🔍 Análisis Detallado de Orden #<?= $orderId ?></h1>

        <?php if(!$order): ?>
            <div class="alert alert-danger">Orden no encontrada</div>
            <a href="purchases.php" class="btn btn-primary">← Volver</a>
            <?php exit; ?>
        <?php endif; ?>

        <!-- Información de la Compra -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">📋 Información de la Compra</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <td width="200"><strong>ID Orden:</strong></td>
                        <td><?= $order['id'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Cliente:</strong></td>
                        <td><?= htmlspecialchars($order['nombre']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><code><?= htmlspecialchars($order['email']) ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>Proyecto ID:</strong></td>
                        <td><?= $order['proyecto_id'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Proyecto Título:</strong></td>
                        <td><?= htmlspecialchars($order['titulo']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Estado:</strong></td>
                        <td>
                            <span class="badge bg-<?= $order['status'] === 'approved' ? 'success' : 'warning' ?>">
                                <?= htmlspecialchars($order['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Método:</strong></td>
                        <td><?= htmlspecialchars($order['metodo']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Referencia:</strong></td>
                        <td><?= htmlspecialchars($order['referencia']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Creado:</strong></td>
                        <td><?= htmlspecialchars($order['created_at']) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Ruta del Archivo -->
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">📦 Ruta del Archivo ZIP (CLAVE)</h5>
            </div>
            <div class="card-body">
                <h6>Ruta guardada en BD (download_path):</h6>
                <div class="code-block">
                    <code><?= htmlspecialchars($order['download_path'] ?: '(NULL)') ?></code>
                </div>

                <?php 
                $storedPath = $order['download_path'];
                if($storedPath):
                    // Misma lógica de resolución que usa el sistema
                    $resolvedPath = $storedPath;
                    $isWindowsAbs = preg_match('~^[A-Za-z]:\\\\~', $storedPath) === 1;
                    $isUnixAbs = str_starts_with($storedPath, '/');
                    
                    if (!$isWindowsAbs && !$isUnixAbs) {
                        $baseDir = rtrim(SECURE_DOWNLOAD_BASE, DIRECTORY_SEPARATOR);
                        $resolvedPath = $baseDir . DIRECTORY_SEPARATOR . ltrim($storedPath, '/\\');
                    }
                ?>
                
                <h6 class="mt-3">SECURE_DOWNLOAD_BASE configurado:</h6>
                <div class="code-block">
                    <code><?= htmlspecialchars(SECURE_DOWNLOAD_BASE) ?></code>
                </div>

                <h6 class="mt-3">Ruta completa resuelta por el sistema:</h6>
                <div class="code-block">
                    <code><?= htmlspecialchars($resolvedPath) ?></code>
                </div>

                <h6 class="mt-3">¿El archivo existe?</h6>
                <?php if(is_file($resolvedPath)): ?>
                    <div class="alert alert-success">
                        <span class="success">✓ SÍ EXISTE</span>
                        <br>Tamaño: <strong><?= number_format(filesize($resolvedPath)/1024/1024, 2) ?> MB</strong>
                        <br>Última modificación: <?= date('Y-m-d H:i:s', filemtime($resolvedPath)) ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <span class="error">✗ NO EXISTE</span>
                        <br>El sistema buscó en: <code><?= htmlspecialchars($resolvedPath) ?></code>
                    </div>
                <?php endif; ?>

                <?php else: ?>
                    <div class="alert alert-warning">
                        No hay ruta de descarga configurada para este proyecto
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tokens Generados -->
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">🔑 Tokens de Descarga Generados</h5>
            </div>
            <div class="card-body">
                <?php if(count($tokenList) > 0): ?>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Token</th>
                            <th>Creado</th>
                            <th>Expira</th>
                            <th>Estado</th>
                            <th>Enlace</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tokenList as $t): ?>
                        <tr>
                            <td><?= $t['id'] ?></td>
                            <td><code><?= htmlspecialchars(substr($t['token'], 0, 12)) ?>...</code></td>
                            <td><?= htmlspecialchars($t['created_at']) ?></td>
                            <td><?= htmlspecialchars($t['expires_at']) ?></td>
                            <td>
                                <?php 
                                $expired = strtotime($t['expires_at']) < time();
                                $used = $t['used'];
                                ?>
                                <?php if($expired): ?>
                                    <span class="badge bg-secondary">Expirado</span>
                                <?php elseif($used): ?>
                                    <span class="badge bg-success">Usado</span>
                                <?php else: ?>
                                    <span class="badge bg-primary">Válido</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= siteUrl('download.php?t=' . urlencode($t['token'])) ?>" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary">
                                    Ver Enlace
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <div class="alert alert-warning">
                        No se han generado tokens para esta orden
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Análisis y Recomendación -->
        <div class="card mb-3">
            <div class="card-header bg-warning">
                <h5 class="mb-0">🎯 Análisis y Recomendación</h5>
            </div>
            <div class="card-body">
                <h6>Para que los nuevos proyectos funcionen igual que esta orden:</h6>
                
                <?php if($storedPath && is_file($resolvedPath)): ?>
                    <ol>
                        <li>
                            <strong>Tipo de ruta:</strong>
                            <?php if(str_starts_with($storedPath, '/')): ?>
                                <span class="badge bg-info">Absoluta (Linux)</span>
                            <?php elseif(preg_match('~^[A-Za-z]:\\\\~', $storedPath)): ?>
                                <span class="badge bg-info">Absoluta (Windows)</span>
                            <?php else: ?>
                                <span class="badge bg-success">Relativa</span> ← Recomendado
                            <?php endif; ?>
                        </li>
                        
                        <li class="mt-2">
                            <strong>Patrón usado:</strong>
                            <div class="code-block">
                                <code><?= htmlspecialchars($storedPath) ?></code>
                            </div>
                        </li>
                        
                        <li class="mt-2">
                            <strong>Para nuevos proyectos, usar:</strong>
                            <?php 
                            // Detectar patrón
                            if(preg_match('~^(\d+)/~', $storedPath, $m)):
                                $projectIdPattern = $m[1];
                            ?>
                                <div class="code-block">
                                    <code>PROYECTO_ID/nombre_archivo.zip</code>
                                </div>
                                <p class="mb-0 mt-2">
                                    Ejemplo: Si subes ZIP para proyecto ID=5, guarda como: <code>5/mi-proyecto.zip</code>
                                </p>
                            <?php else: ?>
                                <div class="code-block">
                                    <code><?= htmlspecialchars($storedPath) ?></code>
                                </div>
                                <p class="mb-0 mt-2">Usar el mismo formato exacto</p>
                            <?php endif; ?>
                        </li>
                        
                        <li class="mt-2">
                            <strong>Directorio base debe estar en:</strong>
                            <div class="code-block">
                                <code><?= htmlspecialchars(SECURE_DOWNLOAD_BASE) ?></code>
                            </div>
                        </li>
                    </ol>
                    
                    <div class="alert alert-success mt-3">
                        <strong>✓ Esta orden SÍ funcionó porque:</strong>
                        <ul class="mb-0">
                            <li>La ruta en BD es correcta: <code><?= htmlspecialchars($storedPath) ?></code></li>
                            <li>El archivo existe en: <code><?= htmlspecialchars($resolvedPath) ?></code></li>
                            <li>El token se generó correctamente</li>
                            <li>El correo se envió con el enlace válido</li>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        Esta orden NO tiene archivo ZIP configurado o el archivo no existe.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Logs de Email -->
        <?php 
        $logFile = __DIR__ . '/../logs/email_debug.log';
        if(file_exists($logFile)):
            $logs = file_get_contents($logFile);
            $orderLogs = [];
            foreach(explode("\n", $logs) as $line) {
                if(strpos($line, 'Orden #'.$orderId) !== false || strpos($line, $order['email']) !== false) {
                    $orderLogs[] = $line;
                }
            }
        ?>
        <?php if(count($orderLogs) > 0): ?>
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">📝 Logs de Email</h5>
            </div>
            <div class="card-body">
                <pre class="mb-0" style="font-size: 0.875rem; max-height: 300px; overflow-y: auto;"><?php 
                    foreach($orderLogs as $log) {
                        echo htmlspecialchars($log) . "\n";
                    }
                ?></pre>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="purchases.php" class="btn btn-primary">← Volver a Compras</a>
            <a href="check_paths.php" class="btn btn-warning">Ver Todas las Rutas</a>
            <?php if($order['proyecto_id']): ?>
                <a href="upload_zip.php" class="btn btn-success">Subir ZIP</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
