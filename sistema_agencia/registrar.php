<?php
session_start();

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct()
    {
        $this->host = getenv('MYSQL_HOST') ?: 'localhost';
        $this->db_name = getenv('MYSQL_DATABASE') ?: 'sistema_agencia';
        $this->username = getenv('MYSQL_USER') ?: 'root';
        $this->password = getenv('MYSQL_PASSWORD') ?: '';

        if (!$this->host || !$this->db_name || !$this->username || !$this->password) {
            error_log("Error: Algunas variables de entorno no están definidas.");
        }
    }

    public function getConnection()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            error_log("Error de conexión: " . $exception->getMessage());
            echo "Error de conexión a la base de datos.";
        }

        return $this->conn;
    }
}

class UserRegistration
{
    private $conn;
    private $table = 'registro_usuario';

    public function __construct()
    {
        try {
            $database = new Database();
            $this->conn = $database->getConnection();
            if (!$this->conn) {
                throw new Exception("Error de conexión a la base de datos");
            }
        } catch (Exception $e) {
            error_log("Error en constructor UserRegistration: " . $e->getMessage());
            throw $e;
        }
    }

    private function getClientIP()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    private function checkExistingIP($ip)
    {
        $query = "SELECT COUNT(*) FROM {$this->table} WHERE ip_registro = :ip";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ip', $ip);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    private function validatePassword($password)
    {
        return strlen($password) >= 8 &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[a-z]/', $password) &&
            preg_match('/[0-9]/', $password);
    }

    private function generateVerificationCode()
    {
        return 'AT' . strtoupper(substr(md5(uniqid()), 0, 3));
    }

    public function register($username, $password, $habboName, $verificationCode = null)
    {
        try {
            if (empty($username) || empty($password) || empty($habboName)) {
                return ['success' => false, 'message' => 'Todos los campos son requeridos'];
            }

            $ip = $this->getClientIP();

            if ($this->checkExistingIP($ip)) {
                return ['success' => false, 'message' => 'Ya existe un registro con esta IP'];
            }

            // Primera fase: Generar código
            if (empty($verificationCode)) {
                $code = $this->generateVerificationCode();
                $_SESSION['temp_data'] = [
                    'username' => $username,
                    'password' => $password,
                    'habbo_name' => $habboName,
                    'verification_code' => $code,
                    'ip' => $ip
                ];
                return [
                    'success' => true,
                    'verification' => true,
                    'code' => $code,
                    'message' => 'Por favor, coloca este código en tu lema/motto de Habbo'
                ];
            }

            // Segunda fase: Verificación y registro
            if (!isset($_SESSION['temp_data']) || !isset($_SESSION['temp_data']['verification_code'])) {
                return ['success' => false, 'message' => 'Sesión expirada, por favor intenta nuevamente'];
            }

            if ($verificationCode !== $_SESSION['temp_data']['verification_code']) {
                return ['success' => false, 'message' => 'Código de verificación incorrecto'];
            }

            // Verificar si el nombre de Habbo ya existe
            $checkHabbo = "SELECT COUNT(*) FROM {$this->table} WHERE nombre_habbo = :habbo_name";
            $stmt = $this->conn->prepare($checkHabbo);
            $stmt->bindParam(':habbo_name', $_SESSION['temp_data']['habbo_name']);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                return ['success' => false, 'message' => 'Este nombre de Habbo ya está registrado'];
            }

            $hashedPassword = password_hash($_SESSION['temp_data']['password'], PASSWORD_DEFAULT);
            $query = "INSERT INTO {$this->table} 
                     (usuario_registro, password_registro, nombre_habbo, rol_id, rango, fecha_registro, ip_registro, verificado) 
                     VALUES (:username, :password, :habbo_name, 1, 'Agente', NOW(), :ip, 0)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $_SESSION['temp_data']['username']);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':habbo_name', $_SESSION['temp_data']['habbo_name']);
            $stmt->bindParam(':ip', $_SESSION['temp_data']['ip']);

            if ($stmt->execute()) {
                $_SESSION['user_id'] = $this->conn->lastInsertId();
                $_SESSION['username'] = $_SESSION['temp_data']['username'];
                $_SESSION['rango'] = 'En Espera de ser verificado';
                unset($_SESSION['temp_data']);
                return ['success' => true, 'message' => '¡Registro exitoso! Esperando verificación del moderador'];
            }

