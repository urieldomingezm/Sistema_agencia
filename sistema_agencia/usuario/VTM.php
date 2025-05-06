<?php
require_once(GESTION_VENTAS_PATCH . 'mostrar_ventas.php');
?>

<style>
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .table thead th {
        background-color: #2c3e50;
        color: white;
        font-weight: 600;
        padding: 15px;
    }
    
    .table tbody td {
        vertical-align: middle;
        padding: 12px;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(44,62,80,0.05);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(44,62,80,0.1);
    }
    
    .badge {
        padding: 6px 12px;
        font-size: 0.9em;
        font-weight: 500;
        border-radius: 4px;
    }
    
    .bg-success {
        background-color: #28a745!important;
    }
    
    .bg-danger {
        background-color: #dc3545!important;
    }
</style>

<div class="dashboard-container">
    <div class="card">
        <div class="card-header bg-gradient-primary py-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Ventas de Membresías</h3>
            </div>
        </div>
        <div class="card-body">
            <table id="ventasTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
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
                            <?php
                            $badgeClass = '';
                            $estado = strtolower($venta['venta_estado']);
                            if ($estado === 'activo') {
                                $badgeClass = 'bg-success';
                            } elseif ($estado === 'caducado') {
                                $badgeClass = 'bg-danger';
                            }
                            ?>
                            <span class="badge <?= $badgeClass ?>">
                                <?= htmlspecialchars(ucfirst($venta['venta_estado'])) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($venta['venta_costo']) ?></td>
                        <td><?= htmlspecialchars($venta['venta_comprador']) ?></td>
                        <td><?= htmlspecialchars($venta['venta_encargado']) ?></td>
                        <td><?= htmlspecialchars(date('Y-m-d', strtotime($venta['venta_fecha_compra']))) ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="deleteVenta(<?= $venta['venta_id'] ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                            <button class="btn btn-success btn-sm" onclick="renovarVenta(<?= $venta['venta_id'] ?>)">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataTable = new simpleDatatables.DataTable("#ventasTable", {
        searchable: true,
        fixedHeight: true,
        labels: {
            placeholder: "Buscar...",
            perPage: "Registros por página",
            noRows: "No hay registros",
            info: "Mostrando {start} a {end} de {rows} registros",
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