<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');?>


<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-nowrap">            
            <!-- Main Content -->
            <div class="col py-3">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="bi bi-speedometer2"></i> Panel Administrativo</h2>
                        <div>
                            <span class="badge bg-primary"><i class="bi bi-calendar"></i> <?php echo date('d/m/Y'); ?></span>
                        </div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">USUARIOS</h6>
                                            <h2 class="mb-0">1,254</h2>
                                            <span class="text-white-50 small">+12% desde ayer</span>
                                        </div>
                                        <i class="bi bi-people fs-1 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-success h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">INGRESOS</h6>
                                            <h2 class="mb-0">$48,500</h2>
                                            <span class="text-white-50 small">+24% este mes</span>
                                        </div>
                                        <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-warning h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">PENDIENTES</h6>
                                            <h2 class="mb-0">23</h2>
                                            <span class="text-white-50 small">5 nuevos hoy</span>
                                        </div>
                                        <i class="bi bi-exclamation-triangle fs-1 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white bg-danger h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">ALERTAS</h6>
                                            <h2 class="mb-0">3</h2>
                                            <span class="text-white-50 small">Revisar ahora</span>
                                        </div>
                                        <i class="bi bi-bell fs-1 opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Charts Row -->
                    <div class="row g-4 mb-4">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Actividad Mensual</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="lineChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Distribución de Usuarios</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="pieChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tables Row -->
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="bi bi-table"></i> Últimos Usuarios</h5>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Ver todos</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Email</th>
                                                    <th>Registro</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Juan Pérez</td>
                                                    <td>juan@example.com</td>
                                                    <td>Hoy</td>
                                                    <td><span class="badge bg-success">Activo</span></td>
                                                </tr>
                                                <tr>
                                                    <td>María García</td>
                                                    <td>maria@example.com</td>
                                                    <td>Ayer</td>
                                                    <td><span class="badge bg-success">Activo</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Carlos López</td>
                                                    <td>carlos@example.com</td>
                                                    <td>05/06/2024</td>
                                                    <td><span class="badge bg-warning">Pendiente</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Ana Martínez</td>
                                                    <td>ana@example.com</td>
                                                    <td>04/06/2024</td>
                                                    <td><span class="badge bg-success">Activo</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Luis Rodríguez</td>
                                                    <td>luis@example.com</td>
                                                    <td>03/06/2024</td>
                                                    <td><span class="badge bg-danger">Inactivo</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="bi bi-list-check"></i> Tareas Pendientes</h5>
                                    <a href="#" class="btn btn-sm btn-outline-primary">Agregar</a>
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Revisar reporte mensual</h6>
                                                <small class="text-muted">Prioridad: Alta</small>
                                            </div>
                                            <span class="badge bg-primary rounded-pill">Hoy</span>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Actualizar documentación</h6>
                                                <small class="text-muted">Prioridad: Media</small>
                                            </div>
                                            <span class="badge bg-warning rounded-pill">Mañana</span>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Revisar tickets de soporte</h6>
                                                <small class="text-muted">5 nuevos tickets</small>
                                            </div>
                                            <span class="badge bg-danger rounded-pill">Urgente</span>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Preparar presentación</h6>
                                                <small class="text-muted">Reunión del viernes</small>
                                            </div>
                                            <span class="badge bg-info rounded-pill">En progreso</span>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Optimizar base de datos</h6>
                                                <small class="text-muted">Tarea programada</small>
                                            </div>
                                            <span class="badge bg-secondary rounded-pill">Próxima semana</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Script -->
    <script>
        // Line Chart
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [
                    {
                        label: 'Usuarios nuevos',
                        data: [120, 190, 170, 220, 300, 280, 350, 400, 380, 420, 500, 600],
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Ingresos ($)',
                        data: [5000, 8000, 7500, 12000, 15000, 14000, 18000, 20000, 19000, 22000, 25000, 30000],
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Activos', 'Inactivos', 'Pendientes', 'Suspendidos'],
                datasets: [{
                    data: [1200, 50, 23, 15],
                    backgroundColor: [
                        '#0d6efd',
                        '#6c757d',
                        '#ffc107',
                        '#dc3545'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    </script>
</body>