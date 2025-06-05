<?php
class GestionView
{
    private $pagas;
    private $requisitos;

    public function __construct($pagas, $requisitos)
    {
        $this->pagas = $pagas;
        $this->requisitos = $requisitos;
    }

    public function render()
    {
        $counts = $this->calculateCounts();
?>

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

            <script src="/public/assets/custom_general/custom_gestion_pagas/gestion_pagas.js"></script>
        </body>

    <?php
    }

    private function calculateCounts()
    {
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

    private function renderCards($counts)
    {
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

    private function renderPagosTab()
    {
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
                            <th>Estatus</th>
                            <th>Acciones</th>
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
                                    <td>
                                        <?php
                                        $estatus = $paga['estatus'] ?? 'pendiente';
                                        $clase = $estatus === 'completo' ? 'bg-success' : ($estatus === 'rechazado' ? 'bg-secondary' : 'bg-warning');
                                        ?>
                                        <span class="badge <?= $clase ?>"><?= ucfirst($estatus) ?></span>
                                    </td>
                                    <td>
                                        <?php if (empty($paga['estatus'])): ?>
                                            <button class="btn btn-sm btn-success" onclick="actualizarPago(<?= $paga['pagas_id'] ?>, 'recibido')">
                                                Dar paga
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="actualizarPago(<?= $paga['pagas_id'] ?>, 'no_recibido')">
                                                No recibió
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted">Pago realizado</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No hay datos de pagos disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php
    }

    private function renderRequisitosTab()
    {
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
                                    <td>
                                        <?= htmlspecialchars($requisito['times_as_encargado_count'] ?? 0) ?>
                                        <button class="btn btn-info btn-sm ms-2"
                                            onclick="verDetalles('<?= htmlspecialchars($requisito['id'] ?? '') ?>', 'tiempos')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($requisito['ascensos_as_encargado_count'] ?? 0) ?>
                                        <button class="btn btn-info btn-sm ms-2"
                                            onclick="verDetalles('<?= htmlspecialchars($requisito['id'] ?? '') ?>', 'ascensos')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
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
require_once(CONFIG_PATH . 'bd.php');
require_once(GESTION_PAGAS_PATCH . 'mostrar_usuarios.php');
require_once(PROCESOS_REQUERIMIENTOS_PACTH . 'mostrar_usuarios.php');

// Inicializar la base de datos
$db = new Database();

// Corregir el nombre de la clase
$requisitoService = new RequisitoService();
$requisitos = $requisitoService->obtenerCumplimientos()['data'];

$gestionPagas = new GestionPagas($db);
$pagas = $gestionPagas->obtenerPagas();

// Mostrar la vista
$view = new GestionView($pagas, $requisitos);
$view->render();
?>

<script>
    function verDetalles(id, tipo) {
        Swal.fire({
            title: 'Cargando detalles...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();

                fetch('/private/procesos/gestion_cumplimientos/obtener_detalles.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id=${encodeURIComponent(id)}&tipo=${encodeURIComponent(tipo)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const items = tipo === 'tiempos' ? data.data.tiempos : data.data.ascensos;
                            const titulo = tipo === 'tiempos' ? 'Tiempos como Encargado' : 'Ascensos Realizados';
                            const total = tipo === 'tiempos' ? data.data.usuario.tiempos_count : data.data.usuario.ascensos_count;

                            Swal.fire({
                                title: titulo,
                                html: `
                            <div class="mb-3">
                                <strong>Usuario:</strong> ${data.data.usuario.nombre_habbo}<br>
                                <strong>Registros esta semana:</strong> ${total}
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Rango</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${items.map(item => `
                                            <tr>
                                                <td>${item.usuario_nombre}</td>
                                                <td>${item.rango_usuario}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>`,
                                width: '600px',
                                confirmButtonText: 'Cerrar',
                                confirmButtonColor: '#3085d6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al cargar los detalles'
                        });
                    });
            }
        });
    }

    function actualizarPago(id, tipo) {
        const titulo = tipo === 'recibido' ? 'Confirmar pago' : 'Confirmar no pago';
        const texto = tipo === 'recibido' ? '¿Estás seguro que quieres confirmar el pago?' : '¿Estás seguro que quieres marcar como no recibido?';
        const motivo = tipo === 'recibido' ? 'Pago realizado' : 'Sin pago';

        Swal.fire({
            title: titulo,
            text: texto,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: tipo === 'recibido' ? '#28a745' : '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading
                Swal.fire({
                    title: 'Actualizando...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Realizar la actualización
                fetch('/private/procesos/gestion_pagas/actualizar_pago.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&motivo=${motivo}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'El estado del pago ha sido actualizado',
                            icon: 'success',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            // Recargar la página para ver los cambios
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Error al actualizar el pago',
                            icon: 'error',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al procesar la solicitud',
                        icon: 'error',
                        confirmButtonColor: '#3085d6'
                    });
                });
            }
        });
    }
</script>