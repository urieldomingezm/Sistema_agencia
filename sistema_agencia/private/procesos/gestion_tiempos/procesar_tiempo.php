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
                                      tiempo_status = 'pausa'
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
                        $query_check = "SELECT tiempo_status, tiempo_encargado_usuario, tiempo_iniciado FROM gestion_tiempo WHERE codigo_time = :codigo_time";
                        $stmt_check = $conn->prepare($query_check);
                        $stmt_check->bindParam(':codigo_time', $codigo_time);
                        $stmt_check->execute();
                        
                        $tiempo_data = $stmt_check->fetch(PDO::FETCH_ASSOC);
                        
                        if ($tiempo_data && !empty($tiempo_data['tiempo_encargado_usuario'])) {
                            // Calcular tiempo acumulado
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
                            
                            // Obtener tiempo acumulado actual
                            $query_acumulado = "SELECT tiempo_acumulado FROM gestion_tiempo WHERE codigo_time = :codigo_time";
                            $stmt_acumulado = $conn->prepare($query_acumulado);
                            $stmt_acumulado->bindParam(':codigo_time', $codigo_time);
                            $stmt_acumulado->execute();
                            
                            $tiempo_acumulado_actual = $stmt_acumulado->fetch(PDO::FETCH_ASSOC)['tiempo_acumulado'];
                            
                            // Calcular nuevo tiempo acumulado
                            list($h_acumulado, $m_acumulado, $s_acumulado) = explode(':', $tiempo_acumulado_actual);
                            $tiempo_acumulado_segundos = $h_acumulado * 3600 + $m_acumulado * 60 + $s_acumulado;
                            
                            list($h_transcurrido, $m_transcurrido, $s_transcurrido) = explode(':', $tiempo_transcurrido);
                            $tiempo_transcurrido_segundos = $h_transcurrido * 3600 + $m_transcurrido * 60 + $s_transcurrido;
                            
                            $tiempo_total_segundos = $tiempo_acumulado_segundos + $tiempo_transcurrido_segundos;
                            $horas_total = floor($tiempo_total_segundos / 3600);
                            $minutos_total = floor(($tiempo_total_segundos % 3600) / 60);
                            $segundos_total = $tiempo_total_segundos % 60;
                            $tiempo_acumulado_total = sprintf('%02d:%02d:%02d', $horas_total, $minutos_total, $segundos_total);
                            
                            // Actualizar registro
                            $query = "UPDATE gestion_tiempo SET 
                                      tiempo_encargado_usuario = NULL, 
                                      tiempo_iniciado = '00:00:00',
                                      tiempo_acumulado = :tiempo_acumulado_total,
                                      tiempo_status = 'pausa'
                                      WHERE codigo_time = :codigo_time";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':tiempo_acumulado_total', $tiempo_acumulado_total);
                            $stmt->bindParam(':codigo_time', $codigo_time);
                            
                            if ($stmt->execute()) {
                                $response['success'] = true;
                                $response['message'] = 'Tiempo pausado y liberado correctamente';
                                $response['tiempo_acumulado'] = $tiempo_acumulado_total;
                            } else {
                                $response['message'] = 'Error al pausar y liberar el tiempo';
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
            case 'completar_tiempo':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    
                    try {
                        // Verificar si el tiempo está activo
                        $query_check = "SELECT tiempo_status, tiempo_iniciado, tiempo_acumulado 
                                      FROM gestion_tiempo 
                                      WHERE codigo_time = :codigo_time";
                        $stmt_check = $conn->prepare($query_check);
                        $stmt_check->bindParam(':codigo_time', $codigo_time);
                        $stmt_check->execute();
                        
                        $tiempo_data = $stmt_check->fetch(PDO::FETCH_ASSOC);
                        
                        if ($tiempo_data && $tiempo_data['tiempo_status'] === 'activo') {
                            // Calcular tiempo total
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
                            
                            // Sumar tiempo acumulado y transcurrido
                            list($h_acumulado, $m_acumulado, $s_acumulado) = explode(':', $tiempo_data['tiempo_acumulado']);
                            $tiempo_acumulado_segundos = $h_acumulado * 3600 + $m_acumulado * 60 + $s_acumulado;
                            
                            list($h_transcurrido, $m_transcurrido, $s_transcurrido) = explode(':', $tiempo_transcurrido);
                            $tiempo_transcurrido_segundos = $h_transcurrido * 3600 + $m_transcurrido * 60 + $s_transcurrido;
                            
                            $tiempo_total_segundos = $tiempo_acumulado_segundos + $tiempo_transcurrido_segundos;
                            $horas_total = floor($tiempo_total_segundos / 3600);
                            $minutos_total = floor(($tiempo_total_segundos % 3600) / 60);
                            $segundos_total = $tiempo_total_segundos % 60;
                            $tiempo_total = sprintf('%02d:%02d:%02d', $horas_total, $minutos_total, $segundos_total);
                            
                            // Actualizar registro
                            $query = "UPDATE gestion_tiempo SET 
                                      tiempo_status = 'completado',
                                      tiempo_acumulado = :tiempo_total,
                                      tiempo_iniciado = '00:00:00',
                                      tiempo_encargado_usuario = NULL
                                      WHERE codigo_time = :codigo_time";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':tiempo_total', $tiempo_total);
                            $stmt->bindParam(':codigo_time', $codigo_time);
                            
                            if ($stmt->execute()) {
                                $response['success'] = true;
                                $response['message'] = 'Tiempo completado correctamente';
                            } else {
                                $response['message'] = 'Error al completar el tiempo';
                            }
                        } else {
                            $response['message'] = 'El tiempo no está activo';
                        }
                    } catch (PDOException $e) {
                        $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
                    }
                } else {
                    $response['message'] = 'Código de tiempo no proporcionado';
                }
                break;
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
            case 'designar_tiempo':
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time']) && isset($_POST['usuario_designado']) && !empty($_POST['usuario_designado'])) {
                    $codigo_time = $_POST['codigo_time'];
                    $usuario_designado = $_POST['usuario_designado'];
                    
                    try {
                        // Primero verificar si el usuario tiene un rango válido
                        $query_verificar_rango = "SELECT r.rol_nombre 
                                                FROM registro_usuario ru
                                                JOIN roles r ON ru.rol_id = r.rol_id
                                                WHERE ru.id = :usuario_designado
                                                AND r.rol_nombre IN ('director', 'presidente', 'operativo', 'junta directiva', 'administrador', 'manager', 'fundador')";
                        $stmt_verificar = $conn->prepare($query_verificar_rango);
                        $stmt_verificar->bindParam(':usuario_designado', $usuario_designado);
                        $stmt_verificar->execute();
                        
                        if ($stmt_verificar->rowCount() > 0) {
                            $query = "UPDATE gestion_tiempo SET 
                                      tiempo_encargado_usuario = :usuario_designado
                                      WHERE codigo_time = :codigo_time";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':usuario_designado', $usuario_designado);
                            $stmt->bindParam(':codigo_time', $codigo_time);
                            
                            if ($stmt->execute()) {
                                $response['success'] = true;
                                $response['message'] = 'Tiempo designado correctamente';
                            } else {
                                $response['message'] = 'Error al designar el tiempo';
                            }
                        } else {
                            $response['message'] = 'El usuario designado no tiene un rango válido';
                        }
                    } catch (PDOException $e) {
                        $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
                    }
                } else {
                    $response['message'] = 'Código de tiempo o usuario designado no proporcionado';
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