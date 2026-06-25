<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

$projectId = (int)($_GET['id'] ?? 0);

echo "<h2>Debug Proyecto Específico</h2>";

if (!$projectId) {
    echo "<p>Uso: debug_project.php?id=PROJECT_ID</p>";
    
    // Mostrar lista de proyectos
    $stmt = $pdo->query("SELECT id, titulo FROM proyecto ORDER BY id");
    $proyectos = $stmt->fetchAll();
    
    echo "<h3>Proyectos disponibles:</h3>";
    foreach ($proyectos as $p) {
        echo "<p><a href='?id={$p['id']}'>ID {$p['id']}: {$p['titulo']}</a></p>";
    }
    exit;
}

// Obtener datos completos del proyecto
$stmt = $pdo->prepare("SELECT * FROM proyecto WHERE id = ?");
$stmt->execute([$projectId]);
$proyecto = $stmt->fetch();

if (!$proyecto) {
    echo "<p style='color: red;'>Proyecto no encontrado</p>";
    exit;
}

echo "<h3>Proyecto ID: {$projectId} - {$proyecto['titulo']}</h3>";

echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>Campo</th><th>Valor</th></tr>";

foreach ($proyecto as $campo => $valor) {
    if ($campo === 'password_encrypted' && !empty($valor)) {
        echo "<tr><td>{$campo}</td><td>" . substr($valor, 0, 50) . "... (truncado)</td></tr>";
    } else {
        echo "<tr><td>{$campo}</td><td>" . htmlspecialchars($valor ?: 'NULL') . "</td></tr>";
    }
}
echo "</table>";

echo "<h3>Verificación de Contraseña</h3>";

if (empty($proyecto['password_encrypted'])) {
    echo "<p style='color: orange;'><strong>⚠️ Este proyecto NO tiene contraseña configurada</strong></p>";
    echo "<p>Por eso aparece 'Archivo sin protección' en la descarga.</p>";
    
    // Formulario para establecer contraseña
    if (isset($_POST['set_password'])) {
        $newPassword = trim($_POST['password']);
        if ($newPassword) {
            $encrypted = encryptSecret($newPassword);
            if ($encrypted) {
                $updateStmt = $pdo->prepare('UPDATE proyecto SET password_encrypted = ? WHERE id = ?');
                if ($updateStmt->execute([$encrypted, $projectId])) {
                    echo "<p style='color: green;'><strong>✅ Contraseña establecida exitosamente</strong></p>";
                    echo "<script>setTimeout(() => location.reload(), 2000);</script>";
                } else {
                    echo "<p style='color: red;'><strong>❌ Error al guardar contraseña</strong></p>";
                }
            } else {
                echo "<p style='color: red;'><strong>❌ Error al encriptar contraseña</strong></p>";
            }
        }
    }
    
    echo "<form method='post' style='margin: 20px 0; padding: 20px; border: 1px solid #ccc; background: #f9f9f9;'>";
    echo "<h4>Establecer Contraseña para este Proyecto</h4>";
    echo "<p><label>Nueva Contraseña: <input type='text' name='password' required placeholder='Ej: MiPassword123'></label></p>";
    echo "<p><button type='submit' name='set_password' style='background: green; color: white; padding: 10px 20px; border: none; border-radius: 5px;'>Establecer Contraseña</button></p>";
    echo "</form>";
    
} else {
    echo "<p><strong>Contraseña encriptada encontrada:</strong> " . substr($proyecto['password_encrypted'], 0, 50) . "...</p>";
    
    // Intentar descifrar
    try {
        $decrypted = decryptSecret($proyecto['password_encrypted']);
        if (!empty($decrypted)) {
            echo "<p style='color: green;'><strong>✅ Descifrado exitoso:</strong> {$decrypted}</p>";
        } else {
            echo "<p style='color: red;'><strong>❌ No se pudo descifrar con la clave actual</strong></p>";
            
            // Intentar con clave anterior
            $oldKey = 'REPLACE_WITH_A_RANDOM_32_BYTE_SECRET_123456';
            try {
                $decryptedOld = decryptSecret($proyecto['password_encrypted'], $oldKey);
                if (!empty($decryptedOld)) {
                    echo "<p style='color: orange;'><strong>⚠️ Se puede descifrar con clave anterior:</strong> {$decryptedOld}</p>";
                    
                    // Ofrecer re-encriptar
                    if (isset($_POST['reencrypt'])) {
                        $newEncrypted = encryptSecret($decryptedOld);
                        if ($newEncrypted) {
                            $updateStmt = $pdo->prepare('UPDATE proyecto SET password_encrypted = ? WHERE id = ?');
                            if ($updateStmt->execute([$newEncrypted, $projectId])) {
                                echo "<p style='color: green;'><strong>✅ Re-encriptado exitosamente</strong></p>";
                                echo "<script>setTimeout(() => location.reload(), 2000);</script>";
                            }
                        }
                    } else {
                        echo "<form method='post' style='margin: 10px 0;'>";
                        echo "<button type='submit' name='reencrypt' style='background: orange; color: white; padding: 10px 20px; border: none; border-radius: 5px;'>Re-encriptar con nueva clave</button>";
                        echo "</form>";
                    }
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'><strong>❌ Tampoco funciona con clave anterior</strong></p>";
            }
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'><strong>❌ Error al descifrar:</strong> " . $e->getMessage() . "</p>";
    }
}

echo "<h3>Configuración Actual</h3>";
echo "<p><strong>APP_SECRET:</strong> " . substr(APP_SECRET, 0, 20) . "... (longitud: " . strlen(APP_SECRET) . ")</p>";

// Verificar si config.local.php existe
$configLocalPath = __DIR__ . '/../config.local.php';
echo "<p><strong>config.local.php existe:</strong> " . (file_exists($configLocalPath) ? 'Sí' : 'No') . "</p>";

echo "<hr>";
echo "<p><a href='fix_passwords.php'>← Volver a lista completa</a></p>";
?>
