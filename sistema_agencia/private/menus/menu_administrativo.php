<?php
class AdminNavbar
{
  private $brand;
  private $items;
  private $searchPlaceholder;
  private $searchButtonText;

  public function __construct($brand, $items, $searchPlaceholder = "Buscar", $searchButtonText = "Buscar")
  {
    $this->brand = $brand;
    $this->items = $items;
    $this->searchPlaceholder = $searchPlaceholder;
    $this->searchButtonText = $searchButtonText;
  }

  public function render()
  {
    require_once(PROCESOS_NOTIFICACIONES_PACTH . 'get_notifications.php');
?>
    <nav class="admin-navbar navbar fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand text-white" href="index.php">
          <img src="/public/assets/custom_general/custom_menus/icono.ico" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; margin-right: 10px;" alt="Icono de Sistema">
          <?= $this->brand ?>
        </a>

        <div class="d-flex align-items-center">
          <div class="d-flex align-items-center me-3 gap-2">
            <!-- Botón de usuario -->
            <div class="dropdown">
              <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center position-relative" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-gear me-1"></i>
                <span class="d-none d-sm-inline">
                  <?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : "Admin"; ?>
                </span>
                <span class="d-inline d-sm-none">
                  <?php
                  if (isset($_SESSION["user_id"])) {
                    $notificationManager = new NotificationManager();
                    $userNotifications = $notificationManager->getNotificationsByUserId($_SESSION["user_id"]);

                    if (isset($_SESSION["usuario"])) {
                      $nombre = $_SESSION["usuario"];
                      echo strlen($nombre) > 6 ? substr($nombre, 0, 6) . "..." : $nombre;
                    } else {
                      echo "Admin";
                    }
                  } else {
                    $userNotifications = [];
                    echo "Admin";
                  }
                  ?>
                </span>

                <!-- Icono de notificaciones -->
                <?php if (!empty($userNotifications)): ?>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php echo count($userNotifications); ?>
                    <span class="visually-hidden">unread notifications</span>
                  </span>
                <?php endif; ?>
              </button>

              <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                <li>
                  <h6 class="dropdown-header text-white">Notificaciones</h6>
                </li>

                <?php if (!empty($userNotifications)): ?>
                  <?php foreach ($userNotifications as $notification): ?>
                    <li>
                      <a class="dropdown-item" href="#">
                        <strong><?php echo htmlspecialchars($notification["nombre_habbo"]); ?>:</strong>
                        <?php echo htmlspecialchars($notification["notificacion_mensaje"]); ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li>
                    <span class="dropdown-item text-white">No tienes notificaciones</span>
                  </li>
                <?php endif; ?>

                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item py-2" href="index.php?page=ver_perfil"><i class="bi bi-person-lines-fill me-2"></i> Perfil</a></li>
                <li><a class="dropdown-item py-2" href="index.php?page=configuracion"><i class="bi bi-gear-fill me-2"></i> Configuración</a></li>
                <li>
                  <hr class="dropdown-divider my-1">
                </li>
                <li><a class="dropdown-item py-2" href="index.php?page=cerrar_session"><i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión</a></li>
              </ul>
            </div>
          </div>

          <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-label="Abrir menú">
            <i class="bi bi-list text-white"></i>
          </button>
        </div>

        <div class="offcanvas offcanvas-end" id="offcanvasNavbar">
          <div class="offcanvas-header text-white">
            <h5 class="offcanvas-title">
              Panel Administrativo
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
          </div>

          <div class="offcanvas-body">
            <div class="accordion" id="menuAccordion">
              <?php foreach ($this->items as $index => $item): ?>
                <div class="accordion-item">
                  <?php if (isset($item['dropdown'])): ?>
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse<?= $index ?>"
                        aria-expanded="false">
                        <i class="<?= $this->getMenuIcon($item['name']) ?> me-2"></i>
                        <?= $item['name'] ?>
                      </button>
                    </h2>
                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse"
                      data-bs-parent="#menuAccordion">
                      <div class="accordion-body p-0">
                        <ul class="list-unstyled mb-0">
                          <?php foreach ($item['dropdown'] as $dropdownItem): ?>
                            <?php if (is_array($dropdownItem) && isset($dropdownItem['submenu'])): ?>
                              <!-- Elemento con submenú (tercer nivel) -->
                              <li class="dropdown-submenu">
                                <a class="menu-link dropdown-toggle" href="#" data-bs-toggle="collapse" 
                                  data-bs-target="#submenu-<?= $index ?>-<?= $dropdownItem['id'] ?>">
                                  <i class="<?= $this->getDropdownIcon($dropdownItem['name']) ?> me-2"></i>
                                  <?= $dropdownItem['name'] ?>
                                  <i class="bi bi-chevron-right float-end"></i>
                                </a>
                                <div id="submenu-<?= $index ?>-<?= $dropdownItem['id'] ?>" class="collapse">
                                  <ul class="list-unstyled ps-3">
                                    <?php foreach ($dropdownItem['submenu'] as $subItem): ?>
                                      <?php if ($subItem == 'divider'): ?>
                                        <li><hr class="dropdown-divider mx-1"></li>
                                      <?php else: ?>
                                        <li>
                                          <a class="menu-link" href="<?= $this->getItemUrl($subItem) ?>">
                                            <i class="<?= $this->getDropdownIcon($subItem) ?> me-2"></i>
                                            <?= $subItem ?>
                                          </a>
                                        </li>
                                      <?php endif; ?>
                                    <?php endforeach; ?>
                                  </ul>
                                </div>
                              </li>
                            <?php elseif ($dropdownItem == 'divider'): ?>
                              <li><hr class="dropdown-divider mx-3"></li>
                            <?php else: ?>
                              <!-- Elemento normal (segundo nivel) -->
                              <li>
                                <a class="menu-link" href="<?= $this->getItemUrl($dropdownItem) ?>">
                                  <i class="<?= $this->getDropdownIcon($dropdownItem) ?> me-2"></i>
                                  <?= $dropdownItem ?>
                                </a>
                              </li>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    </div>
                  <?php else: ?>
                    <h2 class="accordion-header">
                      <a class="accordion-button" href="index.php?page=<?= strtolower(str_replace(' ', '_', $item['name'])) ?>">
                        <i class="<?= $this->getMenuIcon($item['name']) ?> me-2"></i>
                        <?= $item['name'] ?>
                      </a>
                    </h2>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>

            <form class="search-form mt-3" role="search" method="GET" action="/admin/index.php">
              <div class="input-group">
                <input type="search" class="form-control" name="q"
                  placeholder="<?= $this->searchPlaceholder ?>" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </nav>

    <style>
      .admin-navbar {
        background-color: #2c3e50;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      }
      
      .admin-navbar .dropdown-submenu .menu-link {
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
      }
      
      .admin-navbar .dropdown-submenu .collapse {
        background-color: rgba(255, 255, 255, 0.05);
      }
      
      .menu-link {
        padding: 0.5rem 1rem;
        display: block;
        color: #f8f9fa;
        text-decoration: none;
        transition: all 0.3s;
      }
      
      .menu-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
      }
      
      .accordion-button:not(.collapsed) {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
      }
      
      .accordion-item {
        background-color: transparent;
        border-color: rgba(255, 255, 255, 0.1);
      }
    </style>
<?php
  }

