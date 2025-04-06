<?php
require_once(CONFIG_PATH . 'bd.php');

class Ascenso {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrarAscenso($usuario, $rango, $misionAntigua, $misionNueva, $firma, $encargado) {
        try {
            // Determinar tiempo de espera según el rango
            $tiemposEspera = [
                'Agente' => '00:30:00',
                'Seguridad' => '02:00:00',
                'Tecnico' => '24:00:00',
                'Logistica' => '48:00:00',
                'Supervisor' => '72:00:00',
                'Director' => '120:00:00',
                'Presidente' => '168:00:00',
                'Operativo' => '240:00:00',
                'Junta directiva' => '360:00:00'
            ];

            $sql = "INSERT INTO gestion_ascenso (
                ascenso_usuario, ascenso_rango, ascenso_mision_antigua, 
                ascenso_mision_nueva, ascenso_firma, ascenso_status, 
                ascenso_hora_proxima, ascenso_encargado_usuario, 
                ascenso_fecha_registro
            ) VALUES (
                :usuario, :rango, :mision_antigua, :mision_nueva, 
                :firma, 'En proceso', :hora_proxima, :encargado, 
                NOW()
            )";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':rango', $rango);
            $stmt->bindParam(':mision_antigua', $misionAntigua);
            $stmt->bindParam(':mision_nueva', $misionNueva);
            $stmt->bindParam(':firma', $firma);
            $stmt->bindParam(':hora_proxima', $tiemposEspera[$rango]);
            $stmt->bindParam(':encargado', $encargado);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar ascenso: " . $e->getMessage());
            return false;
        }
    }
}

