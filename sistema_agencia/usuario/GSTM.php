<?php 

// Rutas para gestion de tiempos
require_once(GESTION_TIEMPO_PATCH . 'mostrar_usuarios.php');
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Gestión de Tiempos</h5>
        </div>
        <div class="card-body">
            <table id="datatable" class="datatable-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Status</th>
                        <th>Tiempo Restado</th>
                        <th>Tiempo Acumulado</th>
                        <th>Tiempo Transcurrido</th>
                        <th>Fecha Registro</th>
                        <th>Encargado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($GLOBALS['tiempos'] as $tiempo): ?>
                    <tr>
                        <td><?= $tiempo['codigo_time'] ?></td>
                        <td><?= $tiempo['tiempo_status'] ?></td>
                        <td><?= $tiempo['tiempo_restado'] ?></td>
                        <td><?= $tiempo['tiempo_acumulado'] ?></td>
                        <td><?= $tiempo['tiempo_transcurrido'] ?></td>
                        <td><?= $tiempo['tiempo_fecha_registro'] ?></td>
                        <td><?= $tiempo['tiempo_encargado_usuario'] ?? 'No disponible' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>