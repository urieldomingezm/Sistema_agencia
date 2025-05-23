<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(CONFIG_PATH . 'bd.php');

$tiempoData = null;
$userCodigoTime = $_SESSION['codigo_time'] ?? null;

if ($userCodigoTime) {
    try {
        $database = new Database();
        $conn = $database->getConnection();

        if ($conn) {
            $sqlTiempo = "SELECT
                                tiempo_status,
                                tiempo_restado,
                                tiempo_acumulado
                            FROM
                                gestion_tiempo
                            WHERE
                                codigo_time = :codigo_time
                            LIMIT 1";

            $stmtTiempo = $conn->prepare($sqlTiempo);
            $stmtTiempo->bindParam(':codigo_time', $userCodigoTime, PDO::PARAM_STR);
            $stmtTiempo->execute();
            $tiempoData = $stmtTiempo->fetch(PDO::FETCH_ASSOC);

        } else {
            error_log("Error al obtener la conexión a la base de datos en ver_tiempo.php");
        }

    } catch (PDOException $e) {
        error_log("Error de PDO al obtener datos de tiempo: " . $e->getMessage());
    } catch (Exception $e) {
        error_log("Error general al obtener datos de tiempo: " . $e->getMessage());
    } finally {
        $conn = null;
    }
} else {
    error_log("No se encontró el codigo_time en la sesión en ver_tiempo.php");
}


?>