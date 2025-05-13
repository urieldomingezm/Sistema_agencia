<?php
require_once(GESTION_ASCENSOS_PATCH . 'mostrar_usuarios.php');
?>

<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Gestión de Ascensos</h5>
        </div>
        <div class="card-body">
            <table id="tabladeusuariosascensos" class="table table-bordered table-striped table-hover text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Código</th>
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
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

