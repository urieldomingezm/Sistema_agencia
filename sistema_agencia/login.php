<?php
// Al inicio del archivo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

// Manejar la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once(PROCESOS_LOGIN_PATH . 'inicio_session.php');
    
    try {
        $login = new UserLogin();
        $result = $login->login($_POST['username'], $_POST['password']);
        
        error_log("Resultado del login: " . print_r($result, true));
        
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch (Exception $e) {
        error_log("Error en login.php: " . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false, 
            'message' => 'Error del sistema: ' . $e->getMessage()
        ]);
    }
    exit;
}

// Only after handling POST, include the header and other content
require_once(TEMPLATES_PATH . 'header.php');
?>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #fff;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 20px;
        border: 2px solid #222;
        box-shadow: 0 10px 20px rgba(34, 34, 34, 0.08);
    }

    .card-header {
        background: #222;
        color: #fff;
        border-radius: 20px 20px 0 0 !important;
        border-bottom: 2px solid #fff;
        padding: 20px;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        border: 2px solid #e0e0e0;
        background: #fff;
        color: #222;
    }

    .form-control:focus {
        border-color: #222;
        box-shadow: 0 0 0 0.25rem rgba(34, 34, 34, 0.08);
        background: #fff;
        color: #222;
    }

    .btn-primary {
        background: #222;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #000;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(34, 34, 34, 0.15);
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

    /* Responsiveness */
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }

        .card {
            margin: 10px;
        }

        .form-control {
            font-size: 16px;
        }
    }

    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .input-group {
        position: relative;
    }

    .just-validate-error-label {
        position: absolute;
        left: 0;
        bottom: -20px;
        font-size: 0.75rem;
        color: #dc3545;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #222;
    }

    .input-group .form-control {
        border-right: none;
    }

    .input-group .btn-outline-secondary {
        border-left: none;
        background: #fff;
        color: #222;
        border-color: #e0e0e0;
    }

    .input-group .btn-outline-secondary:hover {
        background: #f8f9fa;
        color: #000;
    }
</style>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">✨ Iniciar Sesión ✨</h4>
                    </div>
                    <div class="card-body p-3 p-sm-4">
                        <form id="loginForm" method="post">
                            <div class="form-group mb-3">
                                <label class="form-label"><i class="bi bi-person-fill"></i> Usuario</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label"><i class="bi bi-lock-fill"></i> Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                                <label class="form-check-label" for="rememberMe">Recordar mi sesión</label>
                            </div>
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="registrar.php" class="text-decoration-none" style="color: #4a6bff;">¿No tienes cuenta? Regístrate</a>
                            <br>
                            <a href="index.php" class="text-decoration-none" style="color: #4a6bff;">regresar al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.querySelector('input[name="password"]');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bi-eye-fill');
        this.querySelector('i').classList.toggle('bi-eye-slash-fill');
    });

    // Función para manejar el "Recordar sesión"
    function handleRememberMe() {
        const rememberMe = document.getElementById('rememberMe');
        const usernameInput = document.querySelector('input[name="username"]');
        
        if (rememberMe.checked) {
            // Guardar en localStorage con cifrado básico
            const encryptedUsername = btoa(usernameInput.value);
            localStorage.setItem('rememberedUser', encryptedUsername);
        } else {
            localStorage.removeItem('rememberedUser');
        }
    }

    // Cargar usuario recordado al cargar la página
    window.addEventListener('load', function() {
        const rememberedUser = localStorage.getItem('rememberedUser');
        if (rememberedUser) {
            const usernameInput = document.querySelector('input[name="username"]');
            usernameInput.value = atob(rememberedUser);
            document.getElementById('rememberMe').checked = true;
        }
    });

    // Event listener para el checkbox
    document.getElementById('rememberMe').addEventListener('change', handleRememberMe);

    // Manejo del envío del formulario sin JustValidate
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        handleRememberMe();
        event.preventDefault();
        grecaptcha.ready(function() {
            grecaptcha.execute('6LfUGiwrAAAAAPDhTJ-D6pxFBueqlrs82xS_dVf0', {
                    action: 'login'
                })
                .then(function(token) {
                    document.getElementById('g-recaptcha-response').value = token;
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
                                    confirmButtonColor: '#4a6bff'
                                }).then(() => {
                                    if (data.redirect) {
                                        window.location.href = data.redirect;
                                    } else {
                                        window.location.href = '/usuario/index.php';
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message,
                                    confirmButtonColor: '#4a6bff'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al iniciar sesión',
                                confirmButtonColor: '#4a6bff'
                            });
                        });
                });
        });
    });
</script>

<?php
require_once(TEMPLATES_PATH . 'footer.php');
?>