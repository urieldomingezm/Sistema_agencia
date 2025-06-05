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

            // Obtener usuarios a los que se les tomó tiempo esta semana
            $query = "SELECT DISTINCT
                        ru_tomado.nombre_habbo as usuario_nombre,
                        a.rango_actual as rango_usuario
                     FROM historial_tiempos ht
                     INNER JOIN registro_usuario ru_tomado ON ru_tomado.codigo_time = ht.codigo_time
                     LEFT JOIN ascensos a ON a.codigo_time = ru_tomado.codigo_time 
                        AND a.es_recluta = 0
                     WHERE ht.tiempo_encargado_usuario = :nombre_habbo
                     AND YEARWEEK(ht.tiempo_fecha_registro) = YEARWEEK(NOW())";
        
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre_habbo', $usuario['nombre_habbo']);
            $stmt->execute();
            $tiempos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener usuarios ascendidos esta semana
            $query = "SELECT DISTINCT
                        ru_ascendido.nombre_habbo as usuario_nombre,
                        ha.rango_actual as rango_usuario
                     FROM historial_ascensos ha
                     INNER JOIN registro_usuario ru_ascendido ON ru_ascendido.codigo_time = ha.codigo_time
                     WHERE ha.usuario_encargado = :nombre_habbo
                        AND ha.accion = 'ascendido'
                        AND YEARWEEK(ha.fecha_accion) = YEARWEEK(NOW())
                     GROUP BY ru_ascendido.nombre_habbo, ha.rango_actual";
        
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre_habbo', $usuario['nombre_habbo']);
            $stmt->execute();
            $ascensos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Log para depuración
            error_log("Usuario encontrado: " . print_r($usuario, true));
            error_log("Tiempos encontrados: " . count($tiempos));
            error_log("Ascensos encontrados: " . count($ascensos));

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
