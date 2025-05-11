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
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Gestion de ventas membresias</h5>
        </div>
        <div class="card-body">
        <table id="ventasTable" class="table table-striped table-hover">
    <thead>
        <tr class="text-white">
            <th>ID</th>
            <th>Membresia</th>
            <th>Compra</th>
            <th>Caducidad</th>
            <th>Estado</th>
            <th>Costo</th>
            <th>Comprador</th>
            <th>Encargado</th>
            <th>Fecha Compra</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ventas as $venta): ?>
            <tr>
                <td><?= htmlspecialchars($venta['venta_id']) ?></td>
                <td><?= htmlspecialchars($venta['venta_titulo']) ?></td>
                <td><?= htmlspecialchars($venta['venta_compra']) ?></td>
                <td><?= htmlspecialchars($venta['venta_caducidad']) ?></td>
                <td>
                    <span class="badge <?= strtolower($venta['venta_estado']) === 'activo' ? 'bg-success' : 'bg-danger' ?>">
                        <?= htmlspecialchars(ucfirst(strtolower($venta['venta_estado']))) ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($venta['venta_costo']) ?></td>
                <td><?= htmlspecialchars($venta['venta_comprador']) ?></td>
                <td><?= htmlspecialchars($venta['venta_encargado']) ?></td>
                <td><?= htmlspecialchars(date('Y-m-d', strtotime($venta['venta_fecha_compra']))) ?></td>
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



<script>
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        const dataTable = new simpleDatatables.DataTable("#ventasTable", {
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
                infoFiltered: "(filtrado de {rows} registros totales)"
            }
        });
    });
</script>