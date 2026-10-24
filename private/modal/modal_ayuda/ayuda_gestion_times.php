<!-- Modal de Ayuda para Gestión de Tiempos -->
<div class="modal fade" id="Ayuda_gestion_times" tabindex="-1" aria-labelledby="newTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="newTimeModalLabel">Tutorial: Gestión de Tiempos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="tutorialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!-- Slide 1: Bienvenida -->
                        <div class="carousel-item active">
                            <h4 class="text-center mb-4">¡Bienvenido a Gestión de Tiempos!</h4>
                            <p class="text-center">Esta herramienta te permite administrar los tiempos de trabajo de manera eficiente.</p>
                            <div class="text-center mt-4">
                                <img src="assets/img/time_management.png" class="img-fluid mb-3" style="max-width: 200px;" alt="Gestión de Tiempos">
                            </div>
                        </div>

                        <!-- Slide 2: Pestañas -->
                        <div class="carousel-item">
                            <h4 class="text-center mb-4">Navegación por Pestañas</h4>
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <span class="badge bg-secondary">Activos</span>
                                <span class="badge bg-secondary">Pausados</span>
                                <span class="badge bg-secondary">Completados</span>
                            </div>
                            <p class="text-center">Cambia entre diferentes vistas para gestionar los tiempos según su estado.</p>
                        </div>

                        <!-- Slide 3: Acciones -->
                        <div class="carousel-item">
                            <h4 class="text-center mb-4">Acciones Disponibles</h4>
                            <div class="d-flex justify-content-center gap-3 mb-4">
                                <div class="text-center">
                                    <span class="badge bg-success mb-2"><i class="bi bi-check-circle-fill"></i></span>
                                    <p class="small">Completar</p>
                                    <small class="text-muted">Marca una tarea como terminada (puede ser automático)</small>
                                </div>
                                <div class="text-center">
                                    <span class="badge bg-warning mb-2"><i class="bi bi-pause-circle-fill"></i></span>
                                    <p class="small">Pausar</p>
                                    <small class="text-muted">Detiene temporalmente el tiempo</small>
                                </div>
                                <div class="text-center">
                                    <span class="badge bg-info mb-2"><i class="bi bi-eye-fill"></i></span>
                                    <p class="small">Ver Detalles</p>
                                    <small class="text-muted">Muestra información su tiempo</small>
                                </div>
                                <div class="text-center">
                                    <span class="badge bg-primary mb-2"><i class="bi bi-person-fill"></i></span>
                                    <p class="small">Asignar</p>
                                    <small class="text-muted">Asigna tarea a un usuario</small>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 4: Información Importante -->
                        <div class="carousel-item">
                            <h4 class="text-center mb-4">Información Importante</h4>
                            <div class="text-center">
                                <p><i class="bi bi-clock-history"></i> El tiempo se calcula automáticamente</p>
                                <p><i class="bi bi-calculator"></i> Se acumula el tiempo total trabajado</p>
                                <p><i class="bi bi-shield-check"></i> Los permisos varían según tu rol</p>
                                <p><i class="bi bi-award-fill text-warning"></i> El tiempo se marca como "Completado" automáticamente al alcanzar el total requerido para tu rango.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Controles del carrusel -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#tutorialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#tutorialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>

                    <!-- Indicadores -->
                    <div class="carousel-indicators position-relative mt-3">
                        <button type="button" data-bs-target="#tutorialCarousel" data-bs-slide-to="0" class="active bg-dark" aria-current="true"></button>
                        <button type="button" data-bs-target="#tutorialCarousel" data-bs-slide-to="1" class="bg-dark"></button>
                        <button type="button" data-bs-target="#tutorialCarousel" data-bs-slide-to="2" class="bg-dark"></button>
                        <button type="button" data-bs-target="#tutorialCarousel" data-bs-slide-to="3" class="bg-dark"></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>