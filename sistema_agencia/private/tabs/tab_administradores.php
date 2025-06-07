<!-- Navbar inferior estilo app con Tailwind CSS -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow z-50">
  <ul class="flex justify-around items-center py-2 px-4 bg-gradient-to-tr from-white to-gray-100 backdrop-blur-md touch-manipulation select-none">

    <!-- Inicio -->
    <li>
      <a href="?page=inicio" aria-label="Inicio" class="flex flex-col items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 10l9-7 9 7v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V12H9v8a2 2 0 01-2 2H5a2 2 0 01-2-2V10z" />
        </svg>
        <span class="text-xs mt-1">Inicio</span>
      </a>
    </li>

    <!-- Perfil -->
    <li>
      <a href="?page=perfil" aria-label="Perfil" class="flex flex-col items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5.121 17.804A13.937 13.937 0 0112 15c2.403 0 4.64.632 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="text-xs mt-1">Perfil</span>
      </a>
    </li>

    <!-- Más (puede ir al escritorio u otro menú) -->
    <li>
      <a href="?page=escritorio" aria-label="Más opciones" class="flex flex-col items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 6v6l4 2M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
        </svg>
        <span class="text-xs mt-1">Más</span>
      </a>
    </li>

    <!-- Cerrar sesión -->
    <li>
      <a href="?page=cerrar_session" aria-label="Cerrar sesión" class="flex flex-col items-center text-gray-500 hover:text-red-500 transition-all duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        <span class="text-xs mt-1">Salir</span>
      </a>
    </li>

  </ul>
</nav>
