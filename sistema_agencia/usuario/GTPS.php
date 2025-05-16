<?php

// RUTAS DE GESTION DE PAGAS
require_once(GESTION_PAGAS_PATCH . 'mostrar_usuarios.php'); // MOSTRAR USUARIOS
require_once(GESTION_PAGAS_PATCH . 'mostrar_requisitos.php'); // MOSTRAR REQUISITOS
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
                        <h6 class="mb-1 text-muted">Total Pagado</h6>
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
                        <table id="requisitosTable" class="table table-bordered table-striped table-hover text-center mb-0">
                            <thead class="table-info">
                                <tr>
                                    <th>Usuario</th>
                                    <th>Requisito</th> <!-- Añadida columna para el nombre del requisito -->
                                    <th>Estado</th>
                                    <th>Aprobar</th> <!-- Nombre de columna ajustado a "Aprobar" -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($requisitos)) {
                                    foreach ($requisitos as $requisito) {
                                        // Determinar el texto y la clase del badge basado en is_completed
                                        $status_text = $requisito['is_completed'] ? 'Completado' : 'Pendiente';
                                        $status_class = $requisito['is_completed'] ? 'bg-success' : 'bg-danger';
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($requisito['user_codigo_time']); ?></td>
                                        <td><?php echo htmlspecialchars($requisito['requirement_name']); ?></td>
                                        <td>
                                            <span class="badge <?php echo $status_class; ?>">
                                                <?php echo $status_text; ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars(explode(' ', $requisito['last_updated'])[0]); ?></td>
                                        <!-- Añadir más celdas según las columnas -->
                                    </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="4" class="text-center">No hay registros de requisitos pendientes disponibles</td></tr>';
                                }
                                ?>
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
        // Inicializar DataTable para la tabla de Pagos
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

        // Inicializar DataTable para la tabla de Requisitos
        // Asegúrate de que esta tabla solo se inicialice cuando su tab esté activo o visible si es necesario,
        // o simpleDatatables puede manejar elementos ocultos.
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

        // Opcional: Lógica para re-inicializar o ajustar DataTables al cambiar de pestaña si simpleDatatables tiene problemas con elementos ocultos.
        // Esto puede no ser necesario dependiendo de la versión de simpleDatatables y Bootstrap.
        // var myTabs = document.querySelectorAll('#myTab button')
        // myTabs.forEach(function (tab) {
        //   tab.addEventListener('shown.bs.tab', function (event) {
        //     // event.target // newly activated tab
        //     // event.relatedTarget // previous active tab
        //     // Si es necesario, puedes llamar a resize() o similar en la instancia de DataTable
        //     // pagasDataTable.resize();
        //     // requisitosDataTable.resize();
        //   })
        // })
    });
</script>