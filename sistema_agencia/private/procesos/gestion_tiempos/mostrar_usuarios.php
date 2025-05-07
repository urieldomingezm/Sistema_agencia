<?php
require_once(CONFIG_PATH . 'bd.php');

class TiemposManager {
    private $database;
    private $connection;

    public function __construct() {
        $this->database = new Database();
        $this->connection = $this->database->getConnection();
    }

    public function getTiempos() {
        try {
            $query = "SELECT gt.tiempo_id, gt.codigo_time, gt.tiempo_status, gt.tiempo_restado, 
                                 gt.tiempo_acumulado, gt.tiempo_transcurrido, gt.tiempo_encargado_usuario, 
                                 gt.tiempo_fecha_registro, ru.nombre_habbo 
                          FROM gestion_tiempo gt
                          LEFT JOIN registro_usuario ru ON gt.codigo_time = ru.codigo_time";
            
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            error_log("Error al obtener datos de tiempos: " . $e->getMessage());
            return [];
        }
    }
}

// Initialize and use the class
try {
    $tiemposManager = new TiemposManager();
    $GLOBALS['tiempos'] = $tiemposManager->getTiempos();
} catch(Exception $e) {
    error_log("Error initializing TiemposManager: " . $e->getMessage());
    $GLOBALS['tiempos'] = [];
}
?>
