<?php
require_once(GESTION_VENTAS_PATCH . 'mostrar_ventas.php');
require_once(GESTION_RENOVAR_VENTA_PATCH . 'renovar.php');
require_once(GESTION_RENOVAR_VENTA_PATCH . 'eliminar.php');

// RUTAS DE GESTION DE VENTAS DE RANGOS Y TRASLADOS
require_once(PROCESO_VENTAS_RANGOS_PACTH . 'mostrar_informacion.php');


// Calcular estadísticas de resumen para Ventas de Membresías
$totalVentas = count($ventas);
$ventasActivas = 0;
$ventasCaducadas = 0;
$totalCreditosMembresias = 0; // Renombrado para claridad

foreach ($ventas as $venta) {
    if (strtolower($venta['venta_estado']) === 'activo') {
        $ventasActivas++;
    } elseif (strtolower($venta['venta_estado']) === 'caducado') {
        $ventasCaducadas++;
    }
    $totalCreditosMembresias += (float) $venta['venta_costo'];
}

// Calcular estadísticas de resumen para Rangos y Traslados
$totalRangos = count($rangos);
$totalCreditosRangos = 0;

foreach ($rangos as $rango) {
    $totalCreditosRangos += (float) $rango['rangov_costo'];
}

// Calcular total de créditos general
$totalCreditosGeneral = $totalCreditosMembresias;

?>

<div class="container mt-4">
    <div class="row g-2">
        <?php
        $cards = [
            ['icon' => 'cart-fill', 'title' => 'Membresías', 'value' => $totalVentas, 'bg' => 'primary'],
            ['icon' => 'check-circle', 'title' => 'Activas', 'value' => $ventasActivas, 'bg' => 'success'],
            ['icon' => 'x-circle', 'title' => 'Vencidas', 'value' => $ventasCaducadas, 'bg' => 'danger'],
            ['icon' => 'currency-dollar', 'title' => 'Créd. Memb.', 'value' => number_format($totalCreditosMembresias, 0, ',', '.'), 'bg' => 'info'],
        ];

        foreach ($cards as $card): ?>
            <div class="col-md-3 col-sm-6">
                <div class="card text-white bg-<?= $card['bg'] ?>">
                    <div class="card-body p-2">
                        <i class="bi bi-<?= $card['icon'] ?>"></i>
                        <span class="h6"><?= $card['title'] ?></span>
                        <div class="h4 mb-0"><?= $card['value'] ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <br>

    <!-- Acordeón para las tablas -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="ventasTable" class="table table-striped table-hover w-100">
                    <thead>
                        <tr class="text-white">
                            <th>Membresia</th>
                            <th>Estado</th>
                            <th>Compra</th>
                            <th>Caducidad</th>
                            <th>Costo</th>
                            <th>Comprador</th>
                            <th>Encargado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventas as $venta): ?>
                            <tr>
                                <td><?= htmlspecialchars($venta['venta_titulo']) ?></td>
                                <td>
                                    <span class="badge <?= strtolower($venta['venta_estado']) === 'activo' ? 'bg-success' : 'bg-danger' ?>">
                                        <?= htmlspecialchars(ucfirst(strtolower($venta['venta_estado']))) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($venta['venta_compra']) ?></td>
                                <td><?= htmlspecialchars($venta['venta_caducidad']) ?></td>
                                <td><?= htmlspecialchars($venta['venta_costo']) ?></td>
                                <td>
                                    <?php
                                    if ($venta['venta_comprador'] !== null) {
                                        echo htmlspecialchars($venta['nombre_habbo_registrado'] ?: 'Usuario no encontrado');
                                    } else {
                                        echo htmlspecialchars($venta['comprador_externo'] ?: 'No disponible');
                                    }
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($venta['venta_encargado']) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-success btn-sm" onclick="renovarVenta(<?= $venta['venta_id'] ?>)" title="Renovar">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="confirmarEliminarVenta(<?= $venta['venta_id'] ?>)" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="/public/assets/custom_general/custom_ventas/ventas.js"></script>