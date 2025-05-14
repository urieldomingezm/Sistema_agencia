<?php
require_once(GESTION_ASCENSOS_PATCH . 'mostrar_usuarios.php');
?>

<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Gestión de Ascensos</h5>
            <ul class="nav nav-tabs card-header-tabs mt-2">
                <li class="nav-item mx-1">
                    <button class="nav-link active bg-dark text-white border-light" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" style="opacity: 1; transition: opacity 0.3s;">Disponibles</button>
                </li>
                <li class="nav-item mx-1">
                    <button class="nav-link bg-dark text-white border-light" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" style="opacity: 0.6; transition: opacity 0.3s;">En Espera</button>
                </li>
                <li class="nav-item mx-1">
                    <button class="nav-link bg-dark text-white border-light" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" style="opacity: 0.6; transition: opacity 0.3s;">Ascendidos</button>
                </li>
            </ul>
            <style>
                .nav-link.active {
                    opacity: 1 !important;
                }
                .nav-link:not(.active) {
                    opacity: 0.6 !important;
                }
                .nav-link:hover {
                    opacity: 0.8 !important;
                }
            </style>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                    <table class="table table-bordered table-striped table-hover text-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Rango Actual</th>
                                <th>Misión Actual</th>
                                <th>Estado</th>
                                <th>Próximo Ascenso</th>
                                <th>Transcurrido</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($GLOBALS['ascensos'] as $ascenso):
                                if ($ascenso['estado_ascenso'] === 'disponible') {
                                    $tiempoTranscurrido = '00:00:00';
                                    if (!empty($ascenso['fecha_ultimo_ascenso'])) {
                                        $fechaUltimo = new DateTime($ascenso['fecha_ultimo_ascenso']);
                                        $intervaloTranscurrido = $fechaUltimo->diff(new DateTime('now', new DateTimeZone('America/Mexico_City')));
                                        $tiempoTranscurrido = $intervaloTranscurrido->format('%H:%I:%S');
                                    }
                                ?>
                                    <tr data-codigo-time="<?= htmlspecialchars($ascenso['codigo_time']) ?>">
                                        <td><?= htmlspecialchars($ascenso['nombre_habbo']) ?></td>
                                        <td><?= htmlspecialchars($ascenso['rango_actual']) ?></td>
                                        <td><?= htmlspecialchars($ascenso['mision_actual']) ?></td>
                                        <td>
                                            <span class="badge <?= $ascenso['estado_ascenso'] === 'disponible' ? 'bg-success' : ($ascenso['estado_ascenso'] === 'pendiente' ? 'bg-warning' : ($ascenso['estado_ascenso'] === 'en_espera' ? 'bg-secondary' : 'bg-info')) ?>">
                                                <?= htmlspecialchars($ascenso['estado_ascenso']) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($ascenso['fecha_disponible_ascenso'] ? date('Y-m-d H:i:s', strtotime($ascenso['fecha_disponible_ascenso'])) : 'No disponible') ?></td>
                                        <td><?= htmlspecialchars($tiempoTranscurrido) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-codigo="<?= htmlspecialchars($ascenso['codigo_time']) ?>">
                                                Acciones
                                            </button>
                                        </td>
                                    </tr>
                                <?php } endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                        <table class="table table-bordered table-striped table-hover text-center mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Rango Actual</th>
                                    <th>Misión Actual</th>
                                    <th>Estado</th>
                                    <th>Próximo Ascenso</th>
                                    <th>Transcurrido</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($GLOBALS['ascensos'] as $ascenso):
                                    if ($ascenso['estado_ascenso'] === 'en_espera') {
                                        $tiempoTranscurrido = '00:00:00';
                                        if (!empty($ascenso['fecha_ultimo_ascenso'])) {
                                            $fechaUltimo = new DateTime($ascenso['fecha_ultimo_ascenso']);
                                            $intervaloTranscurrido = $fechaUltimo->diff(new DateTime('now', new DateTimeZone('America/Mexico_City')));
                                            $tiempoTranscurrido = $intervaloTranscurrido->format('%H:%I:%S');
                                        }
                                    ?>
                                        <tr data-codigo-time="<?= htmlspecialchars($ascenso['codigo_time']) ?>">
                                            <td><?= htmlspecialchars($ascenso['nombre_habbo']) ?></td>
                                            <td><?= htmlspecialchars($ascenso['rango_actual']) ?></td>
                                            <td><?= htmlspecialchars($ascenso['mision_actual']) ?></td>
                                            <td>
                                                <span class="badge <?= $ascenso['estado_ascenso'] === 'disponible' ? 'bg-success' : ($ascenso['estado_ascenso'] === 'pendiente' ? 'bg-warning' : ($ascenso['estado_ascenso'] === 'en_espera' ? 'bg-secondary' : 'bg-info')) ?>">
                                                    <?= htmlspecialchars($ascenso['estado_ascenso']) ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($ascenso['fecha_disponible_ascenso'] ? date('Y-m-d H:i:s', strtotime($ascenso['fecha_disponible_ascenso'])) : 'No disponible') ?></td>
                                            <td><?= htmlspecialchars($tiempoTranscurrido) ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-codigo="<?= htmlspecialchars($ascenso['codigo_time']) ?>">
                                                    Actualizar
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                            <table class="table table-bordered table-striped table-hover text-center mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Rango Actual</th>
                                        <th>Misión Actual</th>
                                        <th>Estado</th>
                                        <th>Próximo Ascenso</th>
                                        <th>Transcurrido</th>
                                        <th>Actualizar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($GLOBALS['ascensos'] as $ascenso):
                                        if ($ascenso['estado_ascenso'] === 'ascendido') {
                                            $tiempoTranscurrido = '00:00:00';
                                            if (!empty($ascenso['fecha_ultimo_ascenso'])) {
                                                $fechaUltimo = new DateTime($ascenso['fecha_ultimo_ascenso']);
                                                $intervaloTranscurrido = $fechaUltimo->diff(new DateTime('now', new DateTimeZone('America/Mexico_City')));
                                                $tiempoTranscurrido = $intervaloTranscurrido->format('%H:%I:%S');
                                            }
                                        ?>
                                            <tr data-codigo-time="<?= htmlspecialchars($ascenso['codigo_time']) ?>">
                                                <td><?= htmlspecialchars($ascenso['nombre_habbo']) ?></td>
                                                <td><?= htmlspecialchars($ascenso['rango_actual']) ?></td>
                                                <td><?= htmlspecialchars($ascenso['mision_actual']) ?></td>
                                                <td>
                                                    <span class="badge <?= $ascenso['estado_ascenso'] === 'disponible' ? 'bg-success' : ($ascenso['estado_ascenso'] === 'pendiente' ? 'bg-warning' : ($ascenso['estado_ascenso'] === 'en_espera' ? 'bg-secondary' : 'bg-info')) ?>">
                                                        <?= htmlspecialchars($ascenso['estado_ascenso']) ?>
                                                    </span>
                                                </td>
                                                <td><?= htmlspecialchars($ascenso['fecha_disponible_ascenso'] ? date('Y-m-d H:i:s', strtotime($ascenso['fecha_disponible_ascenso'])) : 'No disponible') ?></td>
                                                <td><?= htmlspecialchars($tiempoTranscurrido) ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" data-codigo="<?= htmlspecialchars($ascenso['codigo_time']) ?>">
                                                        Actualizar
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php } endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
</div>

