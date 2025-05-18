<?php
require_once(GESTION_ASCENSOS_PATCH . 'mostrar_usuarios.php');
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Gestión de Ascensos</h5>
        </div>
        <div class="card-body">
            <table id="ascensosTable" class="table table-striped table-hover">
                <thead>
                    <tr class="text-white">
                        <th>ID</th>
                        <th>Código TIME</th>
                        <th>Nombre Habbo</th>
                        <th>Rango Actual</th>
                        <th>Misión Actual</th>
                        <th>Estado Ascenso</th>
                        <th>Fecha Disponible</th>
                        <th>Tiempo Transcurrido</th>
                        <th>Encargado</th>
                        <th>Es Recluta</th>
                        <!-- Puedes añadir más columnas si es necesario -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ascensos)): ?>
                        <?php foreach ($ascensos as $ascenso): ?>
                            <tr>
                                <td><?= htmlspecialchars($ascenso['ascenso_id']) ?></td>
                                <td><?= htmlspecialchars($ascenso['codigo_time']) ?></td>
                                <td><?= htmlspecialchars($ascenso['nombre_habbo']) ?></td>
                                <td><?= htmlspecialchars($ascenso['rango_actual']) ?></td>
                                <td><?= htmlspecialchars($ascenso['mision_actual']) ?></td>
                                <td>
                                    <span class="badge <?= strtolower($ascenso['estado_ascenso']) === 'pendiente' ? 'bg-warning' : (strtolower($ascenso['estado_ascenso']) === 'completado' ? 'bg-success' : 'bg-secondary') ?>">
                                        <?= htmlspecialchars(ucfirst(strtolower($ascenso['estado_ascenso']))) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($ascenso['fecha_disponible_ascenso']) ?></td>
                                <td><?= htmlspecialchars($ascenso['tiempo_ascenso']) ?></td>
                                <td><?= htmlspecialchars($ascenso['usuario_encargado']) ?></td>
                                <td><?= $ascenso['es_recluta'] ? 'Sí' : 'No' ?></td>
                                <!-- Añade más celdas según las columnas -->
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">No hay datos de ascensos disponibles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script para inicializar simple-datatables -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dataTable = new simpleDatatables.DataTable("#ascensosTable", {
            searchable: true,
            fixedHeight: true,
            perPage: 10, // Número de filas por página
            perPageSelect: [10, 25, 50, 100],
            labels: {
                placeholder: "Buscar...",
                perPage: "registros por página",
                noRows: "No se encontraron registros",
                info: "Mostrando {start} a {end} de {rows} registros",
                loading: "Cargando...",
                infoFiltered: " (filtrado de {rows} registros totales)",
                next: "Siguiente",
                previous: "Anterior"
            }
        });
    });
</script>