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
        $html = '<div class="container-fluid p-0">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="bi bi-clock-history me-2 fs-4"></i>
                        <span class="fs-5">Historial de Tiempos como Encargado</span>
                    </h5>
                </div>
                <div class="card-body p-3">';

        if ($this->errorMessage) {
            $html .= '<div class="alert alert-danger mb-3">' . htmlspecialchars($this->errorMessage) . '</div>';
        } elseif (empty($this->tiemposEncargadoData)) {
            $html .= '<div class="alert alert-info mb-3">No hay tiempos registrados donde hayas sido el encargado.</div>';
        } else {
            // Improved cards with hover effects
            $html .= '<div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card h-100 border-start border-primary border-3 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-check fs-3 text-primary me-3"></i>
                                        <div>
                                            <h6 class="card-subtitle mb-1 text-muted small">Total</h6>
                                            <h5 class="card-title mb-0 fw-bold fs-4">' . htmlspecialchars($this->totalEncargadoCount) . '</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-start border-success border-3 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-week fs-3 text-success me-3"></i>
                                        <div>
                                            <h6 class="card-subtitle mb-1 text-muted small">Esta Semana</h6>
                                            <h5 class="card-title mb-0 fw-bold fs-4">' . htmlspecialchars($this->weeklyEncargadoCount) . '</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

            // Improved button with tooltip
            $html .= '<div class="d-grid mb-4">
                        <button type="button" class="btn btn-primary btn-lg rounded-3 shadow-sm" id="btnRegistrarRequisito" data-bs-toggle="tooltip" title="Registrar tus tiempos semanales">
                            Registrar Tiempos Semanales
                        </button>
                    </div>';

            // Improved range section with accordion
            $html .= '<div class="card border shadow-sm mb-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0 d-flex align-items-center">
                                <i class="bi bi-people-fill me-2 fs-4"></i>
                                <span class="fs-5">Tiempos por Rango</span>
                            </h6>
                        </div>';

            if (empty($this->encargadoCountByRange)) {
                $html .= '<div class="alert alert-warning m-3">No hay datos de rangos disponibles.</div>';
            } else {
                $html .= '<div class="accordion accordion-flush" id="accordionRangos">';
                foreach ($this->encargadoCountByRange as $rango => $count) {
                    $html .= '<div class="accordion-item">
                                <h2 class="accordion-header" id="heading' . htmlspecialchars($rango) . '">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . htmlspecialchars($rango) . '">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-badge me-2 text-secondary fs-4"></i>
                                            <span class="text-truncate" style="max-width: 200px;" title="' . htmlspecialchars($rango) . '">' . htmlspecialchars($rango) . '</span>
                                            <span class="badge bg-primary rounded-pill ms-2">' . htmlspecialchars($count) . '</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse' . htmlspecialchars($rango) . '" class="accordion-collapse collapse" data-bs-parent="#accordionRangos">
                                    <div class="accordion-body">';

                    // Aquí se debe agregar la lógica para obtener y mostrar los nombres de las personas
                    if (isset($this->tiemposEncargadoData[$rango])) {
                        foreach ($this->tiemposEncargadoData[$rango] as $persona) {
                            $html .= '<p>' . htmlspecialchars($persona['nombre']) . '</p>';
                        }
                    } else {
                        $html .= '<p>No hay personas registradas para este rango.</p>';
                    }

                    $html .= '    </div>
                                </div>
                            </div>';
                }
                $html .= '</div>';
            }
            $html .= '</div>';
        }

        $html .= '</div>
                </div>
            </div>';

        return $html;
    }

    public function render()
    {
        return $this->renderDashboard();
    }
}

ob_start();

$historialTiempos = new HistorialTiempos();
$weeklyCount = $historialTiempos->weeklyEncargadoCount;
echo $historialTiempos->render();

?>
<head>
    <meta name="keywords" content="Requisitos de paga, ascensos y misiones para los usuarios como tambien traslados">
</head>

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
                    confirmButton: 'btn-sm',
                    cancelButton: 'btn-sm'
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