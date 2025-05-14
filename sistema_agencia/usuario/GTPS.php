<?php
// RUTAS DE GESTION DE PAGAS
require_once(GESTION_PAGAS_PATCH . 'mostrar_usuarios.php'); // MOSTRAR USUARIOS
?>

<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="text-primary">
            GESTION DE PAGAS DE USUARIOS
        </h1>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Total Usuarios</h6>
                        <h4 class="mb-0"><?php echo count(array_unique(array_column($pagas, 'pagas_usuario'))); ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-currency-dollar fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Total Pagado</h6>
                        <h4 class="mb-0"><?php echo array_sum(array_column($pagas, 'pagas_recibio')); ?> créditos</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Gestión de pagos</h5>
            </div>
            <div class="card-body">
                <table id="pagasTable" class="table table-bordered table-striped table-hover text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Usuario</th>
                            <th>Rango</th>
                            <th>Recibió</th>
                            <th>Motivo</th>
                            <th>Completo</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagas as $paga): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($paga['pagas_usuario']); ?></td>
                                <td><?php echo htmlspecialchars($paga['pagas_rango']); ?></td>
                                <td><?php echo htmlspecialchars($paga['pagas_recibio']); ?> c</td>
                                <td><?php echo htmlspecialchars($paga['pagas_motivo']); ?></td>
                                <td>
                                    <span class="badge <?php echo $paga['pagas_completo'] ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $paga['pagas_completo'] ? 'Completo' : 'Pendiente'; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($paga['pagas_descripcion'] ?? 'No disponible'); ?></td>
                                <td><?php echo htmlspecialchars(explode(' ', $paga['pagas_fecha_registro'])[0]); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JS DE GESTION DE PAGAS -->
<script src="/public/assets/custom_general/custom_gestion_pagas/gestion_pagas.js"></script>
