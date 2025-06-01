<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(PROCESO_CAMBIAR_PACTH . 'modificar_password.php');
?>
<div class="modal fade" id="modalCambiarPassword" tabindex="-1" aria-labelledby="modalCambiarPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCambiarPasswordLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <form id="formCambiarPassword" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" id="usuario_id" name="usuario_id">
                    
                    <div class="mb-3">
                        <label for="nombre_habbo" class="form-label fw-bold">Nombre de Habbo</label>
                        <input type="text" class="form-control" id="nombre_habbo" name="nombre_habbo" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nueva_password" class="form-label fw-bold">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="nueva_password" name="nueva_password">
                            <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                                    type="button" id="togglePassword1" 
                                    style="height: 100%; width: 50px;">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>                    </div>
                    
                    <div class="mb-3">
                        <label for="confirmar_password" class="form-label fw-bold">Confirmar Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmar_password" name="confirmar_password">
                            <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                                    type="button" id="togglePassword2" 
                                    style="height: 100%; width: 50px;">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary order-2 order-sm-1" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary order-1 order-sm-2 mb-2 mb-sm-0">
                            <i class="bi bi-check-circle me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
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
                body: formData,
                credentials: 'include' // Agregar esto para incluir cookies de sesión
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                const modalElement = document.getElementById('modalCambiarPassword');
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();
                
                if (data.success) {
                    Swal.fire({
                        title: 'Éxito',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Entendido'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.error || 'Error al actualizar la contraseña');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: error.message,
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
            });
        });
});
</script>