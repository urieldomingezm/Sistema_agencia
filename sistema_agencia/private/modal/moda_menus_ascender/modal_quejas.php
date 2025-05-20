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
    .addField('#asuntoQueja', [
        {
            rule: 'required',
            errorMessage: 'El asunto es requerido'
        },
        {
            rule: 'minLength',
            value: 3,
            errorMessage: 'El asunto debe tener al menos 3 caracteres'
        }
    ])
    .addField('#mensajeQueja', [
        {
            rule: 'required',
            errorMessage: 'El mensaje es requerido'
        },
        {
            rule: 'minLength',
            value: 10,
            errorMessage: 'El mensaje debe tener al menos 10 caracteres'
        }
    ])
    .onSuccess((event) => {
        // Handle form submission here
        console.log('Form submitted successfully');
    });
</script>
