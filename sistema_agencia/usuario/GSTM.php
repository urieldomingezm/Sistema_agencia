<!-- PROCESO DE TOMAR TIEMPO -->

<?php
require_once(GESTION_TIEMPO_PATCH . 'proceso_tiempo.php'); 
?>


<!-- MODALES -->

<?php 
require_once(MODAL_GESTION_TIME_PATH . 'modal_tiempo_informacion_persona.php'); 
require_once(MODAL_GESTION_TIME_PATH . 'modal_tiempo_registro.php'); 
require_once(MODAL_GESTION_TIME_PATH . 'modal_tiempo_informacion_encargado.php'); 
?>


<!-- INFORMACION DE PERFIL DE USUARIO -->
<meta name="keywords" content="Gestion de tiempo de paga, tiempo de paga o time de paga">

<div class="container-fluid mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-gradient-primary py-3 border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="text-white mb-0">
                        <i class="fas fa-clock me-2"></i>Gestión de Tiempos
                    </h5>
                </div>
                <div class="col text-end">
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalTiempo">
                        <i class="fas fa-plus me-2"></i>Nuevo Registro
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaTiempos" class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Usuario</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Restado</th>
                            <th class="text-center">Acumulado</th>
                            <th class="text-center">Transcurrido</th>
                            <th class="text-center">Total</th>
                            <th>Encargado</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tiempos as $tiempo) : ?>
                            <tr data-id="<?= $tiempo['tiempo_id'] ?>" class="align-middle">
                                <td class="text-center"><?= $tiempo['tiempo_id'] ?></td>
                                <td>
                                    <button class="btn btn-link text-decoration-none p-0" data-bs-toggle="modal" data-bs-target="#modalInformacionPersona">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-2">
                                                <i class="fas fa-user-circle text-primary"></i>
                                            </div>
                                            <?= $tiempo['tiempo_usuario'] ?>
                                        </div>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill px-3 <?= getStatusClass($tiempo['tiempo_status']) ?>">
                                        <i class="fas <?= getStatusIcon($tiempo['tiempo_status']) ?> me-1"></i>
                                        <?= $tiempo['tiempo_status'] ?>
                                    </span>
                                </td>
                                <td class="text-center font-monospace"><?= $tiempo['tiempo_restado'] ?></td>
                                <td class="text-center font-monospace"><?= $tiempo['tiempo_acumulado'] ?></td>
                                <td class="text-center tiempo-transcurrido" data-segundos="<?= $tiempo['segundos_transcurridos'] ?>">
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-hourglass-half me-1"></i>
                                        <?= $tiempo['tiempo_transcurrido'] ?>
                                    </span>
                                </td>
                                <td class="text-center font-monospace"><?= $tiempo['tiempo_total'] ?></td>
                                <td>
                                    <button class="btn btn-link text-decoration-none p-0" data-bs-toggle="modal" data-bs-target="#modalInformacionPersonaEncargado">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-2">
                                                <i class="fas fa-user-shield text-primary"></i>
                                            </div>
                                            <?= $tiempo['tiempo_encargado_usuario'] ?>
                                        </div>
                                    </button>
                                </td>
                                <td class="text-center"><?= date('d/m/Y H:i', strtotime($tiempo['tiempo_fecha_registro'])) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-light btn-sm action-btn" onclick="showActionModal(this)" data-tiempo-id="<?= $tiempo['tiempo_id'] ?>">
                                        Acciones
                                    </button>
                                </td>

                                <!-- Action Modal -->
                                <div class="modal fade" id="actionModal" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Acciones de Tiempo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-grid gap-2">
                                                    <button class="btn btn-success action-button" data-action="iniciar">
                                                        <i class="fas fa-play me-2"></i>Iniciar tiempo
                                                    </button>
                                                    <button class="btn btn-danger action-button" data-action="ausente">
                                                        <i class="fas fa-user-clock me-2"></i>Ausente
                                                    </button>
                                                    <button class="btn btn-warning action-button" data-action="pausar">
                                                        <i class="fas fa-pause me-2"></i>Pausar
                                                    </button>
                                                    <button class="btn btn-danger action-button" data-action="detener">
                                                        <i class="fas fa-stop me-2"></i>Parar
                                                    </button>
                                                    <button class="btn btn-info action-button" data-action="completar">
                                                        <i class="fas fa-check me-2"></i>Completado
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    let currentTiempoId = null;

                                    function showActionModal(button) {
                                        currentTiempoId = button.dataset.tiempoId;
                                        const modal = new bootstrap.Modal(document.getElementById('actionModal'));
                                        modal.show();
                                    }

                                    document.querySelectorAll('.action-button').forEach(button => {
                                        button.addEventListener('click', async function() {
                                            const action = this.dataset.action;
                                            const modal = bootstrap.Modal.getInstance(document.getElementById('actionModal'));
                                            modal.hide();

                                            let title, text, icon;
                                            switch (action) {
                                                case 'iniciar':
                                                    title = '¿Iniciar tiempo?';
                                                    text = '¿Deseas iniciar el conteo de tiempo?';
                                                    icon = 'question';
                                                    break;
                                                case 'ausente':
                                                    title = '¿Marcar como ausente?';
                                                    text = 'Se comenzará a contar el tiempo de ausencia';
                                                    icon = 'warning';
                                                    break;
                                                case 'pausar':
                                                    title = '¿Pausar tiempo?';
                                                    text = '¿Deseas pausar el conteo de tiempo?';
                                                    icon = 'question';
                                                    break;
                                                case 'detener':
                                                    title = '¿Detener tiempo?';
                                                    text = 'Se actualizará el tiempo total y se reiniciará el contador';
                                                    icon = 'warning';
                                                    break;
                                                case 'completar':
                                                    title = '¿Marcar como completado?';
                                                    text = '¿Deseas marcar este tiempo como completado?';
                                                    icon = 'question';
                                                    break;
                                            }

                                            const result = await Swal.fire({
                                                title: title,
                                                text: text,
                                                icon: icon,
                                                showCancelButton: true,
                                                confirmButtonText: 'Sí, continuar',
                                                cancelButtonText: 'Cancelar'
                                            });

                                            if (result.isConfirmed) {
                                                // Use the existing action handling logic
                                                const row = document.querySelector(`tr[data-id="${currentTiempoId}"]`);
                                                if (action === 'detener') {
                                                    const tiempoElem = row.querySelector('.tiempo-transcurrido');
                                                    const segundos = parseInt(tiempoElem.dataset.segundos);

                                                    fetch('', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/x-www-form-urlencoded'
                                                        },
                                                        body: `tiempo_id=${currentTiempoId}&accion=detener&tiempo_transcurrido=${segundos}`
                                                    }).then(() => {
                                                        Swal.fire('¡Completado!', 'La acción se ha realizado con éxito.', 'success')
                                                            .then(() => location.reload());
                                                    });
                                                } else {
                                                    fetch('', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/x-www-form-urlencoded'
                                                        },
                                                        body: `tiempo_id=${currentTiempoId}&accion=${action}`
                                                    }).then(() => {
                                                        Swal.fire('¡Completado!', 'La acción se ha realizado con éxito.', 'success')
                                                            .then(() => location.reload());
                                                    });
                                                }
                                            }
                                        });
                                    });
                                </script>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
