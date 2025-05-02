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

class UserLogin
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
            error_log("Error en constructor UserLogin: " . $e->getMessage());
            throw $e;
        }
    }

    public function login($username, $password)
    {
        try {
            if (empty($username) || empty($password)) {
                return ['success' => false, 'message' => 'Usuario y contraseña son requeridos'];
            }

            $query = "SELECT id, usuario_registro, password_registro, rol_id FROM {$this->table} 
                     WHERE usuario_registro = :username";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['password_registro'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['usuario_registro'];
                    $_SESSION['rol_id'] = $user['rol_id'];

                    return ['success' => true, 'message' => '¡Bienvenido!'];
                }
            }

            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al iniciar sesión'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $login = new UserLogin();
        $result = $login->login($_POST['username'], $_POST['password']);
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
    <title>Iniciar Sesión - Agencia Shein</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Add Just-Validate -->
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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

        /* Validation styles */
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
                        <h4 class="mb-0">✨ Iniciar Sesión ✨</h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="username" required>
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
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="registrar.php" class="text-decoration-none" style="color: #8B5CF6;">¿No tienes cuenta? Regístrate</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        const validator = new JustValidate('#loginForm', {
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
            .addField('[name="password"]', [{
                    rule: 'required',
                    errorMessage: 'La contraseña es requerida'
                },
                {
                    rule: 'minLength',
                    value: 8,
                    errorMessage: 'La contraseña debe tener al menos 8 caracteres'
                }
            ])
            .onSuccess((event) => {
                const form = event.target;
                fetch('login.php', {
                        method: 'POST',
                        body: new FormData(form)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Bienvenido!',
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
                            text: 'Error al iniciar sesión',
                            confirmButtonColor: '#8B5CF6'
                        });
                    });
            });
    </script>
</body>

</html>
