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

    // --- Consulta para obtener la lista de ascensos realizados (para la tabla, si aún se necesita) ---
    // Si solo quieres el dashboard, esta consulta puede ser eliminada para optimizar.
    // La mantendremos por ahora por si decides volver a la tabla.
    $stmtLista = $conn->prepare("
        SELECT ha.id, ha.codigo_time, ha.rango_actual, ha.mision_actual,
               ha.firma_encargado, ha.usuario_encargado, ha.accion, ha.realizado_por, ha.fecha_accion,
               ru.usuario_registro, ru.nombre_habbo
        FROM historial_ascensos ha
        LEFT JOIN registro_usuario ru ON ha.codigo_time = ru.codigo_time
        WHERE ha.usuario_encargado = :username OR ha.realizado_por = :username
        ORDER BY ha.fecha_accion DESC
    ");
    $stmtLista->bindParam(':username', $username);
    $stmtLista->execute();
    $historialAscensos = $stmtLista->fetchAll(PDO::FETCH_ASSOC);

    // --- Consulta para el conteo total de ascensos realizados ---
    $stmtTotal = $conn->prepare("
        SELECT COUNT(*) AS total_ascensos
        FROM historial_ascensos
        WHERE usuario_encargado = :username OR realizado_por = :username
    ");
    $stmtTotal->bindParam(':username', $username);
    $stmtTotal->execute();
    $totalAscensos = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total_ascensos'] ?? 0;

    // --- Consulta para el conteo de ascensos por rango ---
    $stmtPorRango = $conn->prepare("
        SELECT rango_actual, COUNT(*) AS count
        FROM historial_ascensos
        WHERE usuario_encargado = :username OR realizado_por = :username
        GROUP BY rango_actual
        ORDER BY count DESC
    ");
    $stmtPorRango->bindParam(':username', $username);
    $stmtPorRango->execute();
    $ascensosPorRango = $stmtPorRango->fetchAll(PDO::FETCH_ASSOC);

    // --- Consulta para el conteo de ascensos por semana ---
    // Nota: La función WEEK() puede variar ligeramente entre sistemas de base de datos (MySQL, PostgreSQL, etc.)
    // Esta sintaxis es común en MySQL. Ajusta si usas otro DB.
    $stmtPorSemana = $conn->prepare("
        SELECT YEAR(fecha_accion) AS year, WEEK(fecha_accion, 1) AS week, COUNT(*) AS count
        FROM historial_ascensos
        WHERE (usuario_encargado = :username OR realizado_por = :username) AND fecha_accion IS NOT NULL
        GROUP BY YEAR(fecha_accion), WEEK(fecha_accion, 1)
        ORDER BY year DESC, week DESC
        LIMIT 10 -- Limitar a las últimas 10 semanas, por ejemplo
    ");
     $stmtPorSemana->bindParam(':username', $username);
     $stmtPorSemana->execute();
     $ascensosPorSemana = $stmtPorSemana->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode([
        'success' => true,
        'historialAscensos' => $historialAscensos, // Lista completa (opcional)
        'totalAscensos' => (int)$totalAscensos,
        'ascensosPorRango' => $ascensosPorRango,
        'ascensosPorSemana' => $ascensosPorSemana
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
     echo json_encode(['success' => false, 'message' => 'Error general: ' . $e->getMessage()]);
}
?>