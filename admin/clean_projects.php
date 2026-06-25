<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

echo "<h2>🧹 Limpiar Proyectos Existentes</h2>";

// Mostrar proyectos actuales
$stmt = $pdo->query("SELECT id, titulo, download_path, password_encrypted FROM proyecto ORDER BY id");
$proyectos = $stmt->fetchAll();

echo "<h3>Proyectos actuales: " . count($proyectos) . "</h3>";

if (empty($proyectos)) {
    echo "<p>No hay proyectos para limpiar.</p>";
} else {
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 20px 0;'>";
    echo "<tr style='background: #f8f9fa;'>";
    echo "<th style='padding: 10px;'>ID</th>";
    echo "<th style='padding: 10px;'>Título</th>";
    echo "<th style='padding: 10px;'>Archivo ZIP</th>";
    echo "<th style='padding: 10px;'>Tiene Contraseña</th>";
    echo "</tr>";
    
    foreach ($proyectos as $p) {
        echo "<tr>";
        echo "<td style='padding: 10px; text-align: center;'>{$p['id']}</td>";
        echo "<td style='padding: 10px;'>" . htmlspecialchars($p['titulo']) . "</td>";
        echo "<td style='padding: 10px;'>" . htmlspecialchars($p['download_path'] ?: 'Sin archivo') . "</td>";
        echo "<td style='padding: 10px; text-align: center;'>" . (!empty($p['password_encrypted']) ? '🔒 Sí' : '🔓 No') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Proceso de limpieza
if (isset($_POST['confirm_clean'])) {
    $cleanType = $_POST['clean_type'];
    
    try {
        $pdo->beginTransaction();
        
        if ($cleanType === 'passwords_only') {
            // Solo limpiar contraseñas
            $stmt = $pdo->prepare("UPDATE proyecto SET password_encrypted = NULL");
            $stmt->execute();
            echo "<div style='background: #d4edda; border: 2px solid #28a745; padding: 20px; margin: 20px 0; border-radius: 10px;'>";
            echo "<h3 style='color: #155724;'>✅ Contraseñas Limpiadas</h3>";
            echo "<p>Se han eliminado todas las contraseñas de los proyectos.</p>";
            echo "<p>Los proyectos siguen existiendo, pero sin contraseñas configuradas.</p>";
            echo "</div>";
            
        } elseif ($cleanType === 'files_and_passwords') {
            // Limpiar archivos y contraseñas
            $stmt = $pdo->prepare("UPDATE proyecto SET download_path = NULL, password_encrypted = NULL, download_mime = NULL, download_size = NULL");
            $stmt->execute();
            echo "<div style='background: #d4edda; border: 2px solid #28a745; padding: 20px; margin: 20px 0; border-radius: 10px;'>";
            echo "<h3 style='color: #155724;'>✅ Archivos y Contraseñas Limpiados</h3>";
            echo "<p>Se han eliminado todos los archivos ZIP y contraseñas.</p>";
            echo "<p>Los proyectos siguen existiendo, pero sin archivos descargables.</p>";
            echo "</div>";
            
        } elseif ($cleanType === 'everything') {
            // Eliminar todo: proyectos, media, compras
            $pdo->exec("DELETE FROM purchase_token");
            $pdo->exec("DELETE FROM purchase");
            $pdo->exec("DELETE FROM media");
            $pdo->exec("DELETE FROM proyecto");
            echo "<div style='background: #d4edda; border: 2px solid #28a745; padding: 20px; margin: 20px 0; border-radius: 10px;'>";
            echo "<h3 style='color: #155724;'>✅ TODO Eliminado</h3>";
            echo "<p>Se han eliminado TODOS los proyectos, media, compras y tokens.</p>";
            echo "<p>El sistema está completamente limpio para empezar de cero.</p>";
            echo "</div>";
        }
        
        $pdo->commit();
        
        // Recargar para mostrar estado actualizado
        echo "<script>setTimeout(() => location.reload(), 3000);</script>";
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<div style='background: #f8d7da; border: 2px solid #dc3545; padding: 20px; margin: 20px 0; border-radius: 10px;'>";
        echo "<h3 style='color: #721c24;'>❌ Error</h3>";
        echo "<p>Error al limpiar: " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "</div>";
    }
}

if (!empty($proyectos)) {
    echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 20px; margin: 20px 0; border-radius: 10px;'>";
    echo "<h3>⚠️ Opciones de Limpieza</h3>";
    echo "<p>Elige qué quieres limpiar antes de subir los proyectos nuevos:</p>";
    
    echo "<form method='post'>";
    echo "<div style='margin: 15px 0;'>";
    echo "<label style='display: block; margin: 10px 0;'>";
    echo "<input type='radio' name='clean_type' value='passwords_only' required> ";
    echo "<strong>Solo contraseñas</strong> - Mantener proyectos y archivos, solo limpiar contraseñas";
    echo "</label>";
    
    echo "<label style='display: block; margin: 10px 0;'>";
    echo "<input type='radio' name='clean_type' value='files_and_passwords' required> ";
    echo "<strong>Archivos y contraseñas</strong> - Mantener proyectos, limpiar archivos ZIP y contraseñas";
    echo "</label>";
    
    echo "<label style='display: block; margin: 10px 0;'>";
    echo "<input type='radio' name='clean_type' value='everything' required> ";
    echo "<strong>TODO</strong> - Eliminar proyectos, archivos, media, compras (empezar completamente de cero)";
    echo "</label>";
    echo "</div>";
    
    echo "<div style='margin: 20px 0;'>";
    echo "<label style='display: block; margin: 10px 0;'>";
    echo "<input type='checkbox' name='confirm_clean' value='1' required> ";
    echo "Confirmo que quiero realizar esta limpieza (esta acción no se puede deshacer)";
    echo "</label>";
    echo "</div>";
    
    echo "<button type='submit' style='background: #dc3545; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px;'>🧹 EJECUTAR LIMPIEZA</button>";
    echo "</form>";
    echo "</div>";
}

echo "<hr>";
echo "<h3>📋 Plan Recomendado</h3>";
echo "<ol>";
echo "<li><strong>Limpiar</strong> - Usar una de las opciones de arriba</li>";
echo "<li><strong>Subir proyectos</strong> - Usar el panel de admin normal</li>";
echo "<li><strong>Establecer contraseñas</strong> - Una diferente para cada proyecto</li>";
echo "<li><strong>Probar</strong> - Hacer compras de prueba para verificar</li>";
echo "</ol>";

echo "<p><strong>Sugerencias de contraseñas por proyecto:</strong></p>";
echo "<ul>";
echo "<li>Calculadora Personal → <code>CalculadoraPersonal2024</code></li>";
echo "<li>Sistema de Ventas → <code>SistemaVentas2024</code></li>";
echo "<li>App Android → <code>AppAndroid2024</code></li>";
echo "<li>Proyecto Web → <code>ProyectoWeb2024</code></li>";
echo "</ul>";

echo "<p><a href='../admin/'>← Volver al panel de admin</a></p>";
?>
