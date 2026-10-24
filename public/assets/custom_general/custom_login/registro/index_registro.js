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