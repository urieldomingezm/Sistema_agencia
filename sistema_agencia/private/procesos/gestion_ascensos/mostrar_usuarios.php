<?php
require_once(CONFIG_PATH . 'bd.php');

class AscensoManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function getAllAscensos()
    {
        // SQL query to select data from the ascensos table and join with registro_usuario
        // Selecting nombre_habbo from registro_usuario table
        $sql = "SELECT
                    a.ascenso_id,
                    a.codigo_time,
                    ru.nombre_habbo, -- Get nombre_habbo from registro_usuario
                    a.rango_actual,
                    a.mision_actual,
                    a.estado_ascenso,
                    a.fecha_ultimo_ascenso,
                    a.fecha_disponible_ascenso,
                    a.usuario_encargado,
                    a.es_recluta
                FROM
                    ascensos a
                JOIN
                    registro_usuario ru ON a.codigo_time = ru.codigo_time -- Join on codigo_time
                WHERE a.rango_actual IN ('Agente', 'Seguridad', 'Técnico', 'Logística', 'Supervisor', 'Director', 'Presidente', 'Operativo')"; // Added WHERE clause back

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Calculate tiempo_ascenso for each row
            foreach ($results as &$row) {
                if (!empty($row['fecha_ultimo_ascenso'])) {
                    $lastAscensoDate = new DateTime($row['fecha_ultimo_ascenso']);
                    $now = new DateTime();
                    $interval = $now->diff($lastAscensoDate);

                    // Calculate total hours, minutes, and seconds
                    $total_seconds = $interval->s + ($interval->i * 60) + ($interval->h * 3600) + ($interval->days * 86400);

                    // Format total seconds into HH:MM:SS
                    $hours = floor($total_seconds / 3600);
                    $minutes = floor(($total_seconds % 3600) / 60);
                    $seconds = $total_seconds % 60;

                    $row['tiempo_ascenso'] = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                } else {
                    $row['tiempo_ascenso'] = 'N/A'; // Or some other default value
                }
            }
            unset($row); // Break the reference with the last element

            return $results;
        } catch(PDOException $exception) {
            error_log("Error fetching ascensos with user data: " . $exception->getMessage());
            return []; // Return empty array on error
        }
    }
}

// Instantiate the Database class and AscensoManager
$database = new Database();
$ascensoManager = new AscensoManager($database);

// Fetch the ascensos data
$ascensos = $ascensoManager->getAllAscensos();

// The $ascensos variable is now available for inclusion in GSAS.php

?>
