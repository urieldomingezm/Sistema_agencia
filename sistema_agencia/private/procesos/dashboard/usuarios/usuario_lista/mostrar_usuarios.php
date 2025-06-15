<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

class RegistroUsuarioManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function getAllRegistroUsuarios() {
        $sql = "SELECT
                    id,
                    usuario_registro,
                    fecha_registro,
                    ip_registro,
                    codigo_time,
                    ip_bloqueo
                FROM
                    registro_usuario
                ORDER BY fecha_registro DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            error_log("Error fetching registro usuarios: " . $exception->getMessage());
            return [];
        }
    }

    public function searchUsuarios($searchTerm) {
        $sql = "SELECT
                    id,
                    usuario_registro,
                    fecha_registro,
                    ip_registro,
                    codigo_time,
                    ip_bloqueo
                FROM
                    registro_usuario
                WHERE 
                    usuario_registro LIKE :search OR
                    ip_registro LIKE :search OR
                    codigo_time LIKE :search
                ORDER BY fecha_registro DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':search', '%' . $searchTerm . '%');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            error_log("Error searching registro usuarios: " . $exception->getMessage());
            return [];
        }
    }

    private function maskIP($ip) {
        if (empty($ip)) return '';
        $parts = explode('.', $ip);
        if (count($parts) === 4) {
            return $parts[0] . '.***.***.' . $parts[3];
        }
        return hash('sha256', $ip);
    }
}

class GestionRegistroUsuario {
    private $registroUsuarios;
    private $database;
    private $registroManager;

    public function __construct($searchTerm = null) {
        $this->database = new Database();
        $this->registroManager = new RegistroUsuarioManager($this->database);
        
        if ($searchTerm) {
            $this->registroUsuarios = $this->registroManager->searchUsuarios($searchTerm);
        } else {
            $this->registroUsuarios = $this->registroManager->getAllRegistroUsuarios();
        }
    }

    public function render() {
        return '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="keywords" content="Lista de usuarios registrados, gestión de usuarios, registro de usuarios">
            <title>Gestión de Usuarios Registrados</title>
            
            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
            
            <!-- DataTables CSS -->
            <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css" rel="stylesheet">
            
            <!-- SweetAlert2 CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            
            <style>
                .avatar-img {
                    transition: transform 0.3s ease;
                }
                .avatar-img:hover {
                    transform: scale(1.1);
                }
                .card-header {
                    border-bottom: 2px solid rgba(0,0,0,0.1);
                }
                .table-responsive {
                    min-height: 400px;
                }
                .status-badge {
                    font-size: 0.75rem;
                    padding: 0.35em 0.65em;
                }
                .swal2-popup {
                    font-size: 1rem !important;
                }
            </style>
        </head>
        <body class="bg-light">
            <div class="container-fluid mt-3">
                '.$this->renderTable().'
                '.$this->renderModals().'
            </div>
            
            <!-- Bootstrap JS Bundle with Popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <!-- DataTables JS -->
            <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
            <!-- SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
            
            '.$this->renderScripts().'
        </body>
        </html>';
    }

