<?php

class HistorialAscensos
{
    private $totalAscensos;
    private $ascensosPorRango;
    private $ascensosPorSemana;
    private $errorMessage;
    public $ascensosEstaSemana;

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
            $this->ascensosEstaSemana = $jsonData['ascensosEstaSemana'] ?? 0;
            $this->errorMessage = null;
        } else {
            $this->totalAscensos = 0;
            $this->ascensosPorRango = [];
            $this->ascensosPorSemana = [];
            $this->ascensosEstaSemana = 0;
            $this->errorMessage = $jsonData['message'] ?? 'Error desconocido al cargar los datos del dashboard.';
        }
    }

    public function render()
    {
        $html = '<div class="container-fluid mt-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-graph-up me-2"></i>Dashboard de Ascensos Realizados</h5>
                </div>
                <div class="card-body p-0">';

        if ($this->errorMessage) {
            $html .= '<div class="alert alert-danger m-3">' . htmlspecialchars($this->errorMessage) . '</div>';
        } else {
            $html .= '<div class="row g-3 m-2">';

            // Tarjeta de total de ascensos
            $html .= '<div class="col-12 col-md-4">
                        <div class="card h-100 border border-primary shadow-sm">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    <i class="bi bi-trophy fs-1 text-primary me-3"></i>
                                    <div>
                                        <h6 class="card-subtitle mb-1 text-muted">Total de Ascensos</h6>
                                        <h3 class="card-title mb-0 fw-bold">' . $this->totalAscensos . '</h3>
                                    </div>
                                </div>
                                <p class="card-text small text-muted">Todos los ascensos realizados</p>
                            </div>
                        </div>
                    </div>';

            // Tarjeta de ascensos esta semana
            $html .= '<div class="col-12 col-md-4">
                        <div class="card h-100 border border-success shadow-sm">
                            <div class="card-body text-center">
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    <i class="bi bi-calendar-week fs-1 text-success me-3"></i>
                                    <div>
                                        <h6 class="card-subtitle mb-1 text-muted">Ascensos esta Semana</h6>
                                        <h3 class="card-title mb-0 fw-bold">' . $this->ascensosEstaSemana . '</h3>
                                    </div>
                                </div>
                                <p class="card-text small text-muted">Desde el lunes de esta semana</p>
                            </div>
                        </div>
                    </div>';

            // Tarjeta de ascensos por rango
            $html .= '<div class="col-12 col-md-4">
                        <div class="card h-100 border border-secondary shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0"><i class="bi bi-people-fill me-2"></i>Ascensos por Rango</h6>
                            </div>
                            <div class="card-body p-0">';

            if (!empty($this->ascensosPorRango)) {
                $html .= '<ul class="list-group list-group-flush">';
                foreach ($this->ascensosPorRango as $item) {
                    $html .= '<li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-badge me-3 text-secondary"></i>
                                    <span>' . htmlspecialchars($item['rango_actual'] ?? 'Sin Rango') . '</span>
                                </div>
                                <span class="badge bg-primary rounded-pill">' . $item['count'] . '</span>
                              </li>';
                }
                $html .= '</ul>';
            } else {
                 $html .= '<div class="alert alert-warning m-3">No hay datos de ascensos por rango</div>';
            }

            $html .= '</div>
                        </div>
                    </div>';

            $html .= '</div>';

            // Botón de acción
            $html .= '<div class="d-grid gap-2 col-md-6 mx-auto my-4">
                        <button type="button" class="btn btn-primary btn-lg rounded-pill shadow" id="btnRegistrarAscensoSemanal">
                            <i class="bi bi-save me-2"></i>Registrar Ascensos Semanales
                        </button>
                    </div>';
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

ob_start();

$historialAscensos = new HistorialAscensos();
$weeklyAscensosCount = $historialAscensos->ascensosEstaSemana;
echo $historialAscensos->render();

?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnRegistrarAscenso = document.getElementById('btnRegistrarAscensoSemanal');
    const weeklyAscensosCount = <?php echo json_encode($weeklyAscensosCount); ?>;

    if (btnRegistrarAscenso) {
        btnRegistrarAscenso.addEventListener('click', function() {
            if (weeklyAscensosCount === 0) {
                Swal.fire({
                    title: 'Sin Ascensos Registrados',
                    text: 'No tienes ascensos realizados esta semana para registrar.',
                    icon: 'info',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#3085d6',
                    backdrop: 'rgba(0,0,0,0.4)'
                });
                return;
            }

            Swal.fire({
                title: 'Confirmar Registro',
                html: `¿Deseas registrar tus <b>${weeklyAscensosCount}</b> ascensos realizados esta semana?`,
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
                    const requirementName = `${weeklyAscensosCount} ascensos realizados esta semana`;
                    const type = 'ascensos';

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