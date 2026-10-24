<?php
require_once(GESTION_PAGAS_PATCH . 'mostrar_usuarios.php');
require_once(PROCESOS_REQUERIMIENTOS_PACTH . 'mostrar_usuarios.php');

// Calcular usuarios pendientes y aceptados de la tabla de cumplimientos
$pendientes_count = 0;
$aceptados_count = 0;

if (!empty($GLOBALS['cumplimientos']) && is_array($GLOBALS['cumplimientos'])) {
    foreach ($GLOBALS['cumplimientos'] as $cumplimiento) {
        if ($cumplimiento['is_completed'] == 0) {
            $pendientes_count++;
        } else {
            $aceptados_count++;
        }
    }
}
?>

<div class="container-fluid py-4">
    <!-- Header con título y breadcrumb -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gestión de Pagos</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-primary fw-bold">
                <i class="bi bi-cash-coin me-2"></i>Gestión de Pagos y Requisitos
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
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Usuarios (Pagos)</h6>
                            <h2 class="mb-0 fw-bold"><?php echo count(array_unique(array_column($pagas, 'pagas_usuario'))); ?></h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people-fill fs-3 text-primary"></i>
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
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Créditos a Pagar</h6>
                            <h2 class="mb-0 fw-bold"><?php echo array_sum(array_column($pagas, 'pagas_recibio')); ?></h2>
                            <small class="text-muted">créditos</small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-currency-dollar fs-3 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-warning border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Pendientes</h6>
                            <h2 class="mb-0 fw-bold"><?php echo $pendientes_count; ?></h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-clock fs-3 text-warning"></i>
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
                            <h6 class="text-uppercase text-muted fw-semibold mb-2">Aceptados</h6>
                            <h2 class="mb-0 fw-bold"><?php echo $aceptados_count; ?></h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-check-circle fs-3 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas principales -->
    <div class="card shadow border-0">
        <div class="card-header bg-white border-bottom p-0">
            <ul class="nav nav-tabs nav-tabs-alt" id="mainTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active py-3 px-4" id="pagos-tab" data-bs-toggle="tab" data-bs-target="#pagos-tab-pane" type="button" role="tab">
                        <i class="bi bi-cash-stack me-2"></i> Derecho a Pago
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3 px-4" id="requisitos-tab" data-bs-toggle="tab" data-bs-target="#requisitos-tab-pane" type="button" role="tab">
                        <i class="bi bi-list-check me-2"></i> Pendientes por Aceptar
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="tab-content" id="mainTabsContent">
                <!-- Tab de Pagos -->
                <div class="tab-pane fade show active" id="pagos-tab-pane" role="tabpanel" aria-labelledby="pagos-tab">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Listado de Pagos</h5>
                            <div class="d-flex">
                                <div class="input-group me-2" style="width: 250px;">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" id="searchPagos" class="form-control" placeholder="Buscar...">
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                                        <i class="bi bi-funnel"></i> Filtros
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Todos</a></li>
                                        <li><a class="dropdown-item" href="#">Completos</a></li>
                                        <li><a class="dropdown-item" href="#">Pendientes</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#">Resetear</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="pagasTable" class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start">Usuario</th>
                                        <th>Rango</th>
                                        <th>Sueldo</th>
                                        <th>Membresía</th>
                                        <th>Requisito</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pagas as $paga): ?>
                                        <tr>
                                            <td class="text-start">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <span class="avatar-initial rounded-circle bg-primary text-white"><?php echo substr(htmlspecialchars($paga['pagas_usuario']), 0, 1); ?></span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0"><?php echo htmlspecialchars($paga['pagas_usuario']); ?></h6>
                                                        <small class="text-muted">ID: <?php echo htmlspecialchars($paga['pagas_id'] ?? 'N/A'); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo htmlspecialchars($paga['pagas_rango']); ?></span>
                                            </td>
                                            <td>
                                                <span class="fw-bold"><?php echo htmlspecialchars($paga['pagas_recibio']); ?></span>
                                                <small class="text-muted">créditos</small>
                                            </td>
                                            <td>
                                                <?php if(isset($paga['venta_titulo']) && !empty($paga['venta_titulo'])): ?>
                                                    <span class="badge bg-purple"><?php echo htmlspecialchars($paga['venta_titulo']); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">No tiene</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge <?php echo $paga['pagas_completo'] ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?php echo $paga['pagas_completo'] ? 'Completo' : 'Pendiente'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                    $fecha = explode(' ', $paga['pagas_fecha_registro'])[0];
                                                    echo '<span class="d-block">' . htmlspecialchars($fecha) . '</span>';
                                                    echo '<small class="text-muted">' . (new DateTime($fecha))->format('D, M Y') . '</small>';
                                                ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Ver Detalles</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Editar</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-text me-2"></i>Generar Recibo</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Mostrando <span class="fw-bold">1</span> a <span class="fw-bold">10</span> de <span class="fw-bold"><?php echo count($pagas); ?></span> registros
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Anterior</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Tab de Requisitos -->
                <div class="tab-pane fade" id="requisitos-tab-pane" role="tabpanel" aria-labelledby="requisitos-tab">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Pendientes por Aceptar</h5>
                            <div class="d-flex">
                                <div class="input-group me-2" style="width: 250px;">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" id="searchRequisitos" class="form-control" placeholder="Buscar...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="cumplimientosTable" class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Requisitos</th>
                                        <th>Tiempos</th>
                                        <th>Ascensos</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($GLOBALS['cumplimientos']) && is_array($GLOBALS['cumplimientos'])): ?>
                                        <?php foreach ($GLOBALS['cumplimientos'] as $cumplimiento): ?>
                                            <tr>
                                                <td class="fw-bold">#<?= htmlspecialchars($cumplimiento['id']) ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm me-2">
                                                            <span class="avatar-initial rounded-circle bg-success text-white"><?= substr(htmlspecialchars($cumplimiento['user']), 0, 1); ?></span>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0"><?= htmlspecialchars($cumplimiento['user']) ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?= !empty($cumplimiento['requirement_name']) ? htmlspecialchars($cumplimiento['requirement_name']) : '<span class="text-muted">no disponible</span>' ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?= htmlspecialchars($cumplimiento['times_as_encargado_count']) ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-warning"><?= htmlspecialchars($cumplimiento['ascensos_as_encargado_count']) ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge <?= $cumplimiento['is_completed'] ? 'bg-success' : 'bg-warning' ?>">
                                                        <?= $cumplimiento['is_completed'] ? 'Completado' : 'En espera' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button class="btn btn-outline-success btn-completo" data-id="<?= htmlspecialchars($cumplimiento['id']) ?>">
                                                            <i class="bi bi-check-circle"></i> Aprobar
                                                        </button>
                                                        <button class="btn btn-outline-danger btn-no-completo" data-id="<?= htmlspecialchars($cumplimiento['id']) ?>">
                                                            <i class="bi bi-x-circle"></i> Rechazar
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="bi bi-folder-x fs-1 text-muted mb-2"></i>
                                                    <h5 class="text-muted">No hay datos de cumplimiento disponibles</h5>
                                                    <p class="text-muted">No se encontraron registros pendientes por aceptar</p>
                                                    <button class="btn btn-primary mt-2">
                                                        <i class="bi bi-plus-circle me-1"></i> Crear nuevo requisito
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if (!empty($GLOBALS['cumplimientos']) && is_array($GLOBALS['cumplimientos'])): ?>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Mostrando <span class="fw-bold">1</span> a <span class="fw-bold"><?= min(10, count($GLOBALS['cumplimientos'])) ?></span> de <span class="fw-bold"><?= count($GLOBALS['cumplimientos']) ?></span> registros
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Anterior</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para acciones -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Confirmar acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                ¿Estás seguro de realizar esta acción?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmAction">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .avatar-initial {
        font-weight: 600;
    }
    
    .bg-purple {
        background-color: #6f42c1;
    }
    
    .nav-tabs-alt .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
    }
    
    .nav-tabs-alt .nav-link.active {
        border-bottom-color: #0d6efd;
        background-color: transparent;
    }
    
    .table-hover tbody tr {
        transition: all 0.2s;
    }
    
    .table-hover tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    
    .border-start {
        border-left-width: 4px !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Manejar eventos de los botones de completado
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-completo')) {
            const id = e.target.closest('.btn-completo').dataset.id;
            handleCompleto(id);
        } else if (e.target.closest('.btn-no-completo')) {
            const id = e.target.closest('.btn-no-completo').dataset.id;
            handleNoCompleto(id);
        }
    });
    
    // Búsqueda en tiempo real para la tabla de pagos
    const searchPagos = document.getElementById('searchPagos');
    if (searchPagos) {
        searchPagos.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#pagasTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
    
    // Búsqueda en tiempo real para la tabla de requisitos
    const searchRequisitos = document.getElementById('searchRequisitos');
    if (searchRequisitos) {
        searchRequisitos.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#cumplimientosTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    }
});

