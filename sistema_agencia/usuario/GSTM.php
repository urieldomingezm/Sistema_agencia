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
            <table id="datatable_tiempos" class="table table-bordered table-striped table-hover text-center mb-0">
                <thead>
                    <tr>
                        <th>Habbo</th>
                        <th>Estado</th>
                        <th>Restado</th>
                        <th>Acumulado</th>
                        <th>Iniciado</th>
                        <th>Encargado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($GLOBALS['tiempos'] as $tiempo): ?>
                        <tr>
                            <td><?= $tiempo['habbo_name'] ?></td>
                            <td>
                                <?php
                                $status = $tiempo['tiempo_status'];
                                $badge_class = '';
                                $status_text = '';

                                switch (strtolower($status)) {
                                    case 'pausa':
                                        $badge_class = 'warning';
                                        $status_text = 'Pausa';
                                        break;
                                    case 'completado':
                                        $badge_class = 'success';
                                        $status_text = 'Completado';
                                        break;
                                    case 'ausente':
                                        $badge_class = 'danger';
                                        $status_text = 'Ausente';
                                        break;
                                    case 'terminado':
                                        $badge_class = 'info';
                                        $status_text = 'Terminado';
                                        break;
                                    case 'activo':
                                        $badge_class = 'success';
                                        $status_text = 'Activo';
                                        break;
                                    default:
                                        $badge_class = 'secondary';
                                        $status_text = $status;
                                }
                                ?>
                                <span class="badge bg-<?= $badge_class ?>"><?= $status_text ?></span>
                            </td>
                            <td><?= $tiempo['tiempo_restado'] ?></td>
                            <td><?= $tiempo['tiempo_acumulado'] ?></td>
                            <td><?= $tiempo['tiempo_iniciado'] ?></td>
                            <td><?= $tiempo['tiempo_encargado_usuario'] ?? 'No disponible' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTable
        const dataTable = new simpleDatatables.DataTable("#datatable_tiempos", {
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