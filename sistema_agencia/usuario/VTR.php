<?php

// RUTAS DE GESTION DE VENTAS DE RANGOS Y TRASLADOS
require_once(PROCESO_VENTAS_RANGOS_PACTH.'mostrar_informacion.php'); // MOSTRAR USUARIOS

?>

<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="text-primary">
            GESTION DE VENTAS DE RANGOS Y TRASLADOS
        </h1>
    </div>

    <!-- Tabla de Pagas -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="pagasTable" class="table table-bordered table-striped table-hover text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Rango Anterior</th>
                            <th>Misión Anterior</th>
                            <th>Rango Nuevo</th>
                            <th>Misión Nueva</th>
                            <th>Comprador</th>
                            <th>Vendedor</th>
                            <th>Fecha</th>
                            <th>Firma Usuario</th>
                            <th>Firma Encargado</th>
                            <th>Costo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rangos as $rango): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rango['rangov_id']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_tipo']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_rango_anterior']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_mision_anterior']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_rango_nuevo']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_mision_nuevo']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_comprador']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_vendedor']); ?></td>
                                <td><?php echo htmlspecialchars(explode(' ', $rango['rangov_fecha'])[0]); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_firma_usuario']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_firma_encargado']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_costo']); ?></td>
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
        const dataTable = new simpleDatatables.DataTable("#pagasTable", {
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