function handleCompleto(id) {
    const modal = new bootstrap.Modal(document.getElementById('actionModal'));
    document.getElementById('modalTitle').textContent = 'Confirmar aprobación';
    document.getElementById('modalBody').innerHTML = `
        <div class="mb-3">
            <label class="form-label">Selecciona el tipo de cumplimiento:</label>
            <select class="form-select" id="approvalType">
                <option value="complete_all">Completó todos sus requisitos</option>
                <option value="complete_bonus">Cumplió pura nomina</option>
            </select>
        </div>
        <p class="text-muted">¿Estás seguro de marcar este requisito como completado?</p>
    `;
    
    document.getElementById('confirmAction').onclick = function() {
        const approvalType = document.getElementById('approvalType').value;
        updateStatus(id, approvalType);
        modal.hide();
    };
    
    modal.show();
}

function handleNoCompleto(id) {
    const modal = new bootstrap.Modal(document.getElementById('actionModal'));
    document.getElementById('modalTitle').textContent = 'Confirmar rechazo';
    document.getElementById('modalBody').innerHTML = `
        <div class="mb-3">
            <label class="form-label">Motivo del rechazo (opcional):</label>
            <textarea class="form-control" id="rejectionReason" rows="2" placeholder="Especifica el motivo..."></textarea>
        </div>
        <p class="text-danger">¿Estás seguro de marcar este requisito como no completado?</p>
    `;
    
    document.getElementById('confirmAction').onclick = function() {
        const rejectionReason = document.getElementById('rejectionReason').value;
        updateStatus(id, 'incomplete', rejectionReason);
        modal.hide();
    };
    
    modal.show();
}

function updateStatus(id, status, note = '') {
    // Mostrar loader
    const loader = Swal.fire({
        title: 'Procesando...',
        html: 'Por favor espera mientras actualizamos el estado',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Enviar datos al servidor
    const formData = new FormData();
    formData.append('id', id);
    formData.append('status', status);
    if (note) formData.append('note', note);
    
    fetch('/private/procesos/gestion_cumplimientos/requisitos_completado.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        loader.close();
        
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: data.message || 'Ocurrió un error al procesar la solicitud',
            });
        }
    })
    .catch((error) => {
        loader.close();
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Hubo un problema al comunicarse con el servidor.',
        });
    });
}
</script>