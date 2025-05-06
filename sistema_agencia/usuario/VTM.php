<?php
require_once(GESTION_VENTAS_PATCH . 'mostrar_ventas.php');
?>

<style>
    .table-responsive {
        max-width: 100%;
        overflow-x: auto;
    }

    .table th,
    .table td {
        white-space: nowrap;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .table th {
        position: sticky;
        top: 0;
        background-color: rgb(0, 128, 255);
        z-index: 1;
    }

    .dataTables_wrapper {
        margin-top: 1rem;
    }

    .dataTables_filter input {
        margin-left: 0.5rem;
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 0.375rem 0.75rem;
    }
</style>

<div class="table-responsive">
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
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown<?= $venta['venta_id'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                Acciones
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionDropdown<?= $venta['venta_id'] ?>">
                                <li>
                                    <button class="dropdown-item text-danger" onclick="deleteVenta(<?= $venta['venta_id'] ?>)">
                                        <i class="bi bi-trash me-2"></i>Eliminar
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item text-success" onclick="renovarVenta(<?= $venta['venta_id'] ?>)">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Renovar
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dataTable = new simpleDatatables.DataTable("#ventasTable", {
            searchable: true,
            fixedHeight: true,
            perPage: 10,
            perPageSelect: [10, 25, 50, 100],
            labels: {
                placeholder: "Buscar...",
                perPage: "{select} registros por página",
                noRows: "No se encontraron registros",
                info: "Mostrando {start} a {end} de {rows} registros",
                loading: "Cargando...",
                infoFiltered: "(filtrado de {rows} registros totales)"
            }
        });
    });

    function deleteVenta(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Implementar lógica de eliminación
            }
        });
    }

    function renovarVenta(id) {
        // Implementar lógica de renovación
    }
</script>