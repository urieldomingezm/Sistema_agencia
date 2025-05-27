<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

header('Content-Type: application/json');

if (!isset($_POST['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de usuario no proporcionado.']);
    exit;
}

$usuario_id = intval($_POST['usuario_id']);

try {
    $db = new Database();
    $conn = $db->getConnection();
    if (!$conn) {
        throw new Exception('No se pudo conectar a la base de datos.');
    }
    $stmt = $conn->prepare('UPDATE registro_usuario SET ip_bloqueo = NULL WHERE id = ?');
    $stmt->execute([$usuario_id]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontró el usuario o ya estaba desbloqueado.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}