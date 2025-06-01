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
        $query = "
        SELECT gp.*
        FROM gestion_pagas gp
        INNER JOIN (
            SELECT pagas_usuario, MAX(pagas_fecha_registro) AS ultima_fecha
            FROM gestion_pagas
            GROUP BY pagas_usuario
        ) ultimas
        ON gp.pagas_usuario = ultimas.pagas_usuario AND gp.pagas_fecha_registro = ultimas.ultima_fecha
        ORDER BY gp.pagas_fecha_registro DESC
    ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$db = new Database();
$gestionPagas = new GestionPagas($db);
$pagas = $gestionPagas->obtenerPagas();
