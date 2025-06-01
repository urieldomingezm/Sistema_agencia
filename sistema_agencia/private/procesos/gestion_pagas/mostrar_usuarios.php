<?php

require_once(CONFIG_PATH . 'bd.php');

class GestionPagas
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db->getConnection();
    }

    public function obtenerPagas()
    {
        $query = "SELECT pagas_usuario, pagas_recibio, pagas_motivo, pagas_completo, pagas_rango, pagas_descripcion, pagas_fecha_registro FROM gestion_pagas ORDER BY pagas_fecha_registro DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$db = new Database();
$gestionPagas = new GestionPagas($db);
$pagas = $gestionPagas->obtenerPagas();

?>