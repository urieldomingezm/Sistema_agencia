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