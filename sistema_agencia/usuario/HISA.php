<?php

class HistorialAscensos
{
    private $totalAscensos;
    private $ascensosPorRango;
    private $ascensosPorSemana;
    private $errorMessage;

    public function __construct()
    {
        if (!defined('CONFIG_PATH')) {
             define('CONFIG_PATH', __DIR__ . '/../../private/conexion/');
        }
        if (!defined('PRIVATE_PATH')) {
             define('PRIVATE_PATH', __DIR__ . '/../../private/');
        }

        require_once(CONFIG_PATH . 'bd.php');
        ob_start();
        require_once(PRIVATE_PATH . 'procesos/gestion_ascensos/mis_ascensos.php');
        $jsonData = json_decode(ob_get_clean(), true);

        if (isset($jsonData['success']) && $jsonData['success']) {
            $this->totalAscensos = $jsonData['totalAscensos'] ?? 0;
            $this->ascensosPorRango = $jsonData['ascensosPorRango'] ?? [];
            $this->ascensosPorSemana = $jsonData['ascensosPorSemana'] ?? [];
            $this->errorMessage = null;
        } else {
            $this->totalAscensos = 0;
            $this->ascensosPorRango = [];
            $this->ascensosPorSemana = [];
            $this->errorMessage = $jsonData['message'] ?? 'Error desconocido al cargar los datos del dashboard.';
        }
    }

    public function render()
    {
        $html = '<div class="container mt-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dashboard de Ascensos Realizados</h5>
                </div>
                <div class="card-body">';

        if ($this->errorMessage) {
            $html .= '<div class="alert alert-danger mb-0">' . htmlspecialchars($this->errorMessage) . '</div>';
        } else {
            $html .= '<div class="row">';

            // Tarjeta de Conteo Total (Color primario como en HIST.php)
            $html .= '<div class="col-md-4 mb-3">
                        <div class="card text-center bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total de Ascensos Realizados</h5>
                                <p class="card-text display-4 fw-bold">' . $this->totalAscensos . '</p>
                            </div>
                        </div>
                    </div>';

            // Tarjeta de Ascensos por Rango (Color info como en HIST.php)
            $html .= '<div class="col-md-4 mb-3">
                        <div class="card text-center bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Ascensos por Rango</h5>
                                <ul class="list-group list-group-flush">';
            if (!empty($this->ascensosPorRango)) {
                foreach ($this->ascensosPorRango as $item) {
                    $html .= '<li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                ' . htmlspecialchars($item['rango_actual'] ?? 'Sin Rango') . '
                                <span class="badge bg-secondary rounded-pill">' . $item['count'] . '</span>
                              </li>';
                }
            } else {
                 $html .= '<li class="list-group-item text-center text-muted">Sin datos por rango</li>';
            }
            $html .= '</ul>
                            </div>
                        </div>
                    </div>';

            // Tarjeta de Ascensos por Semana (Color success como en HIST.php)
            $html .= '<div class="col-md-4 mb-3">
                        <div class="card text-center bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Ascensos por Semana (Últimas 10)</h5>
                                <ul class="list-group list-group-flush">';
             if (!empty($this->ascensosPorSemana)) {
                foreach ($this->ascensosPorSemana as $item) {
                    $html .= '<li class="list-group-item d-flex justify-content-between align-items-center text-dark">
                                Semana ' . htmlspecialchars($item['week'] ?? 'N/A') . ' (' . htmlspecialchars($item['year'] ?? 'N/A') . ')
                                <span class="badge bg-secondary rounded-pill">' . $item['count'] . '</span>
                              </li>';
                }
            } else {
                 $html .= '<li class="list-group-item text-center text-muted">Sin datos por semana</li>';
            }
            $html .= '</ul>
                            </div>
                        </div>
                    </div>';

            $html .= '</div>';
        }

        $html .= '</div>
            </div>
        </div>';

        return $html;
    }

    private function renderRowAscenso($ascenso)
    {
         $nombreUsuarioAscendido = isset($ascenso['usuario_registro']) ? $ascenso['usuario_registro'] :
                                   (isset($ascenso['nombre_habbo']) ? $ascenso['nombre_habbo'] : 'No disponible');

        return '<tr>
            <td>' . ($ascenso['codigo_time'] ?? 'N/A') . ' (' . $nombreUsuarioAscendido . ')</td>
            <td>' . ($ascenso['rango_actual'] ?? 'N/A') . '</td>
            <td>' . ($ascenso['mision_actual'] ?? 'N/A') . '</td>
            <td>' . ($ascenso['accion'] ?? 'N/A') . '</td>
            <td>' . ($ascenso['realizado_por'] ?? 'N/A') . '</td>
            <td>' . ($ascenso['fecha_accion'] ?? 'N/A') . '</td>
        </tr>';
    }
}

$historialAscensos = new HistorialAscensos();
echo $historialAscensos->render();
?>