document.addEventListener('DOMContentLoaded', function() {
    // Configuración común para todas las tablas
    const tableConfig = {
        searchable: true,
        fixedHeight: true,
        perPage: 10, // Número de filas por página
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
});