    private function renderTable() {
        $html = '
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Registro de Usuarios</h5>
                <div>
                    <span class="badge bg-light text-dark me-2">
                        <i class="bi bi-people-fill me-1"></i> Total: ' . count($this->registroUsuarios) . '
                    </span>
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#Ayuda_registro_usuario">
                        <i class="bi bi-question-circle me-1"></i> Ayuda
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="registroUsuarioTable" class="table table-hover table-striped table-bordered align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%" class="text-center">ID</th>
                                <th width="25%" class="text-start">Usuario</th>
                                <th width="20%" class="text-center">Fecha Registro</th>
                                <th width="20%" class="text-center">IP Registro</th>
                                <th width="15%" class="text-center">Estado</th>
                                <th width="15%" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';

        foreach ($this->registroUsuarios as $registro) {
            $html .= $this->renderRow($registro);
        }

        $html .= '
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light py-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary" id="refreshBtn">
                                <i class="bi bi-arrow-clockwise me-1"></i>Actualizar
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#statsModal">
                                <i class="bi bi-graph-up me-1"></i>Estadísticas
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <span class="text-muted small">
                            <i class="bi bi-info-circle me-1"></i>Última actualización: ' . date('d/m/Y H:i:s') . '
                        </span>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    private function renderRow($registro) {
        $id = $registro['id'] ?? '';
        $usuario_registro = $registro['usuario_registro'] ?? '';
        $fecha_registro = $registro['fecha_registro'] ?? '';
        $ip_registro = $registro['ip_registro'] ?? '';
        $codigo_time = $registro['codigo_time'] ?? '';
        $ip_bloqueo = $registro['ip_bloqueo'] ?? '';

        // Mask IP addresses
        $masked_ip = $this->maskIP($ip_registro);
        $masked_ip_bloqueo = $this->maskIP($ip_bloqueo);

        $fechaFormateada = !empty($fecha_registro) ? date('d/m/Y H:i:s', strtotime($fecha_registro)) : '';
        
        // Estado del usuario (bloqueado o activo)
        $estadoBadge = $this->getEstadoBadge($masked_ip_bloqueo);
        
        // Acciones
        $acciones = $this->getAcciones($id, $ip_bloqueo);

        return '
        <tr data-id="'.$id.'">
            <td class="text-center align-middle">
                <span class="badge bg-secondary">' . htmlspecialchars($id) . '</span>
            </td>
            <td class="text-start align-middle">
                <div class="d-flex align-items-center">
                    <img loading="lazy" class="me-2 rounded-circle avatar-img" 
                         src="https://www.habbo.es/habbo-imaging/avatarimage?user=' . urlencode($usuario_registro) . '&amp;headonly=1&amp;head_direction=3&amp;size=m" 
                         alt="' . htmlspecialchars($usuario_registro) . '" 
                         title="' . htmlspecialchars($usuario_registro) . '" 
                         width="32" height="32">
                    <div>
                        <span class="fw-semibold">' . htmlspecialchars($usuario_registro) . '</span>
                        <div class="text-muted small">ID: ' . htmlspecialchars($codigo_time) . '</div>
                    </div>
                </div>
            </td>
            <td class="text-center align-middle">
                <span class="small">' . htmlspecialchars($fechaFormateada) . '</span>
            </td>
            <td class="text-center align-middle">
                <span class="text-muted small" data-bs-toggle="tooltip" title="' . htmlspecialchars($ip_registro) . '">
                    ' . htmlspecialchars($masked_ip) . '
                </span>
            </td>
            <td class="text-center align-middle">
                ' . $estadoBadge . '
            </td>
            <td class="text-center align-middle">
                ' . $acciones . '
            </td>
        </tr>';
    }

    private function maskIP($ip) {
        if (empty($ip)) return '';
        $parts = explode('.', $ip);
        if (count($parts) === 4) {
            return $parts[0] . '.***.***.' . $parts[3];
        }
        return hash('sha256', $ip);
    }

    private function getEstadoBadge($ip_bloqueo) {
        if (!empty($ip_bloqueo)) {
            return '<span class="badge bg-danger status-badge"><i class="bi bi-lock-fill me-1"></i>Bloqueado</span>';
        } else {
            return '<span class="badge bg-success status-badge"><i class="bi bi-check-circle-fill me-1"></i>Activo</span>';
        }
    }

    private function getAcciones($id, $ip_bloqueo) {
        $btnClass = empty($ip_bloqueo) ? 'btn-warning' : 'btn-success';
        $btnIcon = empty($ip_bloqueo) ? 'bi-lock-fill' : 'bi-unlock-fill';
        $btnText = empty($ip_bloqueo) ? 'Bloquear' : 'Desbloquear';
        
        return '
        <div class="btn-group btn-group-sm" role="group">
            <button class="btn btn-sm btn-primary view-btn" data-id="'.$id.'">
                <i class="bi bi-eye-fill"></i>
            </button>
            <button class="btn btn-sm '.$btnClass.' toggle-block-btn" data-id="'.$id.'" data-blocked="'.(!empty($ip_bloqueo) ? '1' : '0').'">
                <i class="bi '.$btnIcon.'"></i>
            </button>
            <button class="btn btn-sm btn-danger delete-btn" data-id="'.$id.'">
                <i class="bi bi-trash-fill"></i>
            </button>
        </div>';
    }

    private function renderModals() {
        return '
        <!-- Modal de Ayuda -->
        <div class="modal fade" id="Ayuda_registro_usuario" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="bi bi-question-circle-fill me-2"></i>Ayuda - Registro de Usuarios</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <h5 class="alert-heading"><i class="bi bi-info-circle-fill me-2"></i>Información</h5>
                            <hr>
                            <p>Este módulo muestra todos los usuarios registrados en el sistema con información detallada sobre cada registro.</p>
                        </div>
                        
                        <h5 class="mt-4"><i class="bi bi-list-check me-2"></i>Funcionalidades</h5>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item"><i class="bi bi-search me-2 text-primary"></i><strong>Buscar usuarios</strong> - Puedes buscar por nombre de usuario, ID o IP</li>
                            <li class="list-group-item"><i class="bi bi-funnel-fill me-2 text-primary"></i><strong>Filtrar registros</strong> - Filtra por estado, fechas u otros criterios</li>
                            <li class="list-group-item"><i class="bi bi-download me-2 text-primary"></i><strong>Exportar datos</strong> - Exporta la lista a CSV, Excel o PDF</li>
                            <li class="list-group-item"><i class="bi bi-lock-fill me-2 text-primary"></i><strong>Gestión de bloqueos</strong> - Bloquea o desbloquea usuarios directamente</li>
                        </ul>
                        
                        <div class="alert alert-warning">
                            <h5 class="alert-heading"><i class="bi bi-exclamation-triangle-fill me-2"></i>Advertencia</h5>
                            <hr>
                            <p>El bloqueo de usuarios es una acción irreversible que puede afectar la experiencia del usuario. Utilice esta función con precaución.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal de Estadísticas -->
        <div class="modal fade" id="statsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title"><i class="bi bi-graph-up me-2"></i>Estadísticas de Registros</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-muted">Total Usuarios</h6>
                                        <h2 class="text-primary">'.count($this->registroUsuarios).'</h2>
                                        <div class="progress mt-2" style="height: 10px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-muted">Usuarios Activos</h6>
                                        <h2 class="text-success">'.$this->countActiveUsers().'</h2>
                                        <div class="progress mt-2" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: '.$this->getActivePercentage().'%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-muted">Usuarios Bloqueados</h6>
                                        <h2 class="text-danger">'.$this->countBlockedUsers().'</h2>
                                        <div class="progress mt-2" style="height: 10px;">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: '.$this->getBlockedPercentage().'%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card bg-light h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-muted">Registros Hoy</h6>
                                        <h2 class="text-warning">'.$this->countTodayRegistrations().'</h2>
                                        <div class="progress mt-2" style="height: 10px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: '.$this->getTodayPercentage().'%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mt-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-calendar-week me-2"></i>Registros por día (últimos 7 días)</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center py-4">
                                    <span class="text-muted"><i class="bi bi-bar-chart-fill me-2"></i>Gráfico de registros</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">
                            <i class="bi bi-download me-1"></i>Exportar Reporte
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal de Exportación -->
        <div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-download me-2"></i>Exportar Datos</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Formato de exportación</label>
                            <select class="form-select">
                                <option selected>Seleccione un formato</option>
                                <option value="csv">CSV (Excel)</option>
                                <option value="pdf">PDF</option>
                                <option value="json">JSON</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rango de fechas</label>
                            <div class="input-group">
                                <input type="date" class="form-control" placeholder="Desde">
                                <span class="input-group-text">a</span>
                                <input type="date" class="form-control" placeholder="Hasta">
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="exportAll" checked>
                            <label class="form-check-label" for="exportAll">
                                Exportar todos los registros ('.count($this->registroUsuarios).')
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success">
                            <i class="bi bi-download me-1"></i>Exportar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal de Filtros -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title"><i class="bi bi-funnel-fill me-2"></i>Filtrar Registros</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Estado del usuario</label>
                            <select class="form-select">
                                <option selected>Todos</option>
                                <option value="active">Solo activos</option>
                                <option value="blocked">Solo bloqueados</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rango de fechas</label>
                            <div class="input-group">
                                <input type="date" class="form-control" placeholder="Desde">
                                <span class="input-group-text">a</span>
                                <input type="date" class="form-control" placeholder="Hasta">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ordenar por</label>
                            <select class="form-select">
                                <option value="fecha_desc" selected>Fecha (más reciente primero)</option>
                                <option value="fecha_asc">Fecha (más antiguo primero)</option>
                                <option value="nombre_asc">Nombre (A-Z)</option>
                                <option value="nombre_desc">Nombre (Z-A)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-outline-danger">
                            <i class="bi bi-x-circle me-1"></i>Limpiar Filtros
                        </button>
                        <button type="button" class="btn btn-primary">
                            <i class="bi bi-funnel-fill me-1"></i>Aplicar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>';
    }

    private function renderScripts() {
        return '
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inicializar DataTable
            const dataTable = new simpleDatatables.DataTable("#registroUsuarioTable", {
                searchable: true,
                sortable: true,
                perPage: 25,
                perPageSelect: [10, 25, 50, 100],
                labels: {
                    placeholder: "Buscar...",
                    perPage: "registros por página",
                    noRows: "No se encontraron registros",
                    info: "Mostrando {start} a {end} de {rows} registros"
                },
                columns: [
                    { select: 1, sortable: false }
                ]
            });
            
            dataTable.columns().sort(2, "desc");
            
            // Inicializar tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll(\'[data-bs-toggle="tooltip"]\'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Manejar búsqueda
            document.getElementById("searchForm")?.addEventListener("submit", function(e) {
                e.preventDefault();
                const searchTerm = document.getElementById("searchInput")?.value.trim();
                if(searchTerm) {
                    window.location.href = "?search=" + encodeURIComponent(searchTerm);
                }
            });
            
            // Manejar botón de actualización
            document.getElementById("refreshBtn")?.addEventListener("click", function() {
                window.location.reload();
            });
            
            // Función para hacer peticiones AJAX
            async function makeRequest(url, method, data) {
                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        body: JSON.stringify(data)
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    return await response.json();
                } catch (error) {
                    console.error("Error en la petición:", error);
                    throw error;
                }
            }
            
            // Manejar botones de visualización
            document.querySelectorAll(".view-btn").forEach(btn => {
                btn.addEventListener("click", function() {
                    const userId = this.getAttribute("data-id");
                    
                    // Aquí podrías implementar una llamada AJAX para obtener los detalles
                    // y mostrarlos en un modal o SweetAlert2
                    Swal.fire({
                        title: "Detalles del Usuario",
                        html: `Cargando detalles del usuario ID: ${userId}...`,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            // Simular carga de datos
                            setTimeout(() => {
                                Swal.getHtmlContainer().innerHTML = `
                                    <div class="text-start">
                                        <p><strong>ID:</strong> ${userId}</p>
                                        <p><strong>Nombre:</strong> Usuario Ejemplo</p>
                                        <p><strong>Registrado el:</strong> 01/01/2023</p>
                                        <p><strong>Estado:</strong> Activo</p>
                                    </div>
                                `;
                                Swal.showLoading();
                                Swal.update({
                                    showConfirmButton: true,
                                    confirmButtonText: "Cerrar"
                                });
                            }, 1000);
                        }
                    });
                });
            });
            
