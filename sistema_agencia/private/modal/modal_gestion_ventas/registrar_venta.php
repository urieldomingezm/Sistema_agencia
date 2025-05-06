<div class="modal fade" id="registrarVentaModal" tabindex="-1" aria-labelledby="registrarVentaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registrarVentaModalLabel">Registrar Nueva Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registrarVentaForm">
                    <div class="mb-3">
                        <label for="ventaTitulo" class="form-label">Título de la Venta</label>
                        <select class="form-select" id="ventaTitulo" name="ventaTitulo" required>
                            <option value="">Seleccione una opción</option>
                            <option value="Membresía Básica">Membresía Básica</option>
                            <option value="Membresía Premium">Membresía Premium</option>
                            <option value="Membresía VIP">Membresía VIP</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fechaCompra" class="form-label">Fecha de Compra</label>
                        <input type="date" class="form-control" id="fechaCompra" name="fechaCompra" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fechaCaducidad" class="form-label">Fecha de Caducidad</label>
                        <input type="date" class="form-control" id="fechaCaducidad" name="fechaCaducidad" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nombreComprador" class="form-label">Nombre del Comprador</label>
                        <input type="text" class="form-control" id="nombreComprador" name="nombreComprador" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nombreEncargado" class="form-label">Nombre del Encargado</label>
                        <input type="text" class="form-control" id="nombreEncargado" name="nombreEncargado" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarVenta()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Establecer fecha actual
    const fechaActual = new Date().toISOString().split('T')[0];
    document.getElementById('fechaCompra').value = fechaActual;
    
    // Calcular fecha de caducidad (1 mes después)
    const fechaCaducidad = new Date();
    fechaCaducidad.setMonth(fechaCaducidad.getMonth() + 1);
    document.getElementById('fechaCaducidad').value = fechaCaducidad.toISOString().split('T')[0];
});

function guardarVenta() {
    // Lógica para guardar la venta
    const formData = new FormData(document.getElementById('registrarVentaForm'));
    
    fetch('/private/procesos/gestion_ventas/registrar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        } else {
            alert('Error al guardar la venta');
        }
    });
}
</script>