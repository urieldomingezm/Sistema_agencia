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
            // Obtener usuario desde gestion_requisitos
            $query = "SELECT gr.*, ru.codigo_time, ru.nombre_habbo 
                     FROM gestion_requisitos gr
                     LEFT JOIN registro_usuario ru ON gr.user = ru.nombre_habbo
                     WHERE gr.id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                return ['success' => false, 'message' => 'Usuario no encontrado'];
            }

            // Obtener usuarios a los que se les tomó tiempo
            $query = "SELECT DISTINCT
                        ru.nombre_habbo as usuario_nombre,
                        a.rango_actual as rango_usuario,
                        gt.tiempo_fecha_registro as fecha
                     FROM gestion_tiempo gt
                     INNER JOIN registro_usuario ru ON ru.codigo_time = gt.codigo_time
                     LEFT JOIN ascensos a ON a.codigo_time = ru.codigo_time AND a.es_recluta = 0
                     WHERE gt.tiempo_encargado_usuario = :codigo_time
                     ORDER BY gt.tiempo_fecha_registro DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo_time', $usuario['codigo_time']);
            $stmt->execute();
            $tiempos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener usuarios ascendidos
            $query = "SELECT DISTINCT
                        ru.nombre_habbo as usuario_nombre,
                        a.rango_actual as rango_usuario,
                        a.fecha_ultimo_ascenso as fecha
                     FROM ascensos a
                     INNER JOIN registro_usuario ru ON ru.codigo_time = a.codigo_time
                     WHERE a.usuario_encargado = :codigo_time
                     AND a.estado_ascenso = 'Completado'
                     ORDER BY a.fecha_ultimo_ascenso DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo_time', $usuario['codigo_time']);
            $stmt->execute();
            $ascensos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'data' => [
                    'usuario' => [
                        'nombre_habbo' => $usuario['nombre_habbo'],
                        'tiempos_count' => $usuario['times_as_encargado_count'],
                        'ascensos_count' => $usuario['ascensos_as_encargado_count']
                    ],
                    'tiempos' => $tiempos,
                    'ascensos' => $ascensos
                ]
            ];
        } catch (Exception $e) {
            error_log("Error en obtenerDetallesUsuario: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al obtener detalles: ' . $e->getMessage()];
        }
    }

    private function cerrarConexion()
    {
        $this->conn = null;
    }
}
