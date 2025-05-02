<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

// First handle the login POST request before any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once(PROCESOS_LOGIN_PATH . 'inicio_session.php');
    exit; // Stop execution after handling the POST request
}

// Only after handling POST, include the header and other content
require_once(TEMPLATES_PATH . 'header.php');
require_once(PROCESOS_LOGIN_PATH . 'inicio_session.php');
?>

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

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">✨ Iniciar Sesión ✨</h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="loginForm" method="post">
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person-fill"></i> Usuario</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label"><i class="bi bi-lock-fill"></i> Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye-fill"></i>
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
</body>

<script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye-fill');
            this.querySelector('i').classList.toggle('bi-eye-slash-fill');
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

<?php 
require_once(TEMPLATES_PATH . 'footer.php');
?>
