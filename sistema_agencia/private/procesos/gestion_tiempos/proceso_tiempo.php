<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    $query = "SELECT *, 
        TIMESTAMPDIFF(SECOND, tiempo_fecha_registro, NOW()) as segundos_transcurridos 
    FROM gestion_tiempo";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $tiempos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tiempo_id']) && isset($_POST['tiempo_transcurrido'])) {
        $tiempo_id = $_POST['tiempo_id'];
        $tiempo_transcurrido = $_POST['tiempo_transcurrido'];

        // Format time for display
        $horas = str_pad(floor($tiempo_transcurrido / 3600), 2, "0", STR_PAD_LEFT);
        $minutos = str_pad(floor(($tiempo_transcurrido % 3600) / 60), 2, "0", STR_PAD_LEFT);
        $segundos = str_pad($tiempo_transcurrido % 60, 2, "0", STR_PAD_LEFT);
        $tiempo_formateado = "$horas:$minutos:$segundos";

        // Get current status and times
        $queryActual = "SELECT tiempo_status, tiempo_acumulado, tiempo_total, tiempo_restado FROM gestion_tiempo WHERE tiempo_id = :tiempo_id";
        $stmt = $conn->prepare($queryActual);
        $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
        $stmt->execute();
        $tiempoActual = $stmt->fetch(PDO::FETCH_ASSOC);

        // Convert times to seconds for calculations
        $tiempo_acumulado_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_acumulado'] . " UTC");
        $tiempo_total_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_total'] . " UTC");
        $tiempo_restado_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_restado'] . " UTC");

        if ($tiempoActual['tiempo_status'] === 'Corriendo') {
            // Add elapsed time to both accumulated and total time
            $tiempo_acumulado_segundos += $tiempo_transcurrido;
            $tiempo_total_segundos += $tiempo_transcurrido;
        } elseif ($tiempoActual['tiempo_status'] === 'Ausente') {
            // Add to restado time
            $tiempo_restado_segundos += $tiempo_transcurrido;
            // Subtract from accumulated time
            $tiempo_acumulado_segundos = max(0, $tiempo_acumulado_segundos - $tiempo_transcurrido);
            // Update total time with the new accumulated time
            $tiempo_total_segundos = $tiempo_acumulado_segundos;
        }

        // Format final times
        $tiempo_acumulado = gmdate("H:i:s", $tiempo_acumulado_segundos);
        $tiempo_total = gmdate("H:i:s", $tiempo_total_segundos);
        $tiempo_restado = gmdate("H:i:s", $tiempo_restado_segundos);

        // Update database
        $updateQuery = "UPDATE gestion_tiempo SET 
            tiempo_transcurrido = :tiempo_formateado,
            tiempo_acumulado = :tiempo_acumulado,
            tiempo_total = :tiempo_total,
            tiempo_restado = :tiempo_restado
            WHERE tiempo_id = :tiempo_id";
    
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':tiempo_formateado', $tiempo_formateado, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_acumulado', $tiempo_acumulado, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_total', $tiempo_total, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_restado', $tiempo_restado, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
        $stmt->execute();
        exit;
    }

    // Handler for updating time status and calculations
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tiempo_id']) && isset($_POST['accion'])) {
        $tiempo_id = $_POST['tiempo_id'];
        $accion = $_POST['accion'];
    
        // Get current times before updating
        $queryActual = "SELECT tiempo_transcurrido, tiempo_acumulado, tiempo_total FROM gestion_tiempo WHERE tiempo_id = :tiempo_id";
        $stmt = $conn->prepare($queryActual);
        $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
        $stmt->execute();
        $tiempoActual = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Convert current times to seconds
        $tiempo_transcurrido_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_transcurrido'] . " UTC");
        $tiempo_acumulado_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_acumulado'] . " UTC");
        $tiempo_total_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_total'] . " UTC");
    
        switch ($accion) {
            case 'iniciar':
                $updateQuery = "UPDATE gestion_tiempo SET 
                    tiempo_status = 'Corriendo',
                    tiempo_fecha_registro = NOW()
                    WHERE tiempo_id = :tiempo_id";
                break;
    
            case 'pausar':
                // Add elapsed time to accumulated and total time
                $tiempo_acumulado = gmdate("H:i:s", $tiempo_acumulado_segundos + $tiempo_transcurrido_segundos);
                $tiempo_total = gmdate("H:i:s", $tiempo_total_segundos + $tiempo_transcurrido_segundos);
                
                $updateQuery = "UPDATE gestion_tiempo SET 
                    tiempo_status = 'Pausado',
                    tiempo_transcurrido = '00:00:00',
                    tiempo_acumulado = :tiempo_acumulado,
                    tiempo_total = :tiempo_total
                    WHERE tiempo_id = :tiempo_id";
                break;
    
            case 'detener':
                // Add elapsed time to accumulated and total time
                $tiempo_acumulado = gmdate("H:i:s", $tiempo_acumulado_segundos + $tiempo_transcurrido_segundos);
                $tiempo_total = gmdate("H:i:s", $tiempo_total_segundos + $tiempo_transcurrido_segundos);
                
                $updateQuery = "UPDATE gestion_tiempo SET 
                    tiempo_status = 'Pausado',
                    tiempo_transcurrido = '00:00:00',
                    tiempo_acumulado = :tiempo_acumulado,
                    tiempo_total = :tiempo_total
                    WHERE tiempo_id = :tiempo_id";
                break;
    
            case 'ausente':
                $updateQuery = "UPDATE gestion_tiempo SET 
                    tiempo_status = 'Ausente',
                    tiempo_fecha_registro = NOW()
                    WHERE tiempo_id = :tiempo_id";
                break;
    
            case 'completar':
                // Check if accumulated time is >= 3 hours (10800 seconds)
                if ($tiempo_acumulado_segundos >= 10800) {
                    $updateQuery = "UPDATE gestion_tiempo SET 
                        tiempo_status = 'Completado',
                        tiempo_transcurrido = '00:00:00'
                        WHERE tiempo_id = :tiempo_id";
                }
                break;
        }
    
        if (isset($updateQuery)) {
            $stmt = $conn->prepare($updateQuery);
            if ($accion === 'pausar' || $accion === 'detener') {
                $stmt->bindParam(':tiempo_acumulado', $tiempo_acumulado, PDO::PARAM_STR);
                $stmt->bindParam(':tiempo_total', $tiempo_total, PDO::PARAM_STR);
            }
            $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
            $stmt->execute();
            exit;
        }
    }

    // Handler for stopping time and calculating totals
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tiempo_id']) && isset($_POST['accion']) && $_POST['accion'] === 'detener') {
        $tiempo_id = $_POST['tiempo_id'];
        $tiempo_transcurrido = $_POST['tiempo_transcurrido'];

        // Get current times and status
        $queryActual = "SELECT tiempo_acumulado, tiempo_total, tiempo_status FROM gestion_tiempo WHERE tiempo_id = :tiempo_id";
        $stmt = $conn->prepare($queryActual);
        $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
        $stmt->execute();
        $tiempoActual = $stmt->fetch(PDO::FETCH_ASSOC);

        // Convert times to seconds for calculations
        $tiempo_acumulado_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_acumulado'] . " UTC");
        $tiempo_total_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_total'] . " UTC");

        if ($tiempoActual['tiempo_status'] === 'Ausente') {
            // If status is Ausente, subtract from both accumulated and total
            $tiempo_acumulado_nuevo = $tiempo_acumulado_segundos - $tiempo_transcurrido;
            $tiempo_total_nuevo = $tiempo_total_segundos - $tiempo_transcurrido;
        } else {
            // Otherwise, add to both accumulated and total
            $tiempo_acumulado_nuevo = $tiempo_acumulado_segundos + $tiempo_transcurrido;
            $tiempo_total_nuevo = $tiempo_total_segundos + $tiempo_transcurrido;
        }

        // Format new times
        $tiempo_acumulado = gmdate("H:i:s", $tiempo_acumulado_nuevo);
        $tiempo_total = gmdate("H:i:s", $tiempo_total_nuevo);

        // Update database with all time values
        $updateQuery = "UPDATE gestion_tiempo SET 
            tiempo_acumulado = :tiempo_acumulado,
            tiempo_total = :tiempo_total,
            tiempo_transcurrido = '00:00:00',
            tiempo_status = 'Pausado',
            tiempo_fecha_registro = NOW()
            WHERE tiempo_id = :tiempo_id";

        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':tiempo_acumulado', $tiempo_acumulado, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_total', $tiempo_total, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
        $stmt->execute();
        exit;
    }
} catch (PDOException $e) {
    error_log("Error al obtener datos: " . $e->getMessage());
    $tiempos = [];
}
?>