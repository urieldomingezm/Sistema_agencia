<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');?>

<body class="bg-light">
    <div class="container-fluid">
        <!-- Wizard Progress -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step active" data-target="#info-part">
                            <button class="step-trigger" role="tab">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Información General</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#tasks-part">
                            <button class="step-trigger" role="tab">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Gestión de Tareas</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#reports-part">
                            <button class="step-trigger" role="tab">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Reportes</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <!-- Quick Stats -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body d-flex justify-content-between">
                                <div>
                                    <h6>EMPLEADOS ACTIVOS</h6>
                                    <h2>156</h2>
                                </div>
                                <i class="bi bi-people-fill fs-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success">
                            <div class="card-body d-flex justify-content-between">
                                <div>
                                    <h6>PROYECTOS</h6>
                                    <h2>24</h2>
                                </div>
                                <i class="bi bi-folder-fill fs-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning">
                            <div class="card-body d-flex justify-content-between">
                                <div>
                                    <h6>TAREAS PENDIENTES</h6>
                                    <h2>38</h2>
                                </div>
                                <i class="bi bi-list-check fs-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info">
                            <div class="card-body d-flex justify-content-between">
                                <div>
                                    <h6>DOCUMENTOS</h6>
                                    <h2>295</h2>
                                </div>
                                <i class="bi bi-file-earmark-text fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Administrative Tools -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Gestión de Personal</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Registro de Empleados</h6>
                                            <span class="badge bg-primary">Nuevo</span>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Control de Asistencia</h6>
                                            <span class="badge bg-success">Activo</span>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Nómina y Pagos</h6>
                                            <span class="badge bg-warning">Pendiente</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Documentación</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Políticas y Procedimientos</h6>
                                            <i class="bi bi-file-pdf text-danger"></i>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Manuales Operativos</h6>
                                            <i class="bi bi-file-word text-primary"></i>
                                        </div>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Formatos Administrativos</h6>
                                            <i class="bi bi-file-excel text-success"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Table -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Actividad Reciente</h5>
                        <button class="btn btn-primary btn-sm">Ver Todo</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Actividad</th>
                                        <th>Departamento</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Ana Martínez</td>
                                        <td>Actualización de inventario</td>
                                        <td>Logística</td>
                                        <td>Hoy 10:30</td>
                                        <td><span class="badge bg-success">Completado</span></td>
                                    </tr>
                                    <tr>
                                        <td>Carlos Ruiz</td>
                                        <td>Reporte mensual</td>
                                        <td>Finanzas</td>
                                        <td>Ayer 15:45</td>
                                        <td><span class="badge bg-warning">En proceso</span></td>
                                    </tr>
                                    <tr>
                                        <td>Laura Sánchez</td>
                                        <td>Solicitud de vacaciones</td>
                                        <td>RH</td>
                                        <td>Ayer 09:15</td>
                                        <td><span class="badge bg-info">Pendiente</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>