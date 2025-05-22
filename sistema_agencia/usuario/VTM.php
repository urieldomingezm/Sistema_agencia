<?php
require_once(GESTION_VENTAS_PATCH . 'mostrar_ventas.php');
require_once(GESTION_RENOVAR_VENTA_PATCH . 'renovar.php');
require_once(GESTION_RENOVAR_VENTA_PATCH . 'eliminar.php');
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

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4 align-items-center justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="h3 mb-0 text-primary fw-bold">
                <i class="bi bi-cart-fill me-2"></i>Gestión de Ventas de Membresías
            </h1>
        </div>
    </div>

    <!-- Tarjetas resumen -->
    <div class="row mb-4 g-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-primary border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Total Ventas</h6>
                            <h2 class="mb-0 fw-bold"><?= $totalVentas ?></h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-cart-fill fs-3 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-success border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Activas</h6>
                            <h2 class="mb-0 fw-bold"><?= $ventasActivas ?></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-danger border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Vencidas</h6>
                            <h2 class="mb-0 fw-bold"><?= $ventasCaducadas ?></h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded">
                            <i class="bi bi-x-circle-fill fs-3 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-info border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Obtenidos</h6>
                            <h2 class="mb-0 fw-bold"><?= number_format($totalCreditosMembresias, 0, ',', '.') ?></h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-currency-dollar fs-3 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de ventas -->
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">
                <i class="bi bi-table me-2"></i>Listado de Ventas
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="ventasTable" class="table table-striped table-hover w-100">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center">Membresía</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Compra</th>
                            <th class="text-center">Caducidad</th>
                            <th class="text-center">Costo</th>
                            <th class="text-center">Comprador</th>
                            <th class="text-center">Encargado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventas as $venta): ?>
                            <tr class="align-middle">
                                <td class="text-center"><?= htmlspecialchars($venta['venta_titulo']) ?></td>
                                <td class="text-center">
                                    <span class="badge <?= strtolower($venta['venta_estado']) === 'activo' ? 'bg-success' : 'bg-danger' ?>">
                                        <?= htmlspecialchars(ucfirst(strtolower($venta['venta_estado']))) ?>
                                    </span>
                                </td>
                                <td class="text-center"><?= htmlspecialchars($venta['venta_compra']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($venta['venta_caducidad']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($venta['venta_costo']) ?></td>
                                <td class="text-center">
                                    <?php
                                    if ($venta['venta_comprador'] !== null) {
                                        echo htmlspecialchars($venta['nombre_habbo_registrado'] ?: 'Usuario no encontrado');
                                    } else {
                                        echo htmlspecialchars($venta['comprador_externo'] ?: 'No disponible');
                                    }
                                    ?>
                                </td>
                                <td class="text-center"><?= htmlspecialchars($venta['venta_encargado']) ?></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button class="btn btn-sm btn-outline-success" onclick="renovarVenta(<?= $venta['venta_id'] ?>)" title="Renovar">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="confirmarEliminarVenta(<?= $venta['venta_id'] ?>)" title="Eliminar">
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