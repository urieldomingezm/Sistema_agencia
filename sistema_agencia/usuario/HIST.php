<?php

class HistorialTiempos
{
    private $tiemposEncargadoData;
    private $totalEncargadoCount;
    public $weeklyEncargadoCount;
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
        $html = '<div class="container-fluid mt-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-clock-history me-2"></i>Historial de Tiempos como Encargado</h5>
                </div>
                <div class="card-body p-0">';

        if ($this->errorMessage) {
            $html .= '<div class="alert alert-danger m-3">' . htmlspecialchars($this->errorMessage) . '</div>';
        } elseif (empty($this->tiemposEncargadoData)) {
             $html .= '<div class="alert alert-info m-3">No hay tiempos registrados donde hayas sido el encargado.</div>';
        }
        else {
            $html .= '<div class="row g-3 m-2">';

            // Tarjeta de total de tiempos
            $html .= '<div class="col-12 col-md-6">
                        <div class="card h-100 border border-primary shadow-sm">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    <i class="bi bi-person-check fs-1 text-primary me-3"></i>
                                    <div>
                                        <h6 class="card-subtitle mb-1 text-muted">Total de Tiempos</h6>
                                        <h3 class="card-title mb-0 fw-bold">' . htmlspecialchars($this->totalEncargadoCount) . '</h3>
                                    </div>
                                </div>
                                <p class="card-text small text-muted">Todos los tiempos registrados como encargado</p>
                            </div>
                        </div>
                    </div>';

            // Tarjeta de tiempos esta semana
            $html .= '<div class="col-12 col-md-6">
                        <div class="card h-100 border border-success shadow-sm">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    <i class="bi bi-calendar-week fs-1 text-success me-3"></i>
                                    <div>
                                        <h6 class="card-subtitle mb-1 text-muted">Tiempos esta Semana</h6>
                                        <h3 class="card-title mb-0 fw-bold">' . htmlspecialchars($this->weeklyEncargadoCount) . '</h3>
                                    </div>
                                </div>
                                <p class="card-text small text-muted">Tiempos tomados desde el lunes de esta semana</p>
                            </div>
                        </div>
                    </div>';

            $html .= '</div>';

            // Botón de acción
            $html .= '<div class="d-grid gap-2 col-md-6 mx-auto my-4">
                        <button type="button" class="btn btn-primary btn-lg rounded-pill shadow" id="btnRegistrarRequisito">
                            <i class="bi bi-save me-2"></i>Registrar Tiempos Semanales
                        </button>
                    </div>';

            // Sección de tiempos por rango
            $html .= '<div class="card border border-secondary shadow-sm m-2">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0"><i class="bi bi-people-fill me-2"></i>Tiempos por Rango</h5>
                        </div>
                        <div class="card-body p-0">';

            if (empty($this->encargadoCountByRange)) {
                $html .= '<div class="alert alert-warning m-3">No hay datos de rangos disponibles.</div>';
            } else {
                $html .= '<ul class="list-group list-group-flush">';
                foreach ($this->encargadoCountByRange as $rango => $count) {
                    $html .= '<li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-badge me-3 text-secondary"></i>
                                    <span>' . htmlspecialchars($rango) . '</span>
                                </div>
                                <span class="badge bg-primary rounded-pill fs-6">' . htmlspecialchars($count) . '</span>
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
$weeklyCount = $historialTiempos->weeklyEncargadoCount;
echo $historialTiempos->render();

?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnRegistrar = document.getElementById('btnRegistrarRequisito');
    const weeklyTiemposCount = <?php echo json_encode($weeklyCount); ?>;

    if (btnRegistrar) {
        btnRegistrar.addEventListener('click', function() {
            if (weeklyTiemposCount === 0) {
                Swal.fire({
                    title: 'Sin Tiempos Registrados',
                    text: 'No tienes tiempos tomados como encargado esta semana para registrar.',
                    icon: 'info',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#3085d6',
                    backdrop: 'rgba(0,0,0,0.4)'
                });
                return;
            }

            Swal.fire({
                title: 'Confirmar Registro',
                html: `¿Deseas registrar tus <b>${weeklyTiemposCount}</b> tiempos tomados como encargado esta semana?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-circle me-2"></i>Sí, Registrar',
                cancelButtonText: '<i class="bi bi-x-circle me-2"></i>Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                backdrop: 'rgba(0,0,0,0.4)',
                customClass: {
                    confirmButton: 'btn-lg',
                    cancelButton: 'btn-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const requirementName = `${weeklyTiemposCount} tiempos tomados esta semana`;
                    const type = 'tiempos';

                    Swal.fire({
                        title: 'Registrando...',
                        html: 'Por favor espera mientras procesamos tu solicitud',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        backdrop: 'rgba(0,0,0,0.4)'
                    });

                    fetch('/private/procesos/gestion_cumplimientos/registrar_requisitos.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'requirement_name=' + encodeURIComponent(requirementName) + '&type=' + encodeURIComponent(type)
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            Swal.fire({
                                title: '¡Registro Exitoso!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor: '#3085d6',
                                backdrop: 'rgba(0,0,0,0.4)'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Entendido',
                                confirmButtonColor: '#3085d6',
                                backdrop: 'rgba(0,0,0,0.4)'
                            });
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error de Conexión',
                            text: 'Ocurrió un error al comunicarse con el servidor.',
                            icon: 'error',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#3085d6',
                            backdrop: 'rgba(0,0,0,0.4)'
                        });
                    });
                }
            });
        });
    }
});
</script>