            // Manejar botones de bloqueo/desbloqueo
            document.querySelectorAll(".toggle-block-btn").forEach(btn => {
                btn.addEventListener("click", async function() {
                    const userId = this.getAttribute("data-id");
                    const isBlocked = this.getAttribute("data-blocked") === "1";
                    const action = isBlocked ? "desbloquear" : "bloquear";
                    
                    const result = await Swal.fire({
                        title: `¿${isBlocked ? "Desbloquear" : "Bloquear"} usuario?`,
                        text: `Estás a punto de ${action} este usuario. ¿Deseas continuar?`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: `Sí, ${action}`,
                        cancelButtonText: "Cancelar",
                        reverseButtons: true,
                        customClass: {
                            confirmButton: `btn ${isBlocked ? "btn-success" : "btn-warning"} mx-2`,
                            cancelButton: "btn btn-secondary mx-2"
                        },
                        buttonsStyling: false
                    });
                    
                    if (result.isConfirmed) {
                        try {
                            // Mostrar loading
                            Swal.fire({
                                title: "Procesando...",
                                text: `Por favor espera mientras se ${action} al usuario`,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            
                            // Simular llamada AJAX
                            // En un caso real, aquí harías una petición al servidor
                            // const response = await makeRequest("/api/users/toggle-block", "POST", { id: userId });
                            
                            // Simular retardo de red
                            await new Promise(resolve => setTimeout(resolve, 1500));
                            
                            // Mostrar resultado
                            Swal.fire({
                                title: "¡Éxito!",
                                text: `El usuario ha sido ${action}do correctamente.`,
                                icon: "success",
                                confirmButtonText: "Aceptar",
                                willClose: () => {
                                    // Recargar la página para ver los cambios
                                    window.location.reload();
                                }
                            });
                        } catch (error) {
                            Swal.fire({
                                title: "Error",
                                text: `Ocurrió un error al intentar ${action} al usuario.`,
                                icon: "error",
                                confirmButtonText: "Aceptar"
                            });
                            console.error(error);
                        }
                    }
                });
            });
            
            // Manejar botones de eliminación
            document.querySelectorAll(".delete-btn").forEach(btn => {
                btn.addEventListener("click", async function() {
                    const userId = this.getAttribute("data-id");
                    const row = this.closest("tr");
                    const userName = row.querySelector("td:nth-child(2) .fw-semibold").textContent;
                    
                    const result = await Swal.fire({
                        title: "¿Eliminar registro?",
                        html: `Estás a punto de eliminar el registro de <strong>${userName}</strong> (ID: ${userId}).<br><br>Esta acción no se puede deshacer.`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Sí, eliminar",
                        cancelButtonText: "Cancelar",
                        reverseButtons: true,
                        customClass: {
                            confirmButton: "btn btn-danger mx-2",
                            cancelButton: "btn btn-secondary mx-2"
                        },
                        buttonsStyling: false,
                        focusCancel: true
                    });
                    
                    if (result.isConfirmed) {
                        try {
                            // Mostrar loading
                            Swal.fire({
                                title: "Eliminando...",
                                text: "Por favor espera mientras se elimina el registro",
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            
                            // Simular llamada AJAX
                            // En un caso real, aquí harías una petición al servidor
                            // const response = await makeRequest("/api/users/delete", "DELETE", { id: userId });
                            
                            // Simular retardo de red
                            await new Promise(resolve => setTimeout(resolve, 1500));
                            
                            // Mostrar resultado
                            Swal.fire({
                                title: "¡Eliminado!",
                                text: "El registro ha sido eliminado correctamente.",
                                icon: "success",
                                confirmButtonText: "Aceptar",
                                willClose: () => {
                                    // Recargar la página para ver los cambios
                                    window.location.reload();
                                }
                            });
                        } catch (error) {
                            Swal.fire({
                                title: "Error",
                                text: "Ocurrió un error al intentar eliminar el registro.",
                                icon: "error",
                                confirmButtonText: "Aceptar"
                            });
                            console.error(error);
                        }
                    }
                });
            });
        });
        </script>';
    }

    private function countActiveUsers() {
        return count(array_filter($this->registroUsuarios, function($user) {
            return empty($user['ip_bloqueo']);
        }));
    }

    private function countBlockedUsers() {
        return count(array_filter($this->registroUsuarios, function($user) {
            return !empty($user['ip_bloqueo']);
        }));
    }

    private function countTodayRegistrations() {
        $today = date('Y-m-d');
        return count(array_filter($this->registroUsuarios, function($user) use ($today) {
            return date('Y-m-d', strtotime($user['fecha_registro'])) === $today;
        }));
    }

    private function getActivePercentage() {
        if (empty($this->registroUsuarios)) return 0;
        return round(($this->countActiveUsers() / count($this->registroUsuarios)) * 100);
    }

    private function getBlockedPercentage() {
        if (empty($this->registroUsuarios)) return 0;
        return round(($this->countBlockedUsers() / count($this->registroUsuarios)) * 100);
    }

    private function getTodayPercentage() {
        if (empty($this->registroUsuarios)) return 0;
        return round(($this->countTodayRegistrations() / count($this->registroUsuarios)) * 100);
    }
}

// Obtener término de búsqueda si existe
$searchTerm = isset($_GET['search']) ? $_GET['search'] : null;

// Renderizar la página
$gestionRegistroUsuario = new GestionRegistroUsuario($searchTerm);
echo $gestionRegistroUsuario->render();
?>