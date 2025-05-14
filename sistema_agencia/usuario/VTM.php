<?php
// PROCESO PARA ELIMINAR, RENOVAR, VENDER Y MOSTRAR LAS VENTAS DEL SITIO
require_once(GESTION_VENTAS_PATCH . 'renovar_eliminar_registrar.php');
require_once(GESTION_VENTAS_PATCH . 'mostrar_ventas.php');

// MODAL PARA VENTA, RENOVAR Y ELIMINAR
require_once(GESTION_RENOVAR_VENTA_PATCH . 'vender.php');
require_once(GESTION_RENOVAR_VENTA_PATCH . 'renovar.php');

?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Gestion de ventas membresias</h5>
            <ul class="nav nav-tabs card-header-tabs mt-2">
                <li class="nav-item mx-1">
                    <button class="nav-link active bg-primary text-white border-light" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" style="opacity: 1; transition: opacity 0.3s;">Activas</button>
                </li>
                <li class="nav-item mx-1">
                    <button class="nav-link bg-primary text-white border-light" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" style="opacity: 0.6; transition: opacity 0.3s;">Caducadas</button>
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
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                    <table id="ventasTableactivos" class="table table-striped table-hover">
                        <thead>
                            <tr class="text-white">
                                <th>ID</th>
                                <th>Membresia</th>
                                <th>Estado</th>
                                <th>Comprador</th>
                                <th>Encargado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventas as $venta): ?>
                                <tr>
                                    <td><?= htmlspecialchars($venta['venta_id']) ?></td>
                                    <td><?= htmlspecialchars($venta['venta_titulo']) ?></td>
                                    <td>
                                        <span class="badge <?= strtolower($venta['venta_estado']) === 'activo' ? 'bg-success' : 'bg-danger' ?>">
                                            <?= htmlspecialchars(ucfirst(strtolower($venta['venta_estado']))) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($venta['venta_comprador']) ?></td>
                                    <td><?= htmlspecialchars($venta['venta_encargado']) ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-danger btn-sm" onclick="deleteVenta(<?= $venta['venta_id'] ?>)">
                                                    Eliminar
                                                </button>
                                                <button class="btn btn-success btn-sm" onclick="renovarVenta(<?= $venta['venta_id'] ?>)">
                                                    Renovar
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                    <table id="ventasCaducadasTable" class="table table-striped table-hover">
                        <thead>
                            <tr class="text-white">
                                <th>ID</th>
                                <th>Membresia</th>
                                <th>Estado</th>
                                <th>Comprador</th>
                                <th>Encargado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventasCaducadas as $venta): ?>
                                <tr>
                                    <td><?= htmlspecialchars($venta['venta_id']) ?></td>
                                    <td><?= htmlspecialchars($venta['venta_titulo']) ?></td>
                                    <td>
                                        <span class="badge <?= strtolower($venta['venta_estado']) === 'activo' ? 'bg-success' : 'bg-danger' ?>">
                                            <?= htmlspecialchars(ucfirst(strtolower($venta['venta_estado']))) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($venta['venta_comprador']) ?></td>
                                    <td><?= htmlspecialchars($venta['venta_encargado']) ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-danger btn-sm" onclick="deleteVenta(<?= $venta['venta_id'] ?>)">
                                                    Eliminar
                                                </button>
                                                <button class="btn btn-success btn-sm" onclick="renovarVenta(<?= $venta['venta_id'] ?>)">
                                                    Renovar
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CUSTOM JS PARA TABLA MEMBRESIAS -->
<script src="/public/assets/custom_general/custom_gestion_ventas/ventas_membresias.js"></script>