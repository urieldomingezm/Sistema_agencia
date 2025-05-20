<?php
require_once(PROCESO_CAMBIAR_PACTH . 'mostrar_usuarios.php');
require_once(PROCESO_CAMBIAR_PACTH . 'modificar_password.php');
require_once(MODAL_GESTION_USUARIOS_PACH . 'modal_password.php');
?>

<script>
    const PROCESO_CAMBIAR_PACTH = '/private/procesos/gestion_usuarios/';
</script>


<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Gestión de Usuarios</h5>
        </div>
        <div class="card-body">
            <div class="justify-content-center">
                <table id="usuariosTable" class="table table-bordered table-striped table-hover w-100">
                    <thead>
                        <tr class="text-white text-center">
                            <th>ID</th>
                            <th>Habbo</th>
                            <th>Password</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td class="text-center align-middle"><?= htmlspecialchars($usuario['id']) ?></td>
                                <td class="text-start align-middle">
                                    <div class="d-flex align-items-center">
                                        <img loading="lazy" class="me-2" src="https://www.habbo.es/habbo-imaging/avatarimage?user=<?= urlencode($usuario['nombre_habbo']) ?>&amp;headonly=1&amp;head_direction=3&amp;size=m" alt="<?= htmlspecialchars($usuario['nombre_habbo']) ?>" title="<?= htmlspecialchars($usuario['nombre_habbo']) ?>">
                                        <span><?= htmlspecialchars($usuario['nombre_habbo']) ?></span>
                                    </div>
                                </td>
                                <td class="text-center align-middle"><?= htmlspecialchars(substr($usuario['password_registro'], 0, 20)) ?></td>
                                <td class="text-center align-middle">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button class="btn btn-primary btn-sm rounded-pill" onclick="editarUsuario(<?= $usuario['id'] ?>)">
                                            Cambiar contraseña
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <br>
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

    function editarUsuario(id) {
        const tabla = document.getElementById('usuariosTable');
        let nombreHabbo = '';

        const filas = tabla.querySelectorAll('tbody tr');
        filas.forEach(fila => {
            const celdaId = fila.querySelector('td:first-child');
            if (celdaId && celdaId.textContent == id) {
                nombreHabbo = fila.querySelector('td:nth-child(2)').textContent;
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

    function eliminarUsuario(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Eliminar usuario con ID:', id);
            }
        });
    }
</script>