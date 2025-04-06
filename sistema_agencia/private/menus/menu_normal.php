<?php

class Navbar
{
  private $brand;
  private $items;
  private $searchPlaceholder;
  private $searchButtonText;

  public function __construct($brand, $items, $searchPlaceholder = "Search", $searchButtonText = "Search")
  {
    $this->brand = $brand;
    $this->items = $items;
    $this->searchPlaceholder = $searchPlaceholder;
    $this->searchButtonText = $searchButtonText;
  }

  public function render()
  {
    echo '<style>
      .dropdown-menu {
        background-color: #343a40;
      }
      .dropdown-item {
        color: white;
      }
      .dropdown-item:hover, .dropdown-item:focus {
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
      }
      .user-dropdown .dropdown-toggle::after {
        display: none;
      }
      .navbar-brand {
        flex-grow: 1;
        text-align: center;
      }
      .navbar-nav {
        flex-grow: 1;
        justify-content: flex-end;
      }
      .navbar-nav .nav-item {
        margin-left: 15px;
      }
      .user-dropdown {
        margin-left: auto;
        display: flex;
        align-items: center;
      }
      .user-dropdown .dropdown-toggle {
        padding-left: 10px;
        padding-right: 10px;
      }
      .user-dropdown img {
        margin-right: 10px;
      }
      @media (max-width: 991.98px) {
        .navbar-nav {
          flex-direction: column;
          align-items: flex-start;
        }
        .navbar-nav .nav-item {
          margin-left: 0;
          margin-bottom: 10px;
        }
        .navbar-collapse {
          padding-top: 10px;
        }
      }
    </style>';

    echo '<nav class="navbar navbar-expand-lg fixed-top" style="background-color:rgb(209, 25, 96);" data-bs-theme="dark">';
    echo '<div class="container-fluid d-flex">';

    // Navbar brand centrado
    echo '<a class="navbar-brand text-white" href="#">' . $this->brand . '</a>';

    // Botón del toggler con SVG personalizado
    echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
          </svg>';
    echo '</button>';

    echo '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
    
    // Elementos alineados a la derecha
    echo '<ul class="navbar-nav ms-auto mb-2 mb-lg-0">';

    foreach ($this->items as $item) {
      if (isset($item['dropdown'])) {
        echo '<li class="nav-item dropdown">';
        echo '<a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
        echo $item['name'];
        echo '</a>';
        echo '<ul class="dropdown-menu">';
        foreach ($item['dropdown'] as $dropdownItem) {
          if ($dropdownItem == 'divider') {
            echo '<li><hr class="dropdown-divider"></li>';
          } else {
            // Modificando para agregar los href de 'Iniciar Session' y 'Registrarse'
            if ($dropdownItem == 'Iniciar Session') {
              echo '<li><a class="dropdown-item" href="login.php">' . $dropdownItem . '</a></li>';
            } elseif ($dropdownItem == 'Registrarse') {
              echo '<li><a class="dropdown-item" href="registrar.php">' . $dropdownItem . '</a></li>';
            } else {
              echo '<li><a class="dropdown-item" href="login.php">' . $dropdownItem . '</a></li>';
            }
          }
        }
        echo '</ul>';
        echo '</li>';
      } else {
        echo '<li class="nav-item">';
        echo '<a class="nav-link text-white' . (isset($item['active']) && $item['active'] ? ' active' : '') . '" href="#">' . $item['name'] . '</a>';
        echo '</li>';
      }
    }

    echo '</ul>';

    // Formulario de búsqueda
    echo '<form class="d-flex ms-3" role="search">';
    echo '<input class="form-control me-2 bg-light text-dark" type="search" placeholder="' . $this->searchPlaceholder . '" aria-label="Search">';
    echo '<button class="btn btn-light" type="submit">' . $this->searchButtonText . '</button>';
    echo '</form>';

    echo '</div>';
    echo '</div>';
    echo '</nav>';
  }
}

$items = [
  ['name' => 'Inicio', 'active' => true],
  ['name' => 'Unirse', 'dropdown' => ['Iniciar session','Registrarse']],
  ['name' => 'Informacion', 'dropdown' => ['Rangos']],
];

$navbar = new Navbar('Agencia Atenas', $items);
$navbar->render();

?>