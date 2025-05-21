<?php
require_once(__DIR__ . '/../../conexion/bd.php'); // Asegúrate de que la ruta sea correcta

function get_notificaciones_usuario($user_id) {
    global $conexion; // Asumiendo que $conexion es tu objeto de conexión global
    $notificaciones = [];
    $query = "SELECT * FROM notificaciones WHERE user_id = ? AND leida = FALSE ORDER BY fecha_creacion DESC";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $notificaciones[] = $row;
    }
    $stmt->close();
    return $notificaciones;
}

function marcar_notificacion_leida($notification_id) {
    global $conexion;
    $query = "UPDATE notificaciones SET leida = TRUE WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();
    $stmt->close();
}

// Puedes agregar más funciones según necesites (ej. crear notificación)
?>