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
               a.rango_actual -- Obtenemos el rango de la tabla ascensos
        FROM historial_tiempos ht
        LEFT JOIN registro_usuario ru ON ht.codigo_time = ru.codigo_time -- Para obtener el nombre del usuario afectado
        LEFT JOIN ascensos a ON ht.codigo_time = a.codigo_time -- Para obtener el rango del usuario afectado
        WHERE ht.tiempo_encargado_usuario = :username
        ORDER BY ht.tiempo_fecha_registro DESC
    ");
    $stmtEncargado->bindParam(':username', $username);
    $stmtEncargado->execute();
    $tiemposEncargadoData = $stmtEncargado->fetchAll(PDO::FETCH_ASSOC);

    // No necesitamos calcular totales ni tiempos semanales aquí si solo mostramos la lista de encargado

    echo json_encode([
        'success' => true,
        'tiemposEncargado' => $tiemposEncargadoData, // Enviamos el array completo con rango
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