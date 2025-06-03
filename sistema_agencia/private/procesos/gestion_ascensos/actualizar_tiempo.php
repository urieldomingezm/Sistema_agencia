<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

class AscensoTimeManager {
    private $conn;
    private $tiempoAscensoSegundosPorRango;

    public function __construct($db) {
        $this->conn = $db->getConnection();
        require_once(__DIR__ . '/rangos_data.php');
        $this->tiempoAscensoSegundosPorRango = $tiempoAscensoSegundosPorRango;
    }

    public function verificarTiempoAscenso($id_ascenso, $auto_update = false) {
        try {
            // Obtener tiempo requerido y transcurrido
            $query = "SELECT 
                tiempo_requerido,
                tiempo_transcurrido,
                estado_ascenso
            FROM ascensos 
            WHERE id = :id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id_ascenso);
            $stmt->execute();
            
            $ascenso = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$ascenso) {
                throw new Exception("Ascenso no encontrado");
            }

            // Convertir tiempos a segundos para comparación
            $tiempo_req = $this->timeToSeconds($ascenso['tiempo_requerido']);
            $tiempo_trans = $this->timeToSeconds($ascenso['tiempo_transcurrido']);
            
            if ($tiempo_trans >= $tiempo_req) {
                // Actualizar estado si se cumplió el tiempo
                $update = "UPDATE ascensos SET 
                    estado_ascenso = 'disponible',
                    fecha_disponible_ascenso = '00:00:00'
                    WHERE id = :id";
                    
                $stmt = $this->conn->prepare($update);
                $stmt->bindParam(':id', $id_ascenso);
                $stmt->execute();
                
                return [
                    'success' => true,
                    'message' => 'Tiempo completado - Disponible para ascenso',
                    'tiempo_disponible' => true
                ];
            } else {
                // Calcular tiempo restante
                $segundos_restantes = $tiempo_req - $tiempo_trans;
                $tiempo_restante = $this->secondsToTime($segundos_restantes);
                
                return [
                    'success' => true,
                    'message' => "Tiempo restante: $tiempo_restante",
                    'tiempo_disponible' => false
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function timeToSeconds($time) {
        $parts = explode(':', $time);
        return ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];
    }

    private function secondsToTime($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_ascenso = $data['id'] ?? null;
    $auto_update = $data['auto_update'] ?? false;

    if ($id_ascenso) {
        $database = new Database();
        $timeManager = new AscensoTimeManager($database);
        $result = $timeManager->verificarTiempoAscenso($id_ascenso, $auto_update);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['success' => false, 'message' => 'ID de ascenso no proporcionado']);
    }
}