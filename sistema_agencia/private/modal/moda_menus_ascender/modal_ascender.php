<?php
require_once(CONFIG_PATH . 'bd.php');

class Ascenso
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registrarAscenso($usuario, $rango, $mision_antigua, $mision_nueva, $firma, $motivo, $hora_proxima, $encargado)
    {
        try {
            $sql = "INSERT INTO gestion_ascenso 
                    (ascenso_usuario, ascenso_rango, ascenso_mision_antigua, ascenso_mision_nueva, ascenso_firma, ascenso_status, ascenso_motivo, ascenso_hora_proxima, ascenso_encargado_usuario, ascenso_fecha_registro) 
                    VALUES (:usuario, :rango, :mision_antigua, :mision_nueva, :firma, 'en proceso', :motivo, :hora_proxima, :encargado, NOW())";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':rango', $rango);
            $stmt->bindParam(':mision_antigua', $mision_antigua);
            $stmt->bindParam(':mision_nueva', $mision_nueva);
            $stmt->bindParam(':firma', $firma);
            $stmt->bindParam(':motivo', $motivo);
            $stmt->bindParam(':hora_proxima', $hora_proxima);
            $stmt->bindParam(':encargado', $encargado);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar ascenso: " . $e->getMessage());
            return false;
        }
    }
}

// Función para obtener la hora según el rango
function obtenerHoraPorRango($rango)
{
    $horas = [
        'Agente' => '00:30:00', // 30 minutos
        'Seguridad' => '02:00:00', // 2 horas
        'Técnico' => '24:00:00', // 24 horas
        'Logística' => '48:00:00', // 62 horas
        'Supervisor' => '72:30:00', // 3 dias
        'Director' => '120:00:00', // 5 dias
        'Presidente' => '168:00:00', // 7 dias
        'Operativo' => '216:00:00' // 9 dias
    ];

    return isset($horas[$rango]) ? $horas[$rango] : '00:00:00';
}

// Procesar formulario si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardarAscenso'])) {
    $rango = $_POST['ascenso_rango'];
    $hora_proxima = obtenerHoraPorRango($rango);
    $database = new Database();
    $db = $database->getConnection();
    $ascenso = new Ascenso($db);

    $resultado = $ascenso->registrarAscenso(
        $_POST['ascenso_usuario'],
        $rango,
        $_POST['ascenso_mision_antigua'],
        $_POST['ascenso_mision_nueva'],
        $_POST['ascenso_firma'],
        $_POST['ascenso_motivo'],
        $hora_proxima, // Hora determinada según el rango
        $_POST['ascenso_encargado_usuario']
    );

    if ($resultado) {
        echo "<script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'Ascenso registrado exitosamente',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/usuario/index.php?page=gestion de ascensos';
            }
        });
    </script>";
    } else {
        echo "<script>
        Swal.fire({
            title: '¡Error!',
            text: 'Error al registrar ascenso',
            icon: 'error',
            confirmButtonText: 'Intentar de nuevo'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/usuario/index.php?page=gestion de ascensos';
            }
        });
    </script>";
    }
}
?>

