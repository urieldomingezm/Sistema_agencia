<?php
require_once(CONFIG_PATH . 'bd.php');

class NotificacionManager {
    private $conexion;

    public function __construct() {
        $db = new Database();
        $this->conexion = $db->getConnection();
    }

    public function obtenerNotificaciones() {
        $query = "SELECT n.notificacion_id, n.notificacion_mensaje, n.notificacion_registro, 
                         n.usuario_id, n.id_encargado, r.usuario_registro
                  FROM gestion_notificaciones n
                  LEFT JOIN registro_usuario r ON n.usuario_id = r.id";
        
        try {
            $stmt = $this->conexion->query($query);
            $notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'status' => 'success',
                'data' => $notificaciones
            ];
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error al obtener las notificaciones: ' . $e->getMessage()
            ];
        }
    }
}

$notificacionManager = new NotificacionManager();
$response = $notificacionManager->obtenerNotificaciones();
?>