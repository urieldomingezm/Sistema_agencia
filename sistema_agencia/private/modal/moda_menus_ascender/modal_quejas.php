<div class="modal fade" id="modalQuejasSugerencias" tabindex="-1" aria-labelledby="modalQuejasSugerenciasLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="modalQuejasSugerenciasLabel">Quejas y Sugerencias</h5>
            </div>
            <div class="modal-body">
                <form id="formQuejasSugerencias" class="needs-validation">
                    <div class="mb-3">
                        <label for="asuntoQueja" class="form-label">Asunto</label>
                        <select class="form-select" id="asuntoQueja" name="asunto" data-validate-field="asunto">
                            <option value="">Seleccione un asunto</option>
                            <option value="Sugerencia">Sugerencia</option>
                            <option value="Problemas con mi dispositivo">Problemas con mi dispositivo</option>
                            <option value="sistema">Problemas con el Sistema</option>
                            <option value="otro">Otro</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="mensajeQueja" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="mensajeQueja" name="mensaje" rows="5"
                            data-validate-field="mensaje"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="formQuejasSugerencias" class="btn btn-outline-primary">Enviar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const validation = new JustValidate('#formQuejasSugerencias', {
        errorFieldCssClass: 'is-invalid',
        focusInvalidField: true,
        lockForm: true
    });

    validation
        .addField('#asuntoQueja', [{
                rule: 'required',
                errorMessage: 'El asunto es requerido'
            },
            {
                rule: 'minLength',
                value: 3,
                errorMessage: 'El asunto debe tener al menos 3 caracteres'
            }
        ])
        .addField('#mensajeQueja', [{
                rule: 'required',
                errorMessage: 'El mensaje es requerido'
            },
            {
                rule: 'minLength',
                value: 10,
                errorMessage: 'El mensaje debe tener al menos 10 caracteres'
            }
        ]);

    const asuntoQuejaSelect = document.getElementById('asuntoQueja');
    const mensajeQuejaTextarea = document.getElementById('mensajeQueja');
    const formQuejasSugerencias = document.getElementById('formQuejasSugerencias');

    const otroAsuntoContainer = document.createElement('div');
    otroAsuntoContainer.classList.add('mb-3');
    otroAsuntoContainer.style.display = 'none';

    const otroAsuntoLabel = document.createElement('label');
    otroAsuntoLabel.setAttribute('for', 'otroAsuntoInput');
    otroAsuntoLabel.classList.add('form-label');
    otroAsuntoLabel.textContent = 'Especificar Asunto';

    const otroAsuntoInput = document.createElement('input');
    otroAsuntoInput.setAttribute('type', 'text');
    otroAsuntoInput.setAttribute('id', 'otroAsuntoInput');
    otroAsuntoInput.setAttribute('name', 'otro_asunto');
    otroAsuntoInput.classList.add('form-control');

    const otroAsuntoInvalidFeedback = document.createElement('div');
    otroAsuntoInvalidFeedback.classList.add('invalid-feedback');

    otroAsuntoContainer.appendChild(otroAsuntoLabel);
    otroAsuntoContainer.appendChild(otroAsuntoInput);
    otroAsuntoContainer.appendChild(otroAsuntoInvalidFeedback);

    asuntoQuejaSelect.closest('.mb-3').after(otroAsuntoContainer);

    asuntoQuejaSelect.addEventListener('change', function() {
        if (this.value === 'otro') {
            otroAsuntoContainer.style.display = 'block';
            validation.addField('#otroAsuntoInput', [{
                    rule: 'required',
                    errorMessage: 'Debe especificar el asunto'
                },
                {
                    rule: 'minLength',
                    value: 5,
                    errorMessage: 'El asunto debe tener al menos 5 caracteres'
                }
            ]);
        } else {
            otroAsuntoContainer.style.display = 'none';
            validation.removeField('#otroAsuntoInput');
            otroAsuntoInput.value = '';
            otroAsuntoInput.classList.remove('is-invalid');
            otroAsuntoInvalidFeedback.textContent = '';
        }
    });

    validation.onSuccess((event) => {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const url = '/private/procesos/gestion_quejas/registrar_queja.php';

        if (formData.get('asunto') === 'otro') {
            const otroAsuntoValue = formData.get('otro_asunto');
            if (otroAsuntoValue) {
                formData.set('asunto', otroAsuntoValue);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe especificar el asunto cuando selecciona "Otro".'
                });
                return;
            }
        }
        formData.delete('otro_asunto');

        Swal.fire({
            title: 'Enviando...',
            text: 'Registrando tu queja/sugerencia...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error('Error en la respuesta del servidor (' + response.status + '): ' + text)
                    });
                }
                return response.json();
            })
            .then(data => {
                Swal.close();
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message
                    }).then(() => {
                        const modalElement = document.getElementById('modalQuejasSugerencias');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                        form.reset();
                        otroAsuntoContainer.style.display = 'none';
                        validation.removeField('#otroAsuntoInput');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Ocurrió un error al registrar la queja/sugerencia.'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo comunicar con el servidor. Inténtalo de nuevo más tarde. Detalles: ' + error.message
                });
            });
    });
</script>