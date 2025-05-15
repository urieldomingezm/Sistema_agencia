document.addEventListener('DOMContentLoaded', function () {
    const rutaRegistrar = '<?php echo $rutaRegistrar; ?>';

    const obtenerFechaMexico = () => {
        const fechaActual = new Date();
        return new Date(fechaActual.toLocaleString('en-US', {
            timeZone: 'America/Mexico_City'
        }));
    };

    const fechaActualMexico = obtenerFechaMexico();
    const fechaCompraFormateada = fechaActualMexico.toISOString().split('T')[0];
    document.getElementById('fechaCompra').value = fechaCompraFormateada;

    actualizarFechaCaducidad();

    document.getElementById('ventaTitulo').addEventListener('change', function () {
        actualizarFechaCaducidad();
    });

    function actualizarFechaCaducidad() {
        const tipoMembresia = document.getElementById('ventaTitulo').value;
        const fechaActualMexico = obtenerFechaMexico();
        let fechaCaducidad;

        if (tipoMembresia === "Membresía VIP") {
            fechaCaducidad = new Date(2030, 11, 31);
        } else {
            fechaCaducidad = new Date(fechaActualMexico);
            fechaCaducidad.setMonth(fechaCaducidad.getMonth() + 1);

            const ultimoDiaMesSiguiente = new Date(fechaCaducidad.getFullYear(), fechaCaducidad.getMonth() + 1, 0).getDate();
            if (fechaCaducidad.getDate() > ultimoDiaMesSiguiente) {
                fechaCaducidad.setDate(ultimoDiaMesSiguiente);
            }
        }

        document.getElementById('fechaCaducidad').value = fechaCaducidad.toISOString().split('T')[0];
    }

    const validator = new window.JustValidate('#registrarVentaForm', {
        errorFieldCssClass: 'is-invalid',
        errorLabelStyle: {
            color: '#dc3545',
            marginTop: '0.25rem',
            fontSize: '0.875em'
        }
    });

    validator
        .addField('#ventaTitulo', [{
            rule: 'required',
            errorMessage: 'Seleccione un título de venta'
        }])
        .addField('#fechaCompra', [{
            rule: 'required',
            errorMessage: 'La fecha de compra es obligatoria'
        }])
        .addField('#fechaCaducidad', [{
            rule: 'required',
            errorMessage: 'La fecha de caducidad es obligatoria'
        }])
        .addField('#nombreComprador', [{
            rule: 'required',
            errorMessage: 'El nombre del comprador es obligatorio'
        }])
        .addField('#nombreEncargado', [{
            rule: 'required',
            errorMessage: 'El nombre del encargado es obligatorio'
        }])
        .onSuccess(function (event) {
            event.preventDefault();
            guardarVenta();
        });

    document.getElementById('btnGuardarVenta').addEventListener('click', function () {
        guardarVenta();
    });
});

function guardarVenta() {
    const form = document.getElementById('registrarVentaForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const rutaRegistrar = '<?php echo $rutaRegistrar; ?>';

    Swal.fire({
        title: 'Procesando',
        text: 'Registrando venta...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const formData = new FormData(form);

    fetch(rutaRegistrar, {
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
                    const modal = bootstrap.Modal.getInstance(document.getElementById('registrarVentaModal'));
                    modal.hide();
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error al guardar la venta'
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

document.getElementById('ventaTitulo').addEventListener('change', function () {
    const compradorContainer = document.getElementById('nombreCompradorContainer');
    const compradorField = document.getElementById('nombreComprador');

    if (this.value === 'Membresía VIP') {
        // Crear input para VIP
        compradorContainer.innerHTML = `
            <div class="form-floating">
                <input type="text" class="form-control" id="nombreComprador" name="nombreComprador" placeholder="Nombre del Comprador" required>
                <label for="nombreComprador">Nombre del Comprador</label>
            </div>
        `;
    } else {
        // Crear select para otras membresías
        compradorContainer.innerHTML = `
            <div class="form-floating">
                <select class="form-select" id="nombreComprador" name="nombreComprador" required>
                    <option value="" selected disabled>Cargando usuarios...</option>
                </select>
                <label for="nombreComprador">Nombre del Comprador</label>
            </div>
        `;

        // Obtener usuarios de la base de datos
        fetch('/private/procesos/gestion_ventas/mostrar_usuarios.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error(data.error || 'Error al cargar usuarios');
                }
                
                const select = document.getElementById('nombreComprador');
                select.innerHTML = '<option value="" selected disabled>Seleccione un usuario</option>';
                data.data.forEach(usuario => {
                    const option = document.createElement('option');
                    option.value = usuario.nombre_habbo;
                    option.textContent = usuario.nombre_habbo;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error al cargar usuarios:', error);
                const select = document.getElementById('nombreComprador');
                select.innerHTML = '<option value="" selected disabled>Error al cargar usuarios</option>';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar usuarios: ' + error.message
                });
            });
    }
});