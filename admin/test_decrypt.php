<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

echo "<h2>Test de Descifrado - Calculadora Personal</h2>";

// Buscar el proyecto Calculadora
$stmt = $pdo->prepare("SELECT * FROM proyecto WHERE titulo LIKE '%calculadora%' OR titulo LIKE '%Calculadora%'");
$stmt->execute();
$proyecto = $stmt->fetch();

if (!$proyecto) {
    echo "<p style='color: red;'>No se encontró el proyecto Calculadora</p>";
    exit;
}

echo "<h3>Proyecto encontrado: ID {$proyecto['id']} - {$proyecto['titulo']}</h3>";

if (empty($proyecto['password_encrypted'])) {
    echo "<p style='color: red;'>❌ El proyecto NO tiene contraseña en la BD</p>";
    exit;
}

echo "<p><strong>Contraseña encriptada en BD:</strong><br>";
echo "<code style='background: #f0f0f0; padding: 10px; display: block; word-break: break-all;'>";
echo htmlspecialchars($proyecto['password_encrypted']);
echo "</code></p>";

echo "<h3>Pruebas de Descifrado</h3>";

// Array de claves posibles
$testKeys = [
    'Clave actual (config.local.php)' => 'jcadenas_2025_secure_key_f8a92b7e4d1c3690',
    'Clave por defecto (config.php)' => 'REPLACE_WITH_A_RANDOM_32_BYTE_SECRET_123456',
    'Otras claves posibles' => [
        'jcadenas_secure_key_2025',
        'jcadenas_2025',
        'jcadenas_key_2025',
        'jcadenas_2025_secure_key',
        'jcadenas_secure_key_2025_f8a92b7e4d1c3690'
    ]
];

$success = false;
$workingKey = '';
$decryptedPassword = '';

