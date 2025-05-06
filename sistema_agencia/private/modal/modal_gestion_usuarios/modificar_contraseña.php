<?php
// PROCESO PARA MOSTRAR TODOS LOS USUARIOS REGISTRADOS EN LA BASE DE DATOS Y PODER EDITARLOS O ELIMINARLOS
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');
require_once(GESTION_USUARIOS_PACH. 'mostrar_usuarios.php');

if (isset($_GET['id'])) {
    $database = new Database();
    $conn = $database->getConnection();
    
    $query = "SELECT id, usuario_registro, nombre_habbo FROM registro_usuario WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="modal fade" id="modalCambiarPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Cambiar contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCambiarPassword">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?? '' ?>">
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="text" class="form-control" value="<?= $usuario['id'] ?? '' ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre de Habbo</label>
                        <input type="text" class="form-control" value="<?= $usuario['nombre_habbo'] ?? '' ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nueva Contraseña</label>
                        <input type="password" name="nueva_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="confirmar_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>



