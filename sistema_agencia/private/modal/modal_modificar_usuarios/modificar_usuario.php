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
                    <form id="formModificarRango">
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
                                        <option value="junta_directiva">Junta Directiva</option>
                                        <option value="administrador">Administrador</option>
                                        <option value="manager">Manager</option>
                                        <option value="fundador">Fundador</option>
                                        <option value="dueno">Dueño</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nuevaMision" class="form-label">Misión</label>
                                    <input type="text" class="form-control" id="nuevaMision" name="nuevaMision"
                                        maxlength="50" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nuevaFirma" class="form-label">Firma (3 chars)</label>
                                    <input type="text" class="form-control" id="nuevaFirma" name="nuevaFirma"
                                        pattern="[A-Z0-9]{3}" title="3 caracteres alfanuméricos en mayúsculas"
                                        maxlength="3" required>
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
            this.initFormValidation();

            // Add event listener for rank selection change
            this.nuevoRangoSelect.addEventListener('change', (e) => this.handleRankChange(e));
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
                        this.infoNombreHabbo.textContent = data.data.nombre_habbo;
                        this.infoRangoActual.textContent = data.data.rango_actual;
                        this.infoMisionActual.textContent = data.data.mision_actual;
                        this.infoFirmaUsuario.textContent = data.data.firma_usuario ? data.data.firma_usuario : 'No disponible';

                        this.nuevaMisionInput.value = data.data.mision_actual;
                        this.nuevaFirmaInput.value = data.data.firma_usuario;

                    } else {
                        console.error('Error al cargar datos del usuario:', data.error);
                        Swal.fire({
                            title: 'Error',
                            text: 'No se pudieron cargar los datos del usuario: ' + data.error,
                            icon: 'error',
                            confirmButtonText: 'Entendido'
                        });
                        const modalInstance = bootstrap.Modal.getInstance(this.modal);
                        modalInstance.hide();
                    }
                })
                .catch(error => {
                    console.error('Error en la solicitud de búsqueda:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error de red al cargar los datos del usuario.',
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                    const modalInstance = bootstrap.Modal.getInstance(this.modal);
                    modalInstance.hide();
                });
        }

        initFormValidation() {
            const validator = new JustValidate(this.form, {
                validateBeforeSubmitting: true,
            });

            validator
                .addField('#nuevoRango', [{
                    rule: 'required',
                    errorMessage: 'El rango es requerido.',
                }, ])
                .addField('#nuevaMision', [{
                        rule: 'required',
                        errorMessage: 'La misión es requerida.',
                    },
                    {
                        rule: 'maxLength',
                        value: 50,
                        errorMessage: 'La misión no debe exceder los 50 caracteres.',
                    },
                ])
                .addField('#nuevaFirma', [{
                        rule: 'required',
                        errorMessage: 'La firma es requerida.',
                    },
                    {
                        rule: 'customRegexp',
                        value: /^[A-Z0-9]{3}$/,
                        errorMessage: 'El formato de la firma es inválido. Debe ser 3 caracteres alfanuméricos en mayúsculas.',
                    },
                ])
                .onSuccess((event) => {
                    this.handleFormSubmit(event);
                });
        }

        handleFormSubmit(event) {
            event.preventDefault();

            const userId = this.userIdInput.value;
            const nuevoRango = this.nuevoRangoSelect.value;
            const nuevaMision = this.nuevaMisionInput.value;
            const nuevaFirma = this.nuevaFirmaInput.value;

            Swal.fire({
                title: 'Guardando cambios...',
                text: 'Por favor espera.',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

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
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            title: 'Éxito',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'Entendido'
                        }).then(() => {
                            window.location.reload();
                        });
                        const modalInstance = bootstrap.Modal.getInstance(this.modal);
                        modalInstance.hide();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al guardar los cambios: ' + data.error,
                            icon: 'error',
                            confirmButtonText: 'Entendido'
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    console.error('Error en la solicitud de modificación:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error de red al guardar los cambios.',
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                });
        }

        handleRankChange(e) {
            const selectedRank = e.target.value;
            const specialRanks = ['administrador', 'manager', 'fundador', 'dueno', 'junta_directiva'];

            // Clear existing options if any
            if (this.missionSelect) {
                this.missionSelect.remove();
                this.missionSelect = null;
            }

            if (specialRanks.includes(selectedRank)) {
                // For special ranks, show text input
                this.nuevaMisionInput.type = 'text';
                this.nuevaMisionInput.style.display = 'block';
                this.nuevaMisionInput.value = '';
            } else {
                // For regular ranks, create select dropdown
                this.nuevaMisionInput.style.display = 'none';

                this.missionSelect = document.createElement('select');
                this.missionSelect.className = 'form-select';
                this.missionSelect.id = 'nuevaMisionSelect';
                this.missionSelect.name = 'nuevaMision';
                this.missionSelect.required = true;

                // Add empty option
                const emptyOption = document.createElement('option');
                emptyOption.value = '';
                emptyOption.textContent = 'Seleccionar';
                this.missionSelect.appendChild(emptyOption);

                // Get missions for selected rank from data_rangos.php
                fetch('/private/modal/modal_modificar_usuarios/data_rangos.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && data[selectedRank]) {
                            data[selectedRank].forEach(mission => {
                                const option = document.createElement('option');
                                option.value = mission;
                                option.textContent = mission;
                                this.missionSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error loading missions:', error);
                    });

                // Insert select after label
                this.nuevaMisionInput.parentNode.insertBefore(this.missionSelect, this.nuevaMisionInput.nextSibling);
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        new UserModificationModalHandler();
    });
</script>