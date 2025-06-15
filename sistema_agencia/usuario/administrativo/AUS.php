<?php require_once(AUDITORIA_ASCENSOS_PATH . 'mostrar_ascensos.php'); ?>

<head>
    <meta name="keywords" content="Auditoría de registros únicos, cambios de rangos, historial de modificaciones">
</head>

<div class="container-fluid mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Registros Únicos de Auditoría</h5>
            <button class="btn btn-light" 
                    id="Ayuda_auditoria_registro-tab" 
                    data-bs-toggle="modal" 
                    data-bs-target="#Ayuda_auditoria_registro">
                <i class="bi bi-question-circle-fill me-1"></i> Ayuda
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="auditoriaRegistroTable" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Rango Anterior</th>
                            <th class="text-center">Rango Nuevo</th>
                            <th class="text-center">Misión Anterior</th>
                            <th class="text-center">Misión Nueva</th>
                            <th class="text-center">Modificador</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($auditoriaRegistros as $registro): 
                            $nombre_habbo = $registro['nombre_habbo'] ?? '';
                            $codigo_time = $registro['codigo_time'] ?? '';
                            $rango_anterior = $registro['rango_anterior'] ?? '';
                            $rango_nuevo = $registro['rango_nuevo'] ?? '';
                            $mision_anterior = $registro['mision_anterior'] ?? '';
                            $mision_nueva = $registro['mision_nueva'] ?? '';
                            $usuario_modificador = $registro['usuario_modificador'] ?? '';
                            
                            // Procesar badges de rangos
                            $badgeAnterior = $gestionAuditoriaRegistro->getRangoBadge($rango_anterior);
                            $badgeNuevo = $gestionAuditoriaRegistro->getRangoBadge($rango_nuevo);
                        ?>
                        <tr>
                            <td class="text-start align-middle">
                                <div class="d-flex align-items-center">
                                    <img loading="lazy" class="me-2 rounded-circle" 
                                         src="https://www.habbo.es/habbo-imaging/avatarimage?user=<?= urlencode($nombre_habbo) ?>&amp;headonly=1&amp;head_direction=3&amp;size=m" 
                                         alt="<?= htmlspecialchars($nombre_habbo) ?>" 
                                         title="<?= htmlspecialchars($nombre_habbo) ?>" 
                                         width="30" height="30">
                                    <div>
                                        <span class="fw-semibold" style="word-break: break-word;"><?= htmlspecialchars($nombre_habbo) ?></span><br>
                                        <small class="text-muted">ID: <?= htmlspecialchars($codigo_time) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center align-middle"><?= $badgeAnterior ?></td>
                            <td class="text-center align-middle"><?= $badgeNuevo ?></td>
                            <td class="text-center align-middle">
                                <small><?= htmlspecialchars($mision_anterior) ?></small>
                            </td>
                            <td class="text-center align-middle">
                                <small><?= htmlspecialchars($mision_nueva) ?></small>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge bg-primary"><?= htmlspecialchars($usuario_modificador) ?></span>
                            </td>
                            <td class="text-center align-middle">
                                <button class="btn btn-info btn-sm" onclick="mostrarDetalles('<?= htmlspecialchars($nombre_habbo) ?>', '<?= htmlspecialchars($rango_anterior) ?>', '<?= htmlspecialchars($rango_nuevo) ?>', '<?= htmlspecialchars($mision_anterior) ?>', '<?= htmlspecialchars($mision_nueva) ?>', '<?= htmlspecialchars($usuario_modificador) ?>')">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="row">
                <div class="col-12 text-end">
                    <span class="badge bg-info"><i class="bi bi-info-circle me-1"></i> Total registros únicos: <?= $gestionAuditoriaRegistro->getTotalRegistros() ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataTable = new simpleDatatables.DataTable('#auditoriaRegistroTable', {
        searchable: true,
        sortable: true,
        perPage: 25,
        perPageSelect: [10, 25, 50, 100],
        labels: {
            placeholder: "Buscar...",
            perPage: "registros por página",
            noRows: "No se encontraron registros",
            info: "Mostrando {start} a {end} de {rows} registros"
        }
    });
});

function mostrarDetalles(nombre, rangoAnterior, rangoNuevo, misionAnterior, misionNueva, modificador) {
    Swal.fire({
        title: 'Detalles de la Modificación',
        html: `
            <div class="text-start">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <img src="https://www.habbo.es/habbo-imaging/avatarimage?user=${nombre}&headonly=1&head_direction=3&size=l" 
                         class="rounded-circle" 
                         alt="${nombre}"
                         style="width: 80px; height: 80px;">
                </div>
                <h5 class="text-center mb-3">${nombre}</h5>
                <hr>
                <p><strong>Rango Anterior:</strong> ${rangoAnterior}</p>
                <p><strong>Rango Nuevo:</strong> ${rangoNuevo}</p>
                <p><strong>Misión Anterior:</strong> ${misionAnterior}</p>
                <p><strong>Misión Nueva:</strong> ${misionNueva}</p>
                <p><strong>Modificado por:</strong> ${modificador}</p>
            </div>
        `,
        width: '600px',
        showCloseButton: true,
        showConfirmButton: false,
        customClass: {
            container: 'swal-wide',
            popup: 'swal-wide'
        }
    });
}
</script>