// Procesar formulario si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardarAscenso'])) {
    header('Content-Type: application/json');
    
    try {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        $database = new Database();
        $db = $database->getConnection();
        $ascenso = new Ascenso($db);

        if (empty($_POST['ascenso_usuario']) || empty($_POST['ascenso_rango'])) {
            throw new Exception('Campos requeridos faltantes');
        }

        $resultado = $ascenso->registrarAscenso(
            $_POST['ascenso_usuario'],
            $_POST['ascenso_rango'],
            $_POST['mision_antigua'] ?? '',
            $_POST['ascenso_mision_nueva'],
            $_POST['ascenso_firma'],
            $_SESSION['username']
        );

        if ($resultado) {
            echo json_encode(['success' => true, 'message' => 'Ascenso registrado correctamente']);
        } else {
            throw new Exception('Error al registrar el ascenso');
        }
    } catch (Exception $e) {
        error_log("Error en ascenso: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}
?>

<!-- Modal HTML -->
<div class="modal fade" id="modal_ascender" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-success border-0">
                <h5 class="modal-title text-white">
                    <i class="fas fa-arrow-up me-2"></i>Registrar persona
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="promotion-indicator text-center mb-4">
                    <div class="rank-change">
                        <i class="fas fa-user-circle current-rank"></i>
                        <i class="fas fa-arrow-up arrow-up"></i>
                        <i class="fas fa-user-circle new-rank"></i>
                    </div>
                </div>

                <form id="promotionForm" method="POST">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user text-success me-2"></i>Usuario
                                </label>
                                <input type="text" class="form-control" name="ascenso_usuario" required>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">
                                    <i class="fas fa-history text-success me-2"></i>Misión Anterior
                                </label>
                                <input class="form-control" name="mision_antigua">
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">
                                    <i class="fas fa-tasks text-success me-2"></i>Misión Nueva
                                </label>
                                <input class="form-control" name="ascenso_mision_nueva" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-star text-success me-2"></i>Nuevo Rango
                                </label>
                                <select class="form-select" name="ascenso_rango" required>
                                    <option value="" disabled selected>Seleccionar rango...</option>
                                    <option value="Agente">Agente</option>
                                    <option value="Seguridad">Seguridad</option>
                                    <option value="Tecnico">Técnico</option>
                                    <option value="Logistica">Logística</option>
                                    <option value="Supervisor">Superviso</option>
                                    <option value="Director">Director</option>
                                    <option value="Presidente">Presidente</option>
                                    <option value="Operativo">Operativo</option>
                                    <option value="Junta directiva">Junta directiva</option>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">
                                    <i class="fas fa-signature text-success me-2"></i>Firma
                                </label>
                                <input class="form-control" name="ascenso_firma" id="firma" maxlength="3" required>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">
                                    <i class="fas fa-user-shield text-success me-2"></i>Encargado
                                </label>
                                <input class="form-control" name="ascenso_encargado_usuario"
                                    value="<?php echo htmlspecialchars($_SESSION['username']); ?>"
                                    readonly required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <input type="hidden" name="guardarAscenso" value="1">
        </form>
        <div class="modal-footer border-0 bg-light">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <i class="fas fa-times me-2"></i>Cancelar
            </button>
            <button type="submit" form="promotionForm" class="btn btn-success">
                <i class="fas fa-arrow-up me-2"></i>Confirmar Promoción
            </button>
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

    .promotion-indicator {
        padding: 1rem;
        background: #f8f9fc;
        border-radius: 10px;
    }

    .rank-change {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        font-size: 2rem;
    }

    .current-rank {
        color: #858796;
    }

    .arrow-up {
        color: #1cc88a;
        font-size: 1.5rem;
        animation: bounce 1s infinite;
    }

    .new-rank {
        color: #4e73df;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    .form-control,
    .form-select {
        border: 1px solid #e3e6f0;
        padding: 0.75rem;
        font-size: 0.9rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1cc88a;
        box-shadow: 0 0 0 0.2rem rgba(28, 200, 138, 0.25);
    }

    .form-label {
        font-weight: 500;
        color: #5a5c69;
    }

    .btn-success {
        background: linear-gradient(45deg, #1cc88a, #169b6b);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(45deg, #169b6b, #147d55);
    }
</style>

<script>
    document.getElementById('promotionForm').addEventListener('submit', function(e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        const formData = new FormData(this);
        formData.append('guardarAscenso', '1');

        fetch(window.location.href, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text().then(text => {
                try {
                    if (text.trim() === '') {
                        throw new Error('Empty response');
                    }
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Server response:', text);
                    throw new Error('Server response was not valid JSON');
                }
            });
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: '¡Éxito!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#1cc88a'
                }).then(() => {
                    location.reload();
                });
            } else {
                throw new Error(data.error || 'Error al registrar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: error.message,
                icon: 'error',
                confirmButtonColor: '#e74a3b'
            });
        });
    });

    // Agregar validación de formulario
    document.getElementById('submitBtn').addEventListener('click', function(e) {
        const form = document.getElementById('promotionForm');
        if (!form.checkValidity()) {
            e.preventDefault();
            form.reportValidity();
        }
    });

// Function to generate mission
function generarMision() {
    const rango = document.querySelector('select[name="ascenso_rango"]').value;
    const firma = document.getElementById('firma').value;
    const misionInput = document.querySelector('input[name="ascenso_mision_nueva"]');

    if (rango && firma) {
        // Determine roman numeral level based on rank
        const niveles = {
            'Agente': 'I',
            'Seguridad': 'I', 
            'Tecnico': 'I',
            'Logistica': 'I',
            'Supervisor': 'I',
            'Director': 'I',
            'Presidente': 'I',
            'Operativo': 'I',
            'Junta directiva': 'I'
        };

        const nivel = niveles[rango] || 'I';
        const mision = `ATN- ${rango} ${nivel} -${firma.toUpperCase()} -SDD #`;
        misionInput.value = mision;
    }
}

// Add event listeners
document.addEventListener('DOMContentLoaded', function() {
    const rangoSelect = document.querySelector('select[name="ascenso_rango"]');
    const firmaInput = document.getElementById('firma');

    if (rangoSelect) {
        rangoSelect.addEventListener('change', generarMision);
    }

    if (firmaInput) {
        firmaInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
            if (this.value.length === 3) {
                generarMision();
            }
        });
    }
});
</script>
