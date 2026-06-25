<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../db.php';
require_once __DIR__.'/auth.php';

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$media_id = (int)($_POST['media_id'] ?? 0);

if(!$media_id) {
    echo json_encode(['success' => false, 'message' => 'ID de media inválido']);
    exit;
}

try {
    // Obtener información del archivo
    $stmt = $pdo->prepare('SELECT * FROM media WHERE id=?');
    $stmt->execute([$media_id]);
    $media = $stmt->fetch();
    
    if(!$media) {
        echo json_encode(['success' => false, 'message' => 'Archivo no encontrado']);
        exit;
    }
    
    // Si es imagen, eliminar archivo físico y sus variantes
    if($media['tipo'] === 'imagen' && str_starts_with($media['ruta'], '/')) {
        $abs_path = __DIR__ . '/..' . $media['ruta'];
        
        // Eliminar archivo original
        if(file_exists($abs_path)) {
            @unlink($abs_path);
        }
        
        // Eliminar variantes responsivas
        $dir = dirname($abs_path);
        $basename = pathinfo($abs_path, PATHINFO_FILENAME);
        $ext = pathinfo($abs_path, PATHINFO_EXTENSION);
        
        $patterns = [
            $dir . DIRECTORY_SEPARATOR . $basename . '-w*.' . $ext,
            $dir . DIRECTORY_SEPARATOR . $basename . '-w*.webp',
            $dir . DIRECTORY_SEPARATOR . $basename . '.webp'
        ];
        
        foreach($patterns as $pattern) {
            foreach(glob($pattern) as $file) {
                @unlink($file);
            }
        }
    }
    
    // Eliminar registro de la base de datos
    $stmt = $pdo->prepare('DELETE FROM media WHERE id=?');
    $stmt->execute([$media_id]);
    
    echo json_encode([
        'success' => true, 
        'message' => ucfirst($media['tipo']) . ' eliminado correctamente'
    ]);
    
} catch(Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error al eliminar: ' . $e->getMessage()
    ]);
}
