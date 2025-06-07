<!-- Navbar inferior estilo app con Tailwind CSS -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow z-50">
  <ul class="flex justify-between items-center py-2 px-3 bg-gradient-to-tr from-white to-gray-100 backdrop-blur-md touch-manipulation select-none">
    <!-- Inicio -->
    <li class="flex-1">
      <a href="?page=inicio" aria-label="Inicio" class="flex flex-col items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 10l9-7 9 7v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V12H9v8a2 2 0 01-2 2H5a2 2 0 01-2-2V10z" />
        </svg>
        <span class="text-[10px] mt-1">Inicio</span>
      </a>
    </li>

    <!-- Perfil -->
    <li class="flex-1">
      <a href="?page=perfil" aria-label="Perfil" class="flex flex-col items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5.121 17.804A13.937 13.937 0 0112 15c2.403 0 4.64.632 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="text-[10px] mt-1">Perfil</span>
      </a>
    </li>

    <!-- Ascender -->
    <li class="flex-1">
      <a href="#" aria-label="Ascender persona" class="flex flex-col items-center text-gray-500 hover:text-indigo-600 transition-all duration-300" data-bs-toggle="modal" data-bs-target="#dar_ascenso_modal">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 12h14M12 5l7 7-7 7" />
        </svg>
        <span class="text-[10px] mt-1">Ascender</span>
      </a>
    </li>

    <!-- Tomar tiempo -->
    <li class="flex-1">
      <a href="?page=tomar_tiempo" aria-label="Tomar tiempo" class="flex flex-col items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></circle>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
        </svg>
        <span class="text-[10px] mt-1">Tiempo</span>
      </a>
    </li>

    <!-- Salir -->
    <li class="flex-1">
      <a href="?page=cerrar_session" aria-label="Cerrar sesión" class="flex flex-col items-center text-gray-500 hover:text-red-500 transition-all duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        <span class="text-[10px] mt-1">Salir</span>
      </a>
    </li>
  </ul>
</nav>


<?php require_once(DAR_ASCENSO_PATCH . 'dar_ascenso.php'); ?>