            return ['success' => false, 'message' => 'Error al guardar el registro'];
        } catch (PDOException $e) {
            error_log("Error en registro: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()];
        }
    }
}

// Manejo de la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $registration = new UserRegistration();
        $result = $registration->register($_POST['username'], $_POST['password'], $_POST['habboName'], isset($_POST['verificationCode']) ? $_POST['verificationCode'] : null);
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Agencia Atenas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Add Just-Validate library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> 
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #F3F0FF 0%, #E9D5FF 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 20px rgba(139, 92, 246, 0.1);
            backdrop-filter: blur(10px);
        }

        .card-header {
            background: linear-gradient(135deg, #A78BFA 0%, #8B5CF6 100%);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            border: none;
            padding: 20px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 2px solid #E9D5FF;
        }

        .form-control:focus {
            border-color: #8B5CF6;
            box-shadow: 0 0 0 0.25rem rgba(139, 92, 246, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #A78BFA 0%, #8B5CF6 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
            transform: translateY(-2px);
        }

        /* Add validation styles */
        .just-validate-error-label {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }

        .just-validate-error-field {
            border-color: #dc3545 !important;
        }

        .just-validate-success-field {
            border-color: #198754 !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">✨ Registro Agencia Atenas ✨</h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="registrationForm">
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nombre en Habbo</label>
                                <input type="text" class="form-control" name="habboName" required>
                                <small class="form-text text-muted">Ingresa tu nombre exacto de Habbo</small>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="verificationSection" style="display: none;" class="mb-3">
                                <label class="form-label">Código de Verificación</label>
                                <input type="text" class="form-control" name="verificationCode">
                                <small class="form-text text-muted">Ingresa el código que colocaste en tu lema/motto de Habbo</small>
                            </div>
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php" class="text-decoration-none" style="color: #8B5CF6;">¿Ya tienes cuenta? Inicia sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
// visualizar contraseña
document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
        // Initialize Just-Validate
        const validator = new JustValidate('#registrationForm', {
            validateBeforeSubmitting: true,
        });

        validator
            .addField('[name="username"]', [{
                    rule: 'required',
                    errorMessage: 'El usuario es requerido'
                },
                {
                    rule: 'minLength',
                    value: 3,
                    errorMessage: 'El usuario debe tener al menos 3 caracteres'
                }
            ])
            .addField('[name="habboName"]', [{
                    rule: 'required',
                    errorMessage: 'El nombre de Habbo es requerido'
                },
                {
                    rule: 'minLength',
                    value: 3,
                    errorMessage: 'El nombre debe tener al menos 3 caracteres'
                }
            ])
            .addField('[name="password"]', [{
                    rule: 'required',
                    errorMessage: 'La contraseña es requerida'
                },
                {
                    rule: 'password',
                    errorMessage: 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número'
                }
            ])
            .onSuccess((event) => {
                const form = event.target;
                fetch('registrar.php', {
                        method: 'POST',
                        body: new FormData(form)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.verification) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Código de Verificación',
                                html: `Tu código es: <strong>${data.code}</strong><br>
                           Por favor, coloca este código en tu lema/motto de Habbo.<br>
                           Una vez colocado, ingresa el código aquí para completar el registro.`,
                                confirmButtonColor: '#8B5CF6'
                            }).then(() => {
                                document.getElementById('verificationSection').style.display = 'block';
                                validator.addField('[name="verificationCode"]', [{
                                        rule: 'required',
                                        errorMessage: 'El código de verificación es requerido'
                                    },
                                    {
                                        rule: 'minLength',
                                        value: 5,
                                        errorMessage: 'El código debe tener 5 caracteres'
                                    }
                                ]);
                            });
                        } else if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Registro Exitoso!',
                                text: data.message,
                                confirmButtonColor: '#8B5CF6'
                            }).then(() => {
                                window.location.href = 'usuario/index.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message,
                                confirmButtonColor: '#8B5CF6'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error en el registro',
                            confirmButtonColor: '#8B5CF6'
                        });
                    });
            });

        // Remove the old event listener since Just-Validate handles it now
        // document.getElementById('registrationForm').addEventListener('submit'... 
    </script>
</body>

</html>