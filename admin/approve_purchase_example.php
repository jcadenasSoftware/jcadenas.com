<?php
/**
 * EJEMPLO: Cómo aprobar una compra desde el dashboard
 * 
 * Este archivo muestra cómo integrar la función de aprobación
 * en tu sistema de administración existente.
 */

require_once __DIR__ . '/../includes/purchase_approval.php';

// Ejemplo de uso cuando se aprueba una compra
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_purchase'])) {
    $purchaseId = (int)($_POST['purchase_id'] ?? 0);
    
    if ($purchaseId) {
        try {
            // Actualizar estado en la base de datos
            global $pdo;
            $stmt = $pdo->prepare('UPDATE purchase SET status = "approved" WHERE id = ?');
            $stmt->execute([$purchaseId]);
            
            // Enviar cuenta de cobro y enlace de descarga
            $success = sendApprovalNotification($purchaseId);
            
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Compra aprobada y notificación enviada']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Compra aprobada pero error al enviar notificación']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID de compra inválido']);
    }
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ejemplo - Aprobar Compra</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .example { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .code { background: #e9ecef; padding: 15px; border-radius: 5px; font-family: monospace; }
    </style>
</head>
<body>
    <h1>Ejemplo: Aprobar Compra</h1>
    
    <div class="example">
        <h3>1. En tu dashboard existente, agrega este código:</h3>
        <div class="code">
// Incluir la función de aprobación<br>
require_once __DIR__ . '/includes/purchase_approval.php';<br><br>

// Cuando apruebes una compra<br>
if ($approveAction) {<br>
&nbsp;&nbsp;&nbsp;&nbsp;// Actualizar estado<br>
&nbsp;&nbsp;&nbsp;&nbsp;$stmt = $pdo->prepare('UPDATE purchase SET status = "approved" WHERE id = ?');<br>
&nbsp;&nbsp;&nbsp;&nbsp;$stmt->execute([$purchaseId]);<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;// Enviar cuenta de cobro y enlace<br>
&nbsp;&nbsp;&nbsp;&nbsp;$success = sendApprovalNotification($purchaseId);<br>
}
        </div>
    </div>
    
    <div class="example">
        <h3>2. Formulario de prueba:</h3>
        <form method="post">
            <label>ID de Compra a Aprobar:</label><br>
            <input type="number" name="purchase_id" required><br><br>
            <button type="submit" name="approve_purchase">Aprobar Compra</button>
        </form>
    </div>
    
    <div class="example">
        <h3>3. Lo que sucede al aprobar:</h3>
        <ul>
            <li>✅ Se actualiza el estado a "approved"</li>
            <li>✅ Se genera la cuenta de cobro en PDF</li>
            <li>✅ Se crea token de descarga (72 horas)</li>
            <li>✅ Se envía email con cuenta de cobro adjunta</li>
            <li>✅ Se incluye enlace de descarga en el email</li>
            <li>✅ Se limpia archivo temporal</li>
        </ul>
    </div>
</body>
</html>
