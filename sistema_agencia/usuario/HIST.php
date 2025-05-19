<?php

class HistorialTiempos
{
    private $tiemposEncargadoData;
    private $totalEncargadoCount;
    public $weeklyEncargadoCount; // Cambiado de private a public
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
                    <h5 class="mb-0">Dashboard tiempos hechos</h5>
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
                                <h5 class="card-title"><i class="bi bi-person-check"></i> Total Tiempos (contando todas semana)</h5>
                                <p class="card-text display-4 fw-bold">' . htmlspecialchars($this->totalEncargadoCount) . '</p>
                            </div>
                        </div>
                    </div>';

            $html .= '<div class="col-md-6 mb-3">
                        <div class="card text-center bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-calendar-week"></i> Tiempos tomados en esta Semana</h5>
                                <p class="card-text display-4 fw-bold">' . htmlspecialchars($this->weeklyEncargadoCount) . '</p>
                            </div>
                        </div>
                    </div>';

            $html .= '</div>';

            // Botón para registrar tiempo - Modificado para usar SweetAlert2
            $html .= '<div class="text-center mb-4">';
            $html .= '<button type="button" class="btn btn-primary" id="btnRegistrarRequisito">'; // Añadido ID
            $html .= 'Registrar mis tiempos hechos de esta semana'; // Texto del botón actualizado
            $html .= '</button>';
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
$weeklyCount = $historialTiempos->weeklyEncargadoCount; // Obtener el conteo semanal
echo $historialTiempos->render();

?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnRegistrar = document.getElementById('btnRegistrarRequisito');
    // Pasar el conteo semanal de PHP a JavaScript
    const weeklyTiemposCount = <?php echo json_encode($weeklyCount); ?>;

    if (btnRegistrar) {
        btnRegistrar.addEventListener('click', function() {
            // Verificar si el conteo semanal es cero
            if (weeklyTiemposCount === 0) {
                Swal.fire({
                    title: 'Sin Tiempos Registrados',
                    text: 'No tienes tiempos tomados como encargado esta semana para registrar.',
                    icon: 'info',
                    confirmButtonText: 'Entendido'
                });
                return; // Detener el proceso si el conteo es cero
            }

            Swal.fire({
                title: 'Confirmar Registro de Tiempos Semanales',
                text: `¿Deseas registrar tus ${weeklyTiemposCount} tiempos tomados como encargado esta semana?`, // Usar el conteo semanal
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, Registrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Construir el nombre del requisito automáticamente
                    const requirementName = `${weeklyTiemposCount} tiempos tomados esta semana`;

                    // Mostrar SweetAlert de carga
                    Swal.fire({
                        title: 'Registrando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Enviar datos al script PHP usando Fetch
                    fetch('/private/procesos/gestion_cumplimientos/registrar_requisitos.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'requirement_name=' + encodeURIComponent(requirementName)
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close(); // Cerrar SweetAlert de carga
                        if (data.success) {
                            Swal.fire(
                                '¡Registrado!',
                                data.message,
                                'success'
                            );
                            // Opcional: Recargar la página o actualizar el dashboard si es necesario
                            // location.reload();
                        } else {
                            Swal.fire(
                                'Error',
                                data.message,
                                'error'
                            );
                        }
                    })
                    .catch((error) => {
                        Swal.close(); // Cerrar SweetAlert de carga
                        console.error('Error:', error);
                        Swal.fire(
                            'Error',
                            'Ocurrió un error al comunicarse con el servidor.',
                            'error'
                        );
                    });
                }
            });
        });
    }
});
</script>