<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');?>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Main Content -->
            <div class="col py-3">
                <div class="container-fluid">
                    <!-- Stats Cards -->
                    <div class="row g-4 mb-4">
                        <!-- ... (Tus tarjetas de stats aquí, igual que antes) ... -->
                    </div>

                    <!-- Charts Row: 2 filas de 3 columnas -->
                    <div class="row g-4 mb-4">
                        <div class="col-lg-4">
                            <div class="card h-100">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Actividad Mensual</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="lineChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card h-100">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Distribución de Usuarios</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="pieChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card h-100">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0"><i class="bi bi-graph-up"></i> Crecimiento</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="barChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-lg-4">
                            <div class="card h-100">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0"><i class="bi bi-pie-chart-fill"></i> Estados</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="doughnutChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card h-100">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0"><i class="bi bi-bar-chart-line"></i> Tareas</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="horizontalBarChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card h-100">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0"><i class="bi bi-pie-chart"></i> Tipos de Usuario</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="polarChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tables Row -->
                    <div class="row g-4">
                        <!-- ... (Tus tablas aquí, igual que antes) ... -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Script -->
    <script>
        // Line Chart
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Usuarios nuevos',
                    data: [120, 190, 170, 220, 300, 280, 350, 400, 380, 420, 500, 600],
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {responsive: true}
        });

        // Pie Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: ['Activos', 'Inactivos', 'Pendientes', 'Suspendidos'],
                datasets: [{
                    data: [1200, 50, 23, 15],
                    backgroundColor: ['#0d6efd', '#6c757d', '#ffc107', '#dc3545']
                }]
            },
            options: {responsive: true}
        });

        // Bar Chart
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Ingresos ($)',
                    data: [5000, 8000, 7500, 12000, 15000, 14000],
                    backgroundColor: '#198754'
                }]
            },
            options: {responsive: true}
        });

        // Doughnut Chart
        new Chart(document.getElementById('doughnutChart'), {
            type: 'doughnut',
            data: {
                labels: ['Activo', 'Pendiente', 'Inactivo'],
                datasets: [{
                    data: [1000, 100, 50],
                    backgroundColor: ['#0d6efd', '#ffc107', '#dc3545']
                }]
            },
            options: {responsive: true}
        });

        // Horizontal Bar Chart
        new Chart(document.getElementById('horizontalBarChart'), {
            type: 'bar',
            data: {
                labels: ['Alta', 'Media', 'Baja'],
                datasets: [{
                    label: 'Tareas',
                    data: [10, 7, 3],
                    backgroundColor: ['#dc3545', '#ffc107', '#0d6efd']
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true
            }
        });

        // Polar Area Chart
        new Chart(document.getElementById('polarChart'), {
            type: 'polarArea',
            data: {
                labels: ['Admin', 'Usuario', 'Invitado'],
                datasets: [{
                    data: [5, 20, 10],
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107']
                }]
            },
            options: {responsive: true}
        });
    </script>
</body>
