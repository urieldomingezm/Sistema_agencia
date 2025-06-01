<?php
class GestionView {
    private $pagas;
    private $requisitos;
    
    public function __construct($pagas, $requisitos) {
        $this->pagas = $pagas;
        $this->requisitos = $requisitos;
    }
    
    public function render() {
        $counts = $this->calculateCounts();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="keywords" content="Requisitos de paga, ascensos y misiones para los usuarios como tambien traslados">
            <title>Gestión de Pagos y Requisitos</title>
            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- Bootstrap Icons -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
            <style>
                .nav-link.active {
                    opacity: 1 !important;
                    border-bottom: 2px solid #0d6efd !important;
                }
                .nav-link:not(.active) {
                    opacity: 0.6 !important;
                }
                .nav-link:hover:not(.active) {
                    opacity: 0.8 !important;
                }
                .card {
                    transition: transform 0.2s, box-shadow 0.2s;
                }
                .card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
                }
                .border-start {
                    border-left-width: 4px !important;
                }
                .table-hover tbody tr:hover {
                    background-color: rgba(13, 110, 253, 0.05);
                }
                .badge {
                    font-size: 0.85em;
                    padding: 0.35em 0.65em;
                }
            </style>
        </head>
        <body class="bg-light">
            <div class="container py-4">
                <div class="text-center mb-4">
                    <h1 class="text-primary fw-bold">
                        <i class="bi bi-cash-stack me-2"></i>GESTIÓN DE PAGOS Y REQUISITOS
                    </h1>
                    <p class="text-muted">Administración de pagos a usuarios y verificación de requisitos</p>
                </div>

                <?php $this->renderCards($counts); ?>
                
