<?php
require_once(CONFIG_PATH . 'bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $conn = $database->getConnection();
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validación adicional
    if (empty($data['id']) || empty($data['nueva_password'])) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit;
    }

    if ($data['nueva_password'] !== $data['confirmar_password']) {
        echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
        exit;
    }
    
    $hashedPassword = password_hash($data['nueva_password'], PASSWORD_DEFAULT);
    
    $query = "UPDATE registro_usuario SET password_registro = :password WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':id', $data['id']);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la contraseña']);
    }
    exit;
}

