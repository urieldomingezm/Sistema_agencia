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
                }
                .nav-link:not(.active) {
                    opacity: 0.6 !important;
                }
                .nav-link:hover {
                    opacity: 0.8 !important;
                }
                .card {
                    transition: transform 0.2s;
                }
                .card:hover {
                    transform: translateY(-5px);
                }
            </style>
        </head>
        <body>
            <div class="container py-4">
                <div class="text-center mb-4">
                    <h1 class="text-primary">
                        GESTION DE PAGOS USUARIOS Y REQUISITOS
                    </h1>
                </div>

                <?php $this->renderCards($counts); ?>
                
                <div class="container mt-4">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Gestión</h5>
                            <ul class="nav nav-tabs card-header-tabs mt-2">
                                <li class="nav-item mx-1">
                                    <button class="nav-link active bg-dark text-white border-light" id="pagos-tab" data-bs-toggle="tab" data-bs-target="#pagos-tab-pane" type="button">Derecho a pago</button>
                                </li>
                                <li class="nav-item mx-1">
                                    <button class="nav-link bg-dark text-white border-light" id="requisitos-tab" data-bs-toggle="tab" data-bs-target="#requisitos-tab-pane" type="button">Pendientes por acceptar</button>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <?php $this->renderPagosTab(); ?>
                                <?php $this->renderRequisitosTab(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap JS Bundle with Popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Tu script personalizado -->
            <script src="/public/assets/custom_general/custom_gestion_pagas/gestion_pagas.js"></script>
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
                'value' => $counts['usuarios']
            ],
            [
                'color' => 'success',
                'icon' => 'bi-currency-dollar',
                'title' => 'Créditos',
                'value' => $counts['creditos']
            ],
            [
                'color' => 'warning',
                'icon' => 'bi-clock',
                'title' => 'Pendiente',
                'value' => $counts['pendientes']
            ],
            [
                'color' => 'success',
                'icon' => 'bi-check-circle',
                'title' => 'Acceptado',
                'value' => $counts['aceptados']
            ]
        ];
        ?>
        <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
            <?php foreach ($cards as $card): ?>
                <div class="col">
                    <div class="card border-start border-<?= $card['color'] ?> border-4 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-<?= $card['color'] ?> bg-opacity-10 p-3 rounded me-3">
                                <i class="bi <?= $card['icon'] ?> fs-3 text-<?= $card['color'] ?>"></i>
                            </div>
                            <div>
                                <h6 class="text-uppercase text-muted fw-semibold mb-2"><?= $card['title'] ?></h6>
                                <h2 class="mb-0 fw-bold"><?= $card['value'] ?></h2>
                            </div>
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
            <div class="table-responsive">
                <table id="pagasTable" class="table table-bordered table-striped table-hover text-center mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Usuario</th>
                            <th>Rango</th>
                            <th>Sueldo</th>
                            <th>Membresía</th>
                            <th>Requisito</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($this->pagas)): ?>
                            <?php foreach ($this->pagas as $paga): ?>
                                <tr>
                                    <td><?= htmlspecialchars($paga['pagas_usuario'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($paga['pagas_rango'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($paga['pagas_recibio'] ?? 0) ?> créditos</td>
                                    <td><?= htmlspecialchars($paga['venta_titulo'] ?? 'No tiene') ?></td>
                                    <td>
                                        <span class="badge <?= ($paga['pagas_completo'] ?? false) ? 'bg-success' : 'bg-danger' ?>">
                                            <?= ($paga['pagas_completo'] ?? false) ? 'Completo' : 'Pendiente' ?>
                                        </span>
                                    </td>
                                    <td><?= isset($paga['pagas_fecha_registro']) ? htmlspecialchars(explode(' ', $paga['pagas_fecha_registro'])[0]) : '' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay datos de pagos disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
    
    private function renderRequisitosTab() {
        ?>
        <div class="tab-pane fade" id="requisitos-tab-pane" role="tabpanel" aria-labelledby="requisitos-tab">
            <div class="table-responsive">
                <table id="cumplimientosTable" class="table table-bordered table-striped table-hover text-center mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Requisitos</th>
                            <th>Tiempos</th>
                            <th>Ascensos</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($this->requisitos)): ?>
                            <?php foreach ($this->requisitos as $requisito): ?>
                                <tr>
                                    <td><?= htmlspecialchars($requisito['id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($requisito['user'] ?? '') ?></td>
                                    <td><?= !empty($requisito['requirement_name']) ? htmlspecialchars($requisito['requirement_name']) : 'no disponible' ?></td>
                                    <td><?= htmlspecialchars($requisito['times_as_encargado_count'] ?? 0) ?></td>
                                    <td><?= htmlspecialchars($requisito['ascensos_as_encargado_count'] ?? 0) ?></td>
                                    <td>
                                        <span class="badge <?= ($requisito['is_completed'] ?? false) ? 'bg-success' : 'bg-warning' ?>">
                                            <?= ($requisito['is_completed'] ?? false) ? 'Completado' : 'En espera' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm btn-completo" data-id="<?= htmlspecialchars($requisito['id'] ?? '') ?>">
                                            Completo
                                        </button>
                                        <button class="btn btn-warning btn-sm btn-no-completo" data-id="<?= htmlspecialchars($requisito['id'] ?? '') ?>">
                                            No completo
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No hay datos de requisitos disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
}

// Archivo principal que muestra la vista (index.php o similar)
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once 'CONFIG_PATH' . 'bd.php';
require_once 'requisito_manager.php';
require_once 'gestion_pagas.php';

// Inicializar la base de datos
$db = new Database();

// Obtener datos
$requisitoManager = new RequisitoManager($db);
$requisitos = $requisitoManager->obtenerRequisitosPendientes();

$gestionPagas = new GestionPagas($db);
$pagas = $gestionPagas->obtenerPagas();

// Mostrar la vista
$view = new GestionView($pagas, $requisitos);
$view->render();
?>