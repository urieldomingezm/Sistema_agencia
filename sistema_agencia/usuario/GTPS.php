<?php

// RUTAS DE GESTION DE PAGAS
require_once(GESTION_PAGAS_PATCH . 'mostrar_usuarios.php'); // MOSTRAR USUARIOS
require_once(GESTION_PAGAS_PATCH . 'mostrar_requisitos.php'); // MOSTRAR REQUISITOS
require_once(PROCESOS_REQUERIMIENTOS_PACTH . 'mostrar_usuarios.php');
?>

<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="text-primary">
            GESTION DE PAGOS USUARIOS Y REQUISITOS
        </h1>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Total Usuarios</h6>
                        <h4 class="mb-0"><?php echo count(array_unique(array_column($pagas, 'pagas_usuario'))); ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-currency-dollar fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Total</h6>
                        <h4 class="mb-0"><?php echo array_sum(array_column($pagas, 'pagas_recibio')); ?> créditos</h4>
                    </div>
                </div>
            </div>
        </div>
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
                    <!-- Tab para Pagos -->
                    <div class="tab-pane fade show active" id="pagos-tab-pane" role="tabpanel" aria-labelledby="pagos-tab">
                        <table id="pagasTable" class="table table-bordered table-striped table-hover text-center mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Rango</th>
                                    <th>Sueldo</th>
                                    <th>Membresia</th>
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
                                        <td><?php echo htmlspecialchars($paga['pagas_motivo']); ?></td>
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

                    <!-- Tab para Requisitos -->
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
                                    <th>Última Actualización</th>
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
                                            <td><?= htmlspecialchars($cumplimiento['last_updated']) ?></td>
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

<script src="/public/assets/custom_general/custom_gestion_pagas/gestion_pagas.js"></script>