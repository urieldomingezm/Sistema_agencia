<!-- Modal Notificación -->
<div class="modal fade" id="modalNotificacion" tabindex="-1" aria-labelledby="modalNotificacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="modalNotificacionLabel">Enviar Notificación</h5>
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
                                        $conn = $db->getConnection();
                                        $query = "SELECT id, usuario_registro FROM registro_usuario ORDER BY usuario_registro ASC";
                                        $stmt = $conn->prepare($query);
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
                                <label for="mensaje" class="form-label fw-bold">Mensaje (10-30 caracteres)</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="6" 
                                    style="resize: none;"></textarea>
                                <div class="form-text" id="mensajeHelp">
                                    <span id="digitCount">0 caracteres</span> (mínimo 10, máximo 30 caracteres)
                                </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const validator = new JustValidate('#formNotificacion', {
            errorFieldCssClass: 'is-invalid',
            successFieldCssClass: 'is-valid'
        });

        // Contador de caracteres
        const mensajeTextarea = document.getElementById('mensaje');
        const digitCountSpan = document.getElementById('digitCount');

        function contarCaracteres(texto) {
            return texto.length;
        }

        mensajeTextarea.addEventListener('input', function() {
            const caracteres = contarCaracteres(this.value);
            digitCountSpan.textContent = caracteres + ' caracteres';
            digitCountSpan.style.color = (caracteres >= 10 && caracteres <= 30) ? 'green' : 'red';
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
                    validator: (value) => {
                        const caracteres = contarCaracteres(value);
                        return caracteres >= 10 && caracteres <= 30;
                    },
                    errorMessage: 'El mensaje debe contener entre 10 y 30 caracteres'
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
                        }).then(() => {
                            window.location.reload();
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