  private function getMenuIcon($itemName)
  {
    $icons = [
      'Dashboard' => 'bi bi-speedometer2',
      'Usuarios' => 'bi bi-people-fill',
      'Membresías' => 'bi bi-person-badge-fill',
      'Rangos' => 'bi bi-award-fill',
      'Pagos' => 'bi bi-credit-card-fill',
      'Reportes' => 'bi bi-graph-up',
      'Configuración' => 'bi bi-gear-fill',
      'Auditoría' => 'bi bi-clipboard2-data-fill'
    ];
    return $icons[$itemName] ?? 'bi bi-circle-fill';
  }

  private function getDropdownIcon($itemName)
  {
    $icons = [
      'Ver perfil' => 'bi bi-person-lines-fill',
      'Configuración' => 'bi bi-gear-fill',
      'Cerrar sesión' => 'bi bi-box-arrow-right',
      'Gestión de usuarios' => 'bi bi-person-gear',
      'Roles y permisos' => 'bi bi-shield-lock',
      'Cambio de contraseñas' => 'bi bi-key-fill',
      'Tipos de membresía' => 'bi bi-card-list',
      'Ventas' => 'bi bi-cash-stack',
      'Renovaciones' => 'bi bi-arrow-repeat',
      'Historial' => 'bi bi-clock-history',
      'Catálogo de rangos' => 'bi bi-collection',
      'Asignación' => 'bi bi-person-plus',
      'Promociones' => 'bi bi-percent',
      'Traslados' => 'bi bi-arrow-left-right',
      'Registro de pagos' => 'bi bi-journal-check',
      'Reporte de ingresos' => 'bi bi-pie-chart-fill',
      'Transacciones' => 'bi bi-arrow-left-right',
      'Estadísticas' => 'bi bi-bar-chart-line-fill',
      'Exportar datos' => 'bi bi-file-earmark-excel',
      'Ajustes del sistema' => 'bi bi-sliders',
      'Backup' => 'bi bi-database-check',
      'Logs de actividad' => 'bi bi-journal-text',
      'Ver todos' => 'bi bi-list-ul'
    ];
    return $icons[$itemName] ?? 'bi bi-circle-fill';
  }

