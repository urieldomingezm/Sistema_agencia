<div class="modal fade" id="modificarRangoModal" tabindex="-1" aria-labelledby="modificarRangoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modificarRangoModalLabel">Modificar Rango</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="codigoTimeUsuario">

                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3">Información del Usuario</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <p><span class="fw-semibold">Nombre Habbo:</span> <span id="infoNombreHabbo"></span></p>
                        </div>
                        <div class="col-md-4">
                            <p><span class="fw-semibold">Rango Actual:</span> <span id="infoRangoActual" class="badge bg-primary"></span></p>
                        </div>
                        <div class="col-md-4">
                            <p><span class="fw-semibold">Misión actual:</span> <span id="infoMisionActual"></span></p>
                        </div>
                        <div class="col-md-4">
                            <p><span class="fw-semibold">Firma:</span> <span id="infoFirmaUsuario"></span></p>
                        </div>
                    </div>
                </div>

                <div class="border-top pt-3">
                    <h6 class="fw-bold text-primary mb-3">Modificar Campos</h6>
                    <form id="formModificarRango" novalidate>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nuevoRango" class="form-label">Rango</label>
                                    <select class="form-select" id="nuevoRango" name="nuevoRango" required>
                                        <option value="">Seleccionar</option>
                                        <option value="agente">Agente</option>
                                        <option value="seguridad">Seguridad</option>
                                        <option value="tecnico">Técnico</option>
                                        <option value="logistica">Logística</option>
                                        <option value="supervisor">Supervisor</option>
                                        <option value="director">Director</option>
                                        <option value="presidente">Presidente</option>
                                        <option value="operativo">Operativo</option>
                                        <option value="junta directiva">Junta Directiva</option>
                                        <option value="administrador">Administrador</option>
                                        <option value="manager">Manager</option>
                                        <option value="fundador">Fundador</option>
                                        <option value="owner">Dueño</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nuevaMision" class="form-label">Misión</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="nuevaMision" 
                                           name="nuevaMision"
                                           data-validate-field="mision">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nuevaFirma" class="form-label">Firma (3 chars)</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="nuevaFirma" 
                                           name="nuevaFirma"
                                           data-validate-field="firma">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    class UserModificationModalHandler {
        constructor() {
            this.modal = document.getElementById('modificarRangoModal');
            this.form = document.getElementById('formModificarRango');
            this.userIdInput = document.getElementById('codigoTimeUsuario');
            this.infoNombreHabbo = document.getElementById('infoNombreHabbo');
            this.infoRangoActual = document.getElementById('infoRangoActual');
            this.infoMisionActual = document.getElementById('infoMisionActual');
            this.infoFirmaUsuario = document.getElementById('infoFirmaUsuario');
            this.nuevaMisionInput = document.getElementById('nuevaMision');
            this.nuevaFirmaInput = document.getElementById('nuevaFirma');
            this.nuevoRangoSelect = document.getElementById('nuevoRango');

            this.initModalEvents();
            this.initFormEvents();
            this.nuevoRangoSelect.addEventListener('change', (e) => this.handleRankChange(e));

            // Configuración de validación de palabras largas
            this.MAX_WORD_LENGTH = 19; // Máximo 19 caracteres por palabra
        }

        initModalEvents() {
            this.modal.addEventListener('show.bs.modal', (e) => this.handleModalShow(e));
        }

        handleModalShow(e) {
            const button = e.relatedTarget;
            const userId = button.getAttribute('data-id');
            this.userIdInput.value = userId;
            this.fetchUserData(userId);
        }

        fetchUserData(userId) {
            fetch('/private/procesos/gestion_modificar/buscar.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        id: userId
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const misionCompleta = data.data.mision_actual;
                        const firma = data.data.firma_usuario;

                        let misionBase = misionCompleta;
                        if (firma) {
                            misionBase = misionCompleta.replace(` -${firma}`, '').replace(` -XDD #A`, '');
                        } else {
                            misionBase = misionCompleta.replace(` -XDD #A`, '');
                        }

                        this.infoNombreHabbo.textContent = data.data.nombre_habbo;
                        this.infoRangoActual.textContent = data.data.rango_actual;
                        this.infoMisionActual.textContent = misionCompleta;
                        this.infoFirmaUsuario.textContent = firma ? firma : 'No disponible';

                        this.nuevoRangoSelect.value = data.data.rango_actual;
                        this.handleFirmaVisibility(data.data.rango_actual);

                        // Aplicar filtro de palabras largas a la misión base
                        misionBase = this.filterLongWords(misionBase);
                        this.nuevaMisionInput.value = misionBase;
                        this.nuevaFirmaInput.value = firma || '';

                        this.misionBase = misionBase;
                        const event = new Event('change');
                        this.nuevoRangoSelect.dispatchEvent(event);
                    } else {
                        console.error('Error al cargar datos del usuario:', data.error);
                        this.showError('No se pudieron cargar los datos del usuario: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud de búsqueda:', error);
                    this.showError('Ocurrió un error de red al cargar los datos del usuario.');
                });
        }

        handleFirmaVisibility(rango) {
            const rangosBasicos = ['agente', 'seguridad', 'tecnico', 'logistica'];
            const firmaContainer = this.nuevaFirmaInput.closest('.mb-3');

            if (rangosBasicos.includes(rango)) {
                firmaContainer.style.display = 'none';
                this.nuevaFirmaInput.value = '';
                this.nuevaFirmaInput.required = false;
            } else {
                firmaContainer.style.display = 'block';
                this.nuevaFirmaInput.required = true;
            }
        }

        initFormEvents() {
            this.form.addEventListener('submit', (event) => {
                event.preventDefault();
                if (this.validateForm()) {
                    this.handleFormSubmit(event);
                }
            });

            // Validación en tiempo real para palabras largas
            this.nuevaMisionInput.addEventListener('input', (e) => {
                e.target.value = this.filterLongWords(e.target.value);
            });
        }

        filterLongWords(text) {
            // Elimina palabras con más de MAX_WORD_LENGTH caracteres
            return text.replace(new RegExp(`\\b\\w{${this.MAX_WORD_LENGTH + 1},}\\b`, 'g'), '');
        }

        validateForm() {
            const nuevoRango = this.nuevoRangoSelect.value;
            let nuevaMision = this.missionSelect ? this.missionSelect.value : this.nuevaMisionInput.value;
            const nuevaFirma = this.nuevaFirmaInput.value;
            const rangosBasicos = ['agente', 'seguridad', 'tecnico', 'logistica'];

            // Validación de rango
            if (!nuevoRango) {
                this.showError('El rango es requerido.');
                return false;
            }

            // Validación de misión
            if (!nuevaMision) {
                this.showError('La misión es requerida.');
                return false;
            }

            if (nuevaMision.length < 12) {
                this.showError('La misión debe tener al menos 12 caracteres.');
                return false;
            }

            // Validación de caracteres permitidos
            if (!/^[a-zA-Z0-9\s\-_.,#]+$/.test(nuevaMision)) {
                this.showError('La misión contiene caracteres no permitidos.');
                return false;
            }

            // Validación de firma para rangos no básicos
            if (!rangosBasicos.includes(nuevoRango)) {
                if (!nuevaFirma) {
                    this.showError('La firma es requerida para este rango.');
                    return false;
                }

                if (!/^[A-Z0-9]{3}$/.test(nuevaFirma)) {
                    this.showError('El formato de la firma es inválido. Debe ser 3 caracteres alfanuméricos en mayúsculas.');
                    return false;
                }
            }

            return true;
        }

        handleFormSubmit(event) {
            const userId = this.userIdInput.value;
            const nuevoRango = this.nuevoRangoSelect.value;
            let nuevaMision = this.missionSelect ? this.missionSelect.value : this.nuevaMisionInput.value;
            const nuevaFirma = this.nuevaFirmaInput.value;

            // Asegurarse de que la misión no tenga palabras largas
            nuevaMision = this.filterLongWords(nuevaMision);

            // Formatear la misión con la firma si existe
            if (nuevaFirma) {
                nuevaMision = `${nuevaMision} -${nuevaFirma}`;
            }
            nuevaMision = `${nuevaMision} -XDD #A`;

            this.showLoading('Guardando cambios...');

            fetch('/private/procesos/gestion_modificar/modificar.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        userId: userId,
                        nuevoRango: nuevoRango,
                        nuevaMision: nuevaMision,
                        nuevaFirma: nuevaFirma
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.showSuccess(data.message, () => window.location.reload());
                        const modalInstance = bootstrap.Modal.getInstance(this.modal);
                        modalInstance.hide();
                    } else {
                        this.showError('Error al guardar los cambios: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud de modificación:', error);
                    this.showError('Ocurrió un error de red al guardar los cambios.');
                });
        }

        handleRankChange(e) {
            const selectedRank = e.target.value;
            const specialRanks = ['administrador', 'manager', 'fundador', 'owner', 'junta directiva'];

            this.handleFirmaVisibility(selectedRank);

            if (this.missionSelect) {
                const selectedMission = this.missionSelect.value;
                this.missionSelect.remove();
                this.missionSelect = null;
            }

            if (specialRanks.includes(selectedRank)) {
                this.nuevaMisionInput.type = 'text';
                this.nuevaMisionInput.style.display = 'block';
                this.nuevaMisionInput.value = this.misionBase || '';
            } else {
                this.nuevaMisionInput.style.display = 'none';

                this.missionSelect = document.createElement('select');
                this.missionSelect.className = 'form-select';
                this.missionSelect.id = 'nuevaMisionSelect';
                this.missionSelect.name = 'nuevaMision';
                this.missionSelect.required = true;

                const emptyOption = document.createElement('option');
                emptyOption.value = '';
                emptyOption.textContent = 'Seleccionar';
                this.missionSelect.appendChild(emptyOption);

                fetch('/private/modal/modal_modificar_usuarios/data_rangos.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data && data[selectedRank]) {
                            data[selectedRank].forEach(mission => {
                                const option = document.createElement('option');
                                option.value = mission;
                                option.textContent = mission;
                                if (mission === this.misionBase) {
                                    option.selected = true;
                                }
                                this.missionSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error loading missions:', error);
                    });

                this.nuevaMisionInput.parentNode.insertBefore(this.missionSelect, this.nuevaMisionInput.nextSibling);
            }
        }

        // Helper methods for notifications
        showLoading(message) {
            Swal.fire({
                title: 'Procesando...',
                text: message,
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => Swal.showLoading()
            });
        }

        showSuccess(message, callback) {
            Swal.fire({
                title: 'Éxito',
                text: message,
                icon: 'success',
                confirmButtonText: 'Entendido'
            }).then(callback);
        }

        showError(message) {
            Swal.fire({
                title: 'Error',
                text: message,
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        new UserModificationModalHandler();
    });
</script>