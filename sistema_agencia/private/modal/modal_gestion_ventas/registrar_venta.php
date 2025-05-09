<div class="modal fade" id="registrarVentaModal" tabindex="-1" aria-labelledby="registrarVentaModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white bg-primary">
                <h5 class="modal-title" id="registrarVentaModalLabel">
Registrar Nueva Venta
                </h5>
            </div>
            <div class="modal-body">
                <form id="registrarVentaForm" class="was-validated">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="ventaTitulo" name="ventaTitulo" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Membresía Básica">Membresía Básica</option>
                                    <option value="Membresía Premium">Membresía Premium</option>
                                    <option value="Membresía VIP">Membresía VIP</option>
                                </select>
                                <label for="ventaTitulo">Título de la Venta</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fechaCompra" name="fechaCompra" readonly required>
                                <label for="fechaCompra">Fecha de Compra</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fechaCaducidad" name="fechaCaducidad" readonly required>
                                <label for="fechaCaducidad">Fecha de Caducidad</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nombreComprador" name="nombreComprador" placeholder="Nombre del Comprador" required>
                                <label for="nombreComprador">Nombre del Comprador</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nombreEncargado" name="nombreEncargado" placeholder="Nombre del Encargado" required>
                                <label for="nombreEncargado">Nombre del Encargado</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 mt-4">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="guardarVenta()">
                            Guardar Venta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Incluye JustValidate desde CDN si no lo tienes ya -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Establecer fecha actual
    const fechaActual = new Date().toISOString().split('T')[0];
    document.getElementById('fechaCompra').value = fechaActual;
    
    // Calcular fecha de caducidad (1 mes después)
    const fechaCaducidad = new Date();
    fechaCaducidad.setMonth(fechaCaducidad.getMonth() + 1);
    document.getElementById('fechaCaducidad').value = fechaCaducidad.toISOString().split('T')[0];

    // JustValidate
    const validator = new window.JustValidate('#registrarVentaForm', {
        errorFieldCssClass: 'is-invalid',
        errorLabelStyle: {
            color: '#dc3545',
            marginTop: '0.25rem',
            fontSize: '0.875em'
        }
    });

    validator
      .addField('#ventaTitulo', [
        {
          rule: 'required',
          errorMessage: 'Seleccione un título de venta'
        }
      ])
      .addField('#fechaCompra', [
        {
          rule: 'required',
          errorMessage: 'La fecha de compra es obligatoria'
        }
      ])
      .addField('#fechaCaducidad', [
        {
          rule: 'required',
          errorMessage: 'La fecha de caducidad es obligatoria'
        }
      ])
      .addField('#nombreComprador', [
        {
          rule: 'required',
          errorMessage: 'El nombre del comprador es obligatorio'
        }
      ])
      .addField('#nombreEncargado', [
        {
          rule: 'required',
          errorMessage: 'El nombre del encargado es obligatorio'
        }
      ])
      .onSuccess(function(event) {
        event.preventDefault();
        guardarVenta();
      });
});

function guardarVenta() {
    const form = document.getElementById('registrarVentaForm');
    const formData = new FormData(form);
    fetch('/private/procesos/gestion_ventas/registrar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Venta registrada exitosamente'
            }).then(() => location.reload());
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al guardar la venta'
            });
        }
    });
}
</script>