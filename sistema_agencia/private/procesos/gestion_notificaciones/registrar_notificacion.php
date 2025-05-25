<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

class NotificacionRegistro {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function registrarNotificacion($mensaje, $usuario_id, $id_encargado) {
        try {
            $query = "INSERT INTO gestion_notificaciones (notificacion_mensaje, notificacion_registro, usuario_id, id_encargado) 
                      VALUES (:mensaje, NOW(), :usuario_id, :id_encargado)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':id_encargado', $id_encargado, PDO::PARAM_INT);
            
            if($stmt->execute()) {
                return ['success' => true, 'message' => 'Notificación registrada exitosamente'];
            } else {
                return ['success' => false, 'message' => 'Error al registrar la notificación'];
            }
        } catch(PDOException $e) {
            error_log('Error en registrarNotificacion: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error en la base de datos'];
        }
    }
}

// Procesar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $notificacionRegistro = new NotificacionRegistro();
    
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
    $destinatario = isset($_POST['destinatario']) ? (int)$_POST['destinatario'] : 0;
    $id_encargado = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
    
    if (empty($mensaje) || $destinatario === 0 || $id_encargado === 0) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
        exit;
    }
    
    $resultado = $notificacionRegistro->registrarNotificacion($mensaje, $destinatario, $id_encargado);
    echo json_encode($resultado);
    exit;
}
?>