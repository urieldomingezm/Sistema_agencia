<?php
// RUTAS DE GESTION DE VENTAS DE RANGOS Y TRASLADOS
require_once(PROCESO_VENTAS_RANGOS_PACTH . 'mostrar_informacion.php');

class VentaRangosDashboard {
    private $rangos;
    
    public function __construct(array $rangos) {
        $this->rangos = $rangos;
    }
    
    public function calcularEstadisticas(): array {
        $totalRangos = count($this->rangos);
        $totalCreditosRangos = array_reduce($this->rangos, fn($carry, $item) => $carry + (float)$item['rangov_costo'], 0);
        
        return [
            'total_rangos' => $totalRangos,
            'total_creditos_rangos' => $totalCreditosRangos,
            'total_general' => $totalCreditosRangos
        ];
    }
    
    public function formatearNumero(float $numero): string {
        return number_format($numero, 0, ',', '.');
    }
    
    public function render(): void {
        $stats = $this->calcularEstadisticas();
        ?>
        <div class="container mt-4">
            <!-- Tarjetas de Resumen -->
            <div class="row g-3 mb-4">
                <?php 
                $cards = [
                    [
                        'icon' => 'person-badge', 
                        'title' => 'Ventas de Rangos', 
                        'value' => $stats['total_rangos'], 
                        'bg' => 'primary',
                        'text' => 'white'
                    ],
                    [
                        'icon' => 'cash-coin', 
                        'title' => 'Total Créditos', 
                        'value' => $this->formatearNumero($stats['total_creditos_rangos']), 
                        'bg' => 'light',
                        'text' => 'dark'
                    ],
                    [
                        'icon' => 'graph-up', 
                        'title' => 'Promedio por Venta', 
                        'value' => $stats['total_rangos'] > 0 ? 
                                   $this->formatearNumero($stats['total_creditos_rangos'] / $stats['total_rangos']) : 0, 
                        'bg' => 'info',
                        'text' => 'white'
                    ],
                    [
                        'icon' => 'calendar-check', 
                        'title' => 'Última Venta', 
                        'value' => !empty($this->rangos) ? 
                                   date('d/m/Y', strtotime(end($this->rangos)['rangov_fecha'])) : 'N/A', 
                        'bg' => 'success',
                        'text' => 'white'
                    ]
                ];
                
                foreach ($cards as $card): ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="card bg-<?= $card['bg'] ?> text-<?= $card['text'] ?> shadow-sm h-100">
                            <div class="card-body text-center">
                                <div class="mb-2">
                                    <i class="bi bi-<?= $card['icon'] ?> fs-1"></i>
                                </div>
                                <h5 class="card-title"><?= $card['title'] ?></h5>
                                <p class="card-text display-6"><?= $card['value'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Tabla de Ventas -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Historial de Ventas de Rangos</h4>
                        <div>
                            <button class="btn btn-sm btn-light" id="exportExcel">
                                <i class="bi bi-file-excel"></i> Exportar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="ventasRangosTable" class="table table-hover table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="15%">Fecha</th>
                                    <th width="10%">Tipo</th>
                                    <th width="20%">Comprador</th>
                                    <th width="20%">Vendedor</th>
                                    <th width="15%">Costo</th>
                                    <th width="15%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->rangos as $rango): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($rango['rangov_id']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($rango['rangov_fecha'])) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $this->getBadgeColor($rango['rangov_tipo']) ?>">
                                                <?= htmlspecialchars($rango['rangov_tipo']) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($rango['rangov_comprador']) ?></td>
                                        <td><?= htmlspecialchars($rango['rangov_vendedor']) ?></td>
                                        <td class="fw-bold">
                                            <?= $this->formatearNumero($rango['rangov_costo']) ?> CR
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary detalles-btn" 
                                                    data-id="<?= $rango['rangov_id'] ?>">
                                                <i class="bi bi-eye"></i> Detalles
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold"><?= $this->formatearNumero($stats['total_creditos_rangos']) ?> CR</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Detalles -->
        <div class="modal fade" id="detallesModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Detalles de Venta</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="detallesContent">
                        <!-- Contenido cargado por AJAX -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Inicializar DataTable
                $('#ventasRangosTable').DataTable({
                    dom: '<"top"lf>rt<"bottom"ip>',
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                    },
                    order: [[0, 'desc']],
                    responsive: true
                });
                
                // Exportar a Excel
                $('#exportExcel').click(function() {
                    $('#ventasRangosTable').table2excel({
                        filename: "Ventas_Rangos_" + new Date().toLocaleDateString()
                    });
                });
                
                // Mostrar detalles
                $('.detalles-btn').click(function() {
                    const id = $(this).data('id');
                    $('#detallesContent').load('/procesos/ventas/rangos/detalles.php?id=' + id, function() {
                        $('#detallesModal').modal('show');
                    });
                });
            });
        </script>
        <?php
    }
    
    private function getBadgeColor(string $tipo): string {
        $colors = [
            'Venta' => 'success',
            'Traslado' => 'info',
            'Promoción' => 'warning',
            'default' => 'secondary'
        ];
        
        return $colors[$tipo] ?? $colors['default'];
    }
}

// Uso de la clase
$dashboard = new VentaRangosDashboard($rangos);
$dashboard->render();
?>