<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

class TiempoManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function liberarEncargado($codigo_time) {
        $response = ['success' => false, 'message' => ''];

        try {
            $query_check = "SELECT tiempo_status, tiempo_iniciado FROM gestion_tiempo WHERE codigo_time = :codigo_time";
            $stmt_check = $this->conn->prepare($query_check);
            $stmt_check->bindParam(':codigo_time', $codigo_time);
            $stmt_check->execute();

            $tiempo_data = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($tiempo_data && strtolower($tiempo_data['tiempo_status']) === 'pausa') {
                date_default_timezone_set('America/Mexico_City');
                $hora_actual = new DateTime();
                $tiempo_iniciado = new DateTime($tiempo_data['tiempo_iniciado']);
                $diferencia = $hora_actual->diff($tiempo_iniciado);
                $tiempo_acumulado = sprintf(
                    '%02d:%02d:%02d',
                    $diferencia->h + ($diferencia->days * 24),
                    $diferencia->i,
                    $diferencia->s
                );

                $query_acumulado = "SELECT tiempo_acumulado FROM gestion_tiempo WHERE codigo_time = :codigo_time";
                $stmt_acumulado = $this->conn->prepare($query_acumulado);
                $stmt_acumulado->bindParam(':codigo_time', $codigo_time);
                $stmt_acumulado->execute();

                $tiempo_acumulado_actual = $stmt_acumulado->fetch(PDO::FETCH_ASSOC)['tiempo_acumulado'];

                list($h, $m, $s) = explode(':', $tiempo_acumulado_actual);
                $tiempo_acumulado_actual_segundos = $h * 3600 + $m * 60 + $s;

                list($h, $m, $s) = explode(':', $tiempo_acumulado);
                $tiempo_nuevo_segundos = $h * 3600 + $m * 60 + $s;

                $tiempo_total_segundos = $tiempo_acumulado_actual_segundos + $tiempo_nuevo_segundos;

                $horas = floor($tiempo_total_segundos / 3600);
                $minutos = floor(($tiempo_total_segundos % 3600) / 60);
                $segundos = $tiempo_total_segundos % 60;
                $tiempo_acumulado_total = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);

                $query = "UPDATE gestion_tiempo SET
                          tiempo_encargado_usuario = NULL,
                          tiempo_iniciado = '00:00:00',
                          tiempo_acumulado = :tiempo_acumulado_total,
                          tiempo_status = 'pausa'
                          WHERE codigo_time = :codigo_time";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':tiempo_acumulado_total', $tiempo_acumulado_total);
                $stmt->bindParam(':codigo_time', $codigo_time);

                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = 'Encargado liberado correctamente y tiempo actualizado';
                    $response['tiempo_acumulado'] = $tiempo_acumulado;
                    $response['tiempo_acumulado_total'] = $tiempo_acumulado_total;
                } else {
                    $response['message'] = 'Error al liberar al encargado';
                }
            } else {
                $response['message'] = 'El usuario no está en estado de pausa';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
        }
        return $response;
    }

    public function pausarTiempo($codigo_time) {
        $response = ['success' => false, 'message' => ''];

        try {
            $query_check = "SELECT gt.tiempo_status, gt.tiempo_encargado_usuario, gt.tiempo_iniciado, gt.tiempo_acumulado, a.rango_actual
                            FROM gestion_tiempo gt
                            JOIN ascensos a ON gt.codigo_time = a.codigo_time
                            WHERE gt.codigo_time = :codigo_time";
            $stmt_check = $this->conn->prepare($query_check);
            $stmt_check->bindParam(':codigo_time', $codigo_time);
            $stmt_check->execute();

            $tiempo_data = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($tiempo_data && !empty($tiempo_data['tiempo_encargado_usuario'])) {
                date_default_timezone_set('America/Mexico_City');
                $hora_actual = new DateTime();
                $tiempo_iniciado = new DateTime($tiempo_data['tiempo_iniciado']);
                $diferencia = $hora_actual->diff($tiempo_iniciado);
                $tiempo_transcurrido = sprintf(
                    '%02d:%02d:%02d',
                    $diferencia->h + ($diferencia->days * 24),
                    $diferencia->i,
                    $diferencia->s
                );

                $tiempo_acumulado_actual = $tiempo_data['tiempo_acumulado'];

                list($h_acumulado, $m_acumulado, $s_acumulado) = explode(':', $tiempo_acumulado_actual);
                $tiempo_acumulado_segundos = $h_acumulado * 3600 + $m_acumulado * 60 + $s_acumulado;

                list($h_transcurrido, $m_transcurrido, $s_transcurrido) = explode(':', $tiempo_transcurrido);
                $tiempo_transcurrido_segundos = $h_transcurrido * 3600 + $m_transcurrido * 60 + $s_transcurrido;

                $tiempo_total_segundos = $tiempo_acumulado_segundos + $tiempo_transcurrido_segundos;
                $horas_total = floor($tiempo_total_segundos / 3600);
                $minutos_total = floor(($tiempo_total_segundos % 3600) / 60);
                $segundos_total = $tiempo_total_segundos % 60;
                $tiempo_acumulado_total = sprintf('%02d:%02d:%02d', $horas_total, $minutos_total, $segundos_total);

                $rango_actual = $tiempo_data['rango_actual'];
                $tiempo_requerido_segundos = 0;

                $tiempos_requeridos = [
                    'Agente' => 7 * 3600,
                    'Tecnico' => 8 * 3600,
                    'Logistica' => 9 * 3600,
                    'Supervisor' => 4 * 3600,
                    'Director' => 6 * 3600,
                    'Presidente' => 5 * 3600,
                    'Seguridad' => 7 * 3600
                ];

                if (isset($tiempos_requeridos[$rango_actual])) {
                    $tiempo_requerido_segundos = $tiempos_requeridos[$rango_actual];
                } else {
                    $tiempo_requerido_segundos = PHP_INT_MAX;
                }

                $nuevo_status = 'pausa';
                if ($tiempo_total_segundos >= $tiempo_requerido_segundos) {
                    $nuevo_status = 'completado';
                }

                $query = "UPDATE gestion_tiempo SET
                          tiempo_encargado_usuario = NULL,
                          tiempo_iniciado = '00:00:00',
                          tiempo_acumulado = :tiempo_acumulado_total,
                          tiempo_status = :nuevo_status
                          WHERE codigo_time = :codigo_time";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':tiempo_acumulado_total', $tiempo_acumulado_total);
                $stmt->bindParam(':nuevo_status', $nuevo_status);
                $stmt->bindParam(':codigo_time', $codigo_time);

                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = 'Tiempo pausado y liberado correctamente';
                    if ($nuevo_status === 'completado') {
                        $response['message'] = 'Tiempo completado automáticamente para el rango ' . $rango_actual;
                    }
                    $response['tiempo_acumulado'] = $tiempo_acumulado_total;
                    $response['nuevo_status'] = $nuevo_status;
                } else {
                    $response['message'] = 'Error al pausar y liberar el tiempo';
                }
            } else {
                $response['message'] = 'El usuario no tiene un encargado asignado o no se encontró el rango';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
        }
        return $response;
    }

    public function verTiempo($codigo_time) {
        $response = ['success' => false, 'message' => ''];

        try {
            $query_check = "SELECT tiempo_status, tiempo_iniciado, tiempo_acumulado FROM gestion_tiempo WHERE codigo_time = :codigo_time";
            $stmt_check = $this->conn->prepare($query_check);
            $stmt_check->bindParam(':codigo_time', $codigo_time);
            $stmt_check->execute();

            $tiempo_data = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($tiempo_data) {
                date_default_timezone_set('America/Mexico_City');
                $hora_actual = new DateTime();
                $tiempo_iniciado = new DateTime($tiempo_data['tiempo_iniciado']);
                $diferencia = $hora_actual->diff($tiempo_iniciado);
                $tiempo_transcurrido = sprintf(
                    '%02d:%02d:%02d',
                    $diferencia->h + ($diferencia->days * 24),
                    $diferencia->i,
                    $diferencia->s
                );

                list($h_acumulado, $m_acumulado, $s_acumulado) = explode(':', $tiempo_data['tiempo_acumulado']);
                $tiempo_acumulado_segundos = $h_acumulado * 3600 + $m_acumulado * 60 + $s_acumulado;

                list($h_transcurrido, $m_transcurrido, $s_transcurrido) = explode(':', $tiempo_transcurrido);
                $tiempo_transcurrido_segundos = $h_transcurrido * 3600 + $m_transcurrido * 60 + $s_transcurrido;

                $tiempo_total_segundos = $tiempo_acumulado_segundos + $tiempo_transcurrido_segundos;
                $horas_total = floor($tiempo_total_segundos / 3600);
                $minutos_total = floor(($tiempo_total_segundos % 3600) / 60);
                $segundos_total = $tiempo_total_segundos % 60;
                $tiempo_total = sprintf('%02d:%02d:%02d', $horas_total, $minutos_total, $segundos_total);

                $response['tiempo_total'] = $tiempo_total;
                $response['success'] = true;
                $response['tiempo_acumulado'] = $tiempo_data['tiempo_acumulado'];
                $response['tiempo_transcurrido'] = $tiempo_transcurrido;
            } else {
                $response['message'] = 'No se encontró el tiempo';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
        }
        return $response;
    }

    public function designarTiempo($codigo_time, $usuario_designado_id) {
        $response = ['success' => false, 'message' => ''];

        try {
            $query_verificar_rango = "SELECT a.rango_actual, ru.codigo_time AS codigo_time_designado, ru.nombre_habbo
                                    FROM registro_usuario ru
                                    JOIN ascensos a ON ru.codigo_time = a.codigo_time
                                    WHERE ru.id = :usuario_designado_id
                                    AND a.rango_actual IN ('director', 'presidente', 'operativo', 'junta directiva', 'administrador', 'manager', 'fundador')";
            $stmt_verificar = $this->conn->prepare($query_verificar_rango);
            $stmt_verificar->bindParam(':usuario_designado_id', $usuario_designado_id);
            $stmt_verificar->execute();

            $usuario_designado_data = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

            if ($usuario_designado_data) {
                $codigo_time_designado = $usuario_designado_data['codigo_time_designado'];
                $nombre_habbo_designado = $usuario_designado_data['nombre_habbo'];

                date_default_timezone_set('America/Mexico_City');
                $fechaActual = new DateTime('now');
                $tiempoIniciado = $fechaActual->format('Y-m-d H:i:s');

                $query = "UPDATE gestion_tiempo SET
                          tiempo_encargado_usuario = :nombre_habbo_designado,
                          tiempo_status = 'activo'
                          WHERE codigo_time = :codigo_time";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':nombre_habbo_designado', $nombre_habbo_designado);
                $stmt->bindParam(':codigo_time', $codigo_time);

                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = 'Tiempo designado y activado correctamente para ' . $nombre_habbo_designado;
                } else {
                    $response['message'] = 'Error al designar el tiempo';
                }
            } else {
                $response['message'] = 'El usuario designado no tiene un rango válido para ser encargado o no se encontró su información.';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Error en la base de datos durante la designación: ' . $e->getMessage();
        }
        return $response;
    }

    public function completarTiempo($codigo_time) {
        $response = ['success' => false, 'message' => ''];

        try {
            $query = "UPDATE gestion_tiempo SET
                      tiempo_status = 'completado'
                      WHERE codigo_time = :codigo_time";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo_time', $codigo_time);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Tiempo marcado como completado correctamente';
            } else {
                $response['message'] = 'Error al marcar el tiempo como completado';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
        }
        return $response;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [
        'success' => false,
        'message' => 'Acción no especificada'
    ];

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        $database = new Database();
        $conn = $database->getConnection();
        $tiempoManager = new TiempoManager($conn);

        switch ($accion) {
            case 'liberar_encargado':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    $response = $tiempoManager->liberarEncargado($codigo_time);
                } else {
                    $response['message'] = 'Código de tiempo no proporcionado';
                }
                break;

            case 'pausar_tiempo':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    $response = $tiempoManager->pausarTiempo($codigo_time);
                } else {
                    $response['message'] = 'Código de tiempo no proporcionado';
                }
                break;

            case 'ver_tiempo':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    $response = $tiempoManager->verTiempo($codigo_time);
                } else {
                    $response['message'] = 'Código de tiempo no proporcionado';
                }
                break;

            case 'designar_tiempo':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time']) && isset($_POST['usuario_designado']) && !empty($_POST['usuario_designado'])) {
                    $codigo_time = $_POST['codigo_time'];
                    $usuario_designado_id = $_POST['usuario_designado'];
                    $response = $tiempoManager->designarTiempo($codigo_time, $usuario_designado_id);
                } else {
                    $response['message'] = 'Código de tiempo o usuario designado no proporcionado';
                }
                break;

            case 'completar_tiempo':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    $response = $tiempoManager->completarTiempo($codigo_time);
                } else {
                    $response['message'] = 'Código de tiempo no proporcionado';
                }
                break;

            default:
                $response['message'] = 'Acción no válida';
                break;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = [
        'success' => false,
        'message' => 'Método de solicitud no permitido'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>