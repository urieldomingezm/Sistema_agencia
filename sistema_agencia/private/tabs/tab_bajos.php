<!-- Navbar inferior con Tailwind CSS e íconos estilizados -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
  <ul class="flex justify-around items-center py-2 px-4 bg-gradient-to-tr from-white to-gray-100 backdrop-blur-md">
    
    <li>
      <a href="?page=inicio" class="flex flex-col items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V12H9v8a2 2 0 01-2 2H5a2 2 0 01-2-2V10z" />
        </svg>
        <span class="text-xs mt-1">Inicio</span>
      </a>
    </li>

    <li>
      <a href="?page=perfil" class="flex flex-col items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.403 0 4.64.632 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="text-xs mt-1">Perfil</span>
      </a>
    </li>

    <li>
      <a href="?page=cerrar_session" class="flex flex-col items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v2m0 8v2m6-6h2M4 12H2m15.364-4.636l1.414-1.414M6.343 17.657l-1.414 1.414m12.728 0l-1.414-1.414M6.343 6.343L4.929 7.757" />
        </svg>
        <span class="text-xs mt-1">Cerrar session</span>
      </a>
    </li>

  </ul>
</nav>
