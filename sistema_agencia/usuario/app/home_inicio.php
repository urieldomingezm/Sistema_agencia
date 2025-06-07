<!-- Contenedor principal -->
<div class="max-w-md mx-auto p-4 bg-gradient-to-b from-indigo-100 via-purple-100 to-pink-100 rounded-xl shadow-lg">

  <!-- Encabezado con avatar estilo Habbo -->
  <div class="text-center mb-6">
    <div class="w-28 h-28 mx-auto rounded-full bg-gradient-to-tr from-yellow-400 via-red-400 to-pink-500 border-4 border-white shadow-lg flex items-center justify-center mb-4 overflow-hidden">
      <span class="text-6xl select-none">😊</span>
    </div>
    <h1 class="text-3xl font-bold text-pink-600 tracking-wider mb-1">¡Bienvenido!</h1>
    <p class="text-purple-700 font-semibold">Gestiona tu fansite con estilo</p>
  </div>

  <!-- Sección: Slider / Tarjetas informativas -->
  <div class="space-y-6">
    <!-- Tarjeta 1 -->
    <div class="bg-white rounded-lg shadow-md p-5 hover:shadow-xl transition cursor-pointer">
      <h2 class="text-2xl font-bold text-indigo-600 mb-1">Agencia Shein APP</h2>
      <p class="text-sm text-indigo-500 font-semibold mb-3">Tu herramienta para fansite</p>
      <p class="text-gray-700 leading-relaxed">Estamos encantados de tenerte aquí. Administra tu comunidad, eventos y noticias con facilidad.</p>
      <button class="mt-5 w-full bg-pink-600 text-white font-bold py-2 rounded-lg hover:bg-pink-700 flex items-center justify-center gap-2 transition">
        <svg class="w-6 h-6 stroke-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" /></svg>
        Comenzar
      </button>
    </div>

    <!-- Tarjeta 2 -->
    <div class="bg-white rounded-lg shadow-md p-5 hover:shadow-xl transition cursor-pointer">
      <h2 class="text-2xl font-bold text-purple-600 mb-3">Nuevas Funciones</h2>
      <ul class="space-y-3 text-gray-800 font-medium">
        <li class="flex items-center gap-3">
          <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
          Reportes mejorados
        </li>
        <li class="flex items-center gap-3">
          <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
          Sincronización en la nube
        </li>
        <li class="flex items-center gap-3">
          <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
          Notificaciones push
        </li>
      </ul>
    </div>
  </div>

  <!-- Sección: Estadísticas -->
  <div class="mt-10">
    <h2 class="text-lg font-extrabold text-gray-600 mb-5 tracking-wide">Resumen rápido</h2>
    <div class="grid grid-cols-3 gap-4 text-center">
      <div>
        <div class="bg-pink-200 rounded-full py-2 px-3 shadow-inner text-pink-700 font-extrabold">25</div>
        <p class="text-sm text-pink-800 font-semibold mt-1">Pedidos</p>
      </div>
      <div>
        <div class="bg-purple-200 rounded-full py-2 px-3 shadow-inner text-purple-700 font-extrabold">12</div>
        <p class="text-sm text-purple-800 font-semibold mt-1">Clientes</p>
      </div>
      <div>
        <div class="bg-teal-200 rounded-full py-2 px-3 shadow-inner text-teal-700 font-extrabold">$8,450</div>
        <p class="text-sm text-teal-800 font-semibold mt-1">Ventas</p>
      </div>
    </div>
  </div>

  <!-- Sección: Accesos rápidos -->
  <div class="mt-10">
    <h2 class="text-lg font-extrabold text-gray-600 mb-5 tracking-wide">Accesos rápidos</h2>
    <div class="grid grid-cols-2 gap-5">
      <!-- Botones de acceso -->
      <template id="shortcut-button">
        <!-- Reutilizable si lo necesitas -->
      </template>
      <button class="flex flex-col items-center p-5 bg-white rounded-lg shadow hover:shadow-lg transition select-none">
        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3h18v18H3z" /></svg>
        <span class="mt-2 font-semibold text-pink-700">Pedidos</span>
      </button>
      <button class="flex flex-col items-center p-5 bg-white rounded-lg shadow hover:shadow-lg transition select-none">
        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /></svg>
        <span class="mt-2 font-semibold text-purple-700">Clientes</span>
      </button>
      <button class="flex flex-col items-center p-5 bg-white rounded-lg shadow hover:shadow-lg transition select-none">
        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" /></svg>
        <span class="mt-2 font-semibold text-teal-700">Reportes</span>
      </button>
      <button class="flex flex-col items-center p-5 bg-white rounded-lg shadow hover:shadow-lg transition select-none">
        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /><path d="M12 6v6l4 2" /></svg>
        <span class="mt-2 font-semibold text-green-700">Ajustes</span>
      </button>
    </div>
  </div>

  <!-- Sección: Notificaciones recientes -->
  <div class="mt-10">
    <h2 class="text-lg font-extrabold text-gray-600 mb-5 tracking-wide">Notificaciones recientes</h2>
    <ul class="space-y-5">
      <!-- Notificación -->
      <li class="bg-white rounded-lg shadow p-4 flex justify-between items-center select-none">
        <div class="flex items-start gap-4">
          <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M12 4a8 8 0 1 0 0 16 8 8 0 0 0 0-16z" /></svg>
          <div>
            <h3 class="font-bold text-gray-700">Pedido completado</h3>
            <p class="text-sm text-gray-500">El pedido #1254 ha sido entregado</p>
          </div>
        </div>
        <span class="text-sm text-gray-400 font-semibold">Hoy</span>
      </li>
      <!-- Más notificaciones... -->
    </ul>
  </div>

  <!-- Banner promocional -->
  <div class="mt-10 bg-pink-600 text-white rounded-xl p-6 text-center shadow-lg select-none">
    <h2 class="text-xl font-extrabold flex items-center justify-center gap-3 tracking-wide">
      <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l3 7h7l-5.5 4.5L17 22l-5-3-5 3 1.5-8.5L2 9h7z" /></svg>
      Pro Version
    </h2>
    <p class="text-sm mt-3 font-semibold">Desbloquea todas las funciones premium</p>
    <button class="mt-5 border border-white px-5 py-2 rounded-lg font-bold hover:bg-white hover:text-pink-600 transition">Actualizar ahora</button>
  </div>

</div>
