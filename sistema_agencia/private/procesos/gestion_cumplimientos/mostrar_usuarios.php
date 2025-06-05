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
            $query = "
                SELECT 
                    ru.nombre_habbo as user,
                    ru.id,
                    (
                        SELECT COUNT(DISTINCT ht.codigo_time)
                        FROM historial_tiempos ht
                        WHERE ht.tiempo_encargado_usuario = ru.nombre_habbo
                        AND YEARWEEK(ht.tiempo_fecha_registro) = YEARWEEK(NOW())
                    ) as times_as_encargado_count,
                    (
                        SELECT COUNT(DISTINCT ha.codigo_time)
                        FROM historial_ascensos ha
                        WHERE ha.usuario_encargado = ru.nombre_habbo
                        AND ha.accion = 'ascendido'
                        AND YEARWEEK(ha.fecha_accion) = YEARWEEK(NOW())
                    ) as ascensos_as_encargado_count,
                    CONCAT(
                        'Esta semana: ',
                        (
                            SELECT COUNT(DISTINCT ht.codigo_time)
                            FROM historial_tiempos ht
                            WHERE ht.tiempo_encargado_usuario = ru.nombre_habbo
                            AND YEARWEEK(ht.tiempo_fecha_registro) = YEARWEEK(NOW())
                        ),
                        ' tiempos y ',
                        (
                            SELECT COUNT(DISTINCT ha.codigo_time)
                            FROM historial_ascensos ha
                            WHERE ha.usuario_encargado = ru.nombre_habbo
                            AND ha.accion = 'ascendido'
                            AND YEARWEEK(ha.fecha_accion) = YEARWEEK(NOW())
                        ),
                        ' ascensos'
                    ) as requirement_name,
                    0 as is_completed
                FROM registro_usuario ru
                WHERE EXISTS (
                    SELECT 1 FROM historial_tiempos ht 
                    WHERE ht.tiempo_encargado_usuario = ru.nombre_habbo
                    AND YEARWEEK(ht.tiempo_fecha_registro) = YEARWEEK(NOW())
                )
                OR EXISTS (
                    SELECT 1 FROM historial_ascensos ha 
                    WHERE ha.usuario_encargado = ru.nombre_habbo
                    AND YEARWEEK(ha.fecha_accion) = YEARWEEK(NOW())
                )
                ORDER BY (
                    SELECT COUNT(*) FROM historial_tiempos ht 
                    WHERE ht.tiempo_encargado_usuario = ru.nombre_habbo
                    AND YEARWEEK(ht.tiempo_fecha_registro) = YEARWEEK(NOW())
                ) + (
                    SELECT COUNT(*) FROM historial_ascensos ha 
                    WHERE ha.usuario_encargado = ru.nombre_habbo
                    AND YEARWEEK(ha.fecha_accion) = YEARWEEK(NOW())
                ) DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response['success'] = true;
            $response['data'] = $resultados;

        } catch (Exception $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }

        return $response;
    }

    public function obtenerDetallesUsuario($id)
    {
        try {
            // Obtener usuario directamente de registro_usuario
            $query = "SELECT ru.nombre_habbo, ru.codigo_time
                     FROM registro_usuario ru
                     WHERE ru.nombre_habbo = (
                         SELECT user 
                         FROM gestion_requisitos 
                         WHERE id = :id
                     )";
            
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
                        COALESCE(a.rango_actual, 'Sin rango') as rango_usuario
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
                     AND YEARWEEK(ha.fecha_accion) = YEARWEEK(NOW())";
        
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre_habbo', $usuario['nombre_habbo']);
            $stmt->execute();
            $ascensos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Log para depuración
            error_log("Usuario encontrado: " . print_r($usuario, true));
            error_log("Total tiempos: " . count($tiempos));
            error_log("Total ascensos: " . count($ascensos));

            return [
                'success' => true,
                'data' => [
                    'usuario' => [
                        'nombre_habbo' => $usuario['nombre_habbo'],
                        'tiempos_count' => count($tiempos),
                        'ascensos_count' => count($ascensos)
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
