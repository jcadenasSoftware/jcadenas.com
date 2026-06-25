<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

echo "<h2>Encontrar Contraseña Real del ZIP</h2>";

// Buscar el proyecto Calculadora
$stmt = $pdo->prepare("SELECT * FROM proyecto WHERE titulo LIKE '%calculadora%' OR titulo LIKE '%Calculadora%'");
$stmt->execute();
$proyecto = $stmt->fetch();

if (!$proyecto) {
    echo "<p style='color: red;'>No se encontró el proyecto</p>";
    exit;
}

echo "<h3>Proyecto: {$proyecto['titulo']}</h3>";
echo "<p><strong>Archivo ZIP:</strong> {$proyecto['download_path']}</p>";

// Contraseñas comunes que podrías haber usado
$possiblePasswords = [
    'CalculadoraPersonal',
    'calculadora',
    'Calculadora',
    'calculadora123',
    'Calculadora123',
    'CalculadoraPersonal123',
    'calculadorapersonal',
    'CALCULADORA',
    'calc123',
    'Calc123',
    'personal',
    'Personal',
    'jcadenas',
    'JCadenas',
    'jcadenas123',
    '123456',
    'password',
    'Password',
    'admin',
    'Admin',
    'calculadora2024',
    'Calculadora2024',
    'CalculadoraPersonal2024'
];

echo "<h3>Contraseñas Posibles para Probar</h3>";
echo "<p>Estas son contraseñas comunes que podrías haber usado al crear el ZIP:</p>";

echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
echo "<h4>📝 Lista de contraseñas para probar manualmente:</h4>";
echo "<ol>";
foreach ($possiblePasswords as $pwd) {
    echo "<li><code style='background: #e9ecef; padding: 2px 6px; border-radius: 3px;'>{$pwd}</code></li>";
}
echo "</ol>";
echo "</div>";

echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h4>🔍 Cómo encontrar la contraseña correcta:</h4>";
echo "<ol>";
echo "<li><strong>Descarga el ZIP</strong> desde el enlace de descarga</li>";
echo "<li><strong>Prueba cada contraseña</strong> de la lista de arriba</li>";
echo "<li><strong>Cuando encuentres la correcta</strong>, vuelve aquí y úsala abajo</li>";
echo "</ol>";
echo "</div>";

// Formulario para establecer la contraseña correcta
if (isset($_POST['set_correct_password'])) {
    $correctPassword = trim($_POST['correct_password']);
    if ($correctPassword) {
        // Encriptar la contraseña correcta
        $encrypted = encryptSecret($correctPassword);
        if ($encrypted) {
            $updateStmt = $pdo->prepare('UPDATE proyecto SET password_encrypted = ? WHERE id = ?');
            if ($updateStmt->execute([$encrypted, $proyecto['id']])) {
                echo "<div style='background: #d4edda; border: 2px solid #28a745; padding: 20px; margin: 20px 0; border-radius: 10px;'>";
                echo "<h3 style='color: #155724;'>✅ ¡CONTRASEÑA ACTUALIZADA!</h3>";
                echo "<p><strong>Nueva contraseña en BD:</strong> <code>{$correctPassword}</code></p>";
                echo "<p>Ahora los clientes recibirán la contraseña correcta que sí funciona con el ZIP.</p>";
                echo "</div>";
            } else {
                echo "<p style='color: red;'>❌ Error al actualizar la base de datos</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Error al encriptar la contraseña</p>";
        }
    }
}

echo "<div style='background: #e7f3ff; border: 2px solid #0066cc; padding: 20px; margin: 20px 0; border-radius: 10px;'>";
echo "<h3>🔧 Establecer Contraseña Correcta</h3>";
echo "<p>Una vez que hayas encontrado la contraseña que SÍ funciona con el ZIP, ingrésala aquí:</p>";
echo "<form method='post'>";
echo "<p>";
echo "<label><strong>Contraseña correcta del ZIP:</strong><br>";
echo "<input type='text' name='correct_password' required placeholder='Ej: CalculadoraPersonal' style='padding: 10px; width: 300px; font-size: 16px;'>";
echo "</label>";
echo "</p>";
echo "<button type='submit' name='set_correct_password' style='background: #28a745; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px;'>✅ ACTUALIZAR CONTRASEÑA EN BD</button>";
echo "</form>";
echo "</div>";

echo "<hr>";
echo "<h3>Información Actual</h3>";
echo "<p><strong>Contraseña actual en BD:</strong> CalculadoraPersonal2024</p>";
echo "<p><strong>Archivo ZIP:</strong> {$proyecto['download_path']}</p>";

// Mostrar ruta completa del archivo
$fullPath = '';
if (!empty($proyecto['download_path'])) {
    $storedPath = $proyecto['download_path'];
    if (str_starts_with($storedPath, '/') || preg_match('~^[A-Za-z]:\\\\~', $storedPath)) {
        $fullPath = $storedPath;
    } else {
        $baseDir = rtrim(SECURE_DOWNLOAD_BASE, DIRECTORY_SEPARATOR);
        $fullPath = $baseDir . DIRECTORY_SEPARATOR . ltrim($storedPath, '/\\');
    }
}

echo "<p><strong>Ruta completa:</strong> {$fullPath}</p>";
echo "<p><strong>Archivo existe:</strong> " . (file_exists($fullPath) ? '✅ Sí' : '❌ No') . "</p>";
if (file_exists($fullPath)) {
    echo "<p><strong>Tamaño:</strong> " . number_format(filesize($fullPath) / 1024 / 1024, 2) . " MB</p>";
}
?>
