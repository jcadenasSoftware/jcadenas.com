<?php
/**
 * Script para verificar la sintaxis de purchase_create.php
 */

echo "<h1>Test de Sintaxis - purchase_create.php</h1>";

// Verificar sintaxis del archivo
$file = dirname(__DIR__) . '/purchase_create.php';
$output = [];
$return_var = 0;

exec("php -l \"$file\" 2>&1", $output, $return_var);

echo "<h3>Resultado del análisis de sintaxis:</h3>";

if ($return_var === 0) {
    echo "<p style='color: green; font-weight: bold;'>✅ SINTAXIS CORRECTA</p>";
    echo "<p>El archivo no tiene errores de sintaxis PHP.</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>❌ ERRORES DE SINTAXIS ENCONTRADOS</p>";
    echo "<pre style='background: #f8d7da; padding: 10px; border-radius: 5px;'>";
    foreach ($output as $line) {
        echo htmlspecialchars($line) . "\n";
    }
    echo "</pre>";
}

echo "<hr>";
echo "<h3>Verificaciones adicionales:</h3>";

// Verificar que el archivo existe
if (file_exists($file)) {
    echo "<p>✅ El archivo existe</p>";
    echo "<p><strong>Ruta:</strong> " . realpath($file) . "</p>";
    echo "<p><strong>Tamaño:</strong> " . number_format(filesize($file)) . " bytes</p>";
    echo "<p><strong>Última modificación:</strong> " . date('d/m/Y H:i:s', filemtime($file)) . "</p>";
} else {
    echo "<p>❌ El archivo no existe</p>";
}

// Verificar includes necesarios
$requiredFiles = [
    'config.php',
    'db.php',
    'includes/invoice_generator.php'
];

echo "<h3>Archivos requeridos:</h3>";
foreach ($requiredFiles as $reqFile) {
    $fullPath = dirname(__DIR__) . '/' . $reqFile;
    if (file_exists($fullPath)) {
        echo "<p>✅ {$reqFile}</p>";
    } else {
        echo "<p>❌ {$reqFile} - <strong>NO ENCONTRADO</strong></p>";
    }
}

echo "<hr>";
echo "<p><a href='purchases.php'>← Volver al panel de compras</a></p>";
?>
