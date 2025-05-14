document.addEventListener('DOMContentLoaded', function() {
    const dataTable = new simpleDatatables.DataTable("#VentasRangos", {
        searchable: true,
        fixedHeight: true,
        labels: {
            placeholder: "Buscar...",
            perPage: "Registros por página",
            noRows: "No hay registros",
            info: "Mostrando {start} a {end} de {rows} registros",
        }
    });
});