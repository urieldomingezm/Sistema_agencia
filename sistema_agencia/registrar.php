<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once(PROCESOS_LOGIN_PATH . 'inicio_registrarse.php');
    exit;
}

require_once(TEMPLATES_PATH . 'header.php');
require_once(PROCESOS_LOGIN_PATH . 'inicio_registrarse.php');
?>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #ffffff;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        border: 2px solid #4a6bff;
        box-shadow: 0 10px 20px rgba(74, 107, 255, 0.2);
    }

    .card-header {
        background: linear-gradient(135deg, #4a6bff 0%, #2541b2 100%);
        color: white;
        border-radius: 20px 20px 0 0 !important;
        border-bottom: 2px solid #ffffff;
        padding: 20px;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        border: 2px solid #e0e0e0;
    }

    .form-control:focus {
        border-color: #4a6bff;
        box-shadow: 0 0 0 0.25rem rgba(74, 107, 255, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #4a6bff 0%, #2541b2 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2541b2 0%, #4a6bff 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 65, 178, 0.3);
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
        margin-bottom: 2rem;  /* Aumentado para dar espacio a los mensajes */
        position: relative;
    }

    .just-validate-error-label {
        position: absolute;
        left: 0;
        top: 100%;  /* Cambiado de bottom a top */
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
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">✨ Registro ✨</h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="registrationForm" method="post">
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person-fill"></i> Usuario</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person-badge-fill"></i> Nombre en Habbo</label>
                                <input type="text" class="form-control" name="habboName" required>
                                <small class="form-text text-muted"><i class="bi bi-info-circle"></i> Ingresa tu nombre exacto de Habbo</small>
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
                            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php" class="text-decoration-none" style="color: #4a6bff;">¿Ya tienes cuenta? Inicia sesión</a>
                            <br>
                            <a href="index.php" class="text-decoration-none" style="color: #4a6bff;">Regresar al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
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
            .addField('[name="username"]', [
                {
                    rule: 'required',
                    errorMessage: 'El usuario es requerido'
                },
                {
                    rule: 'minLength',
                    value: 3,
                    errorMessage: 'El usuario debe tener al menos 3 caracteres'
                },
                {
                    rule: 'maxLength',
                    value: 16,
                    errorMessage: 'El usuario no puede tener más de 16 caracteres'
                }
            ])
            .addField('[name="habboName"]', [
                {
                    rule: 'required',
                    errorMessage: 'El nombre de Habbo es requerido'
                },
                {
                    rule: 'minLength',
                    value: 3,
                    errorMessage: 'El nombre debe tener al menos 3 caracteres'
                },
                {
                    rule: 'maxLength',
                    value: 16,
                    errorMessage: 'El nombre no puede tener más de 16 caracteres'
                }
            ])
            .addField('[name="password"]', [
                {
                    rule: 'required',
                    errorMessage: 'La contraseña es requerida'
                },
                {
                    rule: 'password',
                    errorMessage: 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número'
                },
                {
                    rule: 'maxLength',
                    value: 16,
                    errorMessage: 'La contraseña no puede tener más de 16 caracteres'
                }
            ])
            .onSuccess((event) => {
                event.preventDefault();
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LfUGiwrAAAAAPDhTJ-D6pxFBueqlrs82xS_dVf0', {
                        action: 'register'
                    })
                    .then(function(token) {
                        document.getElementById('g-recaptcha-response').value = token;
                        const form = event.target;
                        fetch('registrar.php', {
                            method: 'POST',
                            body: new FormData(form)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Registro Exitoso!',
                                    text: data.message,
                                    confirmButtonColor: '#4a6bff'
                                }).then(() => {
                                    window.location.href = 'login.php';
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
                                text: 'Ocurrió un error en el registro',
                                confirmButtonColor: '#4a6bff'
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