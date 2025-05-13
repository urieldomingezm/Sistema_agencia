<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [
        'success' => false,
        'message' => 'Acción no especificada'
    ];

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        $database = new Database();
        $conn = $database->getConnection();

        switch ($accion) {
            case 'liberar_encargado':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    
                    try {
                        $query_check = "SELECT tiempo_status, tiempo_iniciado FROM gestion_tiempo WHERE codigo_time = :codigo_time";
                        $stmt_check = $conn->prepare($query_check);
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
                            $stmt_acumulado = $conn->prepare($query_acumulado);
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
                                      tiempo_status = 'inactivo'
                                      WHERE codigo_time = :codigo_time";
                            $stmt = $conn->prepare($query);
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
                } else {
                    $response['message'] = 'Código de tiempo no proporcionado';
                }
                break;
                
            case 'pausar_tiempo':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    
                    try {
                        $query_check = "SELECT tiempo_status, tiempo_encargado_usuario FROM gestion_tiempo WHERE codigo_time = :codigo_time";
                        $stmt_check = $conn->prepare($query_check);
                        $stmt_check->bindParam(':codigo_time', $codigo_time);
                        $stmt_check->execute();
                        
                        $tiempo_data = $stmt_check->fetch(PDO::FETCH_ASSOC);
                        
                        if ($tiempo_data && !empty($tiempo_data['tiempo_encargado_usuario'])) {
                            $query = "UPDATE gestion_tiempo SET 
                                      tiempo_status = 'pausa'
                                      WHERE codigo_time = :codigo_time";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':codigo_time', $codigo_time);
                            
                            if ($stmt->execute()) {
                                $response['success'] = true;
                                $response['message'] = 'Tiempo pausado correctamente';
                            } else {
                                $response['message'] = 'Error al pausar el tiempo';
                            }
                        } else {
                            $response['message'] = 'El usuario no tiene un encargado asignado';
                        }
                    } catch (PDOException $e) {
                        $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
                    }
                } else {
                    $response['message'] = 'Código de tiempo no proporcionado';
                }
            case 'ver_tiempo':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    
                    try {
                        $query_check = "SELECT tiempo_status, tiempo_iniciado, tiempo_acumulado FROM gestion_tiempo WHERE codigo_time = :codigo_time";
                        $stmt_check = $conn->prepare($query_check);
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
                } else {
                    $response['message'] = 'Código de tiempo no proporcionado';
                }
                break;
                
            case 'completar_tiempo':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    
                    try {
                        // Obtener datos actuales del tiempo
                        $query_check = "SELECT tiempo_status, tiempo_iniciado, tiempo_acumulado 
                                      FROM gestion_tiempo 
                                      WHERE codigo_time = :codigo_time";
                        $stmt_check = $conn->prepare($query_check);
                        $stmt_check->bindParam(':codigo_time', $codigo_time);
                        $stmt_check->execute();
                        
                        $tiempo_data = $stmt_check->fetch(PDO::FETCH_ASSOC);
                        
                        if ($tiempo_data && strtolower($tiempo_data['tiempo_status']) !== 'completado') {
                            date_default_timezone_set('America/Mexico_City');
                            
                            // Calcular tiempo transcurrido si está activo
                            if (strtolower($tiempo_data['tiempo_status']) === 'activo') {
                                $hora_actual = new DateTime();
                                $tiempo_iniciado = new DateTime($tiempo_data['tiempo_iniciado']);
                                $diferencia = $hora_actual->diff($tiempo_iniciado);
                                $tiempo_transcurrido = sprintf(
                                    '%02d:%02d:%02d',
                                    $diferencia->h + ($diferencia->days * 24),
                                    $diferencia->i,
                                    $diferencia->s
                                );
                                
                                // Sumar tiempo transcurrido al acumulado
                                list($h_acumulado, $m_acumulado, $s_acumulado) = explode(':', $tiempo_data['tiempo_acumulado']);
                                $tiempo_acumulado_segundos = $h_acumulado * 3600 + $m_acumulado * 60 + $s_acumulado;
                                
                                list($h_transcurrido, $m_transcurrido, $s_transcurrido) = explode(':', $tiempo_transcurrido);
                                $tiempo_transcurrido_segundos = $h_transcurrido * 3600 + $m_transcurrido * 60 + $s_transcurrido;
                                
                                $tiempo_total_segundos = $tiempo_acumulado_segundos + $tiempo_transcurrido_segundos;
                                $horas_total = floor($tiempo_total_segundos / 3600);
                                $minutos_total = floor(($tiempo_total_segundos % 3600) / 60);
                                $segundos_total = $tiempo_total_segundos % 60;
                                $tiempo_acumulado_total = sprintf('%02d:%02d:%02d', $horas_total, $minutos_total, $segundos_total);
                            } else {
                                $tiempo_acumulado_total = $tiempo_data['tiempo_acumulado'];
                            }
                            
                            // Actualizar el registro
                            $query = "UPDATE gestion_tiempo SET 
                                     tiempo_status = 'completado',
                                     tiempo_acumulado = :tiempo_acumulado_total,
                                     tiempo_iniciado = '00:00:00',
                                     tiempo_encargado_usuario = NULL
                                     WHERE codigo_time = :codigo_time";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':tiempo_acumulado_total', $tiempo_acumulado_total);
                            $stmt->bindParam(':codigo_time', $codigo_time);
                            
                            if ($stmt->execute()) {
                                $response['success'] = true;
                                $response['message'] = 'Tiempo completado correctamente';
                            } else {
                                $response['message'] = 'Error al completar el tiempo';
                            }
                        } else {
                            $response['message'] = 'El tiempo ya está completado';
                        }
                    } catch (PDOException $e) {
                        $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
                    }
                } else {
                    $response['message'] = 'Código de tiempo no proporcionado';
                }
                break;
                
            case 'cerrar_tiempo':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    
                    try {
                        $query_check = "SELECT tiempo_status, tiempo_iniciado FROM gestion_tiempo WHERE codigo_time = :codigo_time";
                        $stmt_check = $conn->prepare($query_check);
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
                            $stmt_acumulado = $conn->prepare($query_acumulado);
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
                                      tiempo_status = 'cerrado'
                                      WHERE codigo_time = :codigo_time";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':tiempo_acumulado_total', $tiempo_acumulado_total);
                            $stmt->bindParam(':codigo_time', $codigo_time);
                            
                            if ($stmt->execute()) {
                                $response['success'] = true;
                                $response['message'] = 'Tiempo cerrado correctamente';
                                $response['tiempo_acumulado'] = $tiempo_acumulado;
                                $response['tiempo_acumulado_total'] = $tiempo_acumulado_total;
                            } else {
                                $response['message'] = 'Error al cerrar el tiempo';
                            }
                        } else {
                            $response['message'] = 'El usuario no está en estado de pausa';
                        }
                    } catch (PDOException $e) {
                        $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
                    }
                } else {
                    $response['message'] = 'Código de tiempo no proporcionado';
                }
                break;
                
            default:
                $response['message'] = 'Acción no reconocida';
                break;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>