<div class="modal fade" id="modalAscenso" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-success border-0">
                <h5 class="modal-title text-white">
                    <i class="fas fa-user-plus me-2"></i>Nuevo Ascenso
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="promotion-status text-center mb-4">
                    <div class="promotion-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div class="promotion-text">Nuevo Ascenso en Proceso</div>
                </div>

                <form method="POST" class="was-validated needs-validation">
                    <div class="row g-3">
                        <!-- Primera sección -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="ascenso_usuario" maxlength="14" class="form-control" required placeholder="Usuario">
                                <label><i class="fas fa-user text-success me-2"></i>Usuario</label>
                                <div class="invalid-feedback">Nombre de usuario requerido</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="ascenso_rango" class="form-select" required onchange="cambiarHoraProxima()">
                                    <option value="" disabled selected>Seleccionar rango</option>
                                    <option value="Agente">Agente</option>
                                    <option value="Seguridad">Seguridad</option>
                                    <option value="Técnico">Técnico</option>
                                    <option value="Logística">Logística</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Director">Director</option>
                                    <option value="Presidente">Presidente</option>
                                    <option value="Operativo">Operativo</option>
                                </select>
                                <label><i class="fas fa-star text-success me-2"></i>Rango</label>
                            </div>
                        </div>

                        <!-- Segunda sección -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="ascenso_mision_antigua" required class="form-control" placeholder="Misión Antigua">
                                <label><i class="fas fa-history text-success me-2"></i>Misión Antigua</label>
                                <div class="invalid-feedback">Misión antigua requerida</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="ascenso_mision_nueva" required placeholder="SNY- Agente -I -XDD #" class="form-control">
                                <label><i class="fas fa-tasks text-success me-2"></i>Misión Nueva</label>
                                <div class="invalid-feedback">Formato: SNY- Rango -I -XDD #</div>
                            </div>
                        </div>

                        <!-- Tercera sección -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="ascenso_firma" required maxlength="3" class="form-control text-uppercase" placeholder="Firma">
                                <label><i class="fas fa-signature text-success me-2"></i>Firma</label>
                                <div class="invalid-feedback">3 caracteres en mayúsculas</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="ascenso_motivo" class="form-select" required>
                                    <option value="" disabled selected>Seleccionar motivo</option>
                                    <option value="Cumple el tiempo">Cumple el tiempo</option>
                                    <option value="Traslado">Traslado</option>
                                    <option value="Aspirante">Aspirante</option>
                                </select>
                                <label><i class="fas fa-info-circle text-success me-2"></i>Motivo</label>
                            </div>
                        </div>

                        <!-- Cuarta sección -->
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" id="ascenso_hora_proxima" class="form-control" value="00:00:00" disabled>
                                <label><i class="fas fa-clock text-success me-2"></i>Tiempo de Espera</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" name="ascenso_encargado_usuario" required maxlength="16" class="form-control" placeholder="Encargado">
                                <label><i class="fas fa-user-shield text-success me-2"></i>Encargado</label>
                                <div class="invalid-feedback">Nombre del encargado requerido</div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-0 pb-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" name="guardarAscenso" class="btn btn-success">
                            <i class="fas fa-check me-2"></i>Confirmar Ascenso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-success {
    background: linear-gradient(45deg, #1cc88a, #169b6b);
}

.modal-content {
    border-radius: 15px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.promotion-status {
    background: #f8f9fc;
    padding: 1.5rem;
    border-radius: 10px;
}

.promotion-icon {
    font-size: 2.5rem;
    color: #1cc88a;
    margin-bottom: 0.5rem;
}

.promotion-text {
    color: #5a5c69;
    font-weight: 500;
}

.form-floating > label {
    padding-left: 1.75rem;
}

.form-control:focus, .form-select:focus {
    border-color: #1cc88a;
    box-shadow: 0 0 0 0.2rem rgba(28, 200, 138, 0.25);
}

.form-control, .form-select {
    border: 1px solid #e3e6f0;
}

.btn-success {
    background: linear-gradient(45deg, #1cc88a, #169b6b);
    border: none;
}

.btn-success:hover {
    background: linear-gradient(45deg, #169b6b, #147d55);
}

.invalid-feedback {
    font-size: 80%;
}
</style>

    <script>
        function cambiarHoraProxima() {
            var rango = document.querySelector('select[name="ascenso_rango"]').value;
            var horaProxima = document.getElementById('ascenso_hora_proxima');

            var horas = {
                'Agente': '00:30:00',
                'Seguridad': '02:00:00',
                'Técnico': '24:00:00',
                'Logística': '48:00:00',
                'Supervisor': '72:30:00',
                'Director': '120:00:00',
                'Presidente': '168:00:00',
                'Operativo': '216:00:00'
            };

            horaProxima.value = horas[rango] || '00:00:00'; // Cambiar la hora automáticamente según el rango
        }

        window.onload = cambiarHoraProxima;
    </script>

</body>