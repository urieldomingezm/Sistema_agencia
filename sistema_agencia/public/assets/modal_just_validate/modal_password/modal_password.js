// Función para mostrar/ocultar contraseña
document.getElementById('togglePassword1').addEventListener('click', function() {
    const passwordInput = document.getElementById('nueva_password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});

document.getElementById('togglePassword2').addEventListener('click', function() {
    const passwordInput = document.getElementById('confirmar_password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});

// Inicializar Just-Validate
document.addEventListener('DOMContentLoaded', function() {
    // Crear instancia de Just-Validate
    const validator = new JustValidate('#formCambiarPassword', {
        errorFieldCssClass: 'is-invalid',
        successFieldCssClass: 'is-valid',
        errorLabelStyle: {
            fontSize: '14px',
            color: '#dc3545',
        },
        focusInvalidField: true,
        lockForm: true,
    });

    // Agregar reglas de validación
    validator
        .addField('#nueva_password', [
            {
                rule: 'required',
                errorMessage: 'La contraseña es obligatoria',
            },
            {
                rule: 'minLength',
                value: 6,
                errorMessage: 'La contraseña debe tener al menos 6 caracteres',
            }
        ])
        .addField('#confirmar_password', [
            {
                rule: 'required',
                errorMessage: 'Debe confirmar la contraseña',
            },
            {
                validator: (value, fields) => {
                    return value === fields['#nueva_password'].elem.value;
                },
                errorMessage: 'Las contraseñas no coinciden',
            }
        ])
        .onSuccess((event) => {
            event.preventDefault();
            
            const usuarioId = document.getElementById('usuario_id').value;
            const nuevaPassword = document.getElementById('nueva_password').value;
            
            // Mostrar indicador de carga
            Swal.fire({
                title: 'Procesando',
                text: 'Actualizando contraseña...',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Crear FormData para enviar los datos
            const formData = new FormData();
            formData.append('usuario_id', usuarioId);
            formData.append('nueva_password', nuevaPassword);
            
            // Enviar los datos mediante fetch
            fetch(PROCESO_CAMBIAR_PACTH + 'modificar_password.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor: ' + response.status);
                }
                return response.text();
            })
            .then(data => {
                // Cerrar el modal
                const modalElement = document.getElementById('modalCambiarPassword');
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();
                
                // Verificar si la respuesta es "success"
                if (data.trim() === "success") {
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Contraseña actualizada correctamente',
                        icon: 'success',
                        confirmButtonText: 'Entendido'
                    }).then(() => {
                        // Recargar la página para actualizar los datos
                        window.location.reload();
                    });
                } else {
                    // Si la respuesta no es "success", mostrar un error
                    throw new Error('La respuesta del servidor no fue exitosa: ' + data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al actualizar la contraseña: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
            });
        });
});