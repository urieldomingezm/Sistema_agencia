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
                    // Aquí irá la lógica para eliminar la notificación
                    console.log('Eliminar notificación:', id);
                }
            });
        }
    });
});