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
            
            // Get the modal element and the input field for the user code
            const darAscensoModal = new bootstrap.Modal(document.getElementById('dar_ascenso_modal'));
            const codigoTimeAscensoInput = document.getElementById('codigoTimeAscenso');

            // Set the user code in the input field
            if (codigoTimeAscensoInput) {
                codigoTimeAscensoInput.value = id;
            }

            // Open the modal
            darAscensoModal.show();

            // Optionally, trigger the search automatically after setting the code
            // You might need to find the search button element and trigger its click event
            const buscarUsuarioAscensoBtn = document.getElementById('buscarUsuarioAscenso');
            if (buscarUsuarioAscensoBtn) {
                 buscarUsuarioAscensoBtn.click();
            }

        } else if (e.target.matches('.verificar-tiempo-btn')) {
            const id = e.target.closest('button').dataset.id;
            verificarTiempoAscenso(id);
        }
    });

    // Removed the redundant querySelectorAll loop here
    
    // Add this at the end
    setupAutoTimeChecks();
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

// Add this after the existing event listeners
function setupAutoTimeChecks() {
    // Check every minute (60000ms)
    setInterval(() => {
        document.querySelectorAll('.verificar-tiempo-btn').forEach(btn => {
            const id = btn.dataset.id;
            
            fetch('/private/procesos/gestion_ascensos/actualizar_tiempo.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.tiempo_disponible) {
                    // If time is available, trigger a silent refresh
                    btn.click();
                }
            })
            .catch(error => console.error('Auto-check error:', error));
        });
    }, 60000);
}