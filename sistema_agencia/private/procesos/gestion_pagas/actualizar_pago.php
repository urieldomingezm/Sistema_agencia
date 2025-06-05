<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $motivo = $_POST['motivo'] ?? null;

    if (!$id || !$motivo) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit;
    }

    try {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "UPDATE gestion_pagas 
                 SET pagas_motivo = :motivo
                 WHERE pagas_id = :id";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el pago']);
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Método no permitido']);