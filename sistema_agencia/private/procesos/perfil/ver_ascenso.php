<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(CONFIG_PATH . 'bd.php');

$ascensoData = null;
$userCodigoTime = $_SESSION['codigo_time'] ?? null;

if ($userCodigoTime) {
    try {
        $database = new Database();
        $conn = $database->getConnection();

        if ($conn) {
            $sql = "SELECT
                        a.rango_actual,
                        a.mision_actual,
                        a.firma_usuario,
                        a.estado_ascenso,
                        a.fecha_disponible_ascenso
                    FROM
                        ascensos a
                    JOIN
                        registro_usuario ru ON a.codigo_time = ru.codigo_time
                    WHERE
                        a.codigo_time = :codigo_time";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codigo_time', $userCodigoTime, PDO::PARAM_STR);
            $stmt->execute();
            $ascensoData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$ascensoData) {
                 echo "<!-- No se encontraron datos de ascenso para el usuario logueado -->";
            }

        } else {
            echo "<!-- Error al obtener la conexión a la base de datos -->";
        }

    } catch (PDOException $e) {
        error_log("Error de PDO al obtener datos de ascenso: " . $e->getMessage());
    } catch (Exception $e) {
        error_log("Error general al obtener datos de ascenso: " . $e->getMessage());
    } finally {
        $conn = null;
    }
} else {
    echo "<!-- No se encontró el codigo_time en la sesión. Usuario no logueado o sesión incompleta. -->";
}
?>