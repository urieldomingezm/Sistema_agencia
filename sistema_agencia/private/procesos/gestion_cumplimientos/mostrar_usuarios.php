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
            // Obtener conteos de la semana actual por usuario
            $query = "
                SELECT 
                    ru.nombre_habbo as user,
                    ru.id,
                    COALESCE(tiempos.times_count, 0) as times_as_encargado_count,
                    COALESCE(ascensos.ascensos_count, 0) as ascensos_as_encargado_count,
                    CONCAT(
                        CASE 
                            WHEN tiempos.times_count > 0 THEN CONCAT(tiempos.times_count, ' tiempos tomados')
                            ELSE '0 tiempos'
                        END,
                        ' y ',
                        CASE 
                            WHEN ascensos.ascensos_count > 0 THEN CONCAT(ascensos.ascensos_count, ' ascensos')
                            ELSE '0 ascensos'
                        END,
                        ' esta semana'
                    ) as requirement_name,
                    0 as is_completed
                FROM registro_usuario ru
                LEFT JOIN (
                    SELECT 
                        tiempo_encargado_usuario,
                        COUNT(DISTINCT codigo_time) as times_count
                    FROM historial_tiempos 
                    WHERE YEARWEEK(tiempo_fecha_registro) = YEARWEEK(NOW())
                    GROUP BY tiempo_encargado_usuario
                ) tiempos ON tiempos.tiempo_encargado_usuario = ru.nombre_habbo
                LEFT JOIN (
                    SELECT 
                        usuario_encargado,
                        COUNT(DISTINCT codigo_time) as ascensos_count
                    FROM historial_ascensos 
                    WHERE YEARWEEK(fecha_accion) = YEARWEEK(NOW())
                    AND accion = 'ascendido'
                    GROUP BY usuario_encargado
                ) ascensos ON ascensos.usuario_encargado = ru.nombre_habbo
                WHERE tiempos.times_count > 0 OR ascensos.ascensos_count > 0
                ORDER BY (COALESCE(tiempos.times_count, 0) + COALESCE(ascensos.ascensos_count, 0)) DESC
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response['success'] = true;
            $response['message'] = 'Registros de la semana obtenidos con éxito.';
            $response['data'] = $resultados;

        } catch (PDOException $e) {
            $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
        } catch (Exception $e) {
            $response['message'] = 'Error general: ' . $e->getMessage();
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
