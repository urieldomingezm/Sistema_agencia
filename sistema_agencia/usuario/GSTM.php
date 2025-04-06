<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    $query = "SELECT *, 
        TIMESTAMPDIFF(SECOND, tiempo_fecha_registro, NOW()) as segundos_transcurridos 
    FROM gestion_tiempo";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $tiempos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tiempo_id']) && isset($_POST['tiempo_transcurrido'])) {
        $tiempo_id = $_POST['tiempo_id'];
        $tiempo_transcurrido = $_POST['tiempo_transcurrido'];

        // Format time for display
        $horas = str_pad(floor($tiempo_transcurrido / 3600), 2, "0", STR_PAD_LEFT);
        $minutos = str_pad(floor(($tiempo_transcurrido % 3600) / 60), 2, "0", STR_PAD_LEFT);
        $segundos = str_pad($tiempo_transcurrido % 60, 2, "0", STR_PAD_LEFT);
        $tiempo_formateado = "$horas:$minutos:$segundos";

        // Get current status and times
        $queryActual = "SELECT tiempo_status, tiempo_acumulado, tiempo_total, tiempo_restado FROM gestion_tiempo WHERE tiempo_id = :tiempo_id";
        $stmt = $conn->prepare($queryActual);
        $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
        $stmt->execute();
        $tiempoActual = $stmt->fetch(PDO::FETCH_ASSOC);

        // Convert times to seconds for calculations
        $tiempo_acumulado_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_acumulado'] . " UTC");
        $tiempo_total_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_total'] . " UTC");
        $tiempo_restado_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_restado'] . " UTC");

        if ($tiempoActual['tiempo_status'] === 'Corriendo') {
            // Add elapsed time to both accumulated and total time
            $tiempo_acumulado_segundos += $tiempo_transcurrido;
            $tiempo_total_segundos += $tiempo_transcurrido;
        } elseif ($tiempoActual['tiempo_status'] === 'Ausente') {
            // Add to restado time
            $tiempo_restado_segundos += $tiempo_transcurrido;
            // Subtract from accumulated time
            $tiempo_acumulado_segundos = max(0, $tiempo_acumulado_segundos - $tiempo_transcurrido);
            // Update total time with the new accumulated time
            $tiempo_total_segundos = $tiempo_acumulado_segundos;
        }

        // Format final times
        $tiempo_acumulado = gmdate("H:i:s", $tiempo_acumulado_segundos);
        $tiempo_total = gmdate("H:i:s", $tiempo_total_segundos);
        $tiempo_restado = gmdate("H:i:s", $tiempo_restado_segundos);

        // Update database
        $updateQuery = "UPDATE gestion_tiempo SET 
            tiempo_transcurrido = :tiempo_formateado,
            tiempo_acumulado = :tiempo_acumulado,
            tiempo_total = :tiempo_total,
            tiempo_restado = :tiempo_restado
            WHERE tiempo_id = :tiempo_id";
    
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':tiempo_formateado', $tiempo_formateado, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_acumulado', $tiempo_acumulado, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_total', $tiempo_total, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_restado', $tiempo_restado, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
        $stmt->execute();
        exit;
    }

    // Handler for updating time status and calculations
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tiempo_id']) && isset($_POST['accion'])) {
        $tiempo_id = $_POST['tiempo_id'];
        $accion = $_POST['accion'];
    
        // Get current times before updating
        $queryActual = "SELECT tiempo_transcurrido, tiempo_acumulado, tiempo_total FROM gestion_tiempo WHERE tiempo_id = :tiempo_id";
        $stmt = $conn->prepare($queryActual);
        $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
        $stmt->execute();
        $tiempoActual = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Convert current times to seconds
        $tiempo_transcurrido_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_transcurrido'] . " UTC");
        $tiempo_acumulado_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_acumulado'] . " UTC");
        $tiempo_total_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_total'] . " UTC");
    
        switch ($accion) {
            case 'iniciar':
                $updateQuery = "UPDATE gestion_tiempo SET 
                    tiempo_status = 'Corriendo',
                    tiempo_fecha_registro = NOW()
                    WHERE tiempo_id = :tiempo_id";
                break;
    
            case 'pausar':
                // Add elapsed time to accumulated and total time
                $tiempo_acumulado = gmdate("H:i:s", $tiempo_acumulado_segundos + $tiempo_transcurrido_segundos);
                $tiempo_total = gmdate("H:i:s", $tiempo_total_segundos + $tiempo_transcurrido_segundos);
                
                $updateQuery = "UPDATE gestion_tiempo SET 
                    tiempo_status = 'Pausado',
                    tiempo_transcurrido = '00:00:00',
                    tiempo_acumulado = :tiempo_acumulado,
                    tiempo_total = :tiempo_total
                    WHERE tiempo_id = :tiempo_id";
                break;
    
            case 'detener':
                // Add elapsed time to accumulated and total time
                $tiempo_acumulado = gmdate("H:i:s", $tiempo_acumulado_segundos + $tiempo_transcurrido_segundos);
                $tiempo_total = gmdate("H:i:s", $tiempo_total_segundos + $tiempo_transcurrido_segundos);
                
                $updateQuery = "UPDATE gestion_tiempo SET 
                    tiempo_status = 'Pausado',
                    tiempo_transcurrido = '00:00:00',
                    tiempo_acumulado = :tiempo_acumulado,
                    tiempo_total = :tiempo_total
                    WHERE tiempo_id = :tiempo_id";
                break;
    
            case 'ausente':
                $updateQuery = "UPDATE gestion_tiempo SET 
                    tiempo_status = 'Ausente',
                    tiempo_fecha_registro = NOW()
                    WHERE tiempo_id = :tiempo_id";
                break;
    
            case 'completar':
                // Check if accumulated time is >= 3 hours (10800 seconds)
                if ($tiempo_acumulado_segundos >= 10800) {
                    $updateQuery = "UPDATE gestion_tiempo SET 
                        tiempo_status = 'Completado',
                        tiempo_transcurrido = '00:00:00'
                        WHERE tiempo_id = :tiempo_id";
                }
                break;
        }
    
        if (isset($updateQuery)) {
            $stmt = $conn->prepare($updateQuery);
            if ($accion === 'pausar' || $accion === 'detener') {
                $stmt->bindParam(':tiempo_acumulado', $tiempo_acumulado, PDO::PARAM_STR);
                $stmt->bindParam(':tiempo_total', $tiempo_total, PDO::PARAM_STR);
            }
            $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
            $stmt->execute();
            exit;
        }
    }

    // Handler for stopping time and calculating totals
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tiempo_id']) && isset($_POST['accion']) && $_POST['accion'] === 'detener') {
        $tiempo_id = $_POST['tiempo_id'];
        $tiempo_transcurrido = $_POST['tiempo_transcurrido'];

        // Get current times and status
        $queryActual = "SELECT tiempo_acumulado, tiempo_total, tiempo_status FROM gestion_tiempo WHERE tiempo_id = :tiempo_id";
        $stmt = $conn->prepare($queryActual);
        $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
        $stmt->execute();
        $tiempoActual = $stmt->fetch(PDO::FETCH_ASSOC);

        // Convert times to seconds for calculations
        $tiempo_acumulado_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_acumulado'] . " UTC");
        $tiempo_total_segundos = strtotime("1970-01-01 " . $tiempoActual['tiempo_total'] . " UTC");

        if ($tiempoActual['tiempo_status'] === 'Ausente') {
            // If status is Ausente, subtract from both accumulated and total
            $tiempo_acumulado_nuevo = $tiempo_acumulado_segundos - $tiempo_transcurrido;
            $tiempo_total_nuevo = $tiempo_total_segundos - $tiempo_transcurrido;
        } else {
            // Otherwise, add to both accumulated and total
            $tiempo_acumulado_nuevo = $tiempo_acumulado_segundos + $tiempo_transcurrido;
            $tiempo_total_nuevo = $tiempo_total_segundos + $tiempo_transcurrido;
        }

        // Format new times
        $tiempo_acumulado = gmdate("H:i:s", $tiempo_acumulado_nuevo);
        $tiempo_total = gmdate("H:i:s", $tiempo_total_nuevo);

        // Update database with all time values
        $updateQuery = "UPDATE gestion_tiempo SET 
            tiempo_acumulado = :tiempo_acumulado,
            tiempo_total = :tiempo_total,
            tiempo_transcurrido = '00:00:00',
            tiempo_status = 'Pausado',
            tiempo_fecha_registro = NOW()
            WHERE tiempo_id = :tiempo_id";

        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':tiempo_acumulado', $tiempo_acumulado, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_total', $tiempo_total, PDO::PARAM_STR);
        $stmt->bindParam(':tiempo_id', $tiempo_id, PDO::PARAM_INT);
        $stmt->execute();
        exit;
    }
} catch (PDOException $e) {
    error_log("Error al obtener datos: " . $e->getMessage());
    $tiempos = [];
}
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

<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #A78BFA, #8B5CF6);
    }

    .bg-gradient-info {
        background: linear-gradient(45deg, #36b9cc, #258391);
    }

    .table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th,
    .table td {
        border: 1px solid #e3e6f0;
        padding: 1rem;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fc;
        border-top: none;
        border-bottom: 2px solid #e3e6f0;
    }

    .table tbody tr:hover {
        background-color: rgba(167, 139, 250, 0.05);
    }

    .table tbody td {
        transition: all 0.3s ease;
    }

    .card-body {
        padding: 1.5rem;
        background-color: #ffffff;
        border-radius: 0 0 0.5rem 0.5rem;
    }

    .avatar-xs {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .font-monospace {
        font-family: 'Roboto Mono', monospace;
    }

    .dropdown-menu {
        font-size: 0.875rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
    }

    .dropdown-item i {
        width: 1rem;
        text-align: center;
    }
</style>

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