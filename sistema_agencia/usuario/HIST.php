<?php

class HistorialTiempos
{
    private $tiemposEncargadoData;
    private $totalEncargadoCount;
    private $weeklyEncargadoCount;
    private $encargadoCountByRange;
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
        require_once(PRIVATE_PATH . 'procesos/gestion_tiempos/mis_tiempos.php');
        $jsonData = json_decode(ob_get_clean(), true);

        if (isset($jsonData['success']) && $jsonData['success']) {
            $this->tiemposEncargadoData = $jsonData['tiemposEncargado'] ?? [];
            $this->errorMessage = null;

            $this->calculateEncargadoStats();

        } else {
            $this->tiemposEncargadoData = [];
            $this->totalEncargadoCount = 0;
            $this->weeklyEncargadoCount = 0;
            $this->encargadoCountByRange = [];
            $this->errorMessage = $jsonData['message'] ?? 'Error desconocido al cargar los datos de tiempos como encargado.';
        }
    }

    private function calculateEncargadoStats()
    {
        $this->totalEncargadoCount = count($this->tiemposEncargadoData);
        $this->weeklyEncargadoCount = 0;
        $this->encargadoCountByRange = [];

        $now = new DateTime();
        $startOfWeek = (clone $now)->modify('this week Monday');

        foreach ($this->tiemposEncargadoData as $tiempo) {
            if (isset($tiempo['tiempo_fecha_registro']) && !empty($tiempo['tiempo_fecha_registro'])) {
                 try {
                    $registroDate = new DateTime($tiempo['tiempo_fecha_registro']);
                    if ($registroDate >= $startOfWeek && $registroDate <= $now) {
                         $this->weeklyEncargadoCount++;
                    }
                } catch (Exception $e) {
                    error_log("Fecha de registro inválida en tiempos encargado: " . ($tiempo['tiempo_fecha_registro'] ?? 'N/A') . " - " . $e->getMessage());
                }
            }

            $rango = $tiempo['rango_actual'] ?? 'Desconocido';
            if (!isset($this->encargadoCountByRange[$rango])) {
                $this->encargadoCountByRange[$rango] = 0;
            }
            $this->encargadoCountByRange[$rango]++;
        }

        arsort($this->encargadoCountByRange);
    }

    public function renderDashboard()
    {
        $html = '<div class="container mt-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dashboard de Tiempos como Encargado</h5>
                </div>
                <div class="card-body">';

        if ($this->errorMessage) {
            $html .= '<div class="alert alert-danger mb-0">' . htmlspecialchars($this->errorMessage) . '</div>';
        } elseif (empty($this->tiemposEncargadoData)) {
             $html .= '<div class="alert alert-info mb-0">No hay tiempos registrados donde hayas sido el encargado.</div>';
        }
        else {
            $html .= '<div class="row mb-4">';

            $html .= '<div class="col-md-6 mb-3">
                        <div class="card text-center bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-person-check"></i> Total Tiempos como Encargado</h5>
                                <p class="card-text display-4 fw-bold">' . htmlspecialchars($this->totalEncargadoCount) . '</p>
                            </div>
                        </div>
                    </div>';

            $html .= '<div class="col-md-6 mb-3">
                        <div class="card text-center bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-calendar-week"></i> Como Encargado Esta Semana</h5>
                                <p class="card-text display-4 fw-bold">' . htmlspecialchars($this->weeklyEncargadoCount) . '</p>
                            </div>
                        </div>
                    </div>';

            $html .= '</div>';

            $html .= '<div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-bar-chart-steps"></i> Tiempos Tomados por Rango</h5>';

            if (empty($this->encargadoCountByRange)) {
                $html .= '<p class="text-muted">No hay datos de rangos disponibles.</p>';
            } else {
                $html .= '<ul class="list-group list-group-flush">';
                foreach ($this->encargadoCountByRange as $rango => $count) {
                    $html .= '<li class="list-group-item d-flex justify-content-between align-items-center">
                                ' . htmlspecialchars($rango) . '
                                <span class="badge bg-secondary rounded-pill">' . htmlspecialchars($count) . '</span>
                              </li>';
                }
                $html .= '</ul>';
            }

            $html .= '</div>
            </div>';
        }

        $html .= '</div>
            </div>
        </div>';

        return $html;
    }

    public function render()
    {
        $html = $this->renderDashboard();
        return $html;
    }
}

ob_start();

$historialTiempos = new HistorialTiempos();
echo $historialTiempos->render();

?>