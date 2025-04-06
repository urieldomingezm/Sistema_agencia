<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    $query = "SELECT *, 
        TIMESTAMPDIFF(SECOND, NOW(), 
            DATE_ADD(ascenso_fecha_registro, 
            INTERVAL TIME_TO_SEC(ascenso_hora_proxima) SECOND)
        ) as segundos_restantes 
    FROM gestion_ascenso";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $ascensos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ascenso_id']) && isset($_POST['tiempo_restante'])) {
        $ascenso_id = $_POST['ascenso_id'];
        $tiempo_restante = $_POST['tiempo_restante'];

        if ($tiempo_restante == 0) {
            $nuevo_estado = "Disponible";
            $updateQuery = "UPDATE gestion_ascenso SET ascenso_hora_proxima = '00:00:00', ascenso_status = :nuevo_estado WHERE ascenso_id = :ascenso_id";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bindParam(':nuevo_estado', $nuevo_estado, PDO::PARAM_STR);
        } else {
            $horas = str_pad(floor($tiempo_restante / 3600), 2, "0", STR_PAD_LEFT);
            $minutos = str_pad(floor(($tiempo_restante % 3600) / 60), 2, "0", STR_PAD_LEFT);
            $segundos = str_pad($tiempo_restante % 60, 2, "0", STR_PAD_LEFT);
            $tiempo_formateado = "$horas:$minutos:$segundos";

            $updateQuery = "UPDATE gestion_ascenso SET ascenso_hora_proxima = :tiempo_formateado WHERE ascenso_id = :ascenso_id";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bindParam(':tiempo_formateado', $tiempo_formateado, PDO::PARAM_STR);
        }
        $stmt->bindParam(':ascenso_id', $ascenso_id, PDO::PARAM_INT);
        $stmt->execute();
        exit;
    }
} catch (PDOException $e) {
    error_log("Error al obtener datos: " . $e->getMessage());
    $ascensos = [];
}
?>

<meta name="keywords" content="Gestion de tiempo de ascenso, tiempo de ascenso y ascensos">

