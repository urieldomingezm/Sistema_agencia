<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(CONFIG_PATH . 'bd.php');

$personalData = null;
$membresiaData = null;
$userCodigoTime = $_SESSION['codigo_time'] ?? null;

if ($userCodigoTime) {
    try {
        $database = new Database();
        $conn = $database->getConnection();

        if ($conn) {
            $sqlPersonal = "SELECT
                                id,
                                usuario_registro,
                                password_registro,
                                rol_id,
                                fecha_registro,
                                ip_registro,
                                nombre_habbo,
                                codigo_time
                            FROM
                                registro_usuario
                            WHERE
                                codigo_time = :codigo_time";

            $stmtPersonal = $conn->prepare($sqlPersonal);
            $stmtPersonal->bindParam(':codigo_time', $userCodigoTime, PDO::PARAM_STR);
            $stmtPersonal->execute();
            $personalData = $stmtPersonal->fetch(PDO::FETCH_ASSOC);

            if ($personalData && isset($personalData['nombre_habbo'])) {
                $nombreHabbo = $personalData['nombre_habbo'];

                $sqlMembresia = "SELECT
                                    venta_titulo,
                                    venta_estado
                                FROM
                                    gestion_ventas
                                WHERE
                                    venta_comprador = :nombre_habbo
                                LIMIT 1";

                $stmtMembresia = $conn->prepare($sqlMembresia);
                $stmtMembresia->bindParam(':nombre_habbo', $nombreHabbo, PDO::PARAM_STR);
                $stmtMembresia->execute();
                $membresiaData = $stmtMembresia->fetch(PDO::FETCH_ASSOC);

                if (!$membresiaData) {
                     echo "<!-- no tiene membresia -->";
                }

            } else {
                echo "<!-- No se encontraron datos personales para el codigo_time logueado -->";
            }

        } else {
            echo "<!-- Error al obtener la conexión a la base de datos -->";
        }

    } catch (PDOException $e) {
        error_log("Error de PDO al obtener datos de perfil: " . $e->getMessage());
    } catch (Exception $e) {
        error_log("Error general al obtener datos de perfil: " . $e->getMessage());
    } finally {
        $conn = null;
    }
} else {
    echo "<!-- No se encontró el codigo_time en la sesión. Usuario no logueado o sesión incompleta. -->";
}
?>