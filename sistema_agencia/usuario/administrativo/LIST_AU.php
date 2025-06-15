<?php require_once(USUARIO_LISTA_PATH . 'mostrar_usuarios.php'); ?>

<head>
    <meta name="keywords" content="Lista de usuarios registrados, gestión de usuarios, registro de usuarios">
</head>

<div class="container-fluid mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="bi bi-person-plus me-2"></i>Lista de Usuarios Registrados</h3>
            <button class="btn btn-light btn-lg" 
                    id="Ayuda_registro_usuario-tab" 
                    data-bs-toggle="modal" 
                    data-bs-target="#Ayuda_registro_usuario">
                <i class="bi bi-question-circle-fill me-1"></i> Ayuda
            </button>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="registroUsuarioTable" class="table table-striped table-bordered align-middle mb-0" style="width:100%; font-size: 1.1rem;">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center fs-5">ID</th>
                            <th class="text-center fs-5">Usuario</th>
                            <th class="text-center fs-5">Fecha Registro</th>
                            <th class="text-center fs-5">IP Registro</th>
                            <th class="text-center fs-5">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registroUsuarios as $registro): 
                            $id = $registro['id'] ?? '';
                            $usuario_registro = $registro['usuario_registro'] ?? '';
                            $fecha_registro = $registro['fecha_registro'] ?? '';
                            $ip_registro = $registro['ip_registro'] ?? '';
                            $codigo_time = $registro['codigo_time'] ?? '';
                            $ip_bloqueo = $registro['ip_bloqueo'] ?? '';
                            
                            // Procesar datos
                            $masked_ip = $gestionRegistroUsuario->maskIP($ip_registro);
                            $masked_ip_bloqueo = $gestionRegistroUsuario->maskIP($ip_bloqueo);
                            $fechaFormateada = $gestionRegistroUsuario->formatearFecha($fecha_registro);
                            $estadoBadge = $gestionRegistroUsuario->getEstadoBadge($masked_ip_bloqueo);
                        ?>
                        <tr>
                            <td class="text-center align-middle p-2">
                                <span class="badge bg-secondary fs-6"><?= htmlspecialchars($id) ?></span>
                            </td>
                            <td class="text-start align-middle p-2">
                                <div class="d-flex align-items-center">
                                    <img loading="lazy" class="me-2 rounded-circle" 
                                         src="https://www.habbo.es/habbo-imaging/avatarimage?user=<?= urlencode($usuario_registro) ?>&amp;headonly=1&amp;head_direction=3&amp;size=m" 
                                         alt="<?= htmlspecialchars($usuario_registro) ?>" 
                                         title="<?= htmlspecialchars($usuario_registro) ?>" 
                                         width="35" height="35">
                                    <div>
                                        <span class="fw-semibold fs-5"><?= htmlspecialchars($usuario_registro) ?></span><br>
                                        <span class="text-muted fs-6">ID: <?= htmlspecialchars($codigo_time) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center align-middle p-2 fs-6">
                                <?= htmlspecialchars($fechaFormateada) ?>
                            </td>
                            <td class="text-center align-middle p-2 fs-6">
                                <?= htmlspecialchars($masked_ip) ?>
                            </td>
                            <td class="text-center align-middle p-2"><?= $estadoBadge ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-3">
            <div class="row">
                <div class="col-12 text-end">
                    <span class="badge bg-success fs-5"><i class="bi bi-info-circle me-1"></i> Total usuarios: <?= $gestionRegistroUsuario->getTotalUsuarios() ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataTable = new simpleDatatables.DataTable('#registroUsuarioTable', {
        searchable: true,
        sortable: true,
        perPage: 10,
        perPageSelect: [10, 25, 50, 100],
        labels: {
            placeholder: "Buscar...",
            perPage: "registros por página",
            noRows: "No se encontraron registros",
            info: "Mostrando {start} a {end} de {rows} registros"
        },
        columns: [
            { select: 1, sortable: false }
        ]
    });
    
    dataTable.columns().sort(2, "desc");
});
</script>