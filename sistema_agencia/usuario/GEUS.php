<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    $query = "SELECT h.id, r.usuario_registro, r.nombre_habbo, r.rango, 
              h.verificado_por, h.fecha_verificacion, h.estado_verificacion
              FROM historial_verificaciones h
              INNER JOIN registro_usuario r ON h.usuario_id = r.id
              ORDER BY h.fecha_verificacion DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $verificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
    $verificaciones = [];
}
?>

<div class="container-fluid mt-4">
    <div class="card shadow">
        <div class="card-header bg-gradient-primary">
            <h5 class="text-white mb-0">
                <i class="fas fa-history me-2"></i>Historial de Verificaciones
            </h5>
        </div>
        <div class="card-body">
            <table id="historialTable" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre Habbo</th>
                        <th>Rango</th>
                        <th>Verificado Por</th>
                        <th>Fecha Verificación</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($verificaciones as $verificacion): ?>
                        <tr>
                            <td><?= $verificacion['id'] ?></td>
                            <td><?= htmlspecialchars($verificacion['usuario_registro']) ?></td>
                            <td><?= htmlspecialchars($verificacion['nombre_habbo']) ?></td>
                            <td><?= htmlspecialchars($verificacion['rango']) ?></td>
                            <td><?= htmlspecialchars($verificacion['verificado_por']) ?></td>
                            <td><?= $verificacion['fecha_verificacion'] ?></td>
                            <td>
                                <?php if ($verificacion['estado_verificacion'] == 1): ?>
                                    <span class="badge bg-success">Verificado</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rechazado</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        new simpleDatatables.DataTable("#historialTable", {
            searchable: true,
            fixedHeight: true,
            perPage: 10,
            labels: {
                placeholder: "Buscar en el historial...",
                perPage: "Mostrar registros",
                noRows: "No se encontraron registros",
                info: "Mostrando {start} a {end} de {rows} registros",
                noResults: "No hay resultados"
            }
        });
    });
</script>

<style>
    .badge {
        font-size: 0.875rem;
    }
</style>