foreach ($testKeys as $keyName => $keyValue) {
    if (is_array($keyValue)) {
        foreach ($keyValue as $subKey) {
            echo "<div style='border: 1px solid #ccc; margin: 10px 0; padding: 10px;'>";
            echo "<h4>Probando: {$keyName} - {$subKey}</h4>";
            
            try {
                $result = decryptSecret($proyecto['password_encrypted'], $subKey);
                if (!empty($result)) {
                    echo "<p style='color: green; font-size: 18px;'><strong>✅ ¡ÉXITO!</strong></p>";
                    echo "<p><strong>Contraseña descifrada:</strong> <code style='background: yellow; padding: 5px;'>{$result}</code></p>";
                    $success = true;
                    $workingKey = $subKey;
                    $decryptedPassword = $result;
                    break 2;
                } else {
                    echo "<p style='color: red;'>❌ No funcionó</p>";
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
            }
            echo "</div>";
        }
    } else {
        echo "<div style='border: 1px solid #ccc; margin: 10px 0; padding: 10px;'>";
        echo "<h4>Probando: {$keyName}</h4>";
        echo "<p><strong>Clave:</strong> " . substr($keyValue, 0, 20) . "...</p>";
        
        try {
            $result = decryptSecret($proyecto['password_encrypted'], $keyValue);
            if (!empty($result)) {
                echo "<p style='color: green; font-size: 18px;'><strong>✅ ¡ÉXITO!</strong></p>";
                echo "<p><strong>Contraseña descifrada:</strong> <code style='background: yellow; padding: 5px;'>{$result}</code></p>";
                $success = true;
                $workingKey = $keyValue;
                $decryptedPassword = $result;
                break;
            } else {
                echo "<p style='color: red;'>❌ No funcionó</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
        }
        echo "</div>";
    }
}

if ($success) {
    echo "<div style='background: #d4edda; border: 2px solid #28a745; padding: 20px; margin: 20px 0; border-radius: 10px;'>";
    echo "<h3 style='color: #155724;'>🎉 PROBLEMA IDENTIFICADO Y SOLUCIONADO</h3>";
    echo "<p><strong>Clave que funciona:</strong> " . substr($workingKey, 0, 30) . "...</p>";
    echo "<p><strong>Contraseña del proyecto:</strong> <code style='background: yellow; padding: 10px; font-size: 16px;'>{$decryptedPassword}</code></p>";
    
    // Verificar si es la clave actual
    if ($workingKey === APP_SECRET) {
        echo "<p style='color: green;'>✅ Esta ES la clave actual del sistema</p>";
        echo "<p><strong>Conclusión:</strong> El descifrado debería funcionar. Puede haber un problema en el código de download.php</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Esta NO es la clave actual del sistema</p>";
        echo "<p><strong>Clave actual:</strong> " . substr(APP_SECRET, 0, 30) . "...</p>";
        echo "<p><strong>Solución:</strong> Necesitamos re-encriptar con la clave actual</p>";
        
        // Botón para re-encriptar
        if (isset($_POST['reencrypt'])) {
            $newEncrypted = encryptSecret($decryptedPassword, APP_SECRET);
            if ($newEncrypted) {
                $updateStmt = $pdo->prepare('UPDATE proyecto SET password_encrypted = ? WHERE id = ?');
                if ($updateStmt->execute([$newEncrypted, $proyecto['id']])) {
                    echo "<p style='color: green; font-size: 18px;'><strong>✅ RE-ENCRIPTADO EXITOSO</strong></p>";
                    echo "<p>Ahora el proyecto debería mostrar la contraseña correctamente.</p>";
                    echo "<script>setTimeout(() => location.reload(), 3000);</script>";
                } else {
                    echo "<p style='color: red;'>❌ Error al actualizar la base de datos</p>";
                }
            } else {
                echo "<p style='color: red;'>❌ Error al re-encriptar</p>";
            }
        } else {
            echo "<form method='post'>";
            echo "<button type='submit' name='reencrypt' style='background: #28a745; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px; margin-top: 10px;'>🔄 RE-ENCRIPTAR CON CLAVE ACTUAL</button>";
            echo "</form>";
        }
    }
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; border: 2px solid #dc3545; padding: 20px; margin: 20px 0; border-radius: 10px;'>";
    echo "<h3 style='color: #721c24;'>❌ NINGUNA CLAVE FUNCIONÓ</h3>";
    echo "<p>La contraseña está corrupta o fue encriptada con una clave que no conocemos.</p>";
    echo "<p><strong>Solución:</strong> Establecer una nueva contraseña</p>";
    
    if (isset($_POST['new_password'])) {
        $newPass = trim($_POST['password']);
        if ($newPass) {
            $encrypted = encryptSecret($newPass, APP_SECRET);
            if ($encrypted) {
                $updateStmt = $pdo->prepare('UPDATE proyecto SET password_encrypted = ? WHERE id = ?');
                if ($updateStmt->execute([$encrypted, $proyecto['id']])) {
                    echo "<p style='color: green;'><strong>✅ Nueva contraseña establecida:</strong> {$newPass}</p>";
                } else {
                    echo "<p style='color: red;'>❌ Error al guardar</p>";
                }
            }
        }
    } else {
        echo "<form method='post'>";
        echo "<p><label>Nueva contraseña: <input type='text' name='password' value='CalculadoraPersonal2024' required></label></p>";
        echo "<button type='submit' name='new_password' style='background: #dc3545; color: white; padding: 15px 30px; border: none; border-radius: 5px;'>🆕 ESTABLECER NUEVA CONTRASEÑA</button>";
        echo "</form>";
    }
    echo "</div>";
}

echo "<hr>";
echo "<h3>Información del Sistema</h3>";
echo "<p><strong>APP_SECRET actual:</strong> " . substr(APP_SECRET, 0, 30) . "... (longitud: " . strlen(APP_SECRET) . ")</p>";

// Mostrar función de descifrado que se está usando
echo "<h4>Función decryptSecret actual:</h4>";
echo "<pre style='background: #f8f9fa; padding: 10px; border: 1px solid #dee2e6;'>";
$reflection = new ReflectionFunction('decryptSecret');
echo htmlspecialchars($reflection->getFileName() . ' línea ' . $reflection->getStartLine());
echo "</pre>";
?>
