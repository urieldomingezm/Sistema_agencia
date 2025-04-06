<?php
require_once(CONFIG_PATH . 'bd.php');

class Tiempo {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrarTiempo($usuario, $status, $acumulado, $restado, $transcurrido, $total, $encargado) {
        try {
            // Establecer valores por defecto para los campos
            $transcurrido = '00:00:00';
            $total = '00:00:00';
            $acumulado = '00:00:00';
            $restado = '00:00:00';
            $status = 'Corriendo';

            $sql = "INSERT INTO gestion_tiempo 
                    (tiempo_usuario, tiempo_status, tiempo_restado, tiempo_acumulado, tiempo_transcurrido, tiempo_total, tiempo_encargado_usuario, tiempo_fecha_registro) 
                    VALUES (:usuario, :status, :restado, :acumulado, :transcurrido, :total, :encargado, NOW())";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':acumulado', $acumulado);
            $stmt->bindParam(':transcurrido', $transcurrido);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':encargado', $encargado);
            $stmt->bindParam(':restado', $restado);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar tiempo: " . $e->getMessage());
            return false;
        }
    }
}

// Procesar formulario si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardarTiempo'])) {
    $database = new Database();
    $db = $database->getConnection();
    $tiempo = new Tiempo($db);

    $resultado = $tiempo->registrarTiempo(
        $_POST['tiempo_usuario'] ?? '',
        $_POST['tiempo_status'] ?? '',
        $_POST['restado'] ?? '00:00:00',
        '00:00:00',
        '00:00:00',
        '00:00:00',
        $_POST['tiempo_encargado_usuario'] ?? ''
    );
    

    if ($resultado) {
        echo "<script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'Tiempo registrado exitosamente',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/usuario/index.php?page=Gestion de tiempo';
            }
        });
    </script>";
    } else {
        echo "<script>
        Swal.fire({
            title: '¡Error!',
            text: 'Error al registrar tiempo',
            icon: 'error',
            confirmButtonText: 'Intentar de nuevo'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/usuario/index.php?page=Gestion de tiempo';
            }
        });
    </script>";
    }
}
?>

<div class="modal fade" id="modalTiempo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-info border-0">
                <h5 class="modal-title text-white">
                    <i class="fas fa-clock me-2"></i>Registro de Tiempo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="time-status text-center mb-4">
                    <div class="time-icon">
                        <i class="fas fa-hourglass-start"></i>
                    </div>
                    <div class="time-text">Iniciar Nuevo Registro</div>
                    <div class="time-display mt-2">00:00:00</div>
                </div>

                <form method="POST" class="was-validated">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" 
                                       name="tiempo_usuario" 
                                       maxlength="16" 
                                       class="form-control" 
                                       required 
                                       placeholder="Usuario">
                                <label><i class="fas fa-user text-info me-2"></i>Usuario</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>Usuario requerido
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" 
                                       name="tiempo_encargado_usuario" 
                                       maxlength="16" 
                                       class="form-control" 
                                       required 
                                       placeholder="Encargado">
                                <label><i class="fas fa-user-shield text-info me-2"></i>Encargado</label>
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>Encargado requerido
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-0 pt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" name="guardarTiempo" class="btn btn-info">
                            <i class="fas fa-play me-2"></i>Iniciar Tiempo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-info {
    background: linear-gradient(45deg, #36b9cc, #1a8a9c);
}

.modal-content {
    border-radius: 15px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.time-status {
    background: #f8f9fc;
    padding: 1.5rem;
    border-radius: 10px;
}

.time-icon {
    font-size: 2.5rem;
    color: #36b9cc;
    margin-bottom: 0.5rem;
    animation: rotate 2s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.time-text {
    color: #5a5c69;
    font-weight: 500;
}

.time-display {
    font-size: 2rem;
    font-family: monospace;
    color: #36b9cc;
    font-weight: bold;
}

.form-floating > label {
    padding-left: 1.75rem;
}

.form-control {
    border: 1px solid #e3e6f0;
    height: 3.2rem;
}

.form-control:focus {
    border-color: #36b9cc;
    box-shadow: 0 0 0 0.2rem rgba(54, 185, 204, 0.25);
}

.btn-info {
    background: linear-gradient(45deg, #36b9cc, #1a8a9c);
    border: none;
    color: white;
}

.btn-info:hover {
    background: linear-gradient(45deg, #1a8a9c, #158092);
    color: white;
}

.invalid-feedback {
    font-size: 80%;
    margin-left: 0.5rem;
}
</style>
