<?php
require_once(CONFIG_PATH . 'bd.php');

class Pago
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registrarPago($usuario, $recibio, $motivo, $completo, $descripcion, $rango)
    {
        try {
            $sql = "INSERT INTO gestion_pagas 
                    (pagas_usuario, pagas_recibio, pagas_motivo, pagas_rango, pagas_completo, pagas_descripcion, pagas_fecha_registro) 
                    VALUES (:usuario, :recibio, :motivo, :rango, :completo, :descripcion, NOW())";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':recibio', $recibio);
            $stmt->bindParam(':motivo', $motivo);
            $stmt->bindParam(':completo', $completo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':rango', $rango);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar pago: " . $e->getMessage());
            return false;
        }
    }
}

// Procesar formulario si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardarPago'])) {
    $database = new Database();
    $db = $database->getConnection();
    $pago = new Pago($db);

    $resultado = $pago->registrarPago(
        $_POST['pagas_usuario'],
        $_POST['pagas_recibio'],
        $_POST['pagas_motivo'],
        $_POST['pagas_completo'],
        $_POST['pagas_descripcion'],
        $_POST['pagas_rango']
    );

    if ($resultado) {
        echo "<script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'Pago registrado exitosamente',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/usuario/index.php?page=gestion_de_pagas';
            }
        });
        </script>";
    } else {
        echo "<script>
        Swal.fire({
            title: '¡Error!',
            text: 'Error al registrar pago',
            icon: 'error',
            confirmButtonText: 'Intentar de nuevo'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/usuario/index.php?page=gestion_de_pagas';
            }
        });
        </script>";
    }
}
?>

<!-- Modal para Registrar Pago -->
<div class="modal fade" id="modalpagar" tabindex="-1" aria-labelledby="modalpagarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalpagarLabel">
                    <i class="fas fa-money-bill-wave me-2"></i>Registrar Pago
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="was-validated payment-form">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" name="pagas_usuario" maxlength="16" class="form-control" id="userInput" placeholder="Usuario" required>
                                <label for="userInput">Usuario</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" name="pagas_recibio" class="form-control" id="amountInput" placeholder="Monto" required>
                                <label for="amountInput">Monto Recibido</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="pagas_motivo" class="form-select" id="pagas_motivo" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="Ninguno">Ninguno</option>
                                    <option value="Guarda paga">Guarda paga</option>
                                    <option value="Diamante">Diamante</option>
                                </select>
                                <label for="pagas_motivo">Membresía usada</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="pagas_completo" id="pagas_completo" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="Nomina">Nómina</option>
                                    <option value="Bonificacion">Bonificación</option>
                                    <option value="Completo">Completo</option>
                                </select>
                                <label for="pagas_completo">Tipo de Pago</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="pagas_descripcion" placeholder="Descripción" id="descriptionInput">
                                        <label for="descriptionInput">(Opcional)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="pagas_rango" id="pagas_rango" required>
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="Seguridad">Seguridad</option>
                                            <option value="Tecnico">Tecnico</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Director">Director</option>
                                            <option value="Presidente">Presidente</option>
                                            <option value="Operativo">Operativo</option>
                                            <option value="Junta directiva">Junta directiva</option>
                                        </select>
                                        <label for="pagas_rango">Rango de usuario</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" name="guardarPago" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Registrar Pago
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background: linear-gradient(135deg, #00c6fb 0%, #005bea 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        border: none;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .payment-form .form-control,
    .payment-form .form-select {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .payment-form .form-control:focus,
    .payment-form .form-select:focus {
        border-color: #005bea;
        box-shadow: 0 0 0 0.2rem rgba(0, 91, 234, 0.25);
    }

    .payment-form .form-floating label {
        padding-left: 1rem;
    }

    .payment-form .form-floating>.form-control,
    .payment-form .form-floating>.form-select {
        height: calc(3.5rem + 2px);
        line-height: 1.25;
    }

    .payment-form textarea.form-control {
        height: 100px !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, #00c6fb 0%, #005bea 100%);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 91, 234, 0.2);
    }

    .btn-outline-secondary {
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
        .modal-body {
            padding: 1.5rem;
        }
    }
</style>