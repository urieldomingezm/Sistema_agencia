<?php require_once(USUARIO_LISTA_PATH . 'mostrar_usuarios.php'); ?>

<head>
    <meta name="keywords" content="Lista de usuarios registrados, gestión de usuarios, registro de usuarios, estadísticas de usuarios">
</head>

<div class="container-fluid mt-4">
    <!-- Wizard de Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Total Usuarios</h5>
                            <h2 class="mb-0"><?= $gestionRegistroUsuario->getTotalUsuarios() ?></h2>
                        </div>
                        <i class="bi bi-people-fill fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Usuarios Activos</h5>
                            <h2 class="mb-0"><?= $gestionRegistroUsuario->getUsuariosActivos() ?></h2>
                        </div>
                        <i class="bi bi-check-circle-fill fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Usuarios Bloqueados</h5>
                            <h2 class="mb-0"><?= $gestionRegistroUsuario->getUsuariosBloqueados() ?></h2>
                        </div>
                        <i class="bi bi-lock-fill fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="bi bi-person-plus me-2"></i>Lista de Usuarios Registrados</h3>
            <div>
                <button class="btn btn-light btn-lg me-2" 
                        id="filtroBloqueados" 
                        onclick="filtrarBloqueados()">
                    <i class="bi bi-filter-circle me-1"></i> Mostrar Bloqueados
                </button>
                <button class="btn btn-light btn-lg" 
                        id="Ayuda_registro_usuario-tab" 
                        data-bs-toggle="modal" 
                        data-bs-target="#Ayuda_registro_usuario">
                    <i class="bi bi-question-circle-fill me-1"></i> Ayuda
                </button>
            </div>
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
                            <th class="text-center fs-5">Acciones</th>
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
                        <tr data-estado="<?= empty($ip_bloqueo) ? 'activo' : 'bloqueado' ?>">
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
                            <td class="text-center align-middle p-2">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-info btn-sm" title="Ver detalles" 
                                            onclick="verDetalles(<?= htmlspecialchars($id) ?>)">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" title="Desbloquear usuario"
                                            onclick="desbloquearUsuario(<?= htmlspecialchars($id) ?>)">
                                        <i class="bi bi-unlock-fill"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Cambiar contraseña"
                                            onclick="cambiarPassword('<?= htmlspecialchars($id) ?>', '<?= htmlspecialchars($usuario_registro) ?>')">
                                        <i class="bi bi-key-fill"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" title="Eliminar usuario"
                                            onclick="eliminarUsuario(<?= htmlspecialchars($id) ?>)">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-3">
            <div class="row">
                <div class="col-md-4">
                    <span class="badge bg-primary fs-5"><i class="bi bi-people-fill me-1"></i> Total: <?= $gestionRegistroUsuario->getTotalUsuarios() ?></span>
                </div>
                <div class="col-md-4 text-center">
                    <span class="badge bg-success fs-5"><i class="bi bi-check-circle-fill me-1"></i> Activos: <?= $gestionRegistroUsuario->getUsuariosActivos() ?></span>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-danger fs-5"><i class="bi bi-lock-fill me-1"></i> Bloqueados: <?= $gestionRegistroUsuario->getUsuariosBloqueados() ?></span>
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
            { select: 1, sortable: false },
            { select: 5, sortable: false }
        ]
    });
    
    dataTable.columns().sort(2, "desc");
});

function filtrarBloqueados() {
    const table = document.getElementById('registroUsuarioTable');
    const rows = table.querySelectorAll('tbody tr');
    const btn = document.getElementById('filtroBloqueados');
    
    let mostrarSoloBloqueados = btn.textContent.includes('Mostrar Bloqueados');
    
    rows.forEach(row => {
        if (mostrarSoloBloqueados) {
            if (row.getAttribute('data-estado') === 'bloqueado') {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        } else {
            row.style.display = '';
        }
    });
    
    btn.innerHTML = mostrarSoloBloqueados 
        ? '<i class="bi bi-filter-circle-fill me-1"></i> Mostrar Todos'
        : '<i class="bi bi-filter-circle me-1"></i> Mostrar Bloqueados';
}

function verDetalles(id) {
    console.log('Ver detalles del usuario:', id);
}

function cambiarPassword(id, usuario) {
    Swal.fire({
        title: 'Cambiar Contraseña',
        html: `
            <div class="text-start">
                <p class="mb-3">Usuario: <strong>${usuario}</strong></p>
                <div class="form-group">
                    <label for="newPassword" class="form-label">Nueva Contraseña:</label>
                    <input type="password" id="newPassword" class="form-control" placeholder="Ingrese la nueva contraseña">
                </div>
                <div class="form-group mt-3">
                    <label for="confirmPassword" class="form-label">Confirmar Contraseña:</label>
                    <input type="password" id="confirmPassword" class="form-control" placeholder="Confirme la nueva contraseña">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Cambiar Contraseña',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        preConfirm: () => {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (!newPassword || !confirmPassword) {
                Swal.showValidationMessage('Por favor complete todos los campos');
                return false;
            }
            
            if (newPassword !== confirmPassword) {
                Swal.showValidationMessage('Las contraseñas no coinciden');
                return false;
            }
            
            return { newPassword, confirmPassword };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Simulación',
                'Aquí se implementará el endpoint para cambiar la contraseña',
                'info'
            );
        }
    });
}

function desbloquearUsuario(id) {
    Swal.fire({
        title: '¿Desbloquear usuario?',
        text: "¿Estás seguro de que deseas desbloquear este usuario?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, desbloquear',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/api/usuarios/desbloquear/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        '¡Desbloqueado!',
                        'El usuario ha sido desbloqueado correctamente.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error',
                        'Error al desbloquear usuario: ' + data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Error al desbloquear usuario',
                    'error'
                );
            });
        }
    });
}

function eliminarUsuario(id) {
    Swal.fire({
        title: '¿Eliminar usuario?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/api/usuarios/eliminar/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        '¡Eliminado!',
                        'El usuario ha sido eliminado correctamente.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error',
                        'Error al eliminar usuario: ' + data.message,
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'Error al eliminar usuario',
                    'error'
                );
            });
        }
    });
}
</script>