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
        $query = "SELECT user_codigo_time, is_completed, last_updated, requirement_name 
                  FROM gestion_requisitos 
                  WHERE is_completed = FALSE 
                  ORDER BY last_updated DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$db = new Database();
$requisitoManager = new RequisitoManager($db);
$requisitos = $requisitoManager->obtenerRequisitosPendientes();

?>