<?php
require_once(CONFIG_PATH . 'bd.php');
$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['codigo_time'])) {
    $codigo_time = $_GET['codigo_time'];

    $query = "SELECT historial_id, ascenso_id, codigo_time, mision_anterior, mision_nueva, firma_encargado, usuario_encargado, fecha_ascenso 
              FROM historial_ascensos 
              WHERE codigo_time = :codigo_time 
              ORDER BY fecha_ascenso DESC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':codigo_time', $codigo_time);
    $stmt->execute();
    $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="modal fade" id="historialAscensosModal" tabindex="-1" aria-labelledby="historialAscensosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="historialAscensosModalLabel">Historial de Ascensos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($historial)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Ascenso</th>
                                <th>Misión Anterior</th>
                                <th>Misión Nueva</th>
                                <th>Firma Encargado</th>
                                <th>Encargado</th>
                                <th>Fecha de Ascenso</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historial as $ascenso): ?>
                            <tr>
                                <td><?= htmlspecialchars($ascenso['ascenso_id']) ?></td>
                                <td><?= htmlspecialchars($ascenso['mision_anterior']) ?></td>
                                <td><?= htmlspecialchars($ascenso['mision_nueva']) ?></td>
                                <td><?= htmlspecialchars($ascenso['firma_encargado']) ?></td>
                                <td><?= htmlspecialchars($ascenso['usuario_encargado']) ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($ascenso['fecha_ascenso']))) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="alert alert-info">No se encontraron ascensos registrados para este usuario.</div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>