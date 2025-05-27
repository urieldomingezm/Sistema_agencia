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
const script = document.createElement('script');
script.src = '/public/assets/custom_general/custom_gestion_usuarios/index_modificar_usuario.js';
document.head.appendChild(script);
</script>