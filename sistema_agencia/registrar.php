<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once(PROCESOS_LOGIN_PATH . 'inicio_session.php');
    
    try {
        $login = new UserLogin();
        $result = $login->login($_POST['username'], $_POST['password']);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false, 
            'message' => 'Error del sistema: ' . $e->getMessage()
        ]);
    }
    exit;
}

require_once(TEMPLATES_PATH . 'header.php');
?>

<style>
    :root {
        --primary-color: #4a6bff;
        --secondary-color: #6c757d;
        --success-color: #198754;
        --error-color: #dc3545;
        --dark-color: #111;
        --light-color: #f8f9fa;
        --border-radius: 10px;
        --box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        --transition: all 0.3s ease;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f7ff;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .auth-card {
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        border: none;
        overflow: hidden;
        width: 100%;
        max-width: 500px;
    }

    .auth-card-header {
        background: var(--primary-color);
        color: #fff;
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .auth-card-body {
        padding: 30px;
    }

    .auth-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .auth-subtitle {
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--dark-color);
    }

    .form-control {
        border-radius: var(--border-radius);
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(74, 107, 255, 0.25);
    }

    .input-group-text {
        background-color: var(--light-color);
        border-radius: var(--border-radius) 0 0 var(--border-radius) !important;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        border-radius: var(--border-radius);
        padding: 12px;
        font-weight: 600;
        transition: var(--transition);
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #3a5bef;
        transform: translateY(-2px);
    }

    .auth-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 0.875rem;
    }

    .auth-link {
        color: var(--primary-color);
        font-weight: 500;
        text-decoration: none;
    }

    .auth-link:hover {
        text-decoration: underline;
    }

    /* Password toggle button */
    .password-toggle {
        border-radius: 0 var(--border-radius) var(--border-radius) 0 !important;
        cursor: pointer;
    }

    /* Remember me checkbox */
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Loading overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: none;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .auth-card-body {
            padding: 20px;
        }
    }
</style>

<body>
    <div class="auth-card">
        <div class="auth-card-header">
            <h1 class="auth-title">¡Bienvenido de vuelta!</h1>
            <p class="auth-subtitle">Ingresa tus credenciales para continuar</p>
        </div>
        <div class="auth-card-body">
            <form id="loginForm" method="post">
                <div class="mb-4">
                    <label for="username" class="form-label">
                        <i class="bi bi-person-fill me-2"></i>Usuario o Email
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Ingresa tu usuario o email" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock-fill me-2"></i>Contraseña
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                        <button class="btn btn-outline-secondary password-toggle" type="button" id="togglePassword">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                        <label class="form-check-label" for="rememberMe">Recordar sesión</label>
                    </div>
                    <a href="#" class="auth-link">¿Olvidaste tu contraseña?</a>
                </div>
                
                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                
                <button type="submit" class="btn btn-primary mb-4" id="submitBtn">
                    <span class="spinner-border spinner-border-sm d-none me-2" id="spinner" role="status" aria-hidden="true"></span>
                    Iniciar Sesión
                </button>
                
                <div class="auth-footer">
                    <p>¿No tienes una cuenta? <a href="registrar.php" class="auth-link">Regístrate</a></p>
                    <p class="mt-2"><a href="index.php" class="auth-link"><i class="bi bi-arrow-left me-1"></i>Volver al inicio</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

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

        // Form submission
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const form = event.target;
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('spinner');
            const loadingOverlay = document.getElementById('loadingOverlay');
            
            // Show loading state
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            loadingOverlay.style.display = 'flex';
            
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
                                    confirmButtonColor: 'var(--primary-color)',
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
                                    confirmButtonColor: 'var(--primary-color)'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ocurrió un error al intentar iniciar sesión',
                                confirmButtonColor: 'var(--primary-color)'
                            });
                        })
                        .finally(() => {
                            // Reset loading state
                            submitBtn.disabled = false;
                            spinner.classList.add('d-none');
                            loadingOverlay.style.display = 'none';
                        });
                    });
            });
        });
    </script>
</body>

<?php
require_once(TEMPLATES_PATH . 'footer.php');
?>