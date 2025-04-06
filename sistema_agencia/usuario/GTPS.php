<?php
require_once(CONFIG_PATH . 'bd.php');
$db = new Database();
$conn = $db->getConnection();

$query = "SELECT pagas_usuario, pagas_recibio, pagas_motivo, pagas_completo, pagas_rango, pagas_descripcion, pagas_fecha_registro FROM gestion_pagas ORDER BY pagas_fecha_registro DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$pagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="dashboard-container">
    <div class="dashboard-header bg-gradient-primary py-3 border-0">
        <h1 class="text-white">
            <i class="fas fa-chart-line"></i>
            Dashboard de Pagas
        </h1>
    </div>

    <div class="dashboard-grid">
        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Usuarios</h3>
                    <p><?php echo count(array_unique(array_column($pagas, 'pagas_usuario'))); ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Pagado</h3>
                    <p><?php echo array_sum(array_column($pagas, 'pagas_recibio')); ?> créditos</p>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-header">
                <h2><i class="fas fa-table"></i> Registro de Pagas</h2>
            </div>
            <div class="table-container">
                <table id="pagasTable" class="table-bordered table-striped display-table table text-center">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Rango</th>
                            <th>Recibió</th>
                            <th>Motivo</th>
                            <th>Completo</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagas as $paga): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($paga['pagas_usuario']); ?></td>
                                <td><?php echo htmlspecialchars($paga['pagas_rango']); ?></td>
                                <td><?php echo htmlspecialchars($paga['pagas_recibio']); ?> c</td>
                                <td><?php echo htmlspecialchars($paga['pagas_motivo']); ?></td>
                                <td>
                                    <span class="status-badge <?php echo $paga['pagas_completo'] ? 'complete' : 'incomplete'; ?>">
                                        <?php echo $paga['pagas_completo'] ? 'Completo' : 'Pendiente'; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($paga['pagas_descripcion']); ?></td>
                                <td><?php echo htmlspecialchars($paga['pagas_fecha_registro']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="chart-section">
            <div class="chart-header">
                <h2><i class="fas fa-chart-bar"></i> Análisis de Pagas</h2>
            </div>
            <div class="charts-container">
                <div class="charts-grid">
                    <div class="chart-box">
                        <h3 class="chart-title">Pagos a trabajadores</h3>
                        <div class="chart-wrapper">
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div>
                    <div class="chart-box">
                        <h3 class="chart-title">Pagos mediante rangos</h3>
                        <div class="chart-wrapper">
                            <canvas id="userChart"></canvas>
                        </div>
                    </div>
                    <div class="chart-box">
                        <h3 class="chart-title">Total Acumulado</h3>
                        <div class="chart-wrapper">
                            <canvas id="accumulatedChart"></canvas>
                        </div>
                    </div>
                    <div class="chart-box">
                        <h3 class="chart-title">Placas mas usadas</h3>
                        <div class="chart-wrapper">
                            <canvas id="motivoChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .charts-container {
                    width: 100%;
                    padding: 0.5rem;
                }

                .charts-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 1rem;
                    margin: 0 auto;
                    max-width: 1400px;
                }

                .chart-box {
                    background: #ffffff;
                    border-radius: 12px;
                    padding: 1rem;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                    transition: transform 0.3s ease;
                }

                .chart-box:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                }

                .chart-title {
                    font-size: 1.1rem;
                    color: #2c3e50;
                    margin-bottom: 1rem;
                    text-align: center;
                    font-weight: 600;
                }

                .chart-wrapper {
                    position: relative;
                    height: 300px;
                    width: 100%;
                }

                @media (max-width: 1200px) {
                    .charts-grid {
                        grid-template-columns: repeat(2, 1fr);
                    }
                }

                @media (max-width: 768px) {
                    .charts-grid {
                        grid-template-columns: 1fr;
                    }
                    
                    .chart-wrapper {
                        height: 250px;
                    }
                    
                    .chart-box {
                        padding: 0.75rem;
                    }
                }

                @media (max-width: 480px) {
                    .charts-container {
                        padding: 0.25rem;
                    }
                    
                    .chart-wrapper {
                        height: 200px;
                    }
                    
                    .chart-title {
                        font-size: 1rem;
                    }
                }
            </style>
        </div>
    </div>
