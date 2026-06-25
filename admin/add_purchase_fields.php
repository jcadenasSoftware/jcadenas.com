<?php
require_once __DIR__ . '/../db.php';

echo "<h2>Agregando campos opcionales a la tabla purchase</h2>";

try {
    // Verificar si las columnas ya existen
    $stmt = $pdo->query("DESCRIBE purchase");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $hasDocumento = in_array('documento', $columns);
    $hasDireccion = in_array('direccion', $columns);
    
    echo "<p>Columnas existentes: " . implode(', ', $columns) . "</p>";
    
    // Agregar columna documento si no existe
    if (!$hasDocumento) {
        $pdo->exec("ALTER TABLE purchase ADD COLUMN documento VARCHAR(100) NULL COMMENT 'Número de documento del cliente (opcional)'");
        echo "<p style='color: green;'>✅ Columna 'documento' agregada exitosamente</p>";
    } else {
        echo "<p style='color: blue;'>ℹ️ Columna 'documento' ya existe</p>";
    }
    
    // Agregar columna direccion si no existe
    if (!$hasDireccion) {
        $pdo->exec("ALTER TABLE purchase ADD COLUMN direccion VARCHAR(255) NULL COMMENT 'Dirección del cliente (opcional)'");
        echo "<p style='color: green;'>✅ Columna 'direccion' agregada exitosamente</p>";
    } else {
        echo "<p style='color: blue;'>ℹ️ Columna 'direccion' ya existe</p>";
    }
    
    // Mostrar estructura actualizada
    echo "<h3>Estructura actualizada de la tabla purchase:</h3>";
    $stmt = $pdo->query("DESCRIBE purchase");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    foreach ($columns as $col) {
        echo "<tr>";
        echo "<td>{$col['Field']}</td>";
        echo "<td>{$col['Type']}</td>";
        echo "<td>{$col['Null']}</td>";
        echo "<td>{$col['Key']}</td>";
        echo "<td>{$col['Default']}</td>";
        echo "<td>{$col['Extra']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<p style='color: green; font-weight: bold;'>✅ Proceso completado exitosamente</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
