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
    /* Estilos para JustValidate (se mantienen igual) */
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

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-primary text-white py-4">
                        <div class="text-center">
                            <h3 class="mb-0 fw-bold">¡Bienvenido de nuevo!</h3>
                            <p class="mb-0">Ingresa tus credenciales para continuar</p>
                        </div>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form id="loginForm" method="post" class="needs-validation" novalidate>
                            <div class="mb-4">
                                <label for="username" class="form-label fw-semibold">Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person-fill text-primary"></i></span>
                                    <input type="text" class="form-control py-2" id="username" name="username" placeholder="Ingresa tu usuario o email" required>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu usuario
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock-fill text-primary"></i></span>
                                    <input type="password" class="form-control py-2" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingresa tu contraseña
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Recordar sesión</label>
                                </div>
                                <a href="#" class="text-decoration-none text-primary fw-semibold">¿Olvidaste tu contraseña?</a>
                            </div>
                            
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3 mb-3">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                Iniciar Sesión
                            </button>
                            
                            <div class="text-center pt-3">
                                <p class="mb-0">¿No tienes una cuenta? <a href="registrar.php" class="text-decoration-none fw-semibold text-primary">Regístrate</a></p>
                                <p class="mb-0 mt-2"><a href="index.php" class="text-decoration-none text-muted"><i class="bi bi-arrow-left"></i> Volver al inicio</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Spinner (hidden by default) -->
    <div id="loadingOverlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-none justify-content-center align-items-center" style="z-index: 9999;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>
</body>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye-fill');
            icon.classList.add('bi-eye-slash-fill');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash-fill');
            icon.classList.add('bi-eye-fill');
        }
    });

    // Remember me functionality
    function handleRememberMe() {
        const rememberMe = document.getElementById('rememberMe');
        const usernameInput = document.getElementById('username');
        
        if (rememberMe.checked && usernameInput.value) {
            localStorage.setItem('rememberedUser', usernameInput.value);
        } else {
            localStorage.removeItem('rememberedUser');
        }
    }

    // Load remembered user
    window.addEventListener('load', function() {
        const rememberedUser = localStorage.getItem('rememberedUser');
        if (rememberedUser) {
            document.getElementById('username').value = rememberedUser;
            document.getElementById('rememberMe').checked = true;
        }
    });

    // Form submission with validation
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const form = event.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const spinner = submitBtn.querySelector('.spinner-border');
        const loadingOverlay = document.getElementById('loadingOverlay');
        
        // Show loading state
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');
        loadingOverlay.classList.remove('d-none');
        
        // Handle remember me
        handleRememberMe();
        
        // Execute reCAPTCHA
        grecaptcha.ready(function() {
            grecaptcha.execute('6LfUGiwrAAAAAPDhTJ-D6pxFBueqlrs82xS_dVf0', {action: 'login'})
                .then(function(token) {
                    document.getElementById('g-recaptcha-response').value = token;
                    
                    // Submit form via fetch
                    fetch('login.php', {
                        method: 'POST',
                        body: new FormData(form)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Inicio de sesión exitoso!',
                                text: data.message,
                                confirmButtonColor: '#0d6efd',
                                timer: 2000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = data.redirect || '/usuario/index.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Credenciales incorrectas',
                                confirmButtonColor: '#0d6efd'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al intentar iniciar sesión',
                            confirmButtonColor: '#0d6efd'
                        });
                    })
                    .finally(() => {
                        // Reset loading state
                        submitBtn.disabled = false;
                        spinner.classList.add('d-none');
                        loadingOverlay.classList.add('d-none');
                    });
                });
        });
    });

    // Bootstrap validation
    (function () {
        'use strict'
        
        const forms = document.querySelectorAll('.needs-validation')
        
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

<?php
require_once(TEMPLATES_PATH . 'footer.php');
?>