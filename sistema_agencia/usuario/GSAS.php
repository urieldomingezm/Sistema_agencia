<?php 
// Rutas para gestion de ascensos
require_once(GESTION_ASCENSOS_PATCH . 'mostrar_usuarios.php');
require_once(GESTION_ASCENSOS_PATCH . 'transcurrir_tiempo.php');

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
                                <span class="badge <?= $ascenso['estado_ascenso'] === 'disponible' ? 'bg-success' : ($ascenso['estado_ascenso'] === 'pendiente' ? 'bg-warning' : 'bg-secondary') ?>">
                                    <?= htmlspecialchars($ascenso['estado_ascenso']) ?>
                                </span>
                            </td>
                            <td data-fecha-ascenso="<?= htmlspecialchars($ascenso['fecha_disponible_ascenso']) ?>">
                                <?= htmlspecialchars($ascenso['fecha_disponible_ascenso'] ? date('Y-m-d H:i:s', strtotime($ascenso['fecha_disponible_ascenso'])) : 'No disponible') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
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
