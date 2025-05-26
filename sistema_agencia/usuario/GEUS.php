<?php
require_once(PROCESO_CAMBIAR_PACTH . 'mostrar_usuarios.php');
require_once(PROCESO_CAMBIAR_PACTH . 'modificar_password.php');
require_once(MODAL_GESTION_USUARIOS_PACH . 'modal_password.php');
require_once(MODAL_MODIFICAR_USUARIO_PACH . 'modificar_usuario.php');
?>

<script>
    const PROCESO_CAMBIAR_PACTH = '/private/procesos/gestion_usuarios/';
</script>

<div class="container-fluid mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-people-fill me-2"></i> Gestión de Usuarios</h4>
                <button class="btn btn-light btn-sm rounded-pill" data-bs-toggle="tooltip" data-bs-placement="left" title="Ayuda">
                    <i class="bi bi-question-circle"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="usuariosTable" class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="width: 60px;">ID</th>
                            <th>Usuario Habbo</th>
                            <th class="text-center" style="width: 300px;">Contraseña</th>
                            <th class="text-center" style="width: 180px;">Fecha Registro</th>
                            <th class="text-center" style="width: 200px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr class="border-bottom">
                                <td class="text-center fw-bold"><?= htmlspecialchars($usuario['id']) ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img loading="lazy"
                                            src="https://www.habbo.es/habbo-imaging/avatarimage?user=<?= urlencode($usuario['nombre_habbo']) ?>&headonly=1&head_direction=3&size=m"
                                            alt="<?= htmlspecialchars($usuario['nombre_habbo']) ?>"
                                            class="rounded-circle me-3"
                                            width="40"
                                            height="40">
                                        <div>
                                            <span class="fw-semibold"><?= htmlspecialchars($usuario['nombre_habbo']) ?></span>
                                            <small class="d-block text-muted">ID: <?= htmlspecialchars($usuario['id']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="input-group input-group-sm justify-content-center">
                                        <input type="password"
                                            class="form-control form-control-sm bg-light text-center"
                                            value="<?= htmlspecialchars(substr($usuario['password_registro'], 0, 16)) ?>"
                                            readonly
                                            style="width: 120px;">
                                        <button class="btn btn-outline-secondary btn-sm toggle-password" type="button">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-primary btn-sm rounded-pill px-3 py-1 d-flex align-items-center"
                                            onclick="editarUsuario(<?= $usuario['id'] ?>)"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Cambiar contraseña">
                                            <span>Password</span>
                                        </button>
                                        
                                        <button class="btn btn-info btn-sm rounded-pill px-3 py-1 d-flex align-items-center ms-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modificarRangoModal"
                                            data-id="<?= $usuario['id'] ?>"
                                            title="Modificar rango">
                                            <span>Rango</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Total usuarios: <?= count($usuarios) ?></small>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dataTable = new simpleDatatables.DataTable("#usuariosTable", {
            searchable: true,
            fixedHeight: true,
            perPage: 5,
            perPageSelect: [5, 10, 25, 50, 100],
            labels: {
                placeholder: "Buscar...",
                perPage: "registros por página",
                noRows: "No se encontraron registros",
                info: "Mostrando {start} a {end} de {rows} registros",
                loading: "Cargando...",
                infoFiltered: "(filtrado de {rows} registros totales)"
            },
            layout: {
                top: "{search}",
                bottom: "{info}{pager}"
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Toggle para mostrar/ocultar contraseña
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    });

    function editarUsuario(id) {
        const tabla = document.getElementById('usuariosTable');
        let nombreHabbo = '';

        const filas = tabla.querySelectorAll('tbody tr');
        filas.forEach(fila => {
            const celdaId = fila.querySelector('td:first-child');
            if (celdaId && celdaId.textContent == id) {
                nombreHabbo = fila.querySelector('td:nth-child(2) span.fw-semibold').textContent;
            }
        });

        document.getElementById('usuario_id').value = id;
        document.getElementById('nombre_habbo').value = nombreHabbo;
        document.getElementById('nueva_password').value = '';
        document.getElementById('confirmar_password').value = '';

        const modal = new bootstrap.Modal(document.getElementById('modalCambiarPassword'));
        modal.show();
    }

    document.getElementById('formCambiarPassword').addEventListener('submit', function(e) {
        e.preventDefault();

        const usuarioId = document.getElementById('usuario_id').value;
        const nuevaPassword = document.getElementById('nueva_password').value;
        const confirmarPassword = document.getElementById('confirmar_password').value;

        if (nuevaPassword !== confirmarPassword) {
            Swal.fire({
                title: 'Error',
                text: 'Las contraseñas no coinciden',
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        if (nuevaPassword.trim() === '') {
            Swal.fire({
                title: 'Error',
                text: 'La contraseña no puede estar vacía',
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        Swal.fire({
            title: 'Procesando',
            text: 'Actualizando contraseña...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        const formData = new FormData();
        formData.append('usuario_id', usuarioId);
        formData.append('nueva_password', nuevaPassword);

        fetch(PROCESO_CAMBIAR_PACTH + 'modificar_password.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.text();
            })
            .then(data => {
                const modalElement = document.getElementById('modalCambiarPassword');
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();

                if (data.trim() === "success") {
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Contraseña actualizada correctamente',
                        icon: 'success',
                        confirmButtonText: 'Entendido'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error('La respuesta del servidor no fue exitosa: ' + data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al actualizar la contraseña: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
            });
    });
</script>