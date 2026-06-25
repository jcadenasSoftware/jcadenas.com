<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar Rutas Existentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h1 class="h3 mb-4">🔍 Rutas de ZIPs Existentes</h1>

        <div class="alert alert-info">
            <strong>SECURE_DOWNLOAD_BASE configurado:</strong> <code><?= htmlspecialchars(SECURE_DOWNLOAD_BASE) ?></code>
        </div>

        <?php
        // Obtener TODOS los proyectos con download_path
        $stmt = $pdo->query('SELECT id, titulo, download_path, created_at FROM proyecto ORDER BY id');
        $projects = $stmt->fetchAll();
        ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Proyecto</th>
                    <th>download_path (en BD)</th>
                    <th>Ruta Completa Resuelta</th>
                    <th>¿Existe?</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($projects as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['titulo']) ?></td>
                    <td>
                        <?php if($p['download_path']): ?>
                            <code><?= htmlspecialchars($p['download_path']) ?></code>
                        <?php else: ?>
                            <span class="text-muted">(NULL)</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php 
                        if($p['download_path']) {
                            $storedPath = $p['download_path'];
                            $resolvedPath = $storedPath;
                            
                            // Misma lógica que download.php
                            $isWindowsAbs = preg_match('~^[A-Za-z]:\\\\~', $storedPath) === 1;
                            $isUnixAbs = str_starts_with($storedPath, '/');
                            
                            if (!$isWindowsAbs && !$isUnixAbs) {
                                $baseDir = rtrim(SECURE_DOWNLOAD_BASE, DIRECTORY_SEPARATOR);
                                $resolvedPath = $baseDir . DIRECTORY_SEPARATOR . ltrim($storedPath, '/\\');
                            }
                            
                            echo '<code style="font-size:0.85rem">'. htmlspecialchars($resolvedPath) .'</code>';
                            
                            $exists = is_file($resolvedPath);
                        } else {
                            echo '<span class="text-muted">-</span>';
                            $exists = false;
                        }
                        ?>
                    </td>
                    <td>
                        <?php if($p['download_path']): ?>
                            <?php if($exists): ?>
                                <span class="badge bg-success">✓ Existe</span>
                                <br><small class="text-muted"><?= number_format(filesize($resolvedPath)/1024/1024, 2) ?> MB</small>
                            <?php else: ?>
                                <span class="badge bg-danger">✗ No encontrado</span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="badge bg-secondary">Sin ZIP</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <hr>

        <h4>Análisis de Rutas Usadas:</h4>
        <?php
        // Analizar patrones de rutas
        $patterns = [];
        foreach($projects as $p) {
            if($p['download_path']) {
                $storedPath = $p['download_path'];
                $isWindowsAbs = preg_match('~^[A-Za-z]:\\\\~', $storedPath) === 1;
                $isUnixAbs = str_starts_with($storedPath, '/');
                
                if($isWindowsAbs) {
                    $patterns['Windows Absoluta'][] = $storedPath;
                } elseif($isUnixAbs) {
                    $patterns['Unix Absoluta'][] = $storedPath;
                } else {
                    $patterns['Relativa'][] = $storedPath;
                }
            }
        }
        
        foreach($patterns as $type => $paths):
        ?>
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <strong><?= htmlspecialchars($type) ?></strong> (<?= count($paths) ?> archivos)
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <?php foreach($paths as $path): ?>
                            <li><code><?= htmlspecialchars($path) ?></code></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if(empty($patterns)): ?>
            <div class="alert alert-warning">
                No hay proyectos con download_path configurado todavía.
            </div>
        <?php endif; ?>

        <div class="alert alert-info mt-4">
            <h5>🎯 Conclusión y Recomendación:</h5>
            <p class="mb-2">Basado en las rutas existentes que <strong>SÍ funcionan</strong>, deberías usar el mismo patrón para nuevos proyectos.</p>
            
            <?php 
            // Encontrar el patrón más usado
            if(!empty($patterns)) {
                $mostUsed = array_keys($patterns, max(array_map('count', $patterns)))[0];
                $example = $patterns[$mostUsed][0] ?? '';
                
                if($mostUsed === 'Relativa') {
                    // Extraer el patrón
                    $parts = explode('/', $example);
                    echo '<p class="mb-0"><strong>Patrón recomendado:</strong> <code>PROYECTO_ID/nombre_archivo.zip</code></p>';
                    echo '<p class="mb-0"><strong>Ejemplo:</strong> <code>1/calculadora.zip</code>, <code>2/app-android.zip</code></p>';
                    echo '<p class="mb-0 mt-2"><strong>Se guardará en:</strong> <code>'.htmlspecialchars(SECURE_DOWNLOAD_BASE).'/PROYECTO_ID/archivo.zip</code></p>';
                } else {
                    echo '<p class="mb-0"><strong>Patrón usado:</strong> '.$mostUsed.'</p>';
                    echo '<p class="mb-0"><strong>Ejemplo:</strong> <code>'.htmlspecialchars($example).'</code></p>';
                }
            }
            ?>
        </div>

        <div class="mt-4">
            <a href="purchases.php" class="btn btn-primary">← Volver a Compras</a>
            <a href="upload_zip.php" class="btn btn-success">Subir ZIP</a>
            <a href="diagnose.php" class="btn btn-info">Diagnóstico</a>
        </div>
    </div>
</body>
</html>
