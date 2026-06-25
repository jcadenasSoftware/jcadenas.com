<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/db.php';

if($_SERVER['REQUEST_METHOD']!=='POST'){
    http_response_code(405); 
    echo 'Method not allowed'; 
    exit;
}

$projectId = (int)($_POST['proyecto_id'] ?? 0);
$nombre    = trim($_POST['nombre'] ?? '');
$email     = trim($_POST['email'] ?? '');
$metodo    = trim($_POST['metodo'] ?? '');
$refer     = trim($_POST['referencia'] ?? '');

if(!$projectId || !$nombre || !$email || !$metodo){
    http_response_code(400); 
    echo 'Faltan campos requeridos'; 
    exit;
}

$stmt=$pdo->prepare('SELECT titulo, precio FROM proyecto WHERE id=?');
$stmt->execute([$projectId]);
$proj=$stmt->fetch();
if(!$proj){ 
    http_response_code(404); 
    echo 'Proyecto no encontrado'; 
    exit; 
}

try {
    // Usar solo las columnas básicas que sabemos que existen
    $ins=$pdo->prepare('INSERT INTO purchase (proyecto_id,nombre,email,metodo,monto,moneda,status,referencia) VALUES (?,?,?,?,?,?,?,?)');
    $ins->execute([
        $projectId,
        $nombre,
        $email,
        $metodo,
        $proj['precio']??null,
        'COP',
        'pending',
        $refer
    ]);
    
    echo json_encode(['success' => true, 'message' => 'Compra registrada exitosamente']);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
