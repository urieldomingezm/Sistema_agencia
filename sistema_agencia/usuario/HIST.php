<?php

class HistorialTiempos
{
    private $tiemposEncargado;
    private $tiemposUsuario;

    public function __construct()
    {
        require_once(CONFIG_PATH . 'bd.php');
        require_once(PRIVATE_PATH . 'procesos/gestion_mis_ascensos/mostrar_tiempos.php');

        // Los datos ya están en formato JSON en la salida del script mostrar_tiempos.php
        // Necesitamos capturar esa salida y decodificarla
        $jsonData = json_decode(ob_get_clean(), true);

        if (isset($jsonData['success']) && $jsonData['success']) {
            $this->tiemposEncargado = $jsonData['tiemposEncargado'];
            $this->tiemposUsuario = $jsonData['tiemposUsuario'];
        } else {
            $this->tiemposEncargado = [];
            $this->tiemposUsuario = [];
        }
    }

    public function renderTable()
    {
        $html = '<div class="container mt-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Historial de Tiempos</h5>
                    <ul class="nav nav-tabs card-header-tabs mt-2">
                        <li class="nav-item mx-1">
                            <button class="nav-link active bg-dark text-white border-light" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" style="opacity: 1; transition: opacity 0.3s;">Mis Tiempos</button>
                        </li>
                        <li class="nav-item mx-1">
                            <button class="nav-link bg-dark text-white border-light" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" style="opacity: 0.6; transition: opacity 0.3s;">Tiempos como Encargado</button>
                        </li>
                    </ul>
                    <style>
                        .nav-link.active {
                            opacity: 1 !important;
                        }
                        .nav-link:not(.active) {
                            opacity: 0.6 !important;
                        }
                        .nav-link:hover {
                            opacity: 0.8 !important;
                        }
                    </style>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                            <table id="datatable_mis_tiempos" class="table table-bordered table-striped table-hover text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Tiempo Acumulado</th>
                                        <th>Tiempo Transcurrido</th>
                                        <th>Encargado</th>
                                        <th>Fecha de Registro</th>
                                    </tr>
                                </thead>
                                <tbody>';

        // Renderizar tiempos del usuario
        if (!empty($this->tiemposUsuario)) {
            foreach ($this->tiemposUsuario as $tiempo) {
                $html .= $this->renderRowUsuario($tiempo);
            }
        } else {
            $html .= '<tr><td colspan="5" class="text-center">No hay registros de tiempos disponibles</td></tr>';
        }

        $html .= '</tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <table id="datatable_tiempos_encargado" class="table table-bordered table-striped table-hover text-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Tiempo Acumulado</th>
                                        <th>Fecha de Registro</th>
                                    </tr>
                                </thead>
                                <tbody>';

        // Renderizar tiempos donde el usuario es encargado
        if (!empty($this->tiemposEncargado)) {
            foreach ($this->tiemposEncargado as $tiempo) {
                $html .= $this->renderRowEncargado($tiempo);
            }
        } else {
            $html .= '<tr><td colspan="3" class="text-center">No hay registros de tiempos como encargado</td></tr>';
        }

        $html .= '</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    private function renderRowUsuario($tiempo)
    {
        $nombreUsuario = isset($tiempo['usuario_registro']) ? $tiempo['usuario_registro'] : 
                        (isset($tiempo['nombre_habbo']) ? $tiempo['nombre_habbo'] : 'No disponible');
        
        return '<tr>
            <td>' . $tiempo['codigo_time'] . ' (' . $nombreUsuario . ')</td>
            <td>' . $tiempo['tiempo_acumulado'] . '</td>
            <td>' . $tiempo['tiempo_transcurrido'] . '</td>
            <td>' . ($tiempo['tiempo_encargado_usuario'] ?? 'No asignado') . '</td>
            <td>' . $tiempo['tiempo_fecha_registro'] . '</td>
        </tr>';
    }

    private function renderRowEncargado($tiempo)
    {
        $nombreUsuario = isset($tiempo['usuario_registro']) ? $tiempo['usuario_registro'] : 
                        (isset($tiempo['nombre_habbo']) ? $tiempo['nombre_habbo'] : 'No disponible');
        
        return '<tr>
            <td>' . $tiempo['codigo_time'] . ' (' . $nombreUsuario . ')</td>
            <td>' . $tiempo['tiempo_acumulado'] . '</td>
            <td>' . $tiempo['tiempo_fecha_registro'] . '</td>
        </tr>';
    }
}

// Iniciar buffer de salida para capturar la respuesta JSON de mostrar_tiempos.php
ob_start();

// Instanciar la clase y renderizar la tabla
$historialTiempos = new HistorialTiempos();
echo $historialTiempos->renderTable();
?>

<script>
    $(document).ready(function() {
        // Inicializar DataTables para ambas tablas con configuración mínima
        $('#datatable_mis_tiempos').DataTable({
            order: [
                [4, 'asc']
            ] // Ordenar por fecha de registro (ascendente)
        });

        $('#datatable_tiempos_encargado').DataTable({
            order: [
                [2, 'asc']
            ] // Ordenar por fecha de registro (ascendente)
        });
    });
</script>