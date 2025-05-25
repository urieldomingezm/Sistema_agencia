document.addEventListener('DOMContentLoaded', function() {
    // Configuración para la tabla de notificaciones
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

    // Inicializar la tabla de notificaciones
    if (document.getElementById("datatable_notificaciones")) {
        new simpleDatatables.DataTable("#datatable_notificaciones", tableConfig);
    }

    // Modificar notificación (using event delegation)
    document.addEventListener('click', function(e) {
        if (e.target.matches('.modificar-notificacion')) {
            const id = e.target.dataset.id;
            Swal.fire({
                title: '¿Modificar notificación?',
                text: '¿Estás seguro de que deseas modificar esta notificación?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, modificar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí irá la lógica para modificar la notificación
                    console.log('Modificar notificación:', id);
                }
            });
        } else if (e.target.matches('.eliminar-notificacion')) {
            const id = e.target.dataset.id;
            Swal.fire({
                title: '¿Eliminar notificación?',
                text: '¿Estás seguro de que deseas eliminar esta notificación? Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('id', id);

                    fetch('/private/procesos/gestion_notificaciones/eliminar_notificacion.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '¡Eliminada!',
                                text: 'La notificación ha sido eliminada.',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                window.location.href = '?page=gestion_de_notificaciones';
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message || 'Error al eliminar la notificación',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un error al comunicarse con el servidor',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                }
            });
        }
    });
});