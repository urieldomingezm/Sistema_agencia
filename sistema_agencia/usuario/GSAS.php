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
                        <th>Código</th>
                        <th>Rango Actual</th>
                        <th>Misión Actual</th>
                        <th>Estado</th>
                        <th>Próximo Ascenso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($GLOBALS['ascensos'] as $ascenso): ?>
                    <tr>
                        <td><?= htmlspecialchars($ascenso['codigo_time']) ?></td>
                        <td><?= htmlspecialchars($ascenso['rango_actual']) ?></td>
                        <td><?= htmlspecialchars($ascenso['mision_actual']) ?></td>
                        <td>
                            <span class="badge <?= $ascenso['estado_ascenso'] === 'disponible' ? 'bg-success' : 'bg-warning' ?>">
                                <?= htmlspecialchars($ascenso['estado_ascenso']) ?>
                            </span>
                        </td>
                        <td data-fecha-ascenso="<?= htmlspecialchars($ascenso['fecha_disponible_ascenso']) ?>">
                            <?= htmlspecialchars($ascenso['fecha_disponible_ascenso'] ? date('H:i:s', strtotime($ascenso['fecha_disponible_ascenso'])) : 'No disponible') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabla = document.querySelector("#datatable");
        new simpleDatatables.DataTable(tabla, {
            perPage: 3,
            perPageSelect: [3, 5, 10],
            labels: {
                placeholder: "Buscar...",
                perPage: "{select} registros por página",
                noRows: "No hay registros disponibles",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });
    });

    
</script>



</div>
<script src="GSAS.js"></script>
</body>
</html>

