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

    // Botón de ascender y verificar tiempo (using event delegation)
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
        } else if (e.target.matches('.verificar-tiempo-btn')) {
            const id = e.target.closest('button').dataset.id;
            verificarTiempoAscenso(id);
        }
    });

    // Removed the redundant querySelectorAll loop here
});

function verificarTiempoAscenso(id) {
    fetch('/private/procesos/gestion_ascensos/actualizar_tiempo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Éxito',
                text: data.message,
                icon: 'success',
                confirmButtonColor: '#198754'
            }).then(() => {
                location.reload(); // Recargar la página después del éxito
            });
        } else {
            Swal.fire({
                title: 'Información',
                text: data.message,
                icon: 'info',
                confirmButtonColor: '#0dcaf0'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'No se pudo verificar el tiempo',
            icon: 'error',
            confirmButtonColor: '#dc3545'
        });
    });
}