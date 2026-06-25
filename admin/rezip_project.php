<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

echo "<h2>Re-comprimir Proyecto con Nueva Contraseña</h2>";

// Buscar el proyecto Calculadora
$stmt = $pdo->prepare("SELECT * FROM proyecto WHERE titulo LIKE '%calculadora%' OR titulo LIKE '%Calculadora%'");
$stmt->execute();
$proyecto = $stmt->fetch();

if (!$proyecto) {
    echo "<p style='color: red;'>No se encontró el proyecto</p>";
    exit;
}

echo "<h3>Proyecto: {$proyecto['titulo']}</h3>";

// Obtener ruta del archivo actual
$currentPath = '';
if (!empty($proyecto['download_path'])) {
    $storedPath = $proyecto['download_path'];
    if (str_starts_with($storedPath, '/') || preg_match('~^[A-Za-z]:\\\\~', $storedPath)) {
        $currentPath = $storedPath;
    } else {
        $baseDir = rtrim(SECURE_DOWNLOAD_BASE, DIRECTORY_SEPARATOR);
        $currentPath = $baseDir . DIRECTORY_SEPARATOR . ltrim($storedPath, '/\\');
    }
}

echo "<p><strong>Archivo actual:</strong> {$currentPath}</p>";
echo "<p><strong>Existe:</strong> " . (file_exists($currentPath) ? '✅ Sí' : '❌ No') . "</p>";

if (!file_exists($currentPath)) {
    echo "<p style='color: red;'>❌ No se puede proceder sin el archivo ZIP</p>";
    exit;
}

echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h4>⚠️ Proceso Manual Requerido</h4>";
echo "<p>Para resolver este problema necesitas:</p>";
echo "<ol>";
echo "<li><strong>Descomprimir el ZIP actual</strong> con la contraseña original</li>";
echo "<li><strong>Volver a comprimirlo</strong> con la nueva contraseña: <code>CalculadoraPersonal2024</code></li>";
echo "<li><strong>Subir el nuevo ZIP</strong> reemplazando el anterior</li>";
echo "</ol>";
echo "</div>";

echo "<div style='background: #e7f3ff; border: 2px solid #0066cc; padding: 20px; margin: 20px 0; border-radius: 10px;'>";
echo "<h3>🔧 Pasos Detallados:</h3>";
echo "<h4>1. Descargar y descomprimir:</h4>";
echo "<ul>";
echo "<li>Descarga el ZIP actual desde el enlace de descarga</li>";
echo "<li>Prueba estas contraseñas comunes hasta encontrar la correcta:</li>";
echo "<ul>";
$passwords = ['CalculadoraPersonal', 'calculadora', 'Calculadora', 'calculadora123', 'jcadenas', 'admin', '123456'];
foreach ($passwords as $pwd) {
    echo "<li><code>{$pwd}</code></li>";
}
echo "</ul>";
echo "</ul>";

echo "<h4>2. Re-comprimir con nueva contraseña:</h4>";
echo "<ul>";
echo "<li>Una vez descomprimido, crea un nuevo ZIP</li>";
echo "<li><strong>Usa exactamente esta contraseña:</strong> <code style='background: yellow; padding: 5px;'>CalculadoraPersonal2024</code></li>";
echo "<li>Asegúrate de que el nombre del archivo sea el mismo</li>";
echo "</ul>";

echo "<h4>3. Subir el nuevo ZIP:</h4>";
echo "<ul>";
echo "<li>Sube el nuevo ZIP a la misma ubicación</li>";
echo "<li>O usa el panel de admin para subir un nuevo archivo</li>";
echo "</ul>";
echo "</div>";

// Formulario para subir nuevo ZIP
echo "<div style='background: #f8f9fa; border: 1px solid #dee2e6; padding: 20px; margin: 20px 0; border-radius: 10px;'>";
echo "<h3>📤 Subir Nuevo ZIP (Opcional)</h3>";
echo "<p>Si ya tienes el ZIP re-comprimido con la contraseña correcta, puedes subirlo aquí:</p>";

if (isset($_POST['upload_new_zip']) && isset($_FILES['new_zip'])) {
    $uploadedFile = $_FILES['new_zip'];
    
    if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
        $tempPath = $uploadedFile['tmp_name'];
        $originalName = $uploadedFile['name'];
        
        // Verificar que es un ZIP
        if (pathinfo($originalName, PATHINFO_EXTENSION) !== 'zip') {
            echo "<p style='color: red;'>❌ Solo se permiten archivos ZIP</p>";
        } else {
            // Crear directorio si no existe
            $projectDir = dirname($currentPath);
            if (!is_dir($projectDir)) {
                mkdir($projectDir, 0755, true);
            }
            
            // Mover archivo
            if (move_uploaded_file($tempPath, $currentPath)) {
                echo "<div style='background: #d4edda; border: 2px solid #28a745; padding: 15px; border-radius: 5px;'>";
                echo "<h4 style='color: #155724;'>✅ ¡ZIP ACTUALIZADO!</h4>";
                echo "<p>El nuevo archivo se ha subido correctamente.</p>";
                echo "<p><strong>Ahora la contraseña <code>CalculadoraPersonal2024</code> debería funcionar.</strong></p>";
                echo "</div>";
            } else {
                echo "<p style='color: red;'>❌ Error al subir el archivo</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>❌ Error en la subida: " . $uploadedFile['error'] . "</p>";
    }
}

echo "<form method='post' enctype='multipart/form-data'>";
echo "<p>";
echo "<label><strong>Seleccionar nuevo ZIP:</strong><br>";
echo "<input type='file' name='new_zip' accept='.zip' required style='padding: 10px; margin: 10px 0;'>";
echo "</label>";
echo "</p>";
echo "<p><small style='color: #666;'>Asegúrate de que el ZIP esté comprimido con la contraseña: <code>CalculadoraPersonal2024</code></small></p>";
echo "<button type='submit' name='upload_new_zip' style='background: #007bff; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px;'>📤 SUBIR NUEVO ZIP</button>";
echo "</form>";
echo "</div>";

echo "<hr>";
echo "<p><a href='find_zip_password.php'>🔍 Ir a buscar contraseña original</a></p>";
echo "<p><a href='test_decrypt.php'>🧪 Volver a test de descifrado</a></p>";
?>
