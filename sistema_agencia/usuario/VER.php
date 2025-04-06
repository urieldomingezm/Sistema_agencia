<?php
require_once(CONFIG_PATH . 'bd.php');

$database = new Database();
$conn = $database->getConnection();

// Handle verification and password updates
// Update the verification handling section
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['userId']) && isset($_POST['status'])) {
        try {
            // Begin transaction
            $conn->beginTransaction();

            // Update user verification status
            $stmt = $conn->prepare("UPDATE registro_usuario SET verificado = :status WHERE id = :userId");
            $stmt->bindParam(':status', $_POST['status']);
            $stmt->bindParam(':userId', $_POST['userId']);
            $stmt->execute();

            // Insert into verification history
            $stmt = $conn->prepare("INSERT INTO historial_verificaciones (usuario_id, verificado_por, fecha_verificacion, estado_verificacion) VALUES (:userId, :verificador, NOW(), :estado)");
            $stmt->bindParam(':userId', $_POST['userId']);
            $stmt->bindParam(':verificador', $_SESSION['nombre_habbo']); // Assuming you store the verifier's Habbo name in session
            $stmt->bindParam(':estado', $_POST['status']);
            $stmt->execute();

            // Commit transaction
            $conn->commit();

            echo "<script>window.location.reload();</script>";
            exit();
        } catch (PDOException $e) {
            // Rollback in case of error
            $conn->rollBack();
            error_log("Error updating verification: " . $e->getMessage());
        }
    } elseif (isset($_POST['userId']) && isset($_POST['newPassword'])) {
        try {
            $hashedPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE registro_usuario SET password_registro = :password WHERE id = :userId");
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':userId', $_POST['userId']);
            $stmt->execute();
            echo json_encode(['success' => true]);
            exit();
        } catch (PDOException $e) {
            error_log("Error updating password: " . $e->getMessage());
            echo json_encode(['success' => false]);
            exit();
        }
    }
}

// Query to fetch user data
try {
    $stmt = $conn->prepare("SELECT id, usuario_registro, password_registro, rol_id, fecha_registro, ip_registro, nombre_habbo, verificado, rango FROM registro_usuario");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching users: " . $e->getMessage());
    $result = [];
}
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-gradient-primary text-white">
            <h2 class="mb-0">Gestion de usuarios</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="TablaVerificacion" class="table table-hover table-striped table-bordered">
                    <thead class="thead-dark text-center">
                        <tr class="text-center">
                            <th class="text-center">ID</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Habbo</th>
                            <th class="text-center">IP</th>
                            <th class="text-center">Verificacion</th>
                            <th class="text-center">Rango</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row) { ?>
                            <tr class="align-middle text-center">
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td class="font-weight-bold"><?php echo htmlspecialchars($row['usuario_registro']); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre_habbo']); ?></td>
                                <td><?php echo htmlspecialchars($row['ip_registro']); ?></small></td>
                                <td>
                                    <span class="badge <?php echo ($row['verificado'] == 1) ? 'bg-success' : 'bg-danger'; ?> p-2">
                                        <?php echo ($row['verificado'] == 1) ? 'Verificado' : 'No Verificado'; ?>
                                    </span>
                                </td>
                                <td><span class="badge bg-info p-2"><?php echo htmlspecialchars($row['rango']); ?></span></td>
                                <td>
                                    <form method="POST" style="display: inline;" class="verification-form">
                                        <input type="hidden" name="userId" value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <input type="hidden" name="status" value="<?php echo $row['verificado'] == 1 ? '0' : '1'; ?>">
                                        <button type="submit" class="btn btn-sm <?php echo ($row['verificado'] == 1) ? 'btn-danger' : 'btn-success'; ?>">
                                            <i class="fas fa-<?php echo ($row['verificado'] == 1) ? 'times' : 'check'; ?>"></i>
                                            <?php echo ($row['verificado'] == 1) ? 'Rechazar' : 'Verificar'; ?>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-warning ms-2"
                                        onclick="openPasswordModal('<?php echo htmlspecialchars($row['id']); ?>', '<?php echo htmlspecialchars($row['usuario_registro']); ?>')">
                                        <i class="fas fa-key"></i> Cambio
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for password change -->
<div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="passwordForm">
                    <input type="hidden" id="modalUserId" name="userId">
                    <div class="mb-3">
                        <label class="form-label">Usuario:</label>
                        <input type="text" class="form-control" id="modalUsername" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nueva Contraseña:</label>
                        <input type="password" class="form-control" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Contraseña:</label>
                        <input type="password" class="form-control" id="confirmPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="updatePassword()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .table {
        font-size: 0.95rem;
    }

    .badge {
        font-size: 0.85rem;
    }

    .card {
        border-radius: 10px;
        border: none;
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }

    .btn-sm {
        padding: 0.25rem 0.75rem;
    }

    .thead-dark th {
        background-color: #343a40;
        color: white;
    }
</style>

<script>
    $(document).ready(function() {
        new simpleDatatables.DataTable('#TablaVerificacion');
        $('.verification-form').on('submit', function(e) {

            e.preventDefault();
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: $(this).serialize(),
                success: function() {
                    window.location.reload();
                }
            });
        });
    });

    function openPasswordModal(userId, username) {
        document.getElementById('modalUserId').value = userId;
        document.getElementById('modalUsername').value = username;
        var modal = new bootstrap.Modal(document.getElementById('passwordModal'));
        modal.show();
    }

    function updatePassword() {
        var form = document.getElementById('passwordForm');
        var password = form.elements['newPassword'].value;
        var confirm = document.getElementById('confirmPassword').value;

        if (password !== confirm) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Las contraseñas no coinciden'
            });
            return;
        }

        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: $(form).serialize(),
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Contraseña actualizada correctamente'
                    });
                    var modal = bootstrap.Modal.getInstance(document.getElementById('passwordModal'));
                    modal.hide();
                    form.reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al actualizar la contraseña'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar la contraseña'
                });
            }
        });
    }
</script>