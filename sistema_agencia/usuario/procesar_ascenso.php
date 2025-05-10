<?php
// Incluir archivos necesarios
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

// Asegurarse de que solo se procesen solicitudes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Verificar si es una solicitud para actualizar tiempo
if (isset($_POST['action']) && $_POST['action'] === 'actualizar_tiempo_ascenso') {
    try {
        $database = new Database();
        $conn = $database->getConnection();
        
        $codigoTime = $_POST['codigo_time'];
        $tiempoAscenso = $_POST['tiempo_ascenso'];
        $estadoAscenso = $_POST['estado_ascenso'];
        $tiempoTranscurrido = isset($_POST['tiempo_transcurrido']) ? $_POST['tiempo_transcurrido'] : '00:00:00';
        
        // Validar formato de tiempo
        if (!preg_match('/^\d{2}:\d{2}:\d{2}$/', $tiempoAscenso)) {
            $tiempoAscenso = '00:00:00';
        }

        // Obtener la fecha actual en la zona horaria de México
        $fechaActual = new DateTime('now', new DateTimeZone('America/Mexico_City'));
        $fechaDisponible = '0000-00-00 00:00:00'; // Valor por defecto

        // Consultar datos actuales del ascenso
        $queryActual = "SELECT fecha_disponible_ascenso, fecha_ultimo_ascenso FROM ascensos WHERE codigo_time = :codigo_time";
        $stmtActual = $conn->prepare($queryActual);
        $stmtActual->bindParam(':codigo_time', $codigoTime);
        $stmtActual->execute();
        $ascensoActual = $stmtActual->fetch(PDO::FETCH_ASSOC);

        if ($ascensoActual) {
            if ($ascensoActual['fecha_disponible_ascenso'] != '0000-00-00 00:00:00') {
                $fechaDisponibleBD = new DateTime($ascensoActual['fecha_disponible_ascenso']);
                
                // Obtener el tiempo anterior almacenado
                $tiempoAnterior = '00:00:00';
                $queryTiempoAnterior = "SELECT tiempo_ascenso FROM ascensos WHERE codigo_time = :codigo_time";
                $stmtTiempoAnterior = $conn->prepare($queryTiempoAnterior);
                $stmtTiempoAnterior->bindParam(':codigo_time', $codigoTime);
                $stmtTiempoAnterior->execute();
                $resultadoTiempo = $stmtTiempoAnterior->fetch(PDO::FETCH_ASSOC);
                
                if ($resultadoTiempo && !empty($resultadoTiempo['tiempo_ascenso'])) {
                    $tiempoAnterior = $resultadoTiempo['tiempo_ascenso'];
                }
                
                // Calcular la diferencia entre el tiempo actual y el anterior
                list($h_anterior, $m_anterior, $s_anterior) = explode(':', $tiempoAnterior);
                list($h_actual, $m_actual, $s_actual) = explode(':', $tiempoAscenso);
                
                $segundos_anterior = ($h_anterior * 3600) + ($m_anterior * 60) + $s_anterior;
                $segundos_actual = ($h_actual * 3600) + ($m_actual * 60) + $s_actual;
                
                // Solo restar la diferencia (tiempo adicional)
                $segundos_diferencia = $segundos_actual - $segundos_anterior;
                
                // Si hay tiempo adicional, restar de la fecha disponible
                if ($segundos_diferencia > 0) {
                    // Convertir la diferencia a formato H:M:S
                    $h_diff = floor($segundos_diferencia / 3600);
                    $m_diff = floor(($segundos_diferencia % 3600) / 60);
                    $s_diff = $segundos_diferencia % 60;
                    
                    // Si la fecha disponible es futura
                    if ($fechaDisponibleBD > $fechaActual) {
                        // Crear una copia de la fecha disponible original
                        $nuevaFechaDisponible = clone $fechaDisponibleBD;
                        
                        // Restar SOLO el tiempo adicional transcurrido
                        $nuevaFechaDisponible->sub(new DateInterval("PT{$h_diff}H{$m_diff}M{$s_diff}S"));
                        
                        // Verificar si la nueva fecha es menor o igual a la fecha actual
                        if ($nuevaFechaDisponible <= $fechaActual) {
                            // Si ya se cumplió el tiempo, marcar como disponible
                            $fechaDisponible = '0000-00-00 00:00:00';
                            $estadoAscenso = 'disponible';
                        } else {
                            // Si aún falta tiempo, actualizar la fecha disponible
                            $fechaDisponible = $nuevaFechaDisponible->format('Y-m-d H:i:s');
                            $estadoAscenso = 'pendiente';
                        }
                    } else {
                        // Si la fecha disponible ya pasó, el ascenso está disponible
                        $fechaDisponible = '0000-00-00 00:00:00';
                        $estadoAscenso = 'disponible';
                    }
                } else {
                    // Si no hay tiempo adicional, mantener la fecha disponible actual
                    $fechaDisponible = $fechaDisponibleBD->format('Y-m-d H:i:s');
                }
            } else {
                // Si no hay fecha disponible, verificar si el tiempo acumulado es suficiente
                list($h, $m, $s) = explode(':', $tiempoAscenso);
                $minutosTranscurridos = (int)$h * 60 + (int)$m;
                
                if ($minutosTranscurridos >= 30) {
                    $fechaDisponible = '0000-00-00 00:00:00';
                    $estadoAscenso = 'disponible';
                } else {
                    // Calcular cuántos minutos faltan para llegar a 30
                    $minutosRestantes = 30 - $minutosTranscurridos;
                    $nuevaFechaDisponible = clone $fechaActual;
                    $nuevaFechaDisponible->add(new DateInterval('PT' . ($minutosRestantes * 60) . 'S'));
                    $fechaDisponible = $nuevaFechaDisponible->format('Y-m-d H:i:s');
                    $estadoAscenso = 'pendiente';
                }
            }
        }

        // Registrar el tiempo transcurrido en un log para referencia
        error_log("Actualizando ascenso para $codigoTime - Tiempo: $tiempoAscenso - Estado: $estadoAscenso - Nueva fecha: $fechaDisponible");
        
        $query = "UPDATE ascensos SET 
                  tiempo_ascenso = :tiempo_ascenso, 
                  estado_ascenso = :estado_ascenso,
                  fecha_disponible_ascenso = :fecha_disponible
                  WHERE codigo_time = :codigo_time";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':tiempo_ascenso', $tiempoAscenso);
        $stmt->bindParam(':estado_ascenso', $estadoAscenso);
        $stmt->bindParam(':fecha_disponible', $fechaDisponible);
        $stmt->bindParam(':codigo_time', $codigoTime);
        $stmt->execute();
        
        echo json_encode([
            'success' => true, 
            'message' => 'Actualización exitosa',
            'fecha_actualizada' => true,
            'nueva_fecha' => $fechaDisponible,
            'nuevo_estado' => $estadoAscenso,
            'tiempo_transcurrido' => $tiempoAscenso
        ]);
        
    } catch(PDOException $e) {
        error_log("Error al actualizar tiempo de ascenso: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Acción no reconocida']);
}
?>