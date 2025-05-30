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
        $response = ['success' => false, 'message' => '', 'tiempo_disponible' => false];

        try {
            $id_column = is_numeric($id_ascenso) ? 'ascenso_id' : 'codigo_time';

            // Modificar la consulta para obtener también el rango_actual
            $query = "SELECT fecha_ultimo_ascenso, fecha_disponible_ascenso, rango_actual 
                     FROM ascensos 
                     WHERE " . $id_column . " = :id_ascenso";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_ascenso', $id_ascenso);
            $stmt->execute();

            $ascenso_data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($ascenso_data) {
                date_default_timezone_set('America/Mexico_City');
                $hora_actual = new DateTime();
                $fecha_disponible = new DateTime($ascenso_data['fecha_disponible_ascenso']);
                $rango_actual = strtolower($ascenso_data['rango_actual']);

                // Obtener el tiempo requerido para el rango actual
                $tiempo_requerido = $this->tiempoAscensoSegundosPorRango[$rango_actual] ?? '00:00:00';
                list($horas, $minutos, $segundos) = explode(':', $tiempo_requerido);
                $segundos_requeridos = ($horas * 3600) + ($minutos * 60) + $segundos;

                // Calcular el tiempo transcurrido desde el último ascenso
                $fecha_ultimo = new DateTime($ascenso_data['fecha_ultimo_ascenso']);
                $tiempo_transcurrido = $hora_actual->getTimestamp() - $fecha_ultimo->getTimestamp();
                $dias_trans = floor($tiempo_transcurrido / 86400);
                $horas_trans = floor(($tiempo_transcurrido % 86400) / 3600);
                $minutos_trans = floor(($tiempo_transcurrido % 3600) / 60);
                $segundos_trans = $tiempo_transcurrido % 60;

                if ($tiempo_transcurrido >= $segundos_requeridos) {
                    $update_query = "UPDATE ascensos SET 
                        estado_ascenso = 'disponible',
                        fecha_disponible_ascenso = '00:00:00'
                        WHERE " . $id_column . " = :id_ascenso";
                    
                    $update_stmt = $this->conn->prepare($update_query);
                    $update_stmt->bindParam(':id_ascenso', $id_ascenso);
                    $update_stmt->execute();

                    $response['success'] = true;
                    $response['message'] = $auto_update ? 
                        'Actualización automática: Tiempo cumplido' : 
                        'El tiempo requerido ha sido cumplido y el estado ha sido actualizado';
                    $response['tiempo_disponible'] = true;
                } else {
                    // Calcular tiempo restante
                    $segundos_restantes = $segundos_requeridos - $tiempo_transcurrido;
                    $tiempo_restante = sprintf(
                        '%02d:%02d:%02d',
                        floor($segundos_restantes / 3600),
                        floor(($segundos_restantes % 3600) / 60),
                        $segundos_restantes % 60
                    );
                    
                    // Actualizar fecha_disponible_ascenso con el tiempo restante
                    // Solo actualizar en verificación manual o cada 3 minutos
                    if (!$auto_update || $minutos_trans % 3 === 0) {
                        $update_query = "UPDATE ascensos SET 
                            fecha_disponible_ascenso = :tiempo_restante
                            WHERE " . $id_column . " = :id_ascenso";
                        
                        $update_stmt = $this->conn->prepare($update_query);
                        $update_stmt->bindParam(':tiempo_restante', $tiempo_restante);
                        $update_stmt->bindParam(':id_ascenso', $id_ascenso);
                        $update_stmt->execute();
                    }
                    
                    $response['message'] = $auto_update ? 
                        'Actualización automática: ' . $tiempo_restante : 
                        'Tiempo restante: ' . $tiempo_restante;
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