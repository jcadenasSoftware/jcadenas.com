<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

echo "<h2>Verificación y Corrección de Contraseñas</h2>";

// Obtener todos los proyectos con contraseñas
$stmt = $pdo->query("SELECT id, titulo, password_encrypted FROM proyecto WHERE password_encrypted IS NOT NULL AND password_encrypted != ''");
$proyectos = $stmt->fetchAll();

echo "<h3>Proyectos con contraseñas encriptadas encontrados: " . count($proyectos) . "</h3>";

foreach ($proyectos as $proyecto) {
    echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
    echo "<h4>Proyecto ID: {$proyecto['id']} - {$proyecto['titulo']}</h4>";
    echo "<p><strong>Contraseña encriptada:</strong> " . substr($proyecto['password_encrypted'], 0, 50) . "...</p>";
    
    // Intentar descifrar con la clave actual
    $decrypted = '';
    try {
        $decrypted = decryptSecret($proyecto['password_encrypted']);
        if (!empty($decrypted)) {
            echo "<p style='color: green;'><strong>✅ Descifrado exitoso:</strong> {$decrypted}</p>";
        } else {
            echo "<p style='color: red;'><strong>❌ No se pudo descifrar</strong></p>";
            
            // Intentar con la clave anterior
            $oldKey = 'REPLACE_WITH_A_RANDOM_32_BYTE_SECRET_123456';
            $decryptedOld = '';
            try {
                $decryptedOld = decryptSecret($proyecto['password_encrypted'], $oldKey);
                if (!empty($decryptedOld)) {
                    echo "<p style='color: orange;'><strong>⚠️ Descifrado con clave anterior:</strong> {$decryptedOld}</p>";
                    
                    // Ofrecer re-encriptar con la nueva clave
                    if (isset($_POST['reencrypt_' . $proyecto['id']])) {
                        $newEncrypted = encryptSecret($decryptedOld);
                        if (!empty($newEncrypted)) {
                            $updateStmt = $pdo->prepare('UPDATE proyecto SET password_encrypted = ? WHERE id = ?');
                            if ($updateStmt->execute([$newEncrypted, $proyecto['id']])) {
                                echo "<p style='color: green;'><strong>✅ Re-encriptado exitosamente</strong></p>";
                            } else {
                                echo "<p style='color: red;'><strong>❌ Error al actualizar</strong></p>";
                            }
                        }
                    } else {
                        echo "<form method='post' style='margin-top: 10px;'>";
                        echo "<button type='submit' name='reencrypt_{$proyecto['id']}' style='background: orange; color: white; padding: 5px 10px; border: none; border-radius: 3px;'>Re-encriptar con nueva clave</button>";
                        echo "</form>";
                    }
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'><strong>❌ Error con clave anterior:</strong> " . $e->getMessage() . "</p>";
            }
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'><strong>❌ Error al descifrar:</strong> " . $e->getMessage() . "</p>";
    }
    
    echo "</div>";
}

echo "<hr>";
echo "<h3>Configuración Actual</h3>";
echo "<p><strong>APP_SECRET:</strong> " . substr(APP_SECRET, 0, 20) . "...</p>";
echo "<p><strong>Longitud:</strong> " . strlen(APP_SECRET) . " caracteres</p>";

// Formulario para establecer nueva contraseña
if (isset($_POST['set_password'])) {
    $projectId = (int)$_POST['project_id'];
    $newPassword = trim($_POST['new_password']);
    
    if ($projectId && $newPassword) {
        if (resetProjectPassword($projectId, $newPassword)) {
            echo "<p style='color: green;'><strong>✅ Contraseña establecida para proyecto {$projectId}</strong></p>";
        } else {
            echo "<p style='color: red;'><strong>❌ Error al establecer contraseña</strong></p>";
        }
    }
}

echo "<h3>Establecer Nueva Contraseña</h3>";
echo "<form method='post'>";
echo "<p>";
echo "<label>Proyecto ID: <input type='number' name='project_id' required></label><br>";
echo "<label>Nueva Contraseña: <input type='text' name='new_password' required></label><br>";
echo "<button type='submit' name='set_password' style='background: green; color: white; padding: 10px 20px; border: none; border-radius: 5px; margin-top: 10px;'>Establecer Contraseña</button>";
echo "</p>";
echo "</form>";
?>
