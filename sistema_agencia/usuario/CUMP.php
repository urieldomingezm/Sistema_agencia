<?php
require_once(PROCESOS_REQUERIMIENTOS_PACTH . 'mostrar_usuarios.php'); // Este script ahora llena $GLOBALS['cumplimientos']
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Gestión de requerimientos</h5>
        </div>
        <div class="card-body">
            <table id="cumplimientosTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Requisitos</th>
                        <th>Tiempos</th>
                        <th>Ascensos</th>
                        <th>Estatus</th>
                        <th>Última Actualización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($GLOBALS['cumplimientos']) && is_array($GLOBALS['cumplimientos'])):
                        foreach ($GLOBALS['cumplimientos'] as $cumplimiento):
                    ?>
                            <tr>
                                <td><?= htmlspecialchars($cumplimiento['id']) ?></td>
                                <td><?= htmlspecialchars($cumplimiento['user']) ?></td>
                                <td><?= !empty($cumplimiento['requirement_name']) ? htmlspecialchars($cumplimiento['requirement_name']) : 'no disponible' ?></td>
                                <td><?= htmlspecialchars($cumplimiento['times_as_encargado_count']) ?></td>
                                <td><?= htmlspecialchars($cumplimiento['ascensos_as_encargado_count']) ?></td>
                                <td>
                                    <span class="badge <?= $cumplimiento['is_completed'] ? 'bg-success' : 'bg-warning' ?>">
                                        <?= $cumplimiento['is_completed'] ? 'Completado' : 'En espera' ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($cumplimiento['last_updated']) ?></td>
                                <td>
                                    <button class="btn btn-success btn-sm btn-completo" data-id="<?= htmlspecialchars($cumplimiento['id']) ?>">
                                        <i class="fas fa-check"></i> Completo
                                    </button>
                                    <button class="btn btn-warning btn-sm btn-no-completo" data-id="<?= htmlspecialchars($cumplimiento['id']) ?>">
                                        <i class="fas fa-times"></i> No completo
                                    </button>
                                </td>
                            </tr>
                    <?php
                        endforeach;
                    else:
                    ?>
                        <tr>
                            <td colspan="8" class="text-center">No hay datos de cumplimiento disponibles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable
    const table = new simpleDatatables.DataTable("#cumplimientosTable", {
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

    // Event delegation for buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-completo')) {
            const id = e.target.closest('.btn-completo').dataset.id;
            handleCompleto(id);
        } else if (e.target.closest('.btn-no-completo')) {
            const id = e.target.closest('.btn-no-completo').dataset.id;
            handleNoCompleto(id);
        }
    });
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
    switch(status) {
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
</script>
