document.addEventListener('DOMContentLoaded', function() {
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
});

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
        cancelButtonText: 'Cumplió pura nomina',
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
    fetch('/private/procesos/gestion_cumplimientos/requisitos_completado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + encodeURIComponent(id) + '&status=' + encodeURIComponent(status)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualizado!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: data.message,
                });
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Hubo un problema al comunicarse con el servidor.',
            });
        });
}