<?php
require_once(CONFIG_PATH . 'bd.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'No has iniciado sesión']);
    exit;
}

$username = $_SESSION['username'];

try {
    // Crear instancia de la clase Database
    $database = new Database();
    $conn = $database->getConnection();

    // Primero obtenemos el código_time del usuario actual (aunque no se usa directamente en la consulta de encargado, es buena práctica tenerlo)
    $stmt = $conn->prepare("SELECT codigo_time FROM registro_usuario WHERE usuario_registro = :username OR nombre_habbo = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        // Si el usuario actual no se encuentra en registro_usuario, no puede ser encargado de tiempos
        echo json_encode(['success' => false, 'message' => 'Usuario encargado no encontrado en el sistema de registro.']);
        exit;
    }

    // Consulta para obtener los tiempos donde el usuario es el encargado,
    // incluyendo el nombre del usuario afectado (desde registro_usuario)
    // y el rango actual del usuario afectado (desde ascensos)
    // Nota: Esta unión con 'ascensos' puede devolver múltiples filas por tiempo si el usuario afectado tiene varios registros de ascenso.
    // Si se necesita el rango exacto en el momento del registro del tiempo, la consulta sería más compleja.
    // Para simplificar, obtenemos el rango_actual de CUALQUIER entrada de ascenso para ese usuario.
    $stmtEncargado = $conn->prepare("
        SELECT ht.id, ht.codigo_time, ht.tiempo_acumulado, ht.tiempo_transcurrido,
               ht.tiempo_encargado_usuario, ht.tiempo_fecha_registro,
               ru.usuario_registro, ru.nombre_habbo,
               a.rango_actual
        FROM historial_tiempos ht
        LEFT JOIN registro_usuario ru ON ht.codigo_time = ru.codigo_time
        LEFT JOIN ascensos a ON ht.codigo_time = a.codigo_time
        WHERE ht.tiempo_encargado_usuario = :username
        ORDER BY ht.tiempo_fecha_registro DESC
    ");

    // Consulta para el conteo por persona y rango
    $stmtResumen = $conn->prepare("
        SELECT 
            ru.usuario_registro,
            ru.nombre_habbo,
            a.rango_actual,
            COUNT(*) as total_tiempos,
            SEC_TO_TIME(SUM(TIME_TO_SEC(ht.tiempo_acumulado))) as tiempo_total
        FROM historial_tiempos ht
        LEFT JOIN registro_usuario ru ON ht.codigo_time = ru.codigo_time
        LEFT JOIN ascensos a ON ht.codigo_time = a.codigo_time
        WHERE ht.tiempo_encargado_usuario = :username
        GROUP BY ru.usuario_registro, ru.nombre_habbo, a.rango_actual
        ORDER BY rango_actual, total_tiempos DESC
    ");

    // Ejecutar ambas consultas
    $stmtEncargado->bindParam(':username', $username);
    $stmtResumen->bindParam(':username', $username);
    
    $stmtEncargado->execute();
    $stmtResumen->execute();
    
    $tiemposEncargadoData = $stmtEncargado->fetchAll(PDO::FETCH_ASSOC);
    $resumenTiempos = $stmtResumen->fetchAll(PDO::FETCH_ASSOC);

    // Organizar el resumen por rangos
    $tiemposPorRango = [];
    foreach ($resumenTiempos as $tiempo) {
        $rango = $tiempo['rango_actual'] ?? 'Sin Rango';
        if (!isset($tiemposPorRango[$rango])) {
            $tiemposPorRango[$rango] = [
                'rango_actual' => $rango,
                'count' => 0,
                'personas' => []
            ];
        }
        $tiemposPorRango[$rango]['count'] += $tiempo['total_tiempos'];
        $tiemposPorRango[$rango]['personas'][] = [
            'nombre' => $tiempo['nombre_habbo'] ?? $tiempo['usuario_registro'] ?? 'No disponible',
            'total_tiempos' => $tiempo['total_tiempos'],
            'tiempo_total' => $tiempo['tiempo_total']
        ];
    }

    echo json_encode([
        'success' => true,
        'tiemposEncargado' => $tiemposEncargadoData,
        'tiemposPorRango' => array_values($tiemposPorRango)
    ]);

} catch (PDOException $e) {
    // Log the error for debugging purposes, but provide a generic message to the user
    error_log("Database Error in mis_tiempos.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error al cargar los datos de la base de datos.']);
} catch (Exception $e) {
     error_log("General Error in mis_tiempos.php: " . $e->getMessage());
     echo json_encode(['success' => false, 'message' => 'Ocurrió un error inesperado.']);
}
?>