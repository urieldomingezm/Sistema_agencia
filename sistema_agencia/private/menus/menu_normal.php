<?php

class Navbar
{
  private $brand;
  private $items;

  public function __construct($brand, $items)
  {
    $this->brand = $brand;
    $this->items = $items;
  }

  public function render()
  {
?>
    <nav class="custom-navbar navbar fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand text-white" href="index.php">
          <img src="/public/assets/custom_general/custom_menus/icono.ico" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; margin-right: 10px;" alt="Icono de Agencia Shein">
          <?= $this->brand ?>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-label="Abrir menú">
            <i class="bi bi-list text-white"></i>
          </button>

        <div class="offcanvas offcanvas-end" id="offcanvasNavbar">
          <div class="offcanvas-header text-white">
            <h5 class="offcanvas-title">
              Menú Principal
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
          </div>

          <div class="offcanvas-body">
            <div class="accordion" id="menuAccordion">
              <?php foreach ($this->items as $index => $item): ?>
                <div class="accordion-item">
                  <?php if (isset($item['dropdown'])): ?>
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                              data-bs-target="#collapse<?= $index ?>" aria-expanded="false">
                          <i class="<?= $this->getMenuIcon($item['name']) ?> me-2"></i>
                          <?= $item['name'] ?>
                      </button>
                    </h2>
                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#menuAccordion">
                      <div class="accordion-body">
                        <ul class="list-unstyled">
                          <?php foreach ($item['dropdown'] as $dropdownItem): ?>
                            <?php if ($dropdownItem == 'divider'): ?>
                              <hr class="dropdown-divider">
                            <?php else: ?>
                              <li>
                                <?php if ($dropdownItem == 'Iniciar session'): ?>
                                  <a class="menu-link" href="login.php">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    <?= $dropdownItem ?>
                                  </a>
                                <?php elseif ($dropdownItem == 'Registrarse'): ?>
                                  <a class="menu-link" href="registrar.php">
                                    <i class="bi bi-person-plus me-2"></i>
                                    <?= $dropdownItem ?>
                                  </a>
                                <?php else: ?>
                                  <a class="menu-link" href="<?= $this->getItemUrl($dropdownItem) ?>">
                                    <i class="<?= $this->getDropdownIcon($dropdownItem) ?> me-2"></i>
                                    <?= $dropdownItem ?>
                                  </a>
                                <?php endif; ?>
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
          </div>
        </div>
      </div>
    </nav>
<?php
  }

  private function getMenuIcon($itemName)
  {
    $icons = [
      'Inicio' => 'bi bi-house-door',
      'Unirse' => 'bi bi-people',
      'Informacion' => 'bi bi-info-square'
    ];
    return $icons[$itemName] ?? 'bi bi-circle';
  }

  private function getDropdownIcon($itemName)
  {
    $icons = [
      'Iniciar session' => 'bi bi-box-arrow-in-right',
      'Registrarse' => 'bi bi-person-add',
      'Rangos' => 'bi bi-award-fill'
    ];
    return $icons[$itemName] ?? 'bi bi-circle';
  }

  private function getItemUrl($item)
  {
    if ($item === 'Rangos') {
      return 'rangos.php';
    }
    return 'index.php?page=' . strtolower(str_replace(' ', '_', $item));
  }
}

$items = [
  ['name' => 'Inicio', 'active' => true],
  ['name' => 'Unirse', 'dropdown' => ['Iniciar session', 'Registrarse']],
  ['name' => 'Informacion', 'dropdown' => ['Rangos']],
];

$navbar = new Navbar('Agencia Shein', $items);
$navbar->render();
?>