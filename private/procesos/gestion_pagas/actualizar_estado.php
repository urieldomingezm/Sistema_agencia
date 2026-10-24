<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id']) || !isset($data['estado'])) {
        throw new Exception('Datos incompletos');
    }

    $db = new Database();
    $conn = $db->getConnection();

    $query = "UPDATE gestion_pagas 
              SET estatus = :estado,
                  fecha_actualizacion = NOW() 
              WHERE pagas_id = :id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':estado', $data['estado']);
    $stmt->bindParam(':id', $data['id']);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = $data['estado'] === 'completo' 
            ? 'Pago confirmado correctamente' 
            : 'Estado actualizado a no recibido';
    } else {
        throw new Exception('Error al actualizar el estado');
    }

} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);