<?php
// USR.php - Dashboard de inicio para usuarios administrativos
?>
<meta name="keywords" content="Inicio administrativo, dashboard, panel de control">

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Administrativo</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Panel de Control</li>
    </ol>
    
    <div class="row">
        <!-- Estadísticas rápidas -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Usuarios Registrados</h5>
                    <h2 class="text-center"><?php echo obtenerTotalUsuarios(); ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="index.php?page=gestion_de_usuarios">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5>Pagos Pendientes</h5>
                    <h2 class="text-center"><?php echo obtenerPagosPendientes(); ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="index.php?page=gestion_de_pagas">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h5>Solicitudes Ascensos</h5>
                    <h2 class="text-center"><?php echo obtenerSolicitudesAscenso(); ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="index.php?page=gestion_ascenso">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h5>Notificaciones</h5>
                    <h2 class="text-center"><?php echo obtenerNotificacionesPendientes(); ?></h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="index.php?page=gestion_de_notificaciones">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Actividad Reciente
                </div>
                <div class="card-body">
                    <canvas id="myAreaChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Distribución de Rangos
                </div>
                <div class="card-body">
                    <canvas id="myBarChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Últimos Usuarios Registrados
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Rango</th>
                        <th>Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo obtenerUltimosUsuarios(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
// Funciones de ejemplo (debes implementarlas según tu base de datos)
function obtenerTotalUsuarios() {
    // Implementar consulta a la base de datos
    return "125";
}

function obtenerPagosPendientes() {
    // Implementar consulta a la base de datos
    return "15";
}

function obtenerSolicitudesAscenso() {
    // Implementar consulta a la base de datos
    return "8";
}

function obtenerNotificacionesPendientes() {
    // Implementar consulta a la base de datos
    return "23";
}

function obtenerUltimosUsuarios() {
    // Implementar consulta a la base de datos y devolver HTML
    return '
        <tr>
            <td>101</td>
            <td>Usuario Ejemplo</td>
            <td>Agente</td>
            <td>2023-05-15</td>
            <td>
                <button class="btn btn-sm btn-primary">Ver</button>
                <button class="btn btn-sm btn-warning">Editar</button>
            </td>
        </tr>
        <!-- Más filas según la consulta -->
    ';
}
?>