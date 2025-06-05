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

    public function obtenerDetallesUsuario($id)
    {
        try {
            // Obtener información del usuario
            $query = "SELECT ru.nombre_habbo, ru.codigo_time,
                            COUNT(DISTINCT gt.tiempo_id) as total_tiempos,
                            COUNT(DISTINCT a.ascenso_id) as total_ascensos
                     FROM registro_usuario ru
                     LEFT JOIN gestion_tiempo gt ON ru.codigo_time = gt.codigo_time
                     LEFT JOIN ascensos a ON ru.codigo_time = a.codigo_time
                     WHERE ru.id = :id
                     GROUP BY ru.id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                return ['success' => false, 'message' => 'Usuario no encontrado'];
            }

            // Obtener detalles de tiempos
            $query = "SELECT gt.*, ru.nombre_habbo as encargado_nombre 
                     FROM gestion_tiempo gt
                     LEFT JOIN registro_usuario ru ON gt.tiempo_encargado_usuario = ru.codigo_time
                     WHERE gt.codigo_time = :codigo_time
                     ORDER BY gt.tiempo_fecha_registro DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo_time', $usuario['codigo_time']);
            $stmt->execute();
            $tiempos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener detalles de ascensos
            $query = "SELECT a.*, ru.nombre_habbo as encargado_nombre 
                     FROM ascensos a
                     LEFT JOIN registro_usuario ru ON a.usuario_encargado = ru.codigo_time
                     WHERE a.codigo_time = :codigo_time
                     ORDER BY a.fecha_ultimo_ascenso DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo_time', $usuario['codigo_time']);
            $stmt->execute();
            $ascensos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'data' => [
                    'usuario' => $usuario,
                    'tiempos' => $tiempos,
                    'ascensos' => $ascensos
                ]
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function cerrarConexion()
    {
        $this->conn = null;
    }
}
