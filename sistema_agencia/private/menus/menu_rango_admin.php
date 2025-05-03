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
        <img src="/public/assets/custom_general/custom_menus/icono.png" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
        <?= $this->brand ?>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
          <i class="bi bi-list"></i>
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

  <?php
  }

  private function getMenuIcon($itemName)
  {
    $icons = [
      'Inicio' => 'bi bi-house-door-fill',
      'Perfil' => 'bi bi-person-fill',
      'Informacion' => 'bi bi-info-circle-fill',
      'Ascenso' => 'bi bi-arrow-up-circle-fill',
      'Ventas' => 'bi bi-cart-fill',
      'Paga' => 'bi bi-wallet-fill',
      'Gestion de usuarios' => 'bi bi-people-fill'
    ];
    return $icons[$itemName] ?? 'bi bi-circle-fill';
  }

  private function getDropdownIcon($itemName)
  {
    $icons = [
      'Ver perfil' => 'bi bi-person-circle',
      'Cerrar session' => 'bi bi-box-arrow-right',
      'Requisitos paga' => 'bi bi-list-check',
      'Calcular rango' => 'bi bi-calculator-fill',
      'Gestion de tiempo' => 'bi bi-clock-fill',
      'Gestion ascenso' => 'bi bi-people-fill',
      'Ventas membresias' => 'bi bi-person-badge-fill',
      'total ventas' => 'bi bi-graph-up-arrow',
      'Gestion de pagas' => 'bi bi-wallet2',
      'Pagar usuario' => 'bi bi-cash',
      'Grafico total de pagas' => 'bi bi-pie-chart-fill',
      'Verificar usuarios' => 'bi bi-shield-check-fill', 
      'Gestionar usuarios' => 'bi bi-gear-fill',
      'Vender membresias' => 'bi bi-tags-fill',
      'Vender rangos' => 'bi bi-award-fill',
      'Ventas rangos' => 'bi bi-star-fill',
    ];
    return $icons[$itemName] ?? 'bi bi-circle-fill';
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
