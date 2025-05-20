
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTable para la tabla de Pagos
    const pagasDataTable = new simpleDatatables.DataTable("#pagasTable", {
        searchable: true,
        fixedHeight: true,
        labels: {
            placeholder: "Buscar...",
            perPage: "Registros por página",
            noRows: "No hay registros",
            info: "Mostrando {start} a {end} de {rows} registros",
        }
    });

    // Inicializar DataTable para la tabla de Requisitos
    // Asegúrate de que esta tabla solo se inicialice cuando su tab esté activo o visible si es necesario,
    // o simpleDatatables puede manejar elementos ocultos.
    const requisitosDataTable = new simpleDatatables.DataTable("#requisitosTable", {
        searchable: true,
        fixedHeight: true,
        labels: {
            placeholder: "Buscar...",
            perPage: "Registros por página",
            noRows: "No hay registros",
            info: "Mostrando {start} a {end} de {rows} registros",
        }
    });

    // Initialize DataTable for cumplimientosTable
    const cumplimientosDataTable = new simpleDatatables.DataTable("#cumplimientosTable", {
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
            infoFiltered: "(filtrado de {rows} registros totales)",
            next: "Siguiente",
            previous: "Anterior"
        }
    });


    // Opcional: Lógica para re-inicializar o ajustar DataTables al cambiar de pestaña si simpleDatatables tiene problemas con elementos ocultos.
    // Esto puede no ser necesario dependiendo de la versión de simpleDatatables y Bootstrap.
    // var myTabs = document.querySelectorAll('#myTab button')
    // myTabs.forEach(function (tab) {
    //   tab.addEventListener('shown.bs.tab', function (event) {
    //     // event.target // newly activated tab
    //     // event.relatedTarget // previous active tab
    //     // Si es necesario, puedes llamar a resize() o similar en la instancia de DataTable
    //     // pagasDataTable.resize();
    //     // requisitosDataTable.resize();
    //     // cumplimientosDataTable.resize(); // Add this line
    //   })
    // })
});

// Event delegation for buttons (kept outside DOMContentLoaded as it's on document)
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-completo')) {
        const id = e.target.closest('.btn-completo').dataset.id;
        handleCompleto(id);
    } else if (e.target.closest('.btn-no-completo')) {
        const id = e.target.closest('.btn-no-completo').dataset.id;
        handleNoCompleto(id);
    }
});

function handleCompleto(id) {
    Swal.fire({
        title: 'Selecciona el tipo de cumplimiento',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Completó todos sus requisitos',
        cancelButtonText: 'Cumplió pura bonificación',
        showDenyButton: false,
        reverseButtons: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#ffc107'
    }).then((result) => {
        if (result.isConfirmed) {
            updateStatus(id, 'complete_all');
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            updateStatus(id, 'complete_bonus');
        }
    });
}

function handleNoCompleto(id) {
    Swal.fire({
        title: '¿Marcar como No completo?',
        text: "Esta acción marcará el requisito como no completado.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, marcar como no completo',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            updateStatus(id, 'incomplete');
        }
    });
}

function updateStatus(id, status) {
    // Here you would typically make an AJAX call to your backend
    // For now, we'll just show a success message
    let message = '';
    switch (status) {
        case 'complete_all':
            message = 'Se marcó como "Completó todos sus requisitos"';
            break;
        case 'complete_bonus':
            message = 'Se marcó como "Cumplió pura bonificación"';
            break;
        case 'incomplete':
            message = 'El requisito ha sido marcado como no completo';
            break;
    }

    Swal.fire({
        icon: 'success',
        title: '¡Acción registrada!',
        text: message,
        timer: 2000,
        showConfirmButton: false
    });
}
