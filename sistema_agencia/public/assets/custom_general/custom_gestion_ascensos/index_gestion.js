document.addEventListener('DOMContentLoaded', function() {
    // Configuración para la tabla de disponibles
    const tableConfig = {
        searchable: true,
        perPage: 5,
        perPageSelect: [5, 10, 25, 50, 100],
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

    // Inicializar solo la tabla de disponibles
    if (document.getElementById("ascensosDisponiblesTable")) {
        new simpleDatatables.DataTable("#ascensosDisponiblesTable", tableConfig);
    }

    // Botón de ascender
    document.addEventListener('click', function(e) {
        if (e.target.matches('.ascender-btn')) {
            const id = e.target.dataset.id;
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
                    fetch('/private/procesos/gestion_ascensos/registrar_ascenso.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: id })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return Swal.fire('¡Ascendido!', 'El usuario ha sido ascendido correctamente.', 'success');
                    })
                    .then(() => location.reload())
                    .catch(() => {
                        Swal.fire('Error', 'No se pudo completar el ascenso', 'error');
                    });
                }
            });
        }
    });

    // Botón de posponer
    document.addEventListener('click', function(e) {
        if (e.target.matches('.posponer-btn')) {
            const id = e.target.dataset.id;
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
                    fetch('/posponer_ascenso.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ 
                            id: id,
                            motivo: result.value 
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return Swal.fire('Pospuesto', 'El ascenso ha sido pospuesto.', 'info');
                    })
                    .then(() => location.reload())
                    .catch(() => {
                        Swal.fire('Error', 'No se pudo posponer el ascenso', 'error');
                    });
                }
            });
        }
    });
});