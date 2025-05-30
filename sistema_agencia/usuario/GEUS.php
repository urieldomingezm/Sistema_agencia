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
                            <th class="text-center" style="width: 40px;">ID</th>
                            <th>Usuario Habbo</th>
                            <th class="text-center" style="width: 180px;">Fecha Registro</th>
                            <th class="text-center" style="width: 180px;">Bloqueado</th>
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
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $bloqueado = empty($usuario['ip_bloqueo']) ? 'No bloqueado' : 'Bloqueado';
                                    ?>
                                    <span class="badge <?= $bloqueado === 'No bloqueado' ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $bloqueado ?>
                                    </span>
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

<script src="/public/assets/custom_general/custom_gestion_usuarios/index_gestion_usuarios.js"></script>

<script>
    function mostrarDesbloquearSwal(usuarioId) {
    Swal.fire({
        title: 'Desbloquear usuario',
        html: '<p>¿Estás seguro que deseas desbloquear al usuario con ID ' + usuarioId + '?</p>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, desbloquear',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/private/procesos/gestion_usuarios/desbloquear.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'usuario_id=' + encodeURIComponent(usuarioId)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '¡Desbloqueado!',
                            text: 'El usuario ha sido desbloqueado correctamente.',
                            icon: 'success',
                            confirmButtonText: 'Entendido'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'No se pudo desbloquear el usuario.',
                            icon: 'error',
                            confirmButtonText: 'Entendido'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error en la petición: ' + error,
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                });
        }
    });
}
</script>
<head>
    <meta name="keywords" content="Requisitos de paga, ascensos y misiones para los usuarios como tambien traslados">
</head>