function getStatusClass($status)
{
    switch (strtolower($status)) {
        case 'corriendo':
            return 'bg-success';
        case 'pausado':
            return 'bg-warning text-dark';
        case 'completado':
            return 'bg-info';
        case 'ausente':
            return 'bg-danger';
        default:
            return 'bg-secondary';
    }
}

function getStatusIcon($status)
{
    switch (strtolower($status)) {
        case 'corriendo':
            return 'fa-play';
        case 'pausado':
            return 'fa-pause';
        case 'completado':
            return 'fa-check';
        case 'ausente':
            return 'fa-user-clock';
        default:
            return 'fa-circle';
    }
}

function formatDate($date)
{
    return date('d/m/Y H:i', strtotime($date));
}
?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        new simpleDatatables.DataTable('#tablaTiempos');

        // Handle all action buttons
        document.querySelectorAll('.dropdown-item').forEach(button => {
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                const row = this.closest('tr');
                const tiempoId = row.dataset.id;
                const action = this.querySelector('i').className;

                if (action.includes('fa-play')) {
                    const result = await Swal.fire({
                        title: '¿Iniciar tiempo?',
                        text: '¿Deseas iniciar el conteo de tiempo?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, iniciar',
                        cancelButtonText: 'Cancelar'
                    });

                    if (result.isConfirmed) {
                        fetch('', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `tiempo_id=${tiempoId}&accion=iniciar`
                        }).then(() => {
                            Swal.fire('¡Iniciado!', 'El tiempo ha comenzado a correr.', 'success')
                                .then(() => location.reload());
                        });
                    }
                } else if (action.includes('fa-user-clock')) {
                    const result = await Swal.fire({
                        title: '¿Marcar como ausente?',
                        text: 'Se comenzará a contar el tiempo de ausencia',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, marcar ausente',
                        cancelButtonText: 'Cancelar'
                    });

                    if (result.isConfirmed) {
                        fetch('', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `tiempo_id=${tiempoId}&accion=ausente`
                        }).then(() => {
                            Swal.fire('¡Ausente!', 'Se está contando el tiempo de ausencia.', 'success')
                                .then(() => location.reload());
                        });
                    }
                } else if (action.includes('fa-stop')) {
                    const result = await Swal.fire({
                        title: '¿Detener tiempo?',
                        text: 'Se actualizará el tiempo total y se reiniciará el contador',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, detener',
                        cancelButtonText: 'Cancelar'
                    });

                    if (result.isConfirmed) {
                        const tiempoElem = row.querySelector('.tiempo-transcurrido');
                        const segundos = parseInt(tiempoElem.dataset.segundos);

                        fetch('', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `tiempo_id=${tiempoId}&accion=detener&tiempo_transcurrido=${segundos}`
                        }).then(() => {
                            Swal.fire('¡Detenido!', 'El tiempo se ha actualizado correctamente.', 'success')
                                .then(() => location.reload());
                        });
                    }
                } else if (action.includes('fa-pause')) {
                    const result = await Swal.fire({
                        title: '¿Pausar tiempo?',
                        text: '¿Deseas pausar el conteo de tiempo?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, pausar',
                        cancelButtonText: 'Cancelar'
                    });

                    if (result.isConfirmed) {
                        fetch('', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `tiempo_id=${tiempoId}&accion=pausar`
                        }).then(() => {
                            Swal.fire('¡Pausado!', 'El tiempo se ha pausado.', 'success')
                                .then(() => location.reload());
                        });
                    }
                }
            });
        });

        // Update the time tracking function
        function updateTiempoTranscurrido() {
            document.querySelectorAll(".tiempo-transcurrido").forEach(function(tiempoElem) {
                const row = tiempoElem.closest('tr');
                const status = row.querySelector('.badge').textContent.trim().toLowerCase();

                if (status === 'corriendo' || status === 'ausente') {
                    const initialSeconds = parseInt(tiempoElem.dataset.segundos || 0);
                    
                    if (!tiempoElem.dataset.lastUpdate) {
                        tiempoElem.dataset.lastUpdate = Date.now();
                        tiempoElem.dataset.currentSeconds = initialSeconds;
                    }
                
                    const now = Date.now();
                    const timeDiff = now - parseInt(tiempoElem.dataset.lastUpdate);
                    const secondsToAdd = Math.floor(timeDiff / 1000);
                
                    if (secondsToAdd >= 1) {
                        const currentSeconds = parseInt(tiempoElem.dataset.currentSeconds) + secondsToAdd;
                        tiempoElem.dataset.currentSeconds = currentSeconds;
                        tiempoElem.dataset.lastUpdate = now;
                    
                        const hours = Math.floor(currentSeconds / 3600);
                        const minutes = Math.floor((currentSeconds % 3600) / 60);
                        const seconds = currentSeconds % 60;
                    
                        const timeString = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                    
                        tiempoElem.querySelector('span').innerHTML =
                            `<i class="fas fa-hourglass-half me-1"></i>${timeString}`;
                    
                        // Update server every 60 seconds
                        if (currentSeconds % 60 === 0) {
                            fetch('', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `tiempo_id=${row.dataset.id}&tiempo_transcurrido=${currentSeconds}`
                            });
                        }
                    }
                }
            });
        }

        // Update every second
        setInterval(updateTiempoTranscurrido, 1000);
    });
</script>