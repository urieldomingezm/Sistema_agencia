<meta name="keywords" content="Gestion de ventas de membresias y rangos entre otras cosas mas">

<?php
require_once(CONFIG_PATH . 'bd.php');
$db = new Database();
$conn = $db->getConnection();

$query = "SELECT * FROM gestion_ventas ORDER BY venta_fecha_compra DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="dashboard-container">
    <div class="card">
        <div class="card-header bg-gradient-primary py-3 border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Registro de Ventas</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVentaModal">
                    <i class="fas fa-plus"></i> Nueva Venta
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="ventasTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Comprador</th>
                        <th>Costo</th>
                        <th>Estado</th>
                        <th>Encargado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $venta): ?>
                        <tr>
                            <td><?= $venta['venta_id'] ?></td>
                            <td><?= htmlspecialchars($venta['venta_titulo']) ?></td>
                            <td><?= htmlspecialchars($venta['venta_comprador']) ?></td>
                            <td><?= $venta['venta_costo'] ?> c</td>
                            <td>
                                <span class="badge <?= $venta['venta_estado'] ? 'bg-success' : 'bg-warning' ?>">
                                    <?= $venta['venta_estado'] ? 'Completado' : 'Pendiente' ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($venta['venta_encargado']) ?></td>
                            <td><?= $venta['venta_fecha_compra'] ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="deleteVenta(<?= $venta['venta_id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-success btn-sm" onclick="renovarVenta(<?= $venta['venta_id'] ?>)">
                                    <i class="fas fa-sync-alt"></i>
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

function viewVenta(id) {
    fetch(`get_venta.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            const details = `
                <div class="venta-details">
                    <h4>${data.venta_titulo}</h4>
                    <p><strong>Descripción:</strong> ${data.venta_descripcion}</p>
                    <p><strong>Comprador:</strong> ${data.venta_comprador}</p>
                    <p><strong>Costo:</strong> ${data.venta_costo} créditos</p>
                    <p><strong>Fecha de Compra:</strong> ${data.venta_fecha_compra}</p>
                    <p><strong>Caducidad:</strong> ${data.venta_caducidad}</p>
                    <p><strong>Estado:</strong> ${data.venta_estado ? 'Completado' : 'Pendiente'}</p>
                    <p><strong>Encargado:</strong> ${data.venta_encargado}</p>
                </div>
            `;
            document.getElementById('ventaDetails').innerHTML = details;
            new bootstrap.Modal(document.getElementById('viewVentaModal')).show();
        });
}

function editVenta(id) {
    // Implementar lógica de edición
}

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
</script>

<style>
.dashboard-container {
    padding: 2rem;
}

.dashboard-header {
    margin-bottom: 2rem;
}

.card {
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.card-header {
    background: linear-gradient(135deg, #6e8efb, #4a6cf7);
    color: white;
    border-radius: 15px 15px 0 0 !important;
    padding: 1rem;
}

.btn-primary {
    background: linear-gradient(135deg, #6e8efb, #4a6cf7);
    border: none;
}

.venta-details {
    padding: 1rem;
}

.venta-details h4 {
    color: #4a6cf7;
    margin-bottom: 1rem;
}

.table th {
    background-color: #f8f9fa;
}
</style>