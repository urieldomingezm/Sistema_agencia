<!-- Modal Notificación -->
<div class="modal fade" id="modalNotificacion" tabindex="-1" aria-labelledby="modalNotificacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="modalNotificacionLabel">Enviar Notificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNotificacion" method="POST">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="destinatario" class="form-label fw-bold">Destinatario</label>
                                <select class="form-select" id="destinatario" name="destinatario">
                                    <option value="">Seleccione un destinatario</option>
                                    <?php
                                    require_once(CONFIG_PATH . 'bd.php');
                                    
                                    try {
                                        $db = new Database();
                                        $query = "SELECT id, usuario_registro FROM registro_usuario ORDER BY usuario_registro ASC";
                                        $stmt = $db->prepare($query);
                                        $stmt->execute();
                                        
                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='". htmlspecialchars($row['id']) ."'>" . 
                                                 htmlspecialchars($row['usuario_registro']) . "</option>";
                                        }
                                    } catch(PDOException $e) {
                                        error_log('Error al cargar usuarios: ' . $e->getMessage());
                                        echo "<option value=''>Error al cargar usuarios</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="mensaje" class="form-label fw-bold">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="6" 
                                    style="resize: none;" maxlength="500"></textarea>
                                <div class="form-text" id="mensajeHelp">Caracteres restantes: <span id="charCount">500</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Enviar Notificación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para validación y envío del formulario -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const validator = new JustValidate('#formNotificacion', {
            errorFieldCssClass: 'is-invalid',
            successFieldCssClass: 'is-valid'
        });

        // Contador de caracteres
        const mensajeTextarea = document.getElementById('mensaje');
        const charCountSpan = document.getElementById('charCount');

        mensajeTextarea.addEventListener('input', function() {
            const remainingChars = 500 - this.value.length;
            charCountSpan.textContent = remainingChars;
            if (remainingChars < 50) {
                charCountSpan.style.color = 'red';
            } else {
                charCountSpan.style.color = '';
            }
        });

        validator
            .addField('#destinatario', [
                {
                    rule: 'required',
                    errorMessage: 'Por favor seleccione un destinatario'
                }
            ])
            .addField('#mensaje', [
                {
                    rule: 'required',
                    errorMessage: 'Por favor ingrese un mensaje'
                },
                {
                    rule: 'minLength',
                    value: 10,
                    errorMessage: 'El mensaje debe tener al menos 10 caracteres'
                },
                {
                    rule: 'maxLength',
                    value: 500,
                    errorMessage: 'El mensaje no puede exceder los 500 caracteres'
                }
            ])
            .onSuccess((event) => {
                event.preventDefault();
                
                const formData = new FormData(document.getElementById('formNotificacion'));

                fetch('/private/procesos/gestion_notificaciones/registrar_notificacion.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'La notificación ha sido enviada correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const modal = bootstrap.Modal.getInstance(document.getElementById('modalNotificacion'));
                                modal.hide();
                                document.getElementById('formNotificacion').reset();
                                charCountSpan.textContent = '500';
                                charCountSpan.style.color = '';
                                if (typeof notificacionesTable !== 'undefined') {
                                    notificacionesTable.ajax.reload();
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Hubo un error al enviar la notificación',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un error en la comunicación con el servidor',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                });
            });
    });
</script>