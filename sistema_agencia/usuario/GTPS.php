<?php
require_once(GESTION_PAGAS_PATCH . 'mostrar_usuarios.php');
require_once(PROCESOS_REQUERIMIENTOS_PACTH . 'mostrar_usuarios.php');

// Calcular usuarios pendientes y aceptados de la tabla de cumplimientos
$pendientes_count = 0;
$aceptados_count = 0;

if (!empty($GLOBALS['cumplimientos']) && is_array($GLOBALS['cumplimientos'])) {
    foreach ($GLOBALS['cumplimientos'] as $cumplimiento) {
        if ($cumplimiento['is_completed'] == 0) {
            $pendientes_count++;
        } else {
            $aceptados_count++;
        }
    }
}

?>

<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="text-primary">
            GESTION DE PAGOS USUARIOS Y REQUISITOS
        </h1>
    </div>

    <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
        <?php
        $cards = [
            [
                'color' => 'primary',
                'icon' => 'bi-people-fill',
                'title' => 'Usuarios',
                'value' => count(array_unique(array_column($pagas, 'pagas_usuario')))
            ],
            [
                'color' => 'success',
                'icon' => 'bi-currency-dollar',
                'title' => 'Créditos',
                'value' => (int)array_sum(array_column($pagas, 'pagas_recibio'))
            ],
            [
                'color' => 'warning',
                'icon' => 'bi-clock',
                'title' => 'Pendiente',
                'value' => $pendientes_count
            ],
            [
                'color' => 'success',
                'icon' => 'bi-check-circle',
                'title' => 'Acceptado',
                'value' => $aceptados_count
            ]
        ];

        foreach ($cards as $card): ?>
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

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Gestión</h5>
                <ul class="nav nav-tabs card-header-tabs mt-2">
                    <li class="nav-item mx-1">
                        <button class="nav-link active bg-dark text-white border-light" id="pagos-tab" data-bs-toggle="tab" data-bs-target="#pagos-tab-pane" type="button" style="opacity: 1; transition: opacity 0.3s;">Derecho a pago</button>
                    </li>
                    <li class="nav-item mx-1">
                        <button class="nav-link bg-dark text-white border-light" id="requisitos-tab" data-bs-toggle="tab" data-bs-target="#requisitos-tab-pane" type="button" style="opacity: 0.6; transition: opacity 0.3s;">Pendientes por acceptar</button>
                    </li>
                </ul>
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
                </style>
            </div>

            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="pagos-tab-pane" role="tabpanel" aria-labelledby="pagos-tab">
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
                                <?php foreach ($pagas as $paga): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($paga['pagas_usuario']); ?></td>
                                        <td><?php echo htmlspecialchars($paga['pagas_rango']); ?></td>
                                        <td><?php echo htmlspecialchars($paga['pagas_recibio']); ?> créditos</td>
                                        <td>
                                            <?php
                                            // Mostrar el título de la membresía si existe, de lo contrario "No tiene"
                                            echo htmlspecialchars($paga['venta_titulo'] ?? 'No tiene');
                                            ?>
                                        </td>
                                        <td>
                                            <span class="badge <?php echo $paga['pagas_completo'] ? 'bg-success' : 'bg-danger'; ?>">
                                                <?php echo $paga['pagas_completo'] ? 'Completo' : 'Pendiente'; ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars(explode(' ', $paga['pagas_fecha_registro'])[0]); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="requisitos-tab-pane" role="tabpanel" aria-labelledby="requisitos-tab">
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
                                <?php
                                if (!empty($GLOBALS['cumplimientos']) && is_array($GLOBALS['cumplimientos'])):
                                    foreach ($GLOBALS['cumplimientos'] as $cumplimiento):
                                ?>
                                        <tr>
                                            <td><?= htmlspecialchars($cumplimiento['id']) ?></td>
                                            <td><?= htmlspecialchars($cumplimiento['user']) ?></td>
                                            <td><?= !empty($cumplimiento['requirement_name']) ? htmlspecialchars($cumplimiento['requirement_name']) : 'no disponible' ?></td>
                                            <td><?= htmlspecialchars($cumplimiento['times_as_encargado_count']) ?></td>
                                            <td><?= htmlspecialchars($cumplimiento['ascensos_as_encargado_count']) ?></td>
                                            <td>
                                                <span class="badge <?= $cumplimiento['is_completed'] ? 'bg-success' : 'bg-warning' ?>">
                                                    <?= $cumplimiento['is_completed'] ? 'Completado' : 'En espera' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm btn-completo" data-id="<?= htmlspecialchars($cumplimiento['id']) ?>">
                                                    <i class="fas fa-check"></i> Completo
                                                </button>
                                                <button class="btn btn-warning btn-sm btn-no-completo" data-id="<?= htmlspecialchars($cumplimiento['id']) ?>">
                                                    <i class="fas fa-times"></i> No completo
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                else:
                                    ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No hay datos de cumplimiento disponibles.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pagasDataTable = new simpleDatatables.DataTable("#pagasTable", {
            searchable: true,
            fixedHeight: true,
            labels: {
                placeholder: "Buscar...",
                perPage: "Registros por página",
                noRows: "No hay registros",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });

        const requisitosDataTable = new simpleDatatables.DataTable("#requisitosTable", {
            searchable: true,
            fixedHeight: true,
            labels: {
                placeholder: "Buscar...",
                perPage: "Registros por página",
                noRows: "No hay registros",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });

        const cumplimientosDataTable = new simpleDatatables.DataTable("#cumplimientosTable", {
            searchable: true,
            fixedHeight: true,
            perPage: 10,
            perPageSelect: [10, 25, 50, 100],
            labels: {
                placeholder: "Buscar...",
                perPage: "registros por página",
                noRows: "No se encontraron registros",
                info: "Mostrando {start} a {end} de {rows} registros",
                loading: "Cargando...",
                infoFiltered: "(filtrado de {rows} registros totales)",
                next: "Siguiente",
                previous: "Anterior"
            }
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-completo')) {
            const id = e.target.closest('.btn-completo').dataset.id;
            handleCompleto(id);
        } else if (e.target.closest('.btn-no-completo')) {
            const id = e.target.closest('.btn-no-completo').dataset.id;
            handleNoCompleto(id);
        }
    });

    function handleCompleto(id) {
        Swal.fire({
            title: 'Selecciona el tipo de cumplimiento',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Completó todos sus requisitos',
            cancelButtonText: 'Cumplió pura nomina',
            showDenyButton: false,
            reverseButtons: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#ffc107'
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, 'complete_all');
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                updateStatus(id, 'complete_bonus');
            }
        });
    }

    function handleNoCompleto(id) {
        Swal.fire({
            title: '¿Marcar como No completo?',
            text: "Esta acción marcará el requisito como no completado.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, marcar como no completo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, 'incomplete');
            }
        });
    }

    function updateStatus(id, status) {
        fetch('/private/procesos/gestion_cumplimientos/requisitos_completado.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + encodeURIComponent(id) + '&status=' + encodeURIComponent(status)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: data.message,
                    });
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Hubo un problema al comunicarse con el servidor.',
                });
            });
    }
</script>