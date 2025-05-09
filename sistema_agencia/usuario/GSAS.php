<?php 
// Rutas para gestion de ascensos
require_once(GESTION_ASCENSOS_PATCH . 'mostrar_usuarios.php');
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
$(document).ready(function() {
    // Para cada fila de la tabla
    $('#datatable tbody tr').each(function() {
        var $row = $(this);
        var $tdFecha = $row.find('td[data-fecha-ascenso]');
        var $tdEstado = $row.find('td').eq(3); // Estado está en la cuarta columna
        var $badge = $tdEstado.find('.badge');
        var fechaAscenso = $tdFecha.data('fecha-ascenso');
        
        // Si no hay fecha, saltar
        if (!fechaAscenso || fechaAscenso === 'No disponible') return;

        // Convertir la hora a segundos
        function timeToSeconds(timeStr) {
            var parts = timeStr.split(':');
            if (parts.length !== 3) return 0;
            return parseInt(parts[0],10)*3600 + parseInt(parts[1],10)*60 + parseInt(parts[2],10);
        }

        var segundosRestantes = timeToSeconds(fechaAscenso);

        // Si ya está en 00:00:00, poner en espera
        if (segundosRestantes <= 0) {
            $tdFecha.text('00:00:00');
            $badge.removeClass('bg-success bg-warning').addClass('bg-secondary');
            $badge.text('en_espera');
            return;
        }

        // Cambiar estado a pendiente si está corriendo el tiempo
        $badge.removeClass('bg-success').addClass('bg-warning');
        $badge.text('pendiente');

        // Iniciar temporizador
        var interval = setInterval(function() {
            if (segundosRestantes > 0) {
                segundosRestantes--;
                // Formatear a HH:mm:ss
                var h = String(Math.floor(segundosRestantes/3600)).padStart(2,'0');
                var m = String(Math.floor((segundosRestantes%3600)/60)).padStart(2,'0');
                var s = String(segundosRestantes%60).padStart(2,'0');
                $tdFecha.text(h+':'+m+':'+s);
            }
            if (segundosRestantes <= 0) {
                clearInterval(interval);
                $tdFecha.text('00:00:00');
                $badge.removeClass('bg-success bg-warning').addClass('bg-secondary');
                $badge.text('en_espera');
            }
        }, 1000);
    });
});
</script>
