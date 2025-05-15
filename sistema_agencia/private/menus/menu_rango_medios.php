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
        <a class="navbar-brand text-white" href="index.php">
        <img src="/public/assets/custom_general/custom_menus/icono.png" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
        <?= $this->brand ?>
        </a>

        <div class="d-flex align-items-center">
          <div class="dropdown me-3">
            <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"> 
              <i class="bi bi-person-circle me-1"></i> 
              <span class="d-none d-sm-inline">
                <?php echo isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : "Usuario"; ?>
              </span>
              <span class="d-inline d-sm-none">
                <?php 
                  if(isset($_SESSION["usuario"])) {
                    $nombre = $_SESSION["usuario"];
                    echo strlen($nombre) > 6 ? substr($nombre, 0, 6)."..." : $nombre;
                  } else {
                    echo "Usr";
                  }
                ?>
              </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu shadow-sm" aria-labelledby="userDropdown"> 
              <li><a class="dropdown-item py-2" href="index.php?page=ver_perfil"><i class="bi bi-person me-2"></i> <span class="d-none d-sm-inline">Ver perfil</span><span class="d-inline d-sm-none">Perfil</span></a></li> 
              <li><hr class="dropdown-divider my-1"></li> 
              <li><a class="dropdown-item py-2" href="index.php?page=cerrar_session"><i class="bi bi-box-arrow-right me-2"></i> <span class="d-none d-sm-inline">Cerrar sesión</span><span class="d-inline d-sm-none">Salir</span></a></li> 
            </ul> 
          </div>

          <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
            <i class="bi bi-list text-white"></i>
          </button>
        </div>

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
                  <i class="bi bi-search"></i>
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
      'Ventas' => 'bi bi-cart-fill'
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
      'Gestion ascenso' => 'bi bi-people-fill',
      'Dar ascenso' => 'bi bi-arrow-up-square-fill',
      'Ver mis tiempos' => 'bi bi-clock-history'
    ];
    return $icons[$itemName] ?? 'bi bi-circle-fill';
  }

  private function getItemUrl($item)
  {
    $modalItems = [
      'Calcular rango' => '#" data-bs-toggle="modal" data-bs-target="#modalCalcular',
      'Pagar usuario' => '#" data-bs-toggle="modal" data-bs-target="#modalpagar',
      'Vender membresias y rangos' => '#" data-bs-toggle="modal" data-bs-target="#modalrangos',
      'Dar ascenso' => '#" data-bs-toggle="modal" data-bs-target="#dar_ascenso'
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
  ['name' => 'Ascenso', 'dropdown' => ['Gestion ascenso', 'Ver mis tiempos', 'Ver mis ascensos', 'divider', 'Dar ascenso']],
];

$navbar = new Navbar('Agencia Shein', $items);
$navbar->render();
?>

<script>
$(document).ready(function() {
  $('#modificar_usuario, #dar_ascenso').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
    
    if ($(this).find('.step').length > 0) {
      $(this).find('.step').addClass('d-none');
      $(this).find('.step:first').removeClass('d-none');
    }
    
    $(this).find('.progress-bar').css('width', '0%');
    $(this).find('button[id$="Btn"]').prop('disabled', false);
    $(this).find('button[id="submitBtn"]').addClass('d-none');
    $(this).find('button[id="nextBtn"]').removeClass('d-none');
    $(this).find('#resultadoBusqueda').html('');
    
    if (typeof currentStep !== 'undefined') {
      currentStep = 1;
    }
    
    setTimeout(function() {
      $(document).trigger('modal_reset');
    }, 100);
  });
  
  $('.modal').on('show.bs.modal', function (e) {
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
  
  $('[data-bs-toggle="modal"]').on('click', function(e) {
    var targetModal = $(this).data('bs-target').replace('#', '');
    
    if (window.activeModal && window.activeModal !== targetModal) {
      var modalElement = document.getElementById(window.activeModal);
      if (modalElement) {
        var modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
          modalInstance.hide();
        }
      }
    }
  });
});
</script>

<?php
require_once(MODALES_MENU_PATH . 'modal_calcular.php');
require_once(DAR_ASCENSO_PATCH . 'dar_ascenso.php');