<div class="container-fluid mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-gradient-primary py-3 border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="text-white mb-0">
                        <i class="fas fa-users-cog me-2"></i>Gestión de Ascensos
                    </h5>
                </div>
                <div class="col text-end">
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal_ascender">
                        <i class="fas fa-user-plus me-2"></i>Nuevo Ascenso
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaAscenso" class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Usuario</th>
                            <th>Rango</th>
                            <th class="text-center">Estado</th>
                            <th>Motivo</th>
                            <th>Encargado</th>
                            <th class="text-center">Próximo</th>
                            <th>Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ascensos as $ascenso) : ?>
                            <tr data-id="<?= $ascenso['ascenso_id'] ?>" class="align-middle">
                                <td class="text-center"><?= $ascenso['ascenso_id'] ?></td>
                                <td>
                                    <button class="btn btn-link text-decoration-none p-0"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalInformacionPersona"
                                        data-usuario="<?= htmlspecialchars($ascenso['ascenso_usuario'] ?? 'Información no disponible') ?>"
                                        data-rango="<?= htmlspecialchars($ascenso['ascenso_rango'] ?? 'Información no disponible') ?>"
                                        data-mision-antigua="<?= htmlspecialchars($ascenso['ascenso_mision_antigua'] ?? 'Información no disponible') ?>"
                                        data-mision-nueva="<?= htmlspecialchars($ascenso['ascenso_mision_nueva'] ?? 'Información no disponible') ?>"
                                        data-firma="<?= htmlspecialchars($ascenso['ascenso_firma'] ?? 'Información no disponible') ?>">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-2">
                                                <i class="fas fa-user-circle text-primary"></i>
                                            </div>
                                            <?= $ascenso['ascenso_usuario'] ?? 'Información no disponible' ?>
                                        </div>
                                    </button>
                                </td>
                                <td>
                                    <span class="badge bg-gradient-info text-white rounded-pill px-3">
                                        <i class="fas fa-star me-1"></i><?= $ascenso['ascenso_rango'] ?? 'Información no disponible' ?>
                                    </span>
                                </td>
                                <td class="text-center estado">
                                    <span class="badge rounded-pill px-3 <?= $ascenso['ascenso_status'] == 'Disponible' ? 'bg-purple' : 'bg-warning text-dark' ?>"
                                        <?= $ascenso['ascenso_status'] == 'Disponible' ? 'style="background-color: #8B5CF6;"' : '' ?>>
                                        <i class="fas <?= $ascenso['ascenso_status'] == 'Disponible' ? 'fa-check' : 'fa-clock' ?> me-1"></i>
                                        <?= $ascenso['ascenso_status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i><?= $ascenso['ascenso_motivo'] ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-link text-decoration-none p-0"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalInformacionPersonaEncargado"
                                        data-encargado-nombre="<?= htmlspecialchars($ascenso['ascenso_encargado_usuario']) ?>"
                                        data-encargado-rango="<?= htmlspecialchars($ascenso['ascenso_rango_encargado'] ?? 'No especificado') ?>"
                                        data-encargado-mision-antigua="<?= htmlspecialchars($ascenso['ascenso_mision_antigua_encargado'] ?? 'No especificado') ?>"
                                        data-encargado-mision-nueva="<?= htmlspecialchars($ascenso['ascenso_mision_nueva_encargado'] ?? 'No especificado') ?>"
                                        data-encargado-firma="<?= htmlspecialchars($ascenso['ascenso_firma_encargado'] ?? 'No especificado') ?>">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-2">
                                                <i class="fas fa-user-shield text-primary"></i>
                                            </div>
                                            <?= $ascenso['ascenso_encargado_usuario'] ?>
                                        </div>
                                    </button>
                                </td>
                                <td class="text-center tiempo-restante" 
                                    data-segundos="<?= max(0, $ascenso['segundos_restantes']) ?>">
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-hourglass-half me-1"></i>
                                        <?= $ascenso['ascenso_hora_proxima'] ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?= date('d/m/Y H:i', strtotime($ascenso['ascenso_fecha_registro'])) ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item text-success" href="#" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modal_ascender"
                                                    data-usuario="<?= htmlspecialchars($ascenso['ascenso_usuario']) ?>"
                                                    data-rango="<?= htmlspecialchars($ascenso['ascenso_rango']) ?>"
                                                    data-mision="<?= htmlspecialchars($ascenso['ascenso_mision_nueva']) ?>">
                                                    <i class="fas fa-arrow-up me-2"></i>Ascender
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modal_despedir_persona"
                                                    data-usuario="<?= htmlspecialchars($ascenso['ascenso_usuario']) ?>"
                                                    data-rango="<?= htmlspecialchars($ascenso['ascenso_rango']) ?>">
                                                    <i class="fas fa-user-times me-2"></i>Despedir
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-warning" href="#" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modal_bajar_rango"
                                                    data-usuario="<?= htmlspecialchars($ascenso['ascenso_usuario']) ?>"
                                                    data-rango="<?= htmlspecialchars($ascenso['ascenso_rango']) ?>"
                                                    data-mision="<?= htmlspecialchars($ascenso['ascenso_mision_nueva']) ?>">
                                                    <i class="fas fa-arrow-down me-2"></i>Bajar rango
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
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
        background: linear-gradient(45deg, #36b9cc, #1a8a9c);
    }

    .avatar-xs {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
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

    .badge {
        font-weight: 500;
    }

    .tiempo-restante {
        font-family: 'Courier New', monospace;
    }

    .btn-light {
        background-color: #f8f9fc;
        border-color: #e3e6f0;
    }

    .btn-light:hover {
        background-color: #e3e6f0;
        border-color: #d1d3e2;
    }
</style>

<!-- MODALES PARA LA GESTION DE ASCENSOS-->
<?php
require_once(MODAL_GESTION_ASCENSO_PATH . 'modal_ascenso_ascender.php');
require_once(MODAL_GESTION_ASCENSO_PATH . 'modal_ascenso_baja.php');
require_once(MODAL_GESTION_ASCENSO_PATH . 'modal_ascenso_despedir.php');
require_once(MODAL_GESTION_ASCENSO_PATH . 'modal_ascenso_informacion_encargado.php');
require_once(MODAL_GESTION_ASCENSO_PATH . 'modal_ascenso_informacion_persona.php');
require_once(MODAL_GESTION_ASCENSO_PATH . 'modal_ascenso_registro.php');
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dataTable = new simpleDatatables.DataTable("#tablaAscenso", {
            searchable: true,
            fixedHeight: true,
            perPage: 5,
            labels: {
                placeholder: "Buscar usuarios...",
                perPage: "Mostrar registros",
                noRows: "No se encontraron registros",
                info: "Mostrando {start} a {end} de {rows} registros",
                noResults: "No hay resultados"
            },
            layout: {
                top: "{search}",
                bottom: "{info}{pager}"
            }
        });

        function updateAscensoTime() {
            document.querySelectorAll(".tiempo-restante").forEach(function(tiempoElem) {
                let segundos = parseInt(tiempoElem.dataset.segundos);
                
                if (segundos > 0) {
                    segundos--;
                    tiempoElem.dataset.segundos = segundos;
                    
                    const hours = String(Math.floor(segundos / 3600)).padStart(2, '0');
                    const minutes = String(Math.floor((segundos % 3600) / 60)).padStart(2, '0');
                    const seconds = String(segundos % 60).padStart(2, '0');
                    const timeString = `${hours}:${minutes}:${seconds}`;
                    
                    tiempoElem.querySelector('span').innerHTML = 
                        `<i class="fas fa-hourglass-half me-1"></i>${timeString}`;
    
                    const ascensoId = tiempoElem.closest("tr").dataset.id;
                    fetch('', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `ascenso_id=${ascensoId}&tiempo_restante=${segundos}`
                    });
    
                    if (segundos === 0) {
                        const estadoElem = tiempoElem.closest("tr").querySelector(".estado");
                        estadoElem.innerHTML = '<span class="badge bg-purple" style="background-color: #8B5CF6;">' +
                            '<i class="fas fa-check me-1"></i>Disponible</span>';
                    }
                }
            });
        }

        setInterval(updateAscensoTime, 1000);
    });
</script>
