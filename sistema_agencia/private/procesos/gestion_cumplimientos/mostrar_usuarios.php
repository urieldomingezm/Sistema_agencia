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
            // Obtener usuario y sus contadores desde gestion_requisitos
            $query = "SELECT gr.*, ru.codigo_time, ru.nombre_habbo 
                     FROM gestion_requisitos gr
                     LEFT JOIN registro_usuario ru ON gr.user = ru.nombre_habbo
                     WHERE gr.id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                error_log("No se encontró el usuario con ID: " . $id);
                return ['success' => false, 'message' => 'Usuario no encontrado'];
            }

            // Obtener historial de tiempos
            $query = "SELECT 
                        ht.*,
                        ru_encargado.nombre_habbo as encargado_nombre,
                        ru_usuario.nombre_habbo as usuario_nombre,
                        a.rango_actual
                     FROM historial_tiempos ht
                     LEFT JOIN registro_usuario ru_usuario ON ru_usuario.codigo_time = ht.codigo_time
                     LEFT JOIN registro_usuario ru_encargado ON ru_encargado.codigo_time = ht.tiempo_encargado_usuario
                     LEFT JOIN ascensos a ON a.codigo_time = ru_usuario.codigo_time AND a.es_recluta = 0
                     WHERE ht.tiempo_encargado_usuario = :codigo_time
                     ORDER BY ht.tiempo_fecha_registro DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo_time', $usuario['codigo_time']);
            $stmt->execute();
            $tiempos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener historial de ascensos
            $query = "SELECT 
                        ha.*,
                        ru_ascendido.nombre_habbo as usuario_nombre,
                        ru_encargado.nombre_habbo as encargado_nombre
                     FROM historial_ascensos ha
                     LEFT JOIN registro_usuario ru_ascendido ON ru_ascendido.codigo_time = ha.codigo_time
                     LEFT JOIN registro_usuario ru_encargado ON ru_encargado.codigo_time = ha.usuario_encargado
                     WHERE ha.usuario_encargado = :codigo_time
                     ORDER BY ha.fecha_accion DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':codigo_time', $usuario['codigo_time']);
            $stmt->execute();
            $ascensos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            error_log("Detalles encontrados para usuario: " . $usuario['nombre_habbo']);
            error_log("Tiempos como encargado: " . count($tiempos));
            error_log("Ascensos realizados: " . count($ascensos));

            return [
                'success' => true,
                'data' => [
                    'usuario' => [
                        'nombre_habbo' => $usuario['nombre_habbo'],
                        'tiempos_count' => $usuario['times_as_encargado_count'],
                        'ascensos_count' => $usuario['ascensos_as_encargado_count']
                    ],
                    'tiempos' => array_map(function($tiempo) {
                        return [
                            'usuario_nombre' => $tiempo['usuario_nombre'],
                            'rango' => $tiempo['rango_actual'],
                            'tiempo_acumulado' => $tiempo['tiempo_acumulado'],
                            'fecha' => $tiempo['tiempo_fecha_registro']
                        ];
                    }, $tiempos),
                    'ascensos' => array_map(function($ascenso) {
                        return [
                            'usuario_nombre' => $ascenso['usuario_nombre'],
                            'rango_actual' => $ascenso['rango_actual'],
                            'estado' => $ascenso['estado_ascenso'],
                            'fecha' => $ascenso['fecha_accion']
                        ];
                    }, $ascensos)
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
