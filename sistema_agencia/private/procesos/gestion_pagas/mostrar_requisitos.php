<?php

require_once(CONFIG_PATH . 'bd.php');

class RequisitoManager
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db->getConnection();
    }

    public function obtenerRequisitosPendientes()
    {
        $query = "
        SELECT gr.*
        FROM gestion_requisitos gr
        INNER JOIN (
            SELECT user_codigo_time, MAX(last_updated) AS ultima_fecha
            FROM gestion_requisitos
            WHERE is_completed = FALSE
            GROUP BY user_codigo_time
        ) ultimos
        ON gr.user_codigo_time = ultimos.user_codigo_time AND gr.last_updated = ultimos.ultima_fecha
        WHERE gr.is_completed = FALSE
        ORDER BY gr.last_updated DESC
    ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$db = new Database();
$requisitoManager = new RequisitoManager($db);
$requisitos = $requisitoManager->obtenerRequisitosPendientes();
