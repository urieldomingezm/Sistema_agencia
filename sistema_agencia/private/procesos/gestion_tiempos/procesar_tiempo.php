<?php
// Incluir archivos necesarios
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inicializar la respuesta
    $response = [
        'success' => false,
        'message' => 'Acción no especificada'
    ];

    // Verificar la acción solicitada
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        // Crear instancia de la base de datos
        $database = new Database();
        $conn = $database->getConnection();

        // Procesar según la acción
        switch ($accion) {
            case 'liberar_encargado':
                // Verificar que se proporcionó el código de tiempo
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    
                    try {
                        // Verificar que el usuario esté en estado de pausa
                        $query_check = "SELECT tiempo_status, tiempo_iniciado FROM gestion_tiempo WHERE codigo_time = :codigo_time";
                        $stmt_check = $conn->prepare($query_check);
                        $stmt_check->bindParam(':codigo_time', $codigo_time);
                        $stmt_check->execute();
                        
                        $tiempo_data = $stmt_check->fetch(PDO::FETCH_ASSOC);
                        
                        if ($tiempo_data && strtolower($tiempo_data['tiempo_status']) === 'pausa') {
                            // Obtener la hora actual en México
                            date_default_timezone_set('America/Mexico_City');
                            $hora_actual = new DateTime();
                            
                            // Obtener la hora de inicio y convertirla a objeto DateTime
                            $tiempo_iniciado = new DateTime($tiempo_data['tiempo_iniciado']);
                            
                            // Calcular la diferencia entre la hora actual y la hora de inicio
                            $diferencia = $hora_actual->diff($tiempo_iniciado);
                            
                            // Formatear la diferencia como HH:MM:SS
                            $tiempo_acumulado = sprintf(
                                '%02d:%02d:%02d',
                                $diferencia->h + ($diferencia->days * 24),
                                $diferencia->i,
                                $diferencia->s
                            );
                            
                            // Obtener el tiempo acumulado actual
                            $query_acumulado = "SELECT tiempo_acumulado FROM gestion_tiempo WHERE codigo_time = :codigo_time";
                            $stmt_acumulado = $conn->prepare($query_acumulado);
                            $stmt_acumulado->bindParam(':codigo_time', $codigo_time);
                            $stmt_acumulado->execute();
                            
                            $tiempo_acumulado_actual = $stmt_acumulado->fetch(PDO::FETCH_ASSOC)['tiempo_acumulado'];
                            
                            // Convertir el tiempo acumulado actual a segundos
                            list($h, $m, $s) = explode(':', $tiempo_acumulado_actual);
                            $tiempo_acumulado_actual_segundos = $h * 3600 + $m * 60 + $s;
                            
                            // Convertir el nuevo tiempo acumulado a segundos
                            list($h, $m, $s) = explode(':', $tiempo_acumulado);
                            $tiempo_nuevo_segundos = $h * 3600 + $m * 60 + $s;
                            
                            // Sumar ambos tiempos en segundos
                            $tiempo_total_segundos = $tiempo_acumulado_actual_segundos + $tiempo_nuevo_segundos;
                            
                            // Convertir de nuevo a formato HH:MM:SS
                            $horas = floor($tiempo_total_segundos / 3600);
                            $minutos = floor(($tiempo_total_segundos % 3600) / 60);
                            $segundos = $tiempo_total_segundos % 60;
                            $tiempo_acumulado_total = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
                            
                            // Actualizar el encargado a NULL, el tiempo iniciado a 00:00:00 y el tiempo acumulado
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
                // Verificar que se proporcionó el código de tiempo
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    
                    try {
                        // Verificar que el usuario tenga un encargado asignado
                        $query_check = "SELECT tiempo_status, tiempo_encargado_usuario FROM gestion_tiempo WHERE codigo_time = :codigo_time";
                        $stmt_check = $conn->prepare($query_check);
                        $stmt_check->bindParam(':codigo_time', $codigo_time);
                        $stmt_check->execute();
                        
                        $tiempo_data = $stmt_check->fetch(PDO::FETCH_ASSOC);
                        
                        if ($tiempo_data && !empty($tiempo_data['tiempo_encargado_usuario'])) {
                            // Actualizar el estado a "pausa"
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
                break;
                
            // Aquí puedes agregar más casos para otras acciones
                
            default:
                $response['message'] = 'Acción no reconocida';
                break;
        }
    }
    
    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>