<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

// First handle the login POST request before any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once(PROCESOS_LOGIN_PATH . 'inicio_session.php');
    exit; // Stop execution after handling the POST request
}

// Only after handling POST, include the header and other content
require_once(TEMPLATES_PATH . 'header.php');
?>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f8f5ff;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        border: 2px solid #7b3ed1;
        box-shadow: 0 10px 20px rgba(123, 62, 209, 0.2);
    }

    .card-header {
        background: linear-gradient(135deg, #7b3ed1 0%, #5e2ca5 100%);
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
        border-color: #7b3ed1;
        box-shadow: 0 0 0 0.25rem rgba(123, 62, 209, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #7b3ed1 0%, #5e2ca5 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5e2ca5 0%, #7b3ed1 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(94, 44, 165, 0.3);
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
            /* Mejor legibilidad en móviles */
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
    }

    .input-group .form-control {
        border-right: none;
    }

    .input-group .btn-outline-secondary {
        border-left: none;
        background: white;
    }

    .input-group .btn-outline-secondary:hover {
        background: #f8f9fa;
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

    const validator = new JustValidate('#loginForm', {
        validateBeforeSubmitting: true,
        focusInvalidField: true,
        lockForm: true,
        errorFieldCssClass: 'is-invalid',
        successFieldCssClass: 'is-valid',
        errorLabelStyle: {
            fontSize: '12px',
            color: '#dc3545',
        }
    });

    validator
        .addField('[name="username"]', [{
                rule: 'required',
                errorMessage: 'El usuario es requerido'
            },
            {
                rule: 'maxLength',
                value: 13,
                errorMessage: 'No puede tener más de 13 caracteres'
            },
            {
                rule: 'customRegexp',
                value: /^[a-zA-Z0-9]+$/,
                errorMessage: 'Solo letras y números permitidos'
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
                value: /^[a-zA-Z0-9]+$/,
                errorMessage: 'Solo letras y números permitidos'
            }
        ])
        .onSuccess((event) => {
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

// Modificar el onSuccess del validador para incluir el manejo de "Recordar sesión"
validator.onSuccess((event) => {
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