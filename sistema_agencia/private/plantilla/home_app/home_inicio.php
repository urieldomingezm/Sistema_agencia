<!-- Header con avatar -->
<div class="text-center mb-6">
  <div class="w-28 h-28 mx-auto rounded-full bg-gray-200 overflow-hidden mb-4">
    <!-- <img src="ruta-avatar.jpg" alt="Avatar" class="w-full h-full object-cover"> -->
  </div>
  <h1 class="text-2xl font-semibold text-indigo-600 mb-1">¡Bienvenido!</h1>
  <p class="text-gray-500">Gestiona tu negocio de manera eficiente</p>
</div>

<!-- Slider con tarjetas -->
<div class="space-y-6">
  <div class="bg-white shadow rounded-xl p-6">
    <h2 class="text-xl font-semibold text-indigo-600">Agencia Shein APP</h2>
    <p class="text-gray-500 text-sm mb-4">Tu herramienta de gestión</p>
    <p class="text-gray-700">Estamos encantados de tenerte aquí. Esta aplicación te ayudará a gestionar tus pedidos, clientes y actividades diarias.</p>
    <button class="mt-4 w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition flex items-center justify-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M5 12h14M12 5l7 7-7 7" />
      </svg>
      Comenzar
    </button>
  </div>

  <div class="bg-white shadow rounded-xl p-6">
    <h2 class="text-xl font-semibold text-purple-600">Nuevas Funciones</h2>
    <ul class="mt-4 space-y-2 text-gray-700">
      <li class="flex items-center gap-2">
        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
        Reportes mejorados
      </li>
      <li class="flex items-center gap-2">
        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
        Sincronización en la nube
      </li>
      <li class="flex items-center gap-2">
        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
        Notificaciones push
      </li>
    </ul>
  </div>
</div>

<!-- Estadísticas -->
<div class="mt-8">
  <h2 class="text-lg text-gray-500 font-semibold mb-4">Resumen</h2>
  <div class="grid grid-cols-3 gap-4 text-center">
    <div>
      <div class="inline-block bg-indigo-100 text-indigo-600 rounded-full px-3 py-1 font-bold">25</div>
      <p class="text-sm text-gray-700 mt-1">Pedidos</p>
    </div>
    <div>
      <div class="inline-block bg-purple-100 text-purple-600 rounded-full px-3 py-1 font-bold">12</div>
      <p class="text-sm text-gray-700 mt-1">Clientes</p>
    </div>
    <div>
      <div class="inline-block bg-teal-100 text-teal-600 rounded-full px-3 py-1 font-bold">$8,450</div>
      <p class="text-sm text-gray-700 mt-1">Ventas</p>
    </div>
  </div>
</div>

<!-- Accesos rápidos -->
<div class="mt-8">
  <h2 class="text-lg text-gray-500 font-semibold mb-4">Accesos rápidos</h2>
  <div class="grid grid-cols-2 gap-4 text-center">
    <button class="flex flex-col items-center p-4 bg-white shadow rounded-lg hover:bg-indigo-50 transition">
      <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 3h18v18H3z" /></svg>
      <span class="text-sm mt-2 text-gray-700">Pedidos</span>
    </button>
    <button class="flex flex-col items-center p-4 bg-white shadow rounded-lg hover:bg-purple-50 transition">
      <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /></svg>
      <span class="text-sm mt-2 text-gray-700">Clientes</span>
    </button>
    <button class="flex flex-col items-center p-4 bg-white shadow rounded-lg hover:bg-teal-50 transition">
      <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" /></svg>
      <span class="text-sm mt-2 text-gray-700">Reportes</span>
    </button>
    <button class="flex flex-col items-center p-4 bg-white shadow rounded-lg hover:bg-green-50 transition">
      <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /><path d="M12 6v6l4 2" /></svg>
      <span class="text-sm mt-2 text-gray-700">Ajustes</span>
    </button>
  </div>
</div>

<!-- Notificaciones recientes -->
<div class="mt-8">
  <h2 class="text-lg text-gray-500 font-semibold mb-4">Notificaciones recientes</h2>
  <ul class="space-y-4">
    <li class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
      <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M12 4a8 8 0 1 0 0 16 8 8 0 0 0 0-16z" /></svg>
        <div>
          <h3 class="font-semibold text-gray-700">Pedido completado</h3>
          <p class="text-sm text-gray-500">El pedido #1254 ha sido entregado</p>
        </div>
      </div>
      <span class="text-sm text-gray-400">Hoy</span>
    </li>
    <li class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
      <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M12 4a8 8 0 1 0 0 16 8 8 0 0 0 0-16z" /></svg>
        <div>
          <h3 class="font-semibold text-gray-700">Stock bajo</h3>
          <p class="text-sm text-gray-500">El producto ZX-45 está por agotarse</p>
        </div>
      </div>
      <span class="text-sm text-gray-400">Ayer</span>
    </li>
    <li class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
      <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" /></svg>
        <div>
          <h3 class="font-semibold text-gray-700">Pago recibido</h3>
          <p class="text-sm text-gray-500">Se ha registrado un pago de $1,250</p>
        </div>
      </div>
      <span class="text-sm text-gray-400">2 días</span>
    </li>
  </ul>
</div>

<!-- Banner promocional -->
<div class="mt-8 bg-indigo-600 text-white rounded-xl p-6 text-center shadow">
  <h2 class="text-lg font-semibold flex justify-center items-center gap-2">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2l3 7h7l-5.5 4.5L17 22l-5-3-5 3 1.5-8.5L2 9h7z" /></svg>
    Pro Version
  </h2>
  <p class="text-sm mt-2">Desbloquea todas las funciones premium</p>
  <button class="mt-4 border border-white px-4 py-2 rounded-md hover:bg-white hover:text-indigo-600 transition">Actualizar ahora</button>
</div>