</div>

<style>
    .dashboard-container {
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .dashboard-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .dashboard-header h1 {
        color: #2c3e50;
        font-size: 2rem;
        font-weight: 600;
    }

    .dashboard-grid {
        display: grid;
        gap: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        background: linear-gradient(135deg, #00c6fb 0%, #005bea 100%);
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .stat-info h3 {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
    }

    .stat-info p {
        color: #2c3e50;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    .table-section,
    .chart-section {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .table-header,
    .chart-header {
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 1rem;
    }

    .table-header h2,
    .chart-header h2 {
        color: #2c3e50;
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
    }

    .display-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .display-table td {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .status-badge.complete {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.incomplete {
        background: #f8d7da;
        color: #721c24;
    }

    .chart-container {
        height: 400px;
        position: relative;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dataTable = new simpleDatatables.DataTable("#pagasTable", {
            searchable: true,
            fixedHeight: true,
            labels: {
                placeholder: "Buscar...",
                perPage: "Registros por página",
                noRows: "No hay registros",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const pagas = <?php echo json_encode($pagas); ?>;

        // Daily Payments Chart
        const dailyData = {};
        pagas.forEach(paga => {
            const date = paga.pagas_fecha_registro.split(' ')[0];
            dailyData[date] = (dailyData[date] || 0) + parseInt(paga.pagas_recibio);
        });

        new Chart('dailyChart', {
            type: 'bar',
            data: {
                labels: Object.keys(dailyData),
                datasets: [{
                    label: 'Pagos',
                    data: Object.values(dailyData),
                    borderColor: '#00c6fb',
                    backgroundColor: 'rgba(0, 197, 251, 0.86)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // User Distribution Chart
        const userData = {};
        pagas.forEach(paga => {
            userData[paga.pagas_rango] = (userData[paga.pagas_rango] || 0) + parseInt(paga.pagas_recibio);
        });

        new Chart('userChart', {
            type: 'doughnut',
            data: {
                labels: Object.keys(userData),
                datasets: [{
                    data: Object.values(userData),
                    backgroundColor: [
                        '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4',
                        '#FFEEAD', '#D4A5A5', '#9B59B6'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        align: 'center'
                    }
                }
            }
        });

        // Accumulated Total Chart
        const accData = {};
        let accumulated = 0;
        [...pagas].reverse().forEach(paga => {
            const date = paga.pagas_fecha_registro.split(' ')[0];
            accumulated += parseInt(paga.pagas_recibio);
            accData[date] = accumulated;
        });

        new Chart('accumulatedChart', {
            type: 'line',
            data: {
                labels: Object.keys(accData),
                datasets: [{
                    label: 'Total gastado',
                    data: Object.values(accData),
                    borderColor: '#005bea',
                    backgroundColor: 'rgba(0, 91, 234, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });

        // Motivo Distribution Chart
        const motivoData = {};
        pagas.forEach(paga => {
            motivoData[paga.pagas_motivo] = (motivoData[paga.pagas_motivo] || 0) + parseInt(paga.pagas_recibio);
        });

        new Chart('motivoChart', {
            type: 'bar',
            data: {
                labels: Object.keys(motivoData),
                datasets: [{
                    label: 'Membresias',
                    data: Object.values(motivoData),
                    backgroundColor: '#00c6fb',
                    borderColor: '#005bea',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<style>
    .chart-box {
        height: 400px;
        padding: 20px;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        padding: 20px;
    }

    @media (max-width: 768px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }
</style>