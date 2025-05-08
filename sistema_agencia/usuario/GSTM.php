<?php
// PROCESO PARA MOSTRAR TIEMPOS DE USUARIOS
require_once(GESTION_TIEMPO_PATCH . 'mostrar_usuarios.php');
// require_once(GESTION_TIEMPO_PATCH . 'proceso_control_tiempos.php');

// MODALES PARA ACCIONES DE TIEMPOS DE USUARIOS
require_once(MODAL_GESTION_TIEMPO_PATH . 'modal_acciones.php');

class TimeManagementTable {
    private $tiempos;
    
    public function __construct($tiempos) {
        $this->tiempos = $tiempos;
    }
    
    private function getStatusBadgeClass($status) {
        $statusClasses = [
            'corriendo' => 'bg-success',
            'pausado' => 'bg-warning',
            'ausente' => 'bg-danger',
            'completado' => 'bg-purple'
        ];
        return $statusClasses[$status] ?? 'bg-secondary';
    }
    
    private function renderActionDropdown($codigoTime) {
        $actions = [
            'iniciar' => 'Iniciar',
            'pausar' => 'Pausar',
            'ausente' => 'Ausente',
            'completado' => 'Completado',
            'finalizar' => 'Finalizar'
        ];
        
        $html = '<div class="dropdown">';
        $html .= '<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" ';
        $html .= 'id="actionDropdown' . $codigoTime . '" data-bs-toggle="dropdown" aria-expanded="false">';
        $html .= 'Acciones</button><ul class="dropdown-menu" aria-labelledby="actionDropdown' . $codigoTime . '">';
        
        foreach ($actions as $action => $label) {
            $html .= '<li><a class="dropdown-item" href="#" data-bs-toggle="modal" ';
            $html .= 'data-bs-target="#' . $action . 'Modal" data-id="' . $codigoTime . '">' . $label . '</a></li>';
        }
        
        $html .= '</ul></div>';
        return $html;
    }
    
    public function render() {
        ?>
        <table id="datatable" class="datatable-table table table-striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Status</th>
                    <th>Restado</th>
                    <th>Acumulado</th>
                    <th>Transcurrido</th>
                    <th>Registro</th>
                    <th>Encargado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($this->tiempos as $tiempo): ?>
                <tr>
                    <td><?= $tiempo['nombre_habbo'] ?? $tiempo['codigo_time'] ?></td>
                    <td>
                        <span class="badge <?= $this->getStatusBadgeClass($tiempo['tiempo_status']) ?>">
                            <?= $tiempo['tiempo_status'] ?>
                        </span>
                    </td>
                    <td><?= $tiempo['tiempo_restado'] ?></td>
                    <td><?= $tiempo['tiempo_acumulado'] ?></td>
                    <td><?= $tiempo['tiempo_transcurrido'] ?></td>
                    <td><?= date('Y-m-d', strtotime($tiempo['tiempo_fecha_registro'])) ?></td>
                    <td><?= $tiempo['tiempo_encargado_usuario'] ?? 'No disponible' ?></td>
                    <td><?= $this->renderActionDropdown($tiempo['codigo_time']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }
}

// Initialize and render the table
$timeTable = new TimeManagementTable($GLOBALS['tiempos']);
$timeTable->render();
?>
