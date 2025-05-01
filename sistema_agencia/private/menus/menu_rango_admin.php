<?php
class Navbar
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
?>
    <nav class="custom-navbar navbar fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
          <i class="fas fa-building me-2"></i><?= $this->brand ?>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
          <i class="fas fa-bars"></i>
        </button>

        <div class="offcanvas offcanvas-end" id="offcanvasNavbar">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title">
              <i class="fas fa-compass me-2"></i>Menú Principal
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
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
                                    <?php if ($dropdownItem == 'divider'): ?>
                                        <li><hr class="dropdown-divider mx-3"></li>
                                    <?php else: ?>
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
                        <a class="accordion-button" 
                           href="index.php?page=<?= strtolower(str_replace(' ', '_', $item['name'])) ?>">
                            <i class="<?= $this->getMenuIcon($item['name']) ?> me-2"></i>
                            <?= $item['name'] ?>
                        </a>
                    </h2>
                <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>

            <form class="search-form mt-3" role="search" method="GET" action="/usuario/index.php">
              <div class="input-group">
                <input type="search" class="form-control" name="q" 
                       placeholder="<?= $this->searchPlaceholder ?>" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </nav>

    <style>
      .custom-navbar {
        background: linear-gradient(135deg, #A78BFA 0%, #8B5CF6 100%);
        padding: 1rem;
        box-shadow: 0 2px 15px rgba(139, 92, 246, 0.2);
      }

      .accordion-item {
        border: none;
        background: transparent;
        margin-bottom: 0.5rem;
      }

      .accordion-button {
        background: transparent;
        color: #000;
        font-weight: 500;
        border-radius: 8px;
        padding: 1rem;
        text-decoration: none;
        box-shadow: none;
      }

      .accordion-button:not(.collapsed) {
        background: rgba(139, 92, 246, 0.25);
        color: #000;
        box-shadow: none;
      }

      .accordion-button:hover {
        background: rgba(167, 139, 250, 0.2);
      }

      .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
      }

      .menu-link {
        display: block;
        padding: 0.75rem 1.5rem;
        color: #000;
        text-decoration: none;
        transition: all 0.3s ease;
      }

      .menu-link:hover {
        background: rgba(167, 139, 250, 0.2);
        color: #000;
        text-decoration: none;
      }

      .navbar-brand {
        color: #000;
        font-weight: 600;
        font-size: 1.25rem;
      }

      .navbar-brand:hover {
        color: rgba(0, 0, 0, 0.8);
      }

      .navbar-toggler {
        color: #000;
        font-size: 1.5rem;
      }

      .nav-link {
        color: #000 !important;
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 0.5rem 1rem;
      }

      .nav-link:hover {
        background: rgba(167, 139, 250, 0.2);
        color: #000 !important;
      }

      .nav-link.active {
        background: rgba(139, 92, 246, 0.25);
        color: #000 !important;
      }

      .dropdown-item:hover {
        background: rgba(167, 139, 250, 0.1);
        color: #000;
      }

      .dropdown-menu {
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 0.5rem;
      }

      .dropdown-item {
        color: #000;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
      }

      .dropdown-item:hover {
        background: rgba(0, 123, 255, 0.1);
        color: #000;
      }

      .search-form {
        margin-top: 1rem;
      }

      .search-form .form-control {
        border-radius: 20px 0 0 20px;
        border: 2px solid #000;
        border-right: none;
        color: #000;
        background-color: rgba(167, 139, 250, 0.9);
        height: 45px;
      }

      .search-form .btn {
        border-radius: 0 20px 20px 0;
        border: 2px solid #000;
        border-left: none;
        color: #000;
        background-color: rgba(138, 43, 226, 0.9);
        padding: 0 20px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .search-form .btn:hover {
        background-color: rgba(0, 0, 0, 0.1);
        color: #000;
      }

      .search-form .form-control:focus {
        box-shadow: none;
        border-color: #000;
      }

      .search-form .form-control::placeholder {
        color: rgba(0, 0, 0, 0.6);
      }

      .search-form .input-group {
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      }

      .search-form .btn {
        border-radius: 0 20px 20px 0;
        border: none;
        color: #000;
      }

      .offcanvas-header {
        background: linear-gradient(135deg, #A78BFA 0%, #8B5CF6 100%);
        color: #000;
      }

      .search-form .btn:hover {
        background-color: rgba(139, 92, 246, 0.1);
      }
    </style>
<?php
  }

  private function getMenuIcon($itemName)
  {
    $icons = [
      'Inicio' => 'fas fa-home',
      'Perfil' => 'fas fa-user',
      'Informacion' => 'fas fa-info-circle',
      'Ascenso' => 'fas fa-arrow-up',
      'Ventas' => 'fas fa-shopping-cart',
      'Paga' => 'fas fa-money-bill-wave',
      'Gestion de usuarios' => 'fas fa-user-check'
    ];
    return $icons[$itemName] ?? 'fas fa-circle';
  }

  private function getDropdownIcon($itemName)
  {
    $icons = [
      'Ver perfil' => 'fas fa-user-circle',
      'Cerrar session' => 'fas fa-sign-out-alt',
      'Requisitos paga' => 'fas fa-list-check',
      'Calcular rango' => 'fas fa-calculator',
      'Gestion de tiempo' => 'fas fa-clock',
      'Gestion ascenso' => 'fas fa-users',
      'Ventas membresias' => 'fas fa-id-card',
      'total ventas' => 'fas fa-chart-line',
      'Gestion de pagas' => 'fas fa-wallet',
      'Pagar usuario' => 'fas fa-hand-holding-usd',
      'Grafico total de pagas' => 'fas fa-chart-pie',
      'Verificar usuarios' => 'fas fa-user-shield', 
      'Gestionar usuarios' => 'fas fa-users-cog',
      'Vender membresias' => 'fas fa-tags',
      'Vender rangos' => 'fas fa-crown',
      'Ventas rangos' => 'fas fa-star',
    ];
    return $icons[$itemName] ?? 'fas fa-circle';
  }

  private function getItemUrl($item)
  {
    $modalItems = [
      'Calcular rango' => '#" data-bs-toggle="modal" data-bs-target="#modalCalcular',
      'Pagar usuario' => '#" data-bs-toggle="modal" data-bs-target="#modalpagar',
      'Vender membresias y rangos' => '#" data-bs-toggle="modal" data-bs-target="#modalrangos'
    ];

    if (isset($modalItems[$item])) {
      return $modalItems[$item];
    }

    return 'index.php?page=' . strtolower(str_replace(' ', '_', $item));
  }
}

$items = [
  ['name' => 'Inicio', 'active' => true],
  ['name' => 'Perfil', 'dropdown' => ['Ver perfil', 'Cerrar session']],
  ['name' => 'Informacion', 'dropdown' => ['Requisitos paga', 'Calcular rango']],
  ['name' => 'Ascenso', 'dropdown' => ['Gestion de tiempo', 'Gestion ascenso']],
  ['name' => 'Ventas', 'dropdown' => ['Ventas membresias', 'Ventas rangos', 'total ventas', 'divider', 'Vender membresias','Vender rangos']],
  ['name' => 'Paga', 'dropdown' => ['Gestion de pagas', 'Pagar usuario', 'Grafico total de pagas']],
  ['name' => 'Gestion de usuarios', 'dropdown' => ['Verificar usuarios', 'Gestionar usuarios']],
];

$navbar = new Navbar('Agencia Shein', $items);
$navbar->render();


require_once(MODALES_MENU_PATH . 'modal_calcular.php');
require_once(MODALES_MENU_PAGA_PATH . 'modal_pagar_usuario.php');
require_once(MODALES_MENU_VENTAS_PATH . 'modal_vender_rangos.php');
