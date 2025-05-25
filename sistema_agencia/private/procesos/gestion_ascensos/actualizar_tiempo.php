<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

class AscensoTimeManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function verificarTiempoAscenso($id_ascenso) {
        $response = ['success' => false, 'message' => '', 'tiempo_disponible' => false];

        try {
            // Determine which column to use based on the ID format
            $id_column = is_numeric($id_ascenso) ? 'ascenso_id' : 'codigo_time';

            $query = "SELECT fecha_ultimo_ascenso, fecha_disponible_ascenso FROM ascensos WHERE " . $id_column . " = :id_ascenso";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_ascenso', $id_ascenso);
            $stmt->execute();

            $ascenso_data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($ascenso_data) {
                date_default_timezone_set('America/Mexico_City');
                $hora_actual = new DateTime();
                $fecha_disponible = new DateTime($ascenso_data['fecha_disponible_ascenso']);

                if ($hora_actual >= $fecha_disponible) {
                    // Actualizar con tiempo en 00:00:00
                    $update_query = "UPDATE ascensos SET 
                        estado_ascenso = 'disponible',
                        fecha_disponible_ascenso = '00:00:00'
                        WHERE " . $id_column . " = :id_ascenso";
                    
                    $update_stmt = $this->conn->prepare($update_query);
                    $update_stmt->bindParam(':id_ascenso', $id_ascenso);
                    $update_stmt->execute();

                    $response['success'] = true;
                    $response['message'] = 'El tiempo requerido ha sido cumplido y el estado ha sido actualizado';
                    $response['tiempo_disponible'] = true;
                } else {
                    $diferencia = $fecha_disponible->diff($hora_actual);
                    $tiempo_restante = sprintf(
                        '%d días, %02d:%02d:%02d',
                        $diferencia->days,
                        $diferencia->h,
                        $diferencia->i,
                        $diferencia->s
                    );
                    $response['message'] = 'Tiempo restante: ' . $tiempo_restante;
                    $response['tiempo_disponible'] = false;
                }
            } else {
                $response['message'] = 'No se encontró el registro de ascenso';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
        }

        return $response;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_ascenso = $data['id'] ?? null;

    if ($id_ascenso) {
        $database = new Database();
        $timeManager = new AscensoTimeManager($database);
        $result = $timeManager->verificarTiempoAscenso($id_ascenso);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['success' => false, 'message' => 'ID de ascenso no proporcionado']);
    }
}