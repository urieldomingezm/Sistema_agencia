document.addEventListener('DOMContentLoaded', function() {
    // Configuración común para todas las tablas
    const tableConfig = {
        searchable: true,

        perPage: 10,
        perPageSelect: [10, 25, 50, 100],
        labels: {
            placeholder: "Buscar...",
            perPage: "registros por página",
            noRows: "No se encontraron registros",
            info: "Mostrando {start} a {end} de {rows} registros",
            loading: "Cargando...",
            infoFiltered: " (filtrado de {rows} registros totales)",
            next: "Siguiente",
            previous: "Anterior"
        }
    };

    // Inicializar cada tabla con la misma configuración
    if (document.getElementById("ascensosDisponiblesTable")) {
        new simpleDatatables.DataTable("#ascensosDisponiblesTable", tableConfig);
    }
    
    if (document.getElementById("ascensosAscendidosTable")) {
        new simpleDatatables.DataTable("#ascensosAscendidosTable", tableConfig);
    }
    
    if (document.getElementById("ascensosPendientesTable")) {
        new simpleDatatables.DataTable("#ascensosPendientesTable", tableConfig);
    }

    // Botón de ascender
    $(document).on('click', '.ascender-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Confirmar ascenso?',
            text: "Vas a procesar este ascenso",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, ascender',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX para procesar el ascenso
                $.ajax({
                    url: '/procesar_ascenso.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(response) {
                        Swal.fire('¡Ascendido!', 'El usuario ha sido ascendido correctamente.', 'success')
                            .then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo completar el ascenso', 'error');
                    }
                });
            }
        });
    });

    // Botón de posponer
    $(document).on('click', '.posponer-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Posponer ascenso',
            text: "Indica el motivo para posponer este ascenso",
            input: 'textarea',
            inputPlaceholder: 'Motivo de la posposición...',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Posponer',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if (!value) {
                    return 'Debes indicar un motivo';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX para posponer el ascenso
                $.ajax({
                    url: '/posponer_ascenso.php',
                    method: 'POST',
                    data: { 
                        id: id,
                        motivo: result.value
                    },
                    success: function(response) {
                        Swal.fire('Pospuesto', 'El ascenso ha sido pospuesto.', 'info')
                            .then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo posponer el ascenso', 'error');
                    }
                });
            }
        });
    });

    // Botón de ver detalles
    $(document).on('click', '.detalles-btn', function() {
        const id = $(this).data('id');
        // AJAX para obtener detalles
        $.ajax({
            url: '/obtener_detalles_ascenso.php',
            method: 'GET',
            data: { id: id },
            success: function(response) {
                const data = JSON.parse(response);
                Swal.fire({
                    title: 'Detalles del Ascenso',
                    html: `<div class="text-start">
                        <p><strong>Usuario:</strong> ${data.nombre_habbo}</p>
                        <p><strong>Rango Actual:</strong> ${data.rango_actual}</p>
                        <p><strong>Estado:</strong> ${data.estado_ascenso}</p>
                        <p><strong>Fecha Procesamiento:</strong> ${data.fecha_procesamiento || 'N/A'}</p>
                        <p><strong>Encargado:</strong> ${data.encargado || 'N/A'}</p>
                        <p><strong>Observaciones:</strong> ${data.observaciones || 'Sin observaciones'}</p>
                    </div>`,
                    icon: 'info',
                    confirmButtonText: 'Cerrar',
                    width: '600px'
                });
            },
            error: function() {
                Swal.fire('Error', 'No se pudieron obtener los detalles', 'error');
            }
        });
    });
});