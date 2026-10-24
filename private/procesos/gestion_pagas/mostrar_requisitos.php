<?php
// requisito_manager.php
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
        SELECT 
            gr.id,
            gr.user AS user,
            gr.requirement_name,
            gr.times_as_encargado_count,
            gr.ascensos_as_encargado_count,
            gr.is_completed,
            gr.last_updated
        FROM gestion_requisitos gr
        INNER JOIN (
            SELECT user, MAX(last_updated) AS ultima_fecha
            FROM gestion_requisitos
            WHERE is_completed = FALSE
            GROUP BY user
        ) ultimos
        ON gr.user = ultimos.user AND gr.last_updated = ultimos.ultima_fecha
        WHERE gr.is_completed = FALSE
        ORDER BY gr.last_updated DESC
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>