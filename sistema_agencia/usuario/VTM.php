<?php
// PROCESO PARA ELIMINAR, RENOVAR, VENDER Y MOSTRAR LAS VENTAS DEL SITIO
require_once(GESTION_VENTAS_PATCH . 'mostrar_ventas.php');

// MODAL PARA VENTA, RENOVAR Y ELIMINAR
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
            <th>Estado</th>
            <th>Fecha de Compra</th>
            <th>Fecha de Caducidad</th>
            <th>Costo</th>
            <th>Comprador</th>
            <th>Encargado</th>
            <th>Acciones</th> <!-- Columna de Acciones re-añadida -->
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
                <td><?= htmlspecialchars($venta['venta_compra']) ?></td> <!-- Corregido a venta_compra -->
                <td><?= htmlspecialchars($venta['venta_caducidad']) ?></td>
                <td><?= htmlspecialchars($venta['venta_costo']) ?></td>
                <td>
                    <?php
                        // Mostrar nombre_habbo_registrado si venta_comprador no es NULL, de lo contrario mostrar comprador_externo
                        if ($venta['venta_comprador'] !== null) {
                            echo htmlspecialchars($venta['nombre_habbo_registrado'] ?: 'Usuario no encontrado');
                        } else {
                            echo htmlspecialchars($venta['comprador_externo'] ?: 'No disponible');
                        }
                    ?>
                </td>
                <td><?= htmlspecialchars($venta['venta_encargado']) ?></td>
                <td> <!-- Celda de Acciones re-añadida -->
                    <div class="dropdown">
                        <div class="btn-group" role="group">
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

        // Lógica para manejar el envío del formulario de renovación
        const renovarForm = document.getElementById('renovarVentaForm');
        if (renovarForm) {
            renovarForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir el envío normal del formulario
                procesarRenovacion();
            });
        }
    });

    // Función para abrir el modal de renovación y pasar el ID de la venta
    function renovarVenta(ventaId) {
        const modalElement = document.getElementById('renovarVentaModal');
        const ventaIdInput = modalElement.querySelector('#renovarVentaId');

        if (ventaIdInput) {
            ventaIdInput.value = ventaId; // Establecer el ID de la venta en el campo oculto
        }

        const modal = new bootstrap.Modal(modalElement);
        modal.show(); // Mostrar el modal
    }

    // Función para procesar la renovación via AJAX
    function procesarRenovacion() {
        const form = document.getElementById('renovarVentaForm');
        const ventaId = document.getElementById('renovarVentaId').value;
        const rutaRenovar = '/private/modal/modal_gestion_ventas/renovar.php'; // Asegúrate de que esta ruta sea correcta

        Swal.fire({
            title: 'Procesando',
            text: 'Renovando membresía...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const formData = new FormData();
        formData.append('ventaId', ventaId); // Añadir el ID de la venta al FormData

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
                    const modal = bootstrap.Modal.getInstance(document.getElementById('renovarVentaModal'));
                    modal.hide();
                    location.reload(); // Recargar la página para ver los cambios
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

</script>

<!-- Modal de Renovación -->
<div class="modal fade" id="renovarVentaModal" tabindex="-1" aria-labelledby="renovarVentaModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white bg-success">
                <h5 class="modal-title text-center" id="renovarVentaModalLabel">
                    Renovar Membresía
                </h5>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea renovar esta membresía?</p>
                <form id="renovarVentaForm" method="post">
                    <input type="hidden" id="renovarVentaId" name="ventaId">
                    <div class="modal-footer border-top-0 mt-4">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-outline-success">
                            Confirmar Renovación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>