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
<div class="modal fade" id="modalpagar" tabindex="-1" aria-labelledby="modalpagarLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="modalpagarLabel">
                    Registrar Pago
                </h5>
            </div>
            <div class="modal-body">
                <form method="POST" class="was-validated payment-form" id="pagoForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="pagas_usuario" id="userInput" required>
                                    <option value="" selected disabled>Seleccionar usuario</option>
                                    <?php
                                    $database = new Database();
                                    $db = $database->getConnection();
                                    $query = "SELECT usuario_registro FROM registro_usuario ORDER BY usuario_registro ASC";
                                    $stmt = $db->prepare($query);
                                    $stmt->execute();
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . htmlspecialchars($row['usuario_registro']) . '">' . htmlspecialchars($row['usuario_registro']) . '</option>';
                                    }
                                    ?>
                                </select>
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
                                        <label for="descriptionInput">Descripcion (Opcional)</label>
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
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-2"></i>Cancelar
                        </button>
                        <button type="submit" name="guardarPago" class="btn btn-outline-primary">
                            <i class="bi bi-save me-2"></i>Registrar Pago
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const validation = new JustValidate('#pagoForm', {
            validateBeforeSubmitting: true,
            errorFieldCssClass: 'is-invalid',
            errorLabelCssClass: 'invalid-feedback'
        });

        validation
            .addField('#userInput', [{
                    rule: 'required',
                    errorMessage: 'El usuario es requerido'
                },
                {
                    rule: 'maxLength',
                    value: 16,
                    errorMessage: 'Máximo 16 caracteres'
                }
            ])
            .addField('#amountInput', [{
                    rule: 'required',
                    errorMessage: 'El monto es requerido'
                },
                {
                    rule: 'number',
                    errorMessage: 'Debe ser un número válido'
                },
                {
                    rule: 'minNumber',
                    value: 1,
                    errorMessage: 'El monto debe ser mayor a 0'
                }
            ])
            .addField('#pagas_motivo', [{
                rule: 'required',
                errorMessage: 'Seleccione una membresía'
            }])
            .addField('#pagas_completo', [{
                rule: 'required',
                errorMessage: 'Seleccione un tipo de pago'
            }])
            .addField('#pagas_rango', [{
                rule: 'required',
                errorMessage: 'Seleccione un rango'
            }])
            .onSuccess((event) => {
                event.target.submit();
            });
    });
</script>