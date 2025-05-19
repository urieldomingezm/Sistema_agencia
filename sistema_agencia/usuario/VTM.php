<?php
require_once(GESTION_VENTAS_PATCH . 'mostrar_ventas.php');

require_once(GESTION_RENOVAR_VENTA_PATCH . 'renovar.php');
require_once(GESTION_RENOVAR_VENTA_PATCH . 'eliminar.php');

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
            <th>Estado</th>
            <th>Fecha de Compra</th>
            <th>Fecha de Caducidad</th>
            <th>Costo</th>
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
                <td><?= htmlspecialchars($venta['venta_compra']) ?></td>
                <td><?= htmlspecialchars($venta['venta_caducidad']) ?></td>
                <td><?= htmlspecialchars($venta['venta_costo']) ?></td>
                <td>
                    <?php
                        if ($venta['venta_comprador'] !== null) {
                            echo htmlspecialchars($venta['nombre_habbo_registrado'] ?: 'Usuario no encontrado');
                        } else {
                            echo htmlspecialchars($venta['comprador_externo'] ?: 'No disponible');
                        }
                    ?>
                </td>
                <td><?= htmlspecialchars($venta['venta_encargado']) ?></td>
                <td>
                    <div class="dropdown">
                        <div class="btn-group" role="group">
                            <button class="btn btn-success btn-sm" onclick="renovarVenta(<?= $venta['venta_id'] ?>)">
                                Renovar
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="confirmarEliminarVenta(<?= $venta['venta_id'] ?>)">
                                Eliminar
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

        const renovarForm = document.getElementById('renovarVentaForm');
        if (renovarForm) {
            renovarForm.addEventListener('submit', function(event) {
                event.preventDefault();
                procesarRenovacion();
            });
        }
    });

    function renovarVenta(ventaId) {
        Swal.fire({
            title: '¿Está seguro?',
            text: '¿Desea renovar esta membresía?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Sí, renovar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                procesarRenovacion(ventaId);
            }
        });
    }

    function procesarRenovacion(ventaId) {
        const rutaRenovar = '/private/modal/modal_gestion_ventas/renovar.php';

        Swal.fire({
            title: 'Procesando',
            text: 'Renovando membresía...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const formData = new FormData();
        formData.append('ventaId', ventaId);

        fetch(rutaRenovar, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error al renovar la venta'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al procesar la solicitud: ' + error.message
            });
        });
    }

    function confirmarEliminarVenta(ventaId) {
        Swal.fire({
            title: '¿Está seguro?',
            text: '¡No podrá revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                procesarEliminacion(ventaId);
            }
        });
    }

    function procesarEliminacion(ventaId) {
        const rutaEliminar = '/private/modal/modal_gestion_ventas/eliminar.php';

        Swal.fire({
            title: 'Procesando',
            text: 'Eliminando registro...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const formData = new FormData();
        formData.append('ventaId', ventaId);

        fetch(rutaEliminar, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Eliminado!',
                    text: data.message
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error al eliminar la venta'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al procesar la solicitud: ' + error.message
            });
        });
    }

</script>