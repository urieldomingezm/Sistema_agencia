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
    <style>
      /* Añadir padding al body para que el contenido no quede oculto bajo la navbar fija */
      body {
        padding-top: 60px; /* Ajusta este valor si tu navbar tiene una altura diferente */
      }
      /* Estilos adicionales para la navbar si es necesario */
      .custom-navbar {
          background-color: #2541b2; /* Color de fondo de ejemplo, ajusta si es necesario */
      }
      .custom-navbar .navbar-brand {
          color: white !important;
      }
      .custom-navbar .navbar-toggler {
          color: white !important;
      }
      .offcanvas-header {
          background-color: #2541b2; /* Color de fondo del header del offcanvas */
      }
      .offcanvas-title {
          color: white;
      }
      .btn-close-white {
          filter: invert(1); /* Hace que el botón de cerrar sea blanco */
      }
      .accordion-button {
          color: #212529; /* Color de texto por defecto para los botones del acordeón */
      }
      .accordion-button:not(.collapsed) {
          color: #0d6efd; /* Color de texto para los botones del acordeón expandidos */
          background-color: #e7f1ff; /* Color de fondo para los botones del acordeón expandidos */
      }
      .menu-link {
          color: #212529; /* Color de texto para los enlaces del menú */
          text-decoration: none;
          display: block;
          padding: 0.5rem 1rem;
      }
      .menu-link:hover {
          color: #0d6efd; /* Color de texto al pasar el ratón por los enlaces */
          background-color: #f8f9fa;
      }
    </style>
    <nav class="custom-navbar navbar fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand text-white" href="index.php">
          <!-- Añadido atributo alt a la imagen del logo -->
          <img src="/public/assets/custom_general/custom_menus/icono.png" alt="Logo de Agencia Shein" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
          <?= $this->brand ?>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <i class="bi bi-list text-white"></i>
          </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header text-white">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
              Menú Principal
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <div class="offcanvas-body">
            <div class="accordion" id="menuAccordion">
              <?php foreach ($this->items as $index => $item): ?>
                <div class="accordion-item">
                  <?php if (isset($item['dropdown'])): ?>
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                              data-bs-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
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