                <div class="container mt-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                <h5 class="mb-2 mb-md-0"><i class="bi bi-clipboard-data me-2"></i>Panel de Gestión</h5>
                                <ul class="nav nav-tabs card-header-tabs mt-2 mt-md-0">
                                    <li class="nav-item">
                                        <button class="nav-link active text-white" id="pagos-tab" data-bs-toggle="tab" data-bs-target="#pagos-tab-pane" type="button">
                                            <i class="bi bi-cash-coin me-1"></i> Derecho a pago
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link text-white" id="requisitos-tab" data-bs-toggle="tab" data-bs-target="#requisitos-tab-pane" type="button">
                                            <i class="bi bi-hourglass-split me-1"></i> Pendientes por aceptar
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="card-body p-0">
                            <div class="tab-content p-3" id="myTabContent">
                                <?php $this->renderPagosTab(); ?>
                                <?php $this->renderRequisitosTab(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap JS Bundle with Popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Script personalizado con manejo de errores -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Verificar si el script existe antes de intentar cargarlo
                    const scriptUrl = '/public/assets/custom_general/custom_gestion_pagas/gestion_pagas.js';
                    
                    fetch(scriptUrl, { method: 'HEAD' })
                        .then(response => {
                            if (response.ok) {
                                const script = document.createElement('script');
                                script.src = scriptUrl;
                                document.body.appendChild(script);
                            } else {
                                console.warn('El script personalizado no se encontró en la ruta especificada.');
                            }
                        })
                        .catch(error => {
                            console.error('Error al verificar el script personalizado:', error);
                        });
                    
                    // Manejo básico de botones si el script no carga
                    setTimeout(() => {
                        if (typeof customGestionHandlers === 'undefined') {
                            console.log('Implementando manejo básico de botones...');
                            document.querySelectorAll('.btn-completo, .btn-no-completo').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    const id = this.getAttribute('data-id');
                                    const action = this.classList.contains('btn-completo') ? 'completo' : 'no-completo';
                                    alert(`Acción básica: Marcar ID ${id} como ${action}. En un entorno real, esto enviaría una petición al servidor.`);
                                });
                            });
                        }
                    }, 1000);
                });
            </script>
        </body>
        </html>
        <?php
    }
    
    private function calculateCounts() {
        $pendientes = 0;
        $aceptados = 0;
        
        if (!empty($this->requisitos)) {
            foreach ($this->requisitos as $requisito) {
                if ($requisito['is_completed'] == 0) {
                    $pendientes++;
                } else {
                    $aceptados++;
                }
            }
        }
        
        return [
            'pendientes' => $pendientes,
            'aceptados' => $aceptados,
            'usuarios' => count(array_unique(array_column($this->pagas, 'pagas_usuario'))),
            'creditos' => (int)array_sum(array_column($this->pagas, 'pagas_recibio'))
        ];
    }
    
    private function renderCards($counts) {
        $cards = [
            [
                'color' => 'primary',
                'icon' => 'bi-people-fill',
                'title' => 'Usuarios',
                'value' => $counts['usuarios'],
                'description' => 'Usuarios con derecho a pago'
            ],
            [
                'color' => 'success',
                'icon' => 'bi-currency-dollar',
                'title' => 'Créditos',
                'value' => number_format($counts['creditos']),
                'description' => 'Total distribuidos'
            ],
            [
                'color' => 'warning',
                'icon' => 'bi-clock-history',
                'title' => 'Pendientes',
                'value' => $counts['pendientes'],
                'description' => 'Requisitos por revisar'
            ],
            [
                'color' => 'info',
                'icon' => 'bi-check2-all',
                'title' => 'Aceptados',
                'value' => $counts['aceptados'],
                'description' => 'Requisitos completados'
            ]
        ];
        ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-4">
            <?php foreach ($cards as $card): ?>
                <div class="col">
                    <div class="card h-100 border-start border-<?= $card['color'] ?> border-4 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-<?= $card['color'] ?> bg-opacity-10 p-3 rounded me-3">
                                    <i class="bi <?= $card['icon'] ?> fs-3 text-<?= $card['color'] ?>"></i>
                                </div>
                                <div>
                                    <h6 class="text-uppercase text-muted fw-semibold mb-1 small"><?= $card['title'] ?></h6>
                                    <h2 class="mb-0 fw-bold"><?= $card['value'] ?></h2>
                                </div>
                            </div>
                            <p class="text-muted small mt-2 mb-0"><?= $card['description'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
    
    private function renderPagosTab() {
        ?>
        <div class="tab-pane fade show active" id="pagos-tab-pane" role="tabpanel" aria-labelledby="pagos-tab">
            <?php if (!empty($this->pagas)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-nowrap"><i class="bi bi-person-fill me-1"></i>Usuario</th>
                                <th class="text-nowrap"><i class="bi bi-star-fill me-1"></i>Rango</th>
                                <th class="text-nowrap"><i class="bi bi-coin me-1"></i>Sueldo</th>
                                <th class="text-nowrap"><i class="bi bi-award-fill me-1"></i>Membresía</th>
                                <th class="text-nowrap"><i class="bi bi-list-check me-1"></i>Requisito</th>
                                <th class="text-nowrap"><i class="bi bi-calendar-event me-1"></i>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->pagas as $paga): ?>
                                <tr>
                                    <td><?= htmlspecialchars($paga['pagas_usuario'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($paga['pagas_rango'] ?? 'N/A') ?></td>
                                    <td class="fw-bold"><?= number_format(htmlspecialchars($paga['pagas_recibio'] ?? 0)) ?> créditos</td>
                                    <td><?= !empty($paga['venta_titulo']) ? htmlspecialchars($paga['venta_titulo']) : '<span class="text-muted">No tiene</span>' ?></td>
                                    <td>
                                        <span class="badge rounded-pill <?= ($paga['pagas_completo'] ?? false) ? 'bg-success' : 'bg-danger' ?>">
                                            <?= ($paga['pagas_completo'] ?? false) ? 'Completo' : 'Pendiente' ?>
                                        </span>
                                    </td>
                                    <td><?= isset($paga['pagas_fecha_registro']) ? date('d/m/Y', strtotime($paga['pagas_fecha_registro'])) : 'N/A' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle-fill me-2"></i>No hay datos de pagos disponibles.
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
    
    private function renderRequisitosTab() {
        ?>
        <div class="tab-pane fade" id="requisitos-tab-pane" role="tabpanel" aria-labelledby="requisitos-tab">
            <?php if (!empty($this->requisitos)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-warning">
                            <tr>
                                <th class="text-nowrap">#ID</th>
                                <th class="text-nowrap"><i class="bi bi-person-fill me-1"></i>Usuario</th>
                                <th class="text-nowrap"><i class="bi bi-list-check me-1"></i>Requisitos</th>
                                <th class="text-nowrap"><i class="bi bi-clock-history me-1"></i>Tiempos</th>
                                <th class="text-nowrap"><i class="bi bi-graph-up-arrow me-1"></i>Ascensos</th>
                                <th class="text-nowrap"><i class="bi bi-check-circle me-1"></i>Estatus</th>
                                <th class="text-nowrap"><i class="bi bi-gear-fill me-1"></i>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->requisitos as $requisito): ?>
                                <tr>
                                    <td>#<?= htmlspecialchars($requisito['id'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($requisito['user'] ?? 'N/A') ?></td>
                                    <td><?= !empty($requisito['requirement_name']) ? htmlspecialchars($requisito['requirement_name']) : '<span class="text-muted">No disponible</span>' ?></td>
                                    <td><?= htmlspecialchars($requisito['times_as_encargado_count'] ?? 0) ?></td>
                                    <td><?= htmlspecialchars($requisito['ascensos_as_encargado_count'] ?? 0) ?></td>
                                    <td>
                                        <span class="badge rounded-pill <?= ($requisito['is_completed'] ?? false) ? 'bg-success' : 'bg-warning' ?>">
                                            <?= ($requisito['is_completed'] ?? false) ? 'Completado' : 'En espera' ?>
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-success btn-completo flex-grow-1" data-id="<?= htmlspecialchars($requisito['id'] ?? '') ?>">
                                                <i class="bi bi-check-lg me-1"></i>Completo
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-no-completo flex-grow-1" data-id="<?= htmlspecialchars($requisito['id'] ?? '') ?>">
                                                <i class="bi bi-x-lg me-1"></i>No completo
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>No hay datos de requisitos disponibles.
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}

// Uso seguro de las clases con verificación de existencia
if (!class_exists('Database')) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
    require_once(CONFIG_PATH . 'bd.php');
}

if (!class_exists('GestionPagas') && file_exists(GESTION_PAGAS_PATCH . 'mostrar_usuarios.php')) {
    require_once(GESTION_PAGAS_PATCH . 'mostrar_usuarios.php');
}

if (!class_exists('RequisitoService') && file_exists(PROCESOS_REQUERIMIENTOS_PACTH . 'mostrar_usuarios.php')) {
    require_once(PROCESOS_REQUERIMIENTOS_PACTH . 'mostrar_usuarios.php');
}

// Definir DEBUG_MODE si no está definido
if (!defined('DEBUG_MODE')) {
    define('DEBUG_MODE', false);
}

try {
    // Inicializar la base de datos
    $db = new Database();

    // Obtener datos con manejo de errores
    $requisitos = [];
    $pagas = [];
    
    if (class_exists('RequisitoService')) {
        $requisitoService = new RequisitoService();
        $requisitosData = $requisitoService->obtenerCumplimientos();
        $requisitos = $requisitosData['data'] ?? [];
    }
    
    if (class_exists('GestionPagas')) {
        $gestionPagas = new GestionPagas($db);
        $pagas = $gestionPagas->obtenerPagas() ?: [];
    }

    // Mostrar la vista
    $view = new GestionView($pagas, $requisitos);
    $view->render();
    
} catch (Exception $e) {
    // Manejo básico de errores
    echo '<div class="alert alert-danger m-4">';
    echo '<h4 class="alert-heading">Error al cargar la página</h4>';
    echo '<p>Ocurrió un error al intentar cargar los datos. Por favor, inténtelo nuevamente más tarde.</p>';
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        echo '<hr><p class="mb-0 small text-muted">Detalles: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    echo '</div>';
}