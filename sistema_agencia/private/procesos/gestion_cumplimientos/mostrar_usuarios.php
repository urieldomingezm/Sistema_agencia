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
            // Primero obtener el usuario desde gestion_requisitos
            $query = "SELECT gr.user, ru.nombre_habbo, ru.codigo_time
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

            // Obtener detalles de tiempos
            $query = "SELECT 
                        gt.*,
                        ru_encargado.nombre_habbo as encargado_nombre 
                     FROM gestion_tiempo gt
                     LEFT JOIN registro_usuario ru_usuario ON ru_usuario.codigo_time = gt.codigo_time
                     LEFT JOIN registro_usuario ru_encargado ON ru_encargado.codigo_time = gt.tiempo_encargado_usuario
                     WHERE ru_usuario.nombre_habbo = :nombre_habbo
                     ORDER BY gt.tiempo_fecha_registro DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre_habbo', $usuario['user']);
            $stmt->execute();
            $tiempos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener detalles de ascensos
            $query = "SELECT 
                        a.*,
                        ru_encargado.nombre_habbo as encargado_nombre 
                     FROM ascensos a
                     LEFT JOIN registro_usuario ru_usuario ON ru_usuario.codigo_time = a.codigo_time
                     LEFT JOIN registro_usuario ru_encargado ON ru_encargado.codigo_time = a.usuario_encargado
                     WHERE ru_usuario.nombre_habbo = :nombre_habbo
                     ORDER BY a.fecha_ultimo_ascenso DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre_habbo', $usuario['user']);
            $stmt->execute();
            $ascensos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Agregar logs para debug
            error_log("Usuario encontrado: " . print_r($usuario, true));
            error_log("Tiempos encontrados: " . count($tiempos));
            error_log("Ascensos encontrados: " . count($ascensos));

            return [
                'success' => true,
                'data' => [
                    'usuario' => $usuario,
                    'tiempos' => $tiempos,
                    'ascensos' => $ascensos
                ]
            ];
        } catch (Exception $e) {
            error_log("Error en obtenerDetallesUsuario: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function cerrarConexion()
    {
        $this->conn = null;
    }
}
