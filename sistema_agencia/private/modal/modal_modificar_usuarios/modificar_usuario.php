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
                                        <option value="junta directiva">Junta Directiva</option>
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
            this.initFormEvents(); // Cambiado de initFormValidation a initFormEvents

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
                        const misionCompleta = data.data.mision_actual;
                        const firma = data.data.firma_usuario;
                        
                        // Extraer la misión base sin la firma
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

                        // Establecer el rango actual en el select
                        this.nuevoRangoSelect.value = data.data.rango_actual;
                        
                        // Manejar la visibilidad inicial de la firma
                        this.handleFirmaVisibility(data.data.rango_actual);
                        
                        this.nuevaMisionInput.value = misionBase;
                        this.nuevaFirmaInput.value = firma || '';

                        // Guardar la misión base para uso posterior
                        this.misionBase = misionBase;

                        // Disparar el evento change para manejar las misiones
                        const event = new Event('change');
                        this.nuevoRangoSelect.dispatchEvent(event);
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

        // Agregar método para manejar la visibilidad de la firma
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

                // Validación básica
                if (!this.validateForm()) {
                    return;
                }

                this.handleFormSubmit(event);
            });
        }

        validateForm() {
            const nuevoRango = this.nuevoRangoSelect.value;
            const nuevaMision = this.nuevaMisionInput.value;
            const nuevaFirma = this.nuevaFirmaInput.value;
            const rangosBasicos = ['agente', 'seguridad', 'tecnico', 'logistica'];

            if (!nuevoRango) {
                Swal.fire('Error', 'El rango es requerido.', 'error');
                return false;
            }

            if (!nuevaMision) {
                Swal.fire('Error', 'La misión es requerida.', 'error');
                return false;
            }

            if (nuevaMision.length > 50) {
                Swal.fire('Error', 'La misión no debe exceder los 50 caracteres.', 'error');
                return false;
            }

            // Solo validar firma si no es un rango básico
            if (!rangosBasicos.includes(nuevoRango)) {
                if (!nuevaFirma) {
                    Swal.fire('Error', 'La firma es requerida para este rango.', 'error');
                    return false;
                }

                if (!/^[A-Z0-9]{3}$/.test(nuevaFirma)) {
                    Swal.fire('Error', 'El formato de la firma es inválido. Debe ser 3 caracteres alfanuméricos en mayúsculas.', 'error');
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

            // Formatear la misión con la firma si existe
            if (nuevaFirma) {
                nuevaMision = `${nuevaMision} -${nuevaFirma}`;
            }
            nuevaMision = `${nuevaMision} -XDD #A`;

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

            // Manejar la visibilidad de la firma
            this.handleFirmaVisibility(selectedRank);

            // Clear existing options if any
            if (this.missionSelect) {
                const selectedMission = this.missionSelect.value;
                this.missionSelect.remove();
                this.missionSelect = null;
            }

            if (specialRanks.includes(selectedRank)) {
                // For special ranks, show text input
                this.nuevaMisionInput.type = 'text';
                this.nuevaMisionInput.style.display = 'block';
                this.nuevaMisionInput.value = this.misionBase || '';
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

                // Insert select after label
                this.nuevaMisionInput.parentNode.insertBefore(this.missionSelect, this.nuevaMisionInput.nextSibling);
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        new UserModificationModalHandler();
    });
</script>