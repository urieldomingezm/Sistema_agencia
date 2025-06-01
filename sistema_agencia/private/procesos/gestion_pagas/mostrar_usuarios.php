<?php
// gestion_pagas.php
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
        SELECT 
            gp.id,
            gp.pagas_usuario,
            gp.pagas_rango,
            gp.pagas_recibio,
            gp.pagas_motivo,
            gp.pagas_completo,
            gp.pagas_descripcion,
            gp.pagas_fecha_registro,
            NULL AS venta_titulo  
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
?>