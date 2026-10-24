<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(CONFIG_PATH . 'bd.php');

$requisitosData = [];
$pagasData = [];
$nombreHabbo = $_SESSION['nombre_habbo'] ?? null;

if ($nombreHabbo) {
    try {
        $database = new Database();
        $conn = $database->getConnection();

        if ($conn) {
            $sqlRequisitos = "SELECT
                                id,
                                user,
                                requirement_name,
                                times_as_encargado_count,
                                ascensos_as_encargado_count,
                                is_completed,
                                last_updated
                            FROM
                                gestion_requisitos
                            WHERE
                                user = :nombre_habbo";

            $stmtRequisitos = $conn->prepare($sqlRequisitos);
            $stmtRequisitos->bindParam(':nombre_habbo', $nombreHabbo, PDO::PARAM_STR);
            $stmtRequisitos->execute();
            $requisitosData = $stmtRequisitos->fetchAll(PDO::FETCH_ASSOC);

            $sqlPagas = "SELECT
                            pagas_id,
                            pagas_usuario,
                            pagas_rango,
                            pagas_recibio,
                            pagas_motivo,
                            pagas_completo,
                            pagas_descripcion,
                            pagas_fecha_registro
                        FROM
                            gestion_pagas
                        WHERE
                            pagas_usuario = :nombre_habbo";

            $stmtPagas = $conn->prepare($sqlPagas);
            $stmtPagas->bindParam(':nombre_habbo', $nombreHabbo, PDO::PARAM_STR);
            $stmtPagas->execute();
            $pagasData = $stmtPagas->fetchAll(PDO::FETCH_ASSOC);

        } else {
            error_log("Error al obtener la conexión a la base de datos en ver_requisitos.php");
        }

    } catch (PDOException $e) {
        error_log("Error de PDO al obtener datos de requisitos/pagos: " . $e->getMessage());
    } catch (Exception $e) {
        error_log("Error general al obtener datos de requisitos/pagos: " . $e->getMessage());
    } finally {
        $conn = null;
    }
} else {
    error_log("No se encontró el nombre_habbo en la sesión en ver_requisitos.php");
}
?>