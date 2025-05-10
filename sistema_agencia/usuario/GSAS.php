<?php
// Rutas para gestion de ascensos
require_once(GESTION_ASCENSOS_PATCH . 'mostrar_usuarios.php');

// --- PROCESO DE TRANSCURRIR TIEMPO DIRECTO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['codigo_time'])) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit;
    }

    $codigo_time = $input['codigo_time'];

    try {
        $database = new Database();
        $conn = $database->getConnection();

        // Obtener los datos necesarios del usuario
        $query = "SELECT fecha_ultimo_ascenso, fecha_disponible_ascenso, estado_ascenso FROM ascensos WHERE codigo_time = :codigo_time";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':codigo_time', $codigo_time);
        $stmt->execute();
        $ascenso = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ascenso) {
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            exit;
        }

        // Obtener hora actual de México
        $dtMexico = new DateTime("now", new DateTimeZone("America/Mexico_City"));
        $ahora = $dtMexico->format('Y-m-d H:i:s');

        $fechaUltimo = $ascenso['fecha_ultimo_ascenso'];
        $tiempoRequisito = $ascenso['fecha_disponible_ascenso']; // formato "00:10:00"
        $estadoActual = $ascenso['estado_ascenso'];

        if ($estadoActual === "ascendido") {
            echo json_encode(['success' => false, 'message' => 'El usuario ya fue ascendido.']);
            exit;
        }

        // Calcular diferencia en segundos
        $fechaUltimoAscenso = new DateTime($fechaUltimo, new DateTimeZone("America/Mexico_City"));
        $ahoraDT = new DateTime($ahora, new DateTimeZone("America/Mexico_City"));
        $diffSegundos = $ahoraDT->getTimestamp() - $fechaUltimoAscenso->getTimestamp();

        // Convertir tiempo requisito a segundos
        list($h, $m, $s) = explode(':', $tiempoRequisito);
        $requisitoSegundos = $h * 3600 + $m * 60 + $s;

        $nuevoEstado = "en_espera";
        if ($diffSegundos >= $requisitoSegundos) {
            $nuevoEstado = "pendiente";
        }

        // Actualizar estado solo si cambió
        if ($nuevoEstado !== $estadoActual) {
            $query = "UPDATE ascensos SET estado_ascenso = :nuevo_estado WHERE codigo_time = :codigo_time";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':nuevo_estado', $nuevoEstado);
            $stmt->bindParam(':codigo_time', $codigo_time);
            $stmt->execute();
        }

        echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente', 'nuevo_estado' => $nuevoEstado]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}
?>

<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="text-primary">
            GESTIÓN DE ASCENSOS DE USUARIOS
        </h1>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Total Usuarios</h6>
                        <h4 class="mb-0"><?php echo count($GLOBALS['ascensos']); ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-arrow-up-circle fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Ascensos Disponibles</h6>
                        <h4 class="mb-0">
                            <?php
                            $disponibles = 0;
                            foreach ($GLOBALS['ascensos'] as $ascenso) {
                                if ($ascenso['estado_ascenso'] === 'disponible') $disponibles++;
                            }
                            echo $disponibles;
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Ascensos -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="tabladeusuariosascensos" class="table table-bordered table-striped table-hover text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Rango Actual</th>
                            <th>Misión Actual</th>
                            <th>Estado</th>
                            <th>Próximo Ascenso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($GLOBALS['ascensos'] as $ascenso): ?>
                            <tr data-codigo-time="<?= htmlspecialchars($ascenso['codigo_time']) ?>">
                                <td><?= htmlspecialchars($ascenso['nombre_habbo']) ?></td>
                                <td><?= htmlspecialchars($ascenso['rango_actual']) ?></td>
                                <td><?= htmlspecialchars($ascenso['mision_actual']) ?></td>
                                <td>
                                    <span class="badge <?= $ascenso['estado_ascenso'] === 'disponible' ? 'bg-success' : ($ascenso['estado_ascenso'] === 'pendiente' ? 'bg-warning' : ($ascenso['estado_ascenso'] === 'en_espera' ? 'bg-secondary' : 'bg-info')) ?>">
                                        <?= htmlspecialchars($ascenso['estado_ascenso']) ?>
                                    </span>
                                </td>
                                <td data-fecha-ascenso="<?= htmlspecialchars($ascenso['fecha_disponible_ascenso']) ?>">
                                    <?= htmlspecialchars($ascenso['fecha_disponible_ascenso'] ? date('Y-m-d H:i:s', strtotime($ascenso['fecha_disponible_ascenso'])) : 'No disponible') ?>
                                    <button class="btn btn-sm btn-primary mt-1 actualizar-ascenso"
                                        data-codigo="<?= htmlspecialchars($ascenso['codigo_time']) ?>"
                                        data-fecha-ultimo="<?= htmlspecialchars($ascenso['fecha_ultimo_ascenso']) ?>"
                                        data-tiempo-requisito="<?= htmlspecialchars($ascenso['fecha_disponible_ascenso']) ?>"
                                        data-estado="<?= htmlspecialchars($ascenso['estado_ascenso']) ?>">
                                        Actualizar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.actualizar-ascenso').forEach(btn => {
            btn.addEventListener('click', function() {
                const codigo = this.dataset.codigo;

                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        codigo_time: codigo
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Estado actualizado correctamente. Nuevo estado: " + data.nuevo_estado);
                        location.reload();
                    } else {
                        alert(data.message || "Error al actualizar el estado.");
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const dataTable = new simpleDatatables.DataTable("#tabladeusuariosascensos", {
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
    </script>