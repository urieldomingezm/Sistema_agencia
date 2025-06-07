<!-- Contenedor principal azul -->
<div class="max-w-md mx-auto p-4 bg-gradient-to-b from-blue-100 via-cyan-100 to-indigo-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-900 rounded-xl shadow-lg">

  <!-- Encabezado con avatar estilo Habbo -->
  <div class="text-center mb-6">
    <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 tracking-wider mb-1">¡Bienvenido!</h1>
    <p class="text-blue-700 dark:text-blue-300 font-semibold">Tu portal Habbo Fansite</p>
  </div>

  <!-- Tarjetas informativas -->
  <div class="space-y-6">
    <!-- Tarjeta 1 -->
    <div class="bg-white rounded-lg shadow-md p-5 hover:shadow-xl transition cursor-pointer">
      <h2 class="text-2xl font-bold text-blue-700 mb-1">Agencia Azul</h2>
      <p class="text-sm text-blue-500 font-semibold mb-3">¡Administra tu mundo virtual!</p>
      <p class="text-gray-700 leading-relaxed">Crea, organiza y comunica desde un solo lugar. Eventos, usuarios y comunidad al alcance.</p>
      <button class="mt-5 w-full bg-indigo-600 text-white font-bold py-2 rounded-lg hover:bg-indigo-700 flex items-center justify-center gap-2 transition">
        <svg class="w-6 h-6 stroke-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" /></svg>
        Comenzar
      </button>
    </div>

    <!-- Tarjeta 2 -->
    <div class="bg-white rounded-lg shadow-md p-5 hover:shadow-xl transition cursor-pointer">
      <h2 class="text-2xl font-bold text-cyan-600 mb-3">Lo nuevo</h2>
      <ul class="space-y-3 text-gray-800 font-medium">
        <li class="flex items-center gap-3">
          <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
          Roles personalizados
        </li>
        <li class="flex items-center gap-3">
          <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
          Diseño responsivo
        </li>
        <li class="flex items-center gap-3">
          <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
          Control total de contenido
        </li>
      </ul>
    </div>
  </div>

  <!-- Sección: Estadísticas -->
  <div class="mt-10">
    <h2 class="text-lg font-extrabold text-gray-600 mb-5 tracking-wide">Resumen general</h2>
    <div class="grid grid-cols-3 gap-4 text-center">
      <div>
        <div class="bg-blue-200 rounded-full py-2 px-3 shadow-inner text-blue-700 font-extrabold">42</div>
        <p class="text-sm text-blue-800 font-semibold mt-1">Eventos</p>
      </div>
      <div>
        <div class="bg-indigo-200 rounded-full py-2 px-3 shadow-inner text-indigo-700 font-extrabold">17</div>
        <p class="text-sm text-indigo-800 font-semibold mt-1">Miembros</p>
      </div>
      <div>
        <div class="bg-cyan-200 rounded-full py-2 px-3 shadow-inner text-cyan-700 font-extrabold">12</div>
        <p class="text-sm text-cyan-800 font-semibold mt-1">Noticias</p>
      </div>
    </div>
  </div>

  <!-- Sección: Accesos rápidos -->
  <div class="mt-10">
    <h2 class="text-lg font-extrabold text-gray-600 mb-5 tracking-wide">Accesos rápidos</h2>
    <div class="grid grid-cols-2 gap-5">
      <button class="flex flex-col items-center p-5 bg-white rounded-lg shadow hover:shadow-lg transition select-none">
        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3h18v18H3z" /></svg>
        <span class="mt-2 font-semibold text-indigo-700">Eventos</span>
      </button>
      <button class="flex flex-col items-center p-5 bg-white rounded-lg shadow hover:shadow-lg transition select-none">
        <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /></svg>
        <span class="mt-2 font-semibold text-cyan-700">Usuarios</span>
      </button>
      <button class="flex flex-col items-center p-5 bg-white rounded-lg shadow hover:shadow-lg transition select-none">
        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" /></svg>
        <span class="mt-2 font-semibold text-blue-700">Noticias</span>
      </button>
      <button class="flex flex-col items-center p-5 bg-white rounded-lg shadow hover:shadow-lg transition select-none">
        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /><path d="M12 6v6l4 2" /></svg>
        <span class="mt-2 font-semibold text-green-700">Ajustes</span>
      </button>
    </div>
  </div>

  <!-- Sección: Notificaciones recientes -->
  <div class="mt-10">
    <h2 class="text-lg font-extrabold text-gray-600 mb-5 tracking-wide">Últimos movimientos</h2>
    <ul class="space-y-5">
      <li class="bg-white rounded-lg shadow p-4 flex justify-between items-center select-none">
        <div class="flex items-start gap-4">
          <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M12 4a8 8 0 1 0 0 16 8 8 0 0 0 0-16z" /></svg>
          <div>
            <h3 class="font-bold text-gray-700">Evento publicado</h3>
            <p class="text-sm text-gray-500">Se lanzó "Trivia Retro Habbo"</p>
          </div>
        </div>
        <span class="text-sm text-gray-400 font-semibold">Hoy</span>
      </li>
    </ul>
  </div>

</div>
