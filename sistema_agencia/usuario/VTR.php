<?php

// RUTAS DE GESTION DE VENTAS DE RANGOS Y TRASLADOS
require_once(PROCESO_VENTAS_RANGOS_PACTH . 'mostrar_informacion.php');

?>

<div class="container py-4">
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">RANGOS Y TRASLADOS</h5>
            </div>
            <div class="card-body">
                <table id="VentasRangos" class="table table-bordered table-striped table-hover text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Comprador</th>
                            <th>Vendedor</th>
                            <th>Costo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rangos as $rango): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rango['rangov_id']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_tipo']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_comprador']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_vendedor']); ?></td>
                                <td><?php echo htmlspecialchars($rango['rangov_costo']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- CUSTOM JS PARA TABLA RANGOS VENDIDOS -->
<script src="/public/assets/custom_general/custom_ventas_rangos/venta_rangos.js"></script>