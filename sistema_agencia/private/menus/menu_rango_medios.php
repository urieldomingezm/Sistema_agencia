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
            <ul class="navbar-nav">
              <?php foreach ($this->items as $item): ?>
                <?php if (isset($item['dropdown'])): ?>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                      <i class="<?= $this->getMenuIcon($item['name']) ?> me-2"></i>
                      <?= $item['name'] ?>
                    </a>
                    <ul class="dropdown-menu">
                      <?php foreach ($item['dropdown'] as $dropdownItem): ?>
                        <?php if ($dropdownItem == 'divider'): ?>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                        <?php else: ?>
                          <li>
                            <a class="dropdown-item" href="<?= $this->getItemUrl($dropdownItem) ?>">
                              <i class="<?= $this->getDropdownIcon($dropdownItem) ?> me-2"></i>
                              <?= $dropdownItem ?>
                            </a>
                          </li>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </ul>
                  </li>
                <?php else: ?>
                  <li class="nav-item">
                    <a class="nav-link<?= (isset($item['active']) && $item['active'] ? ' active' : '') ?>"
                      href="index.php?page=<?= strtolower(str_replace(' ', '_', $item['name'])) ?>">
                      <i class="<?= $this->getMenuIcon($item['name']) ?> me-2"></i>
                      <?= $item['name'] ?>
                    </a>
                  </li>
                <?php endif; ?>
              <?php endforeach; ?>
            </ul>

            <form class="search-form" role="search" method="GET" action="/usuario/index.php">
              <div class="input-group">
                <input type="search"
                  class="form-control"
                  name="q"
                  placeholder="<?= $this->searchPlaceholder ?>"
                  aria-label="Search">
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
      'Ventas' => 'fas fa-shopping-cart'
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
      'Gestion ascenso' => 'fas fa-users'
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
  ['name' => 'Ascenso', 'dropdown' => ['Gestion ascenso']]
];

$navbar = new Navbar('Agencia Atenas', $items);
$navbar->render();


require_once(MODALES_MENU_PATH . 'modal_calcular.php');
require_once(MODALES_MENU_PAGA_PATH . 'modal_pagar_usuario.php');
require_once(MODALES_MENU_VENTAS_PATH . 'modal_vender_rangos.php');
