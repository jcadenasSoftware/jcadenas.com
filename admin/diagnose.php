<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diagnóstico del Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .ok { color: #198754; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        code { background: #f8f9fa; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <h1 class="h3 mb-4">🔍 Diagnóstico del Sistema</h1>

        <!-- SMTP Configuration -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">📧 Configuración SMTP</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>SMTP Host:</strong></td>
                        <td><code><?= htmlspecialchars(SMTP_HOST) ?></code></td>
                        <td>
                            <?php if(SMTP_HOST): ?>
                                <span class="ok">✓ Configurado</span>
                            <?php else: ?>
                                <span class="error">✗ No configurado</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>SMTP Port:</strong></td>
                        <td><code><?= SMTP_PORT ?></code></td>
                        <td><span class="ok">✓ OK</span></td>
                    </tr>
                    <tr>
                        <td><strong>SMTP Secure:</strong></td>
                        <td><code><?= htmlspecialchars(SMTP_SECURE) ?></code></td>
                        <td><span class="ok">✓ OK</span></td>
                    </tr>
                    <tr>
                        <td><strong>SMTP User:</strong></td>
                        <td><code><?= htmlspecialchars(SMTP_USER) ?></code></td>
                        <td>
                            <?php if(SMTP_USER): ?>
                                <span class="ok">✓ Configurado</span>
                            <?php else: ?>
                                <span class="error">✗ No configurado</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>SMTP Pass:</strong></td>
                        <td>
                            <?php if(SMTP_PASS): ?>
                                <code>••••••••</code> (<?= strlen(SMTP_PASS) ?> caracteres)
                            <?php else: ?>
                                <code>(vacía)</code>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(SMTP_PASS): ?>
                                <span class="ok">✓ Configurada</span>
                            <?php else: ?>
                                <span class="error">✗ VACÍA - El correo NO se enviará</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

                <?php if(!SMTP_PASS): ?>
                <div class="alert alert-danger">
                    <strong>⚠️ Problema crítico:</strong> La contraseña SMTP está vacía.
                    <br><br>
                    <strong>Solución:</strong> Crear el archivo <code>config.local.php</code> con:
                    <pre class="mt-2 mb-0 bg-dark text-white p-3">
&lt;?php
define('SMTP_PASS', 'TU_CONTRASEÑA_REAL_AQUI');
?&gt;</pre>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Directorio de Descargas -->
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">📦 Directorio de Descargas Seguras</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Ruta Configurada:</strong></td>
                        <td><code><?= htmlspecialchars(SECURE_DOWNLOAD_BASE) ?></code></td>
                        <td>
                            <?php if(is_dir(SECURE_DOWNLOAD_BASE)): ?>
                                <span class="ok">✓ Existe</span>
                            <?php else: ?>
                                <span class="error">✗ NO EXISTE</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Escribible:</strong></td>
                        <td>-</td>
                        <td>
                            <?php if(is_dir(SECURE_DOWNLOAD_BASE) && is_writable(SECURE_DOWNLOAD_BASE)): ?>
                                <span class="ok">✓ Sí</span>
                            <?php else: ?>
                                <span class="error">✗ No escribible</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Sistema Operativo:</strong></td>
                        <td><code><?= PHP_OS ?></code></td>
                        <td>
                            <?php 
                            $isLinux = stripos(PHP_OS, 'linux') !== false;
                            $isWindows = stripos(PHP_OS, 'win') !== false;
                            ?>
                            <?php if($isLinux): ?>
                                <span class="ok">Linux (Producción)</span>
                            <?php elseif($isWindows): ?>
                                <span class="warning">Windows (Local)</span>
                            <?php else: ?>
                                <span class="warning"><?= PHP_OS ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Directorio Actual (__DIR__):</strong></td>
                        <td colspan="2"><code><?= __DIR__ ?></code></td>
                    </tr>
                </table>

                <?php if(!is_dir(SECURE_DOWNLOAD_BASE)): ?>
                <div class="alert alert-danger">
                    <strong>⚠️ Problema crítico:</strong> El directorio de descargas NO existe.
                    <br><br>
                    <strong>Solución para Hostinger:</strong>
                    <ol class="mb-0">
                        <li>Conectar por SSH o File Manager</li>
                        <li>Ir a la carpeta <code>/home/uXXXXXX/</code> (fuera de public_html)</li>
                        <li>Crear carpeta: <code>secure_downloads</code></li>
                        <li>Actualizar <code>config.local.php</code>:
                            <pre class="mt-2 mb-0 bg-dark text-white p-3">
&lt;?php
define('SECURE_DOWNLOAD_BASE', '/home/uXXXXXX/secure_downloads');
?&gt;</pre>
                        </li>
                    </ol>
                </div>
                <?php endif; ?>

                <?php 
                // Listar proyectos y sus ZIPs
                $projects = $pdo->query('SELECT id, titulo, download_path FROM proyecto WHERE download_path IS NOT NULL AND download_path != ""')->fetchAll();
                if($projects):
                ?>
                <hr>
                <h6>Proyectos con ZIP configurado:</h6>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Proyecto</th>
                            <th>Ruta (BD)</th>
                            <th>Archivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($projects as $p): 
                            $storedPath = $p['download_path'];
                            $isAbs = (preg_match('~^[A-Za-z]:\\\\~', $storedPath) === 1 || str_starts_with($storedPath, '/'));
                            if(!$isAbs) {
                                $fullPath = rtrim(SECURE_DOWNLOAD_BASE, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($storedPath, '/\\');
                            } else {
                                $fullPath = $storedPath;
                            }
                            $exists = is_file($fullPath);
                        ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td><?= htmlspecialchars($p['titulo']) ?></td>
                            <td><code><?= htmlspecialchars($storedPath) ?></code></td>
                            <td>
                                <?php if($exists): ?>
                                    <span class="ok">✓ Existe</span>
                                    <small class="d-block text-muted"><?= number_format(filesize($fullPath)/1024/1024, 2) ?> MB</small>
                                <?php else: ?>
                                    <span class="error">✗ NO ENCONTRADO</span>
                                    <small class="d-block text-muted">Buscado en: <?= htmlspecialchars($fullPath) ?></small>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- Prueba de Correo -->
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">✉️ Prueba de Envío de Correo</h5>
            </div>
            <div class="card-body">
                <?php if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_email'])): ?>
                    <?php
                    $testEmail = filter_var($_POST['test_email'], FILTER_VALIDATE_EMAIL);
                    if($testEmail):
                        $subject = 'Prueba de correo - JCadenas';
                        $body = '<h2>Prueba de correo</h2><p>Este es un correo de prueba desde el sistema.</p><p>Fecha: '.date('Y-m-d H:i:s').'</p>';
                        
                        ob_start();
                        $sent = sendSiteEmail($testEmail, $subject, $body);
                        $output = ob_get_clean();
                        
                        if($sent):
                    ?>
                        <div class="alert alert-success">
                            <strong>✓ Correo enviado exitosamente</strong> a <code><?= htmlspecialchars($testEmail) ?></code>
                            <br>Verifica la bandeja de entrada (y spam).
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            <strong>✗ Error al enviar correo</strong>
                            <br>Verifica la configuración SMTP arriba.
                            <?php if($output): ?>
                                <pre class="mt-2 mb-0"><?= htmlspecialchars($output) ?></pre>
                            <?php endif; ?>
                        </div>
                    <?php 
                        endif;
                    else:
                    ?>
                        <div class="alert alert-warning">Email inválido</div>
                    <?php endif; ?>
                <?php endif; ?>

                <form method="post">
                    <div class="input-group">
                        <input type="email" name="test_email" class="form-control" placeholder="tu@email.com" required>
                        <button class="btn btn-primary" type="submit">Enviar Correo de Prueba</button>
                    </div>
                    <small class="text-muted">Se enviará un correo de prueba a este email para verificar SMTP</small>
                </form>
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">ℹ️ Información del Sistema</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>PHP Version:</strong></td>
                        <td><code><?= phpversion() ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>Upload Max Size:</strong></td>
                        <td><code><?= ini_get('upload_max_filesize') ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>Post Max Size:</strong></td>
                        <td><code><?= ini_get('post_max_size') ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>Site Base URL:</strong></td>
                        <td><code><?= htmlspecialchars(SITE_BASE_URL) ?></code></td>
                    </tr>
                    <tr>
                        <td><strong>Site Email From:</strong></td>
                        <td><code><?= htmlspecialchars(SITE_EMAIL_FROM) ?></code></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="purchases.php" class="btn btn-primary">← Volver a Compras</a>
            <a href="check_paths.php" class="btn btn-warning">
                <i class="bi bi-folder-check"></i> Ver Rutas Existentes
            </a>
            <a href="upload_zip.php" class="btn btn-success">Subir ZIP</a>
        </div>
    </div>
</body>
</html>