  private function getItemUrl($item)
  {
    $modalItems = [
      'Agregar usuario' => '#" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario',
      'Cambiar contraseña' => '#" data-bs-toggle="modal" data-bs-target="#modalCambiarPassword',
      'Nueva membresía' => '#" data-bs-toggle="modal" data-bs-target="#modalNuevaMembresia',
      'Registrar pago' => '#" data-bs-toggle="modal" data-bs-target="#modalRegistrarPago',
      'Asignar rango' => '#" data-bs-toggle="modal" data-bs-target="#modalAsignarRango'
    ];

    if (isset($modalItems[$item])) {
      return $modalItems[$item];
    }

    return 'index.php?page=' . strtolower(str_replace(' ', '_', $item));
  }
}

// Configuración del menú con 3 niveles
$adminItems = [
  ['name' => 'Dashboard'],
  ['name' => 'Usuarios', 'dropdown' => [
    ['name' => 'Gestión de usuarios', 'id' => 'gestion', 'submenu' => [
      'Lista de usuarios',
      'Agregar usuario',
      'Modificar usuario',
      'Cambio de contraseñas',
      'divider',
      'Roles y permisos'
    ]],
    'divider',
    'Reporte de usuarios'
  ]],
  ['name' => 'Membresías', 'dropdown' => [
    ['name' => 'Administración', 'id' => 'membresias', 'submenu' => [
      'Tipos de membresía',
      'Ventas',
      'Renovaciones',
      'Historial'
    ]],
    'divider',
    'Reporte de membresías'
  ]],
  ['name' => 'Rangos', 'dropdown' => [
    ['name' => 'Gestión', 'id' => 'rangos', 'submenu' => [
      'Catálogo de rangos',
      'Asignación',
      'Promociones',
      'Traslados'
    ]],
    'divider',
    'Reporte de rangos'
  ]],
  ['name' => 'Pagos', 'dropdown' => [
    ['name' => 'Transacciones', 'id' => 'pagos', 'submenu' => [
      'Registro de pagos',
      'Reporte de ingresos',
      'Transacciones'
    ]],
    'divider',
    'Estadísticas financieras'
  ]],
  ['name' => 'Reportes', 'dropdown' => [
    'Estadísticas',
    'Exportar datos',
    'Reportes personalizados'
  ]],
  ['name' => 'Configuración', 'dropdown' => [
    'Ajustes del sistema',
    'Backup',
    'Logs de actividad'
  ]]
];

$navbar = new AdminNavbar('Panel Administrativo', $adminItems);
$navbar->render();
?>

<!-- Script para manejar los submenús -->
<script>
  $(document).ready(function() {
    // Manejar la apertura/cierre de submenús
    $('.dropdown-submenu a.dropdown-toggle').on('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      var target = $(this).data('bs-target');
      $(target).collapse('toggle');
      
      // Rotar el icono de flecha
      $(this).find('.bi-chevron-right').toggleClass('rotate-90');
    });
    
    // Cerrar otros submenús cuando se abre uno nuevo
    $('.dropdown-submenu .collapse').on('show.bs.collapse', function() {
      $('.dropdown-submenu .collapse').not(this).collapse('hide');
    });
    
    // Manejar modales
    $('.modal').on('show.bs.modal', function(e) {
      var currentModalId = $(this).attr('id');
      
      $('.modal').not(this).each(function() {
        if ($(this).hasClass('show')) {
          var modalInstance = bootstrap.Modal.getInstance(this);
          if (modalInstance) {
            modalInstance.hide();
          }
        }
      });
      
      window.activeModal = currentModalId;
    });
    
    // Rotación de iconos
    $('.accordion-button').on('click', function() {
      $(this).find('.bi').toggleClass('rotate-180');
    });
  });
</script>

<style>
  .rotate-90 {
    transform: rotate(90deg);
    transition: transform 0.3s ease;
  }
  
  .rotate-180 {
    transform: rotate(180deg);
    transition: transform 0.3s ease;
  }
  
  .accordion-button::after {
    display: none; /* Ocultar el icono por defecto de Bootstrap */
  }
</style>
