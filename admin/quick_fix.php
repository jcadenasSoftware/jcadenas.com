<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

echo "<h2>Solución Rápida - Calculadora Personal</h2>";

// Buscar el proyecto "Calculadora personal"
$stmt = $pdo->prepare("SELECT * FROM proyecto WHERE titulo LIKE '%calculadora%' OR titulo LIKE '%Calculadora%'");
$stmt->execute();
$proyectos = $stmt->fetchAll();

if (empty($proyectos)) {
    echo "<p style='color: red;'>No se encontró proyecto con 'Calculadora' en el título</p>";
    
    // Mostrar todos los proyectos
    $allStmt = $pdo->query("SELECT id, titulo FROM proyecto ORDER BY id");
    $allProyectos = $allStmt->fetchAll();
    
    echo "<h3>Todos los proyectos:</h3>";
    foreach ($allProyectos as $p) {
        echo "<p>ID {$p['id']}: {$p['titulo']}</p>";
    }
    exit;
}

foreach ($proyectos as $proyecto) {
    echo "<div style='border: 2px solid #007cba; margin: 20px 0; padding: 20px; background: #f0f8ff;'>";
    echo "<h3>Proyecto ID: {$proyecto['id']} - {$proyecto['titulo']}</h3>";
    
    if (empty($proyecto['password_encrypted'])) {
        echo "<p style='color: orange; font-size: 18px;'><strong>🎯 AQUÍ ESTÁ EL PROBLEMA:</strong></p>";
        echo "<p>Este proyecto NO tiene contraseña configurada, por eso aparece 'Archivo sin protección'.</p>";
        
        // Acción rápida para establecer contraseña
        if (isset($_POST['fix_' . $proyecto['id']])) {
            $password = 'CalculadoraPersonal2024'; // Contraseña por defecto
            $encrypted = encryptSecret($password);
            
            if ($encrypted) {
                $updateStmt = $pdo->prepare('UPDATE proyecto SET password_encrypted = ? WHERE id = ?');
                if ($updateStmt->execute([$encrypted, $proyecto['id']])) {
                    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
                    echo "<h4 style='color: #155724;'>✅ SOLUCIONADO</h4>";
                    echo "<p><strong>Contraseña establecida:</strong> {$password}</p>";
                    echo "<p>Ahora el proyecto mostrará esta contraseña en las descargas.</p>";
                    echo "</div>";
                } else {
                    echo "<p style='color: red;'>❌ Error al guardar en base de datos</p>";
                }
            } else {
                echo "<p style='color: red;'>❌ Error al encriptar contraseña</p>";
            }
        } else {
            echo "<form method='post'>";
            echo "<p style='background: #fff3cd; padding: 15px; border-radius: 5px;'>";
            echo "<strong>Solución:</strong> Establecer contraseña 'CalculadoraPersonal2024' para este proyecto<br>";
            echo "<button type='submit' name='fix_{$proyecto['id']}' style='background: #28a745; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px; margin-top: 10px;'>🔧 SOLUCIONAR AHORA</button>";
            echo "</p>";
            echo "</form>";
        }
        
    } else {
        echo "<p><strong>Contraseña encriptada:</strong> " . substr($proyecto['password_encrypted'], 0, 50) . "...</p>";
        
        // Verificar si se puede descifrar
        try {
            $decrypted = decryptSecret($proyecto['password_encrypted']);
            if (!empty($decrypted)) {
                echo "<p style='color: green;'><strong>✅ Contraseña actual:</strong> {$decrypted}</p>";
                echo "<p>Este proyecto debería mostrar la contraseña correctamente.</p>";
            } else {
                echo "<p style='color: red;'><strong>❌ No se puede descifrar con la clave actual</strong></p>";
                
                // Intentar re-encriptar con nueva contraseña
                if (isset($_POST['reset_' . $proyecto['id']])) {
                    $newPassword = 'CalculadoraPersonal2024';
                    $encrypted = encryptSecret($newPassword);
                    
                    if ($encrypted) {
                        $updateStmt = $pdo->prepare('UPDATE proyecto SET password_encrypted = ? WHERE id = ?');
                        if ($updateStmt->execute([$encrypted, $proyecto['id']])) {
                            echo "<p style='color: green;'><strong>✅ Contraseña reseteada a:</strong> {$newPassword}</p>";
                        }
                    }
                } else {
                    echo "<form method='post'>";
                    echo "<button type='submit' name='reset_{$proyecto['id']}' style='background: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 5px;'>🔄 Resetear Contraseña</button>";
                    echo "</form>";
                }
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'><strong>❌ Error:</strong> " . $e->getMessage() . "</p>";
        }
    }
    
    echo "</div>";
}

echo "<hr>";
echo "<h3>Información del Sistema</h3>";
echo "<p><strong>APP_SECRET:</strong> " . substr(APP_SECRET, 0, 20) . "... (longitud: " . strlen(APP_SECRET) . ")</p>";

$configLocal = __DIR__ . '/../config.local.php';
echo "<p><strong>config.local.php:</strong> " . (file_exists($configLocal) ? 'Existe' : 'No existe') . "</p>";

if (file_exists($configLocal)) {
    $content = file_get_contents($configLocal);
    if (strpos($content, 'APP_SECRET') !== false) {
        echo "<p style='color: green;'>✅ config.local.php define APP_SECRET</p>";
    } else {
        echo "<p style='color: red;'>❌ config.local.php NO define APP_SECRET</p>";
    }
}
?>
