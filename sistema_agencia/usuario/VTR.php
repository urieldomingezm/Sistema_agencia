<?php
// RUTAS DE GESTION DE VENTAS DE RANGOS Y TRASLADOS
require_once(PROCESO_VENTAS_RANGOS_PACTH . 'mostrar_informacion.php');

// Calcular estadísticas de resumen para Rangos y Traslados
$totalRangos = count($rangos);
$totalCreditosRangos = 0;

foreach ($rangos as $rango) {
    $totalCreditosRangos += (float) $rango['rangov_costo'];
}

// Calcular total de créditos general para esta página (solo rangos)
$totalCreditosGeneral = $totalCreditosRangos;

?>

<div class="container mt-4">
    <div class="row g-2">
        <?php
        $cards = [
            ['icon' => 'person-badge', 'title' => 'Rangos', 'value' => $totalRangos, 'bg' => 'secondary'],
            ['icon' => 'cash-coin', 'title' => 'Créd. Rangos', 'value' => number_format($totalCreditosRangos, 0, ',', '.'), 'bg' => 'warning'],
            ['icon' => 'wallet2', 'title' => 'Total Gral.', 'value' => number_format($totalCreditosGeneral, 0, ',', '.'), 'bg' => 'dark']
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

    <!-- Tabla para Rangos y Traslados -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="pagasTable" class="table table-striped table-hover w-100">
                    <thead>
                        <tr class="text-white">
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


<script src="/public/assets/custom_general/custom_ventas/rangos.js"></script>