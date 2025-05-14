document.addEventListener('DOMContentLoaded', function() {
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

    document.getElementById('ventaTitulo').addEventListener('change', function() {
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
        .onSuccess(function(event) {
            event.preventDefault();
            guardarVenta();
        });
        
    document.getElementById('btnGuardarVenta').addEventListener('click', function() {
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