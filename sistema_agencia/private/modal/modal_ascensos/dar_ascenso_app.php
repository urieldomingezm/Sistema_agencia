<?php
// Function to show SweetAlert2 modal for ascensos
function showAscensoModal() {
    echo "<script>
    (async () => {
        // Step 1: Get user code
        const { value: codigo } = await Swal.fire({
            title: 'Gestión de Ascensos',
            html: `
                <div class='text-start mb-3'>
                    <label class='form-label fw-bold'>Código de Usuario (5 caracteres)</label>
                    <input type='text' id='codigoAscenso' class='form-control' maxlength='5' placeholder='Ingrese el código'>
                </div>
            `,
            focusConfirm: false,
            preConfirm: () => {
                return document.getElementById('codigoAscenso').value;
            },
            showCancelButton: true,
            confirmButtonText: 'Buscar Usuario',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'swal-wide'
            }
        });

        if (!codigo) return;

        // Step 2: Search user
        Swal.fire({
            title: 'Buscando usuario...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        const formData = new FormData();
        formData.append('codigo', codigo);

        const response = await fetch('/private/procesos/gestion_ascensos/buscar_usuario.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();

        Swal.close();

        if (!data.success) {
            return Swal.fire('Error', data.message || 'Usuario no encontrado', 'error');
        }

        // Step 3: Show user info and confirm
        const { value: confirm } = await Swal.fire({
            title: 'Confirmar Ascenso',
            html: `
                <div class='text-start'>
                    <div class='mb-2'><strong>Usuario:</strong> ${data.data.nombre_habbo}</div>
                    <div class='mb-2'><strong>Rango Actual:</strong> ${data.data.rango_actual}</div>
                    <div class='mb-2'><strong>Estado:</strong> <span class='badge bg-${data.data.estado_ascenso === 'disponible' ? 'success' : 'danger'}'>${data.data.estado_ascenso}</span></div>
                    ${data.data.estado_ascenso !== 'disponible' ? 
                        '<div class="alert alert-warning mt-3">El usuario no cumple los requisitos para ascender</div>' : ''}
                </div>
            `,
            icon: data.data.estado_ascenso === 'disponible' ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar Ascenso',
            cancelButtonText: 'Cancelar',
            showDenyButton: data.data.estado_ascenso === 'disponible',
            denyButtonText: 'Ver Detalles',
            customClass: {
                popup: 'swal-wide'
            }
        });

        if (confirm) {
            // Step 4: Process ascenso
            Swal.fire({
                title: 'Procesando Ascenso',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            const ascensoResponse = await fetch('/private/procesos/gestion_ascensos/registrar_ascenso.php', {
                method: 'POST',
                body: formData
            });
            const ascensoData = await ascensoResponse.json();

            Swal.fire(
                ascensoData.success ? '¡Éxito!' : 'Error',
                ascensoData.message || (ascensoData.success ? 'Ascenso registrado correctamente' : 'Error al registrar ascenso'),
                ascensoData.success ? 'success' : 'error'
            );

            if (ascensoData.success) {
                setTimeout(() => location.reload(), 1500);
            }
        } else if (confirm === false) {
            // Show detailed view
            await Swal.fire({
                title: 'Detalles del Usuario',
                html: `
                    <div class='text-start'>
                        <div class='mb-2'><strong>Usuario:</strong> ${data.data.nombre_habbo}</div>
                        <div class='mb-2'><strong>Rango Actual:</strong> ${data.data.rango_actual}</div>
                        <div class='mb-2'><strong>Misión Actual:</strong> ${data.data.mision_actual}</div>
                        <div class='mb-2'><strong>Tiempo Transcurrido:</strong> ${data.data.tiempo_transcurrido || 'No disponible'}</div>
                        <div class='mb-2'><strong>Próxima Hora Estimada:</strong> ${data.data.proxima_hora_estimada || 'No disponible'}</div>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Entendido'
            });
        }
    })();
    </script>";
}

// Call the function when needed
showAscensoModal();
?>