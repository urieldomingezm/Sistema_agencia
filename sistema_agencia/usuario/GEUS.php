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
            <table id="usuariosTable" class="table table-striped table-hover">
                <thead>
                    <tr class="text-white">
                        <th>ID</th>
                        <th>Habbo</th>
                        <th>Password</th>
                        <th>Ip</th>
                        <th>Fecha registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['id']) ?></td>
                            <td><?= htmlspecialchars($usuario['nombre_habbo']) ?></td>
                            <td><?= htmlspecialchars(substr($usuario['password_registro'], 0, 10)) ?></td>
                            <td><?= htmlspecialchars(substr(md5($usuario['ip_registro']), 0, 16)) ?></td>
                            <td><?= htmlspecialchars($usuario['fecha_registro']) ?></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-primary btn-sm rounded-pill" onclick="editarUsuario(<?= $usuario['id'] ?>)">
                                        Cambiar contraseña
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JS DE GESTION DE USUARIOS -->
<script src="/public/assets/custom_general/custom_gestion_usuarios/gestion_usuarios.js"></script>