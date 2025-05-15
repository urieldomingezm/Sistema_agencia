<!-- Modal de Ayuda para Gestión de Tiempos -->
<div class="modal fade" id="Ayuda_gestion_times" tabindex="-1" aria-labelledby="newTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="newTimeModalLabel">Ayuda: Gestión de Tiempos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Bienvenido a la sección de Gestión de Tiempos.</h6>
                <p>Aquí puedes administrar los tiempos de trabajo de los usuarios. La tabla principal muestra los tiempos activos, mientras que las otras pestañas muestran los tiempos inactivos/pausados y completados.</p>

                <hr>

                <h6>Funcionalidades Principales:</h6>
                <ul>
                    <li><strong>Pestañas:</strong> Navega entre los tiempos Iniciados (Activos), Inactivos/Pausados y Completados.</li>
                    <li><strong>Tabla de Tiempos:</strong> Cada fila muestra información relevante como el usuario, estado, tiempo restado, acumulado, fecha de inicio y el encargado actual.</li>
                    <li><strong>Acciones:</strong> Utiliza los botones en la columna "Acciones" para interactuar con cada registro de tiempo:
                        <ul>
                            <li><span class="badge bg-success"><i class="bi bi-check-circle-fill"></i></span>: Marcar tiempo como completado (Disponible en tiempos Pausados/Inactivos).</li>
                            <li><span class="badge bg-warning"><i class="bi bi-pause-circle-fill"></i></span>: Pausar el tiempo actual y liberarlo para otro encargado (Disponible en tiempos Activos con encargado).</li>
                            <li><span class="badge bg-info"><i class="bi bi-eye-fill"></i></span>: Ver detalles del tiempo acumulado, transcurrido y total.</li>
                            <li><span class="badge bg-primary"><i class="bi bi-person-fill"></i></span>: Designar un encargado para un tiempo inactivo/pausado.</li>
                            <li><span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i></span>: Liberar al encargado actual sin pausar el tiempo (Solo si el tiempo está en pausa).</li>
                        </ul>
                    </li>
                </ul>

                <hr>

                <h6>Consideraciones Importantes:</h6>
                <ul>
                    <li>El tiempo transcurrido se calcula desde la última vez que se inició el tiempo.</li>
                    <li>El tiempo acumulado es la suma total del tiempo trabajado en ese registro.</li>
                    <li>Solo los usuarios con rangos adecuados pueden realizar ciertas acciones como designar encargados.</li>
                </ul>

                <p class="mt-3 text-muted">Si tienes alguna duda adicional, contacta al administrador del sistema.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>