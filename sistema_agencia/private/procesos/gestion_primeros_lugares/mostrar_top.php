<?php
require_once(CONFIG_PATH . 'bd.php');

class TopEncargados {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        if (!$this->conn) {
            throw new Exception("No se pudo establecer la conexión con la base de datos");
        }
    }

    public function getTopEncargados($limit = 3) {
        $encargados = [];

        // Consulta para contar encargados en historial_tiempos
        $stmt_tiempos = $this->conn->prepare("SELECT tiempo_encargado_usuario, COUNT(*) as count FROM historial_tiempos WHERE tiempo_encargado_usuario IS NOT NULL AND tiempo_encargado_usuario != '' GROUP BY tiempo_encargado_usuario");
        $stmt_tiempos->execute();
        $tiempos_counts = $stmt_tiempos->fetchAll(PDO::FETCH_KEY_PAIR); // Obtiene un array asociativo [usuario => count]

        // Consulta para contar encargados en historial_ascensos
        $stmt_ascensos = $this->conn->prepare("SELECT usuario_encargado, COUNT(*) as count FROM historial_ascensos WHERE usuario_encargado IS NOT NULL AND usuario_encargado != '' GROUP BY usuario_encargado");
        $stmt_ascensos->execute();
        $ascensos_counts = $stmt_ascensos->fetchAll(PDO::FETCH_KEY_PAIR); // Obtiene un array asociativo [usuario => count]

        // Combinar los conteos
        $all_users = array_unique(array_merge(array_keys($tiempos_counts), array_keys($ascensos_counts)));

        foreach ($all_users as $user) {
            $total_count = ($tiempos_counts[$user] ?? 0) + ($ascensos_counts[$user] ?? 0);
            $encargados[$user] = $total_count;
        }

        // Ordenar por conteo total de forma descendente
        arsort($encargados);

        // Obtener el top N, manejando empates en el último lugar
        $top_encargados = [];
        $current_rank = 0;
        $last_count = -1;
        $users_added = 0;

        foreach ($encargados as $user => $count) {
            if ($count !== $last_count) {
                $current_rank++;
            }

            if ($current_rank > $limit && $count !== $last_count) {
                // Si ya superamos el límite y el conteo es diferente al del último lugar, detenemos
                break;
            }

            $top_encargados[] = ['usuario' => $user, 'total_acciones' => $count];
            $last_count = $count;
            $users_added++;

            // Si ya agregamos al menos N usuarios y el siguiente tiene un conteo menor, detenemos
            if ($users_added >= $limit && isset(next($encargados)[$user]) && next($encargados)[$user] < $count) {
                 break;
            }
        }


        return $top_encargados;
    }

    public function __destruct() {
        $this->conn = null; // Cerrar la conexión
    }
}

// Ejemplo de uso (puedes llamar a esta clase desde otro script)
/*
try {
    $topManager = new TopEncargados();
    $top3 = $topManager->getTopEncargados(3); // Obtener el top 3

    // Ahora $top3 contiene un array con los usuarios y sus conteos totales
    // Ejemplo de cómo podrías mostrarlo:
    echo "<h2>Top 3 Encargados</h2>";
    if (!empty($top3)) {
        echo "<ol>";
        foreach ($top3 as $item) {
            echo "<li>{$item['usuario']}: {$item['total_acciones']} acciones</li>";
        }
        echo "</ol>";
    } else {
        echo "<p>No hay datos de encargados disponibles.</p>";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
*/
?>