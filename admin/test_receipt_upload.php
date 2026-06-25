<?php
/**
 * Script de prueba para verificar la funcionalidad de comprobantes
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

echo "<h1>Test de Comprobantes</h1>";

// 1. Verificar directorio de uploads
$uploadDir = dirname(__DIR__) . '/uploads/recibos/';
echo "<h3>1. Directorio de uploads:</h3>";
echo "<p><strong>Ruta:</strong> {$uploadDir}</p>";
echo "<p><strong>Existe:</strong> " . (is_dir($uploadDir) ? "✅ SÍ" : "❌ NO") . "</p>";
echo "<p><strong>Escribible:</strong> " . (is_writable($uploadDir) ? "✅ SÍ" : "❌ NO") . "</p>";

// 2. Verificar compras con comprobantes
echo "<h3>2. Compras con comprobantes en la BD:</h3>";
try {
    $stmt = $pdo->query("SELECT id, nombre, email, recibo_path, created_at FROM purchase WHERE recibo_path IS NOT NULL AND recibo_path != '' ORDER BY id DESC LIMIT 10");
    $purchases = $stmt->fetchAll();
    
    if (empty($purchases)) {
        echo "<p>❌ No hay compras con comprobantes en la base de datos</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Cliente</th><th>Email</th><th>Ruta Comprobante</th><th>Archivo Existe</th><th>Fecha</th></tr>";
        
        foreach ($purchases as $purchase) {
            $filePath = dirname(__DIR__) . '/' . ltrim($purchase['recibo_path'], '/\\');
            $exists = file_exists($filePath) ? "✅" : "❌";
            
            echo "<tr>";
            echo "<td>#{$purchase['id']}</td>";
            echo "<td>" . htmlspecialchars($purchase['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($purchase['email']) . "</td>";
            echo "<td>" . htmlspecialchars($purchase['recibo_path']) . "</td>";
            echo "<td>{$exists}</td>";
            echo "<td>" . date('d/m/Y H:i', strtotime($purchase['created_at'])) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch (Exception $e) {
    echo "<p>❌ Error al consultar la BD: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// 3. Verificar archivos en el directorio
echo "<h3>3. Archivos en el directorio de recibos:</h3>";
if (is_dir($uploadDir)) {
    $files = scandir($uploadDir);
    $files = array_filter($files, function($file) {
        return $file !== '.' && $file !== '..';
    });
    
    if (empty($files)) {
        echo "<p>❌ No hay archivos en el directorio</p>";
    } else {
        echo "<ul>";
        foreach ($files as $file) {
            $fullPath = $uploadDir . $file;
            $size = filesize($fullPath);
            $date = date('d/m/Y H:i', filemtime($fullPath));
            echo "<li><strong>{$file}</strong> - " . number_format($size) . " bytes - {$date}</li>";
        }
        echo "</ul>";
    }
} else {
    echo "<p>❌ El directorio no existe</p>";
}

// 4. Crear directorio si no existe
if (!is_dir($uploadDir)) {
    echo "<h3>4. Creando directorio...</h3>";
    if (mkdir($uploadDir, 0755, true)) {
        echo "<p>✅ Directorio creado exitosamente</p>";
    } else {
        echo "<p>❌ Error al crear directorio</p>";
    }
}

echo "<hr>";
echo "<p><a href='purchases.php'>← Volver al panel de compras</a></p>";
?>
