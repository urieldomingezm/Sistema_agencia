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
        global $historialAscensos;

        $html = '<div class="container-fluid p-0">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0 d-flex align-items-center">
                        <i class="bi bi-graph-up me-2 fs-4"></i>
                        <span class="fs-5">Historial de Ascensos</span>
                    </h5>
                </div>
                <div class="card-body p-3">';

        if ($this->errorMessage) {
            $html .= '<div class="alert alert-danger mb-3">' . htmlspecialchars($this->errorMessage) . '</div>';
        } else {
            $html .= '<div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card h-100 border-start border-primary border-3 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-trophy fs-3 text-primary me-3"></i>
                                        <div>
                                            <h6 class="card-subtitle mb-1 text-muted small">Total de Ascensos</h6>
                                            <h5 class="card-title mb-0 fw-bold fs-4">' . $this->totalAscensos . '</h5>
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
                                            <h5 class="card-title mb-0 fw-bold fs-4">' . $this->ascensosEstaSemana . '</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

            $html .= '<div class="d-grid mb-4">
                        <button type="button" class="btn btn-primary btn-lg rounded-3 shadow-sm" id="btnRegistrarAscensoSemanal" data-bs-toggle="tooltip" title="Registrar tus ascensos semanales">
                            Registrar Ascensos Semanales
                        </button>
                    </div>';

            $html .= '<div class="card border shadow-sm mb-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0 d-flex align-items-center">
                                <i class="bi bi-people-fill me-2 fs-4"></i>
                                <span class="fs-5">Ascensos por Rango</span>
                            </h6>
                        </div>';

            if (empty($this->ascensosPorRango)) {
                $html .= '<div class="alert alert-warning m-3">No hay datos de rangos disponibles.</div>';
            } else {
                $html .= '<div class="accordion accordion-flush" id="accordionRangos">';
                
                foreach ($this->ascensosPorRango as $item) {
                    $item['personas'] = $item['personas'] ?? [];
                    
                    if (isset($historialAscensos) && is_array($historialAscensos)) {
                        foreach ($historialAscensos as $ascenso) {
                            if (isset($ascenso['rango_actual']) && $ascenso['rango_actual'] === $item['rango_actual']) {
                                $nombre = $ascenso['nombre_habbo'] ?? $ascenso['usuario_registro'] ?? 'No disponible';
                                if (!in_array($nombre, $item['personas'])) {
                                    $item['personas'][] = $nombre;
                                }
                            }
                        }
                    }

                    $rangoActual = htmlspecialchars($item['rango_actual'] ?? 'Sin Rango');
                    $count = $item['count'] ?? 0;
                    
                    $html .= '<div class="accordion-item">
                                <h2 class="accordion-header" id="heading' . $rangoActual . '">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $rangoActual . '">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-badge me-2 text-secondary fs-4"></i>
                                            <span class="text-truncate" style="max-width: 200px;" title="' . $rangoActual . '">' . $rangoActual . '</span>
                                            <span class="badge bg-primary rounded-pill ms-2">' . $count . '</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse' . $rangoActual . '" class="accordion-collapse collapse" data-bs-parent="#accordionRangos">
                                    <div class="accordion-body">
                                        <ul class="list-group">';
                    
                    if (!empty($item['personas'])) {
                        foreach ($item['personas'] as $persona) {
                            $html .= '<li class="list-group-item">' . htmlspecialchars($persona) . '</li>';
                        }
                    } else {
                        $html .= '<li class="list-group-item">No hay personas registradas.</li>';
                    }
                    
                    $html .= '        </ul>
                                    </div>
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

        // Include the JavaScript file

        return $html;
    }

    private function renderRowAscenso($ascenso)
    {
        $nombreUsuarioAscendido = $ascenso['usuario_registro'] ?? $ascenso['nombre_habbo'] ?? 'No disponible';
        $codigoTime = $ascenso['codigo_time'] ?? 'N/A';

        return '<tr>
            <td>' . $codigoTime . ' (' . htmlspecialchars($nombreUsuarioAscendido) . ')</td>
            <td>' . htmlspecialchars($ascenso['rango_actual'] ?? 'N/A') . '</td>
            <td>' . htmlspecialchars($ascenso['mision_actual'] ?? 'N/A') . '</td>
            <td>' . htmlspecialchars($ascenso['accion'] ?? 'N/A') . '</td>
            <td>' . htmlspecialchars($ascenso['realizado_por'] ?? 'N/A') . '</td>
            <td>' . htmlspecialchars($ascenso['fecha_accion'] ?? 'N/A') . '</td>
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