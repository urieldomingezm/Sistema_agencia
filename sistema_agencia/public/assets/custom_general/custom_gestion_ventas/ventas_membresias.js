
document.addEventListener('click', function (e) {
    if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu.show').forEach(function (menu) {
            menu.classList.remove('show');
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const dataTable = new simpleDatatables.DataTable("#ventasTableactivos", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        perPageSelect: [10, 25, 50, 100],
        labels: {
            placeholder: "Buscar...",
            perPage: "registros por página",
            noRows: "No se encontraron registros",
            info: "Mostrando {start} a {end} de {rows} registros",
            loading: "Cargando...",
            infoFiltered: "(filtrado de {rows} registros totales)"
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const dataTable = new simpleDatatables.DataTable("#ventasCaducadasTable", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        perPageSelect: [10, 25, 50, 100],
        labels: {
            placeholder: "Buscar...",
            perPage: "registros por página",
            noRows: "No se encontraron registros",
            info: "Mostrando {start} a {end} de {rows} registros",
            loading: "Cargando...",
            infoFiltered: "(filtrado de {rows} registros totales)"
        }
    });
});
