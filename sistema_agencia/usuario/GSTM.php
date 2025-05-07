<?php 
// RUTA PROCESO PARA MOSTRAR TODOS LOS USUARIOS EN LA TABLA DE GESTION DE TIEMPOS
require_once(GESTION_TIEMPO_PATCH . 'mostrar_usuarios.php');

// RUTA DE MODALES PARA GESTION DE TIEMPOS PARA ACCIONES DE GESTION DE TIEMPOS: AUSENTE, PAUSAR, COMPLETADO, INICIAR Y FINALIZAR
?>

<table id="datatable" class="datatable-table table table-striped">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Status</th>
            <th>Restado</th>
            <th>Acumulado</th>
            <th>Transcurrido</th>
            <th>Registro</th>
            <th>Encargado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($GLOBALS['tiempos'] as $tiempo): ?>
        <tr>
            <td><?= $tiempo['nombre_habbo'] ?? $tiempo['codigo_time'] ?></td>
            <td>
                <span class="badge <?php
                    switch($tiempo['tiempo_status']) {
                        case 'corriendo':
                            echo 'bg-success';
                            break;
                        case 'pausado':
                            echo 'bg-warning';
                            break;
                        case 'ausente':
                            echo 'bg-danger';
                            break;
                        case 'completado':
                            echo 'bg-purple';
                            break;
                        default:
                            echo 'bg-secondary';
                    }
                ?>">
                    <?= $tiempo['tiempo_status'] ?>
                </span>
            </td>
            <td><?= $tiempo['tiempo_restado'] ?></td>
            <td><?= $tiempo['tiempo_acumulado'] ?></td>
            <td><?= $tiempo['tiempo_transcurrido'] ?></td>
            <td><?= date('Y-m-d', strtotime($tiempo['tiempo_fecha_registro'])) ?></td>
            <td><?= $tiempo['tiempo_encargado_usuario'] ?? 'No disponible' ?></td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown<?= $tiempo['codigo_time'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                        Acciones
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="actionDropdown<?= $tiempo['codigo_time'] ?>">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#iniciarModal" data-id="<?= $tiempo['codigo_time'] ?>">Iniciar</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#pausarModal" data-id="<?= $tiempo['codigo_time'] ?>">Pausar</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ausenteModal" data-id="<?= $tiempo['codigo_time'] ?>">Ausente</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#completadoModal" data-id="<?= $tiempo['codigo_time'] ?>">Completado</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#finalizarModal" data-id="<?= $tiempo['codigo_time'] ?>">Finalizar</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>