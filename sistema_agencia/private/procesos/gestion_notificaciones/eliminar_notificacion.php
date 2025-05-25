<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

class NotificacionEliminador {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function eliminarNotificacion($id) {
        try {
            $query = "DELETE FROM gestion_notificaciones WHERE notificacion_id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Notificación eliminada exitosamente'];
            } else {
                return ['success' => false, 'message' => 'Error al eliminar la notificación'];
            }
        } catch (PDOException $e) {
            error_log('Error en eliminarNotificacion: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error en la base de datos'];
        }
    }
}

// Procesar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    if ($id === 0) {
        echo json_encode(['success' => false, 'message' => 'ID de notificación no válido']);
        exit;
    }
    
    $eliminador = new NotificacionEliminador();
    $resultado = $eliminador->eliminarNotificacion($id);
    echo json_encode($resultado);
    exit;
}