<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once(PROCESOS_LOGIN_PATH . 'inicio_registrarse.php');
    exit;
}

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
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }

    .card-header {
        background: #111;
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
        color: #111;
    }

    .form-control:focus {
        border-color: #111;
        box-shadow: 0 0 0 0.25rem rgba(0,0,0,0.10);
    }

    .btn-primary {
        background: #111;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #222;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.10);
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

    /* Estilos adicionales para responsividad */
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

    /* Mejoras en la alineación de campos */
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .input-group {
        position: relative;
    }

    /* Ajustes para los mensajes de validación */
    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .just-validate-error-label {
        position: absolute;
        left: 0;
        top: 100%;
        font-size: 0.75rem;
        color: #dc3545;
        margin-top: 0.25rem;
    }

    /* Ajuste para el grupo de contraseña */
    .input-group {
        margin-bottom: 1.5rem;
    }
</style>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="h5 mb-0">✨ Registro ✨</h4>
                    </div>
                    <div class="card-body p-3 p-sm-4">
                        <form id="registrationForm" method="post">
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person-badge-fill"></i> Nombre de habbo</label>
                                <input type="text" class="form-control form-control-sm" name="habboName" required>
                                <small class="form-text text-muted"><i class="bi bi-info-circle"></i> Ingresa tu nombre exacto de Habbo</small>
                            </div>
                            <div class="mb-4">
                                <label class="form-label"><i class="bi bi-lock-fill"></i> Contraseña</label>
                                <div class="input-group input-group-sm">
                                    <input type="password" class="form-control" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <button type="submit" class="btn btn-primary btn-sm w-100">Registrarse</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php" class="text-decoration-none small" style="color: #4a6bff;">¿Ya tienes cuenta? Inicia sesión</a>
                            <br>
                            <a href="index.php" class="text-decoration-none small" style="color: #4a6bff;">Regresar al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            passwordInput.setAttribute('type', passwordInput.type === 'password' ? 'text' : 'password');
            this.querySelector('i').classList.toggle('bi-eye-fill');
            this.querySelector('i').classList.toggle('bi-eye-slash-fill');
        });

        const validator = new JustValidate('#registrationForm', {
            validateBeforeSubmitting: true,
            focusInvalidField: true,
            lockForm: true,
            errorFieldCssClass: 'is-invalid',
            successFieldCssClass: 'is-valid',
            errorLabelStyle: {
                fontSize: '12px',
                color: '#dc3545'
            }
        });

        validator
            .addField('[name="habboName"]', [{
                    rule: 'required',
                    errorMessage: 'El nombre de Habbo es requerido'
                },
                {
                    rule: 'maxLength',
                    value: 15,
                    errorMessage: 'No puede tener más de 15 caracteres'
                },
                {
                    rule: 'customRegexp',
                    value: /^[a-zA-Z0-9\-]+$/,
                    errorMessage: 'Solo letras, números y guiones permitidos'
                },
                {
                    rule: 'customRegexp',
                    value: /^(?:(?!SELECT|INSERT|UPDATE|DELETE|DROP|UNION|EXEC|ALTER|CREATE|TRUNCATE).)*$/i,
                    errorMessage: 'Caracteres no permitidos'
                }
            ])
            .addField('[name="password"]', [{
                    rule: 'required',
                    errorMessage: 'La contraseña es requerida'
                },
                {
                    rule: 'minLength',
                    value: 5,
                    errorMessage: 'Debe tener al menos 5 caracteres'
                },
                {
                    rule: 'maxLength',
                    value: 13,
                    errorMessage: 'No puede tener más de 13 caracteres'
                },
                {
                    rule: 'customRegexp',
                    value: /^[a-zA-Z0-9.!@#$%^&*()_+-=]+$/,
                    errorMessage: 'Solo se permiten letras, números y caracteres especiales comunes'
                }
            ])
            .onSuccess((event) => {
                event.preventDefault();
                grecaptcha.ready(() => {
                    grecaptcha.execute('6LfUGiwrAAAAAPDhTJ-D6pxFBueqlrs82xS_dVf0', {
                            action: 'register'
                        })
                        .then(token => {
                            document.getElementById('g-recaptcha-response').value = token;
                            fetch('registrar.php', {
                                    method: 'POST',
                                    body: new FormData(event.target)
                                })
                                .then(response => response.json())
                                .then(data => {
                                    Swal.fire({
                                        icon: data.success ? 'success' : 'error',
                                        title: data.success ? '¡Registro Exitoso!' : 'Error',
                                        text: data.message,
                                        confirmButtonColor: '#4a6bff'
                                    }).then(() => {
                                        if (data.success) window.location.href = 'login.php';
                                    });
                                })
                                .catch(() => {
                                    Swal.fire({
                                            icon: 'success',
                                            title: '¡Registro Exitoso!',
                                            text: 'Se registro correctamente',
                                            confirmButtonColor: '#4a6bff'
                                        })
                                        .then(() => {
                                            if (data.success) window.location.href = 'login.php';
                                        });
                                });
                        });
                });
            });
    </script>
</body>

<?php
require_once(TEMPLATES_PATH . 'footer.php');
?>