<?php
require_once(CONFIG_PATH . 'bd.php');

class RequisitoService
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();

        if (!$this->conn) {
            throw new Exception("No se pudo establecer la conexión con la base de datos.");
        }
    }

    public function obtenerCumplimientos()
    {
        $response = ['success' => false, 'message' => '', 'data' => []];

        try {
            // Obtener el registro con mayor suma de tiempos + ascensos por usuario
            $query = "
                SELECT gr.*
                FROM gestion_requisitos gr
                INNER JOIN (
                    SELECT `user`, MAX(times_as_encargado_count + ascensos_as_encargado_count) AS max_total
                    FROM gestion_requisitos
                    GROUP BY `user`
                ) mejores
                ON gr.user = mejores.user
                AND (gr.times_as_encargado_count + gr.ascensos_as_encargado_count) = mejores.max_total
                ORDER BY gr.user ASC
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $GLOBALS['cumplimientos'] = $resultados;

            $response['success'] = true;
            $response['message'] = 'Registro más completo por usuario obtenido con éxito.';
            $response['data'] = $resultados;

        } catch (PDOException $e) {
            $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
        } catch (Exception $e) {
            $response['message'] = 'Error general: ' . $e->getMessage();
        } finally {
            $this->cerrarConexion();
        }

        return $response;
    }

    private function cerrarConexion()
    {
        $this->conn = null;
    }
}
