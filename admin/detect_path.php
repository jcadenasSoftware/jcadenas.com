<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detectar Ruta de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h1 class="h3 mb-4">🔍 Detectar Ruta del Usuario en Hostinger</h1>

        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Información del Sistema</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td width="250"><strong>Sistema Operativo:</strong></td>
                        <td><code><?= PHP_OS ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>Directorio Actual (__DIR__):</strong></td>
                        <td><code><?= __DIR__ ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>Usuario del Sistema:</strong></td>
                        <td><code><?= get_current_user() ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>HOME (env):</strong></td>
                        <td><code><?= getenv('HOME') ?: '(no definido)' ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>Directorio del Script:</strong></td>
                        <td><code><?= $_SERVER['SCRIPT_FILENAME'] ?? 'N/A' ?></code></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">🎯 Tu Ruta Completa en Hostinger</h5>
            </div>
            <div class="card-body">
                <?php
                // Detectar el home directory
                $scriptPath = $_SERVER['SCRIPT_FILENAME'] ?? __FILE__;
                
                // En Hostinger, típicamente es /home/uXXXXXXX/public_html/jcadenas/admin/...
                // Necesitamos extraer /home/uXXXXXXX/
                
                if (preg_match('~^(/home/[^/]+)/~', $scriptPath, $matches)) {
                    $homeDir = $matches[1];
                    $yourPath = $homeDir . '/secure_downloads/jcadenas/projects';
                    
                    echo '<div class="alert alert-success">';
                    echo '<h6>✓ Ruta detectada automáticamente:</h6>';
                    echo '<div class="mt-2"><code style="font-size:1.1rem">' . htmlspecialchars($yourPath) . '</code></div>';
                    echo '</div>';
                    
                    // Verificar si existe
                    if (is_dir($yourPath)) {
                        echo '<div class="alert alert-success mt-3">';
                        echo '<strong>✓ La carpeta EXISTE</strong><br>';
                        echo 'Puedes guardar archivos ZIP aquí.';
                        echo '</div>';
                        
                        // Listar contenido
                        $files = @scandir($yourPath);
                        if ($files && count($files) > 2) { // Excluye . y ..
                            echo '<h6 class="mt-3">Archivos encontrados:</h6>';
                            echo '<ul class="list-group">';
                            foreach ($files as $file) {
                                if ($file === '.' || $file === '..') continue;
                                $fullPath = $yourPath . '/' . $file;
                                $size = is_file($fullPath) ? filesize($fullPath) : 0;
                                echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                echo '<code>' . htmlspecialchars($file) . '</code>';
                                if ($size > 0) {
                                    echo '<span class="badge bg-primary">' . number_format($size/1024/1024, 2) . ' MB</span>';
                                } else {
                                    echo '<span class="badge bg-secondary">Carpeta</span>';
                                }
                                echo '</li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '<div class="alert alert-warning mt-3">';
                            echo 'La carpeta existe pero está vacía. Puedes empezar a subir ZIPs.';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning mt-3">';
                        echo '<strong>⚠️ La carpeta NO EXISTE todavía</strong><br>';
                        echo 'Debes crearla en el administrador de archivos de Hostinger:<br>';
                        echo '<ol class="mt-2 mb-0">';
                        echo '<li>Ir a la raíz: <code>' . htmlspecialchars($homeDir) . '/</code></li>';
                        echo '<li>Crear carpeta: <code>secure_downloads</code></li>';
                        echo '<li>Dentro crear: <code>jcadenas</code></li>';
                        echo '<li>Dentro crear: <code>projects</code></li>';
                        echo '</ol>';
                        echo '</div>';
                    }
                    
                    echo '<hr>';
                    echo '<h6>📋 Configuración para config.local.php:</h6>';
                    echo '<div class="alert alert-info">';
                    echo '<pre class="mb-0" style="background:#fff; padding:1rem; border-radius:0.5rem;">&lt;?php<br>';
                    echo "define('SECURE_DOWNLOAD_BASE', '" . htmlspecialchars($yourPath) . "');<br>";
                    echo '?&gt;</pre>';
                    echo '</div>';
                    
                } else {
                    echo '<div class="alert alert-warning">';
                    echo '<strong>No se pudo detectar automáticamente</strong><br>';
                    echo 'Por favor, copia esta información:<br><br>';
                    echo '<strong>Script path:</strong> <code>' . htmlspecialchars($scriptPath) . '</code>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-warning">
                <h5 class="mb-0">⚙️ Actualización Automática de Config</h5>
            </div>
            <div class="card-body">
                <p>El archivo <code>config.php</code> ya está configurado para auto-detectar tu entorno.</p>
                <p class="mb-0">En Hostinger (Linux), usará automáticamente:</p>
                <div class="alert alert-secondary mt-2 mb-0">
                    <code><?= getenv('HOME') ?: ('/home/' . get_current_user()) ?>/secure_downloads/jcadenas/projects</code>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="purchases.php" class="btn btn-primary">← Volver a Compras</a>
            <a href="diagnose.php" class="btn btn-info">Ver Diagnóstico</a>
        </div>
    </div>
</body>
</html>
