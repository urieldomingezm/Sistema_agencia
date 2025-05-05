<?php 

// Rutas para gestion de ascensos
require_once(GESTION_ASCENSOS_PATCH . 'mostrar_usuarios.php');

// Rutas a modales de gestion de ascensos
require_once(DAR_ASCENSO_PATCH . 'informacion_cliente.php');

?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Gestión de Ascensos</h5>
        </div>
        <div class="card-body">
            <table id="datatable" class="datatable-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Rango Actual</th>
                        <th>Misión Actual</th>
                        <th>Estado</th>
                        <th>Próximo Ascenso</th>
                        <th>Encargado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($GLOBALS['ascensos'] as $ascenso): ?>
                    <tr>
                        <td><?= htmlspecialchars($ascenso['usuario_registro']) ?></td>
                        <td><?= htmlspecialchars($ascenso['rango_actual']) ?></td>
                        <td><?= htmlspecialchars($ascenso['mision_actual']) ?></td>
                        <td>
                            <span class="badge <?= $ascenso['estado_ascenso'] === 'disponible' ? 'bg-success' : 'bg-warning' ?>">
                                <?= htmlspecialchars($ascenso['estado_ascenso']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars(date('h:i A', strtotime($ascenso['fecha_disponible_ascenso']))) ?></td>
                        <td><?= htmlspecialchars($ascenso['usuario_encargado'] ?? 'No disponible') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
