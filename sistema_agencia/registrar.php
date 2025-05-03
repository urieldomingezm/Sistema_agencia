<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

// Primero manejar la solicitud POST antes de cualquier salida
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once(PROCESOS_LOGIN_PATH . 'inicio_registrarse.php');
    exit; // Detener ejecución después de manejar POST
}

// Solo después de manejar POST, incluir header y otros contenidos
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
        border: 2px solid #000000;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .card-header {
        background: linear-gradient(135deg, #000000 0%, #333333 100%);
        color: white;
        border-radius: 20px 20px 0 0 !important;
        border-bottom: 2px solid #ffffff;
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
                            <div id="verificationSection" style="display: none;" class="mb-3">
                                <label class="form-label"><i class="bi bi-shield-lock"></i> Código de Verificación</label>
                                <input type="text" class="form-control" name="verificationCode">
                                <small class="form-text text-muted"><i class="bi bi-info-circle"></i> Ingresa el código que colocaste en tu lema/motto de Habbo</small>
                            </div>
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php" class="text-decoration-none" style="color: #8B5CF6;">¿Ya tienes cuenta? Inicia sesión</a>
                            <br>
                            <a href="index.php" class="text-decoration-none" style="color: #8B5CF6;">regresar al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // visualizar contraseña
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye-fill');
            this.querySelector('i').classList.toggle('bi-eye-slash-fill');
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
    </script>
</body>


<?php
require_once(TEMPLATES_PATH . 'footer.php');
?>