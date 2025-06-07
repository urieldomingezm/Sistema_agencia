<div class="min-h-screen bg-gray-50 p-4 md:p-8 flex flex-col justify-center">
  <!-- Contenedor general del perfil -->
  <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
    <!-- Encabezado del perfil -->
    <div class="bg-blue-600 p-6 text-center">
      <div class="w-28 h-28 md:w-32 md:h-32 mx-auto rounded-full border-4 border-white overflow-hidden">
        <img src="https://i.pravatar.cc/300?u=Santidemg2" alt="Avatar" class="w-full h-full object-cover" />
      </div>
      <h1 class="mt-4 text-2xl font-bold text-white">Santidemg2</h1>
      <span class="inline-block mt-2 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">Activo</span>
    </div>

    <!-- Información General -->
    <div class="p-6 space-y-6">
      <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">Información General</h2>
      <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800">
        <div>
          <p class="text-sm text-gray-500">ID</p>
          <p>62</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Usuario</p>
          <p>Santidemg2</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Código</p>
          <p>TSZU8</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Rango</p>
          <p>Web_master</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Membresía</p>
          <p>Sin membresía</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Pagos</p>
          <p></p> <!-- Vacío, puede usarse para algo -->
        </div>
      </div>
    </div>

    <!-- Estado Requisitos -->
    <div class="p-6 bg-gray-50 border-t border-gray-200 space-y-4">
      <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-2 mb-4">Estado Requisitos</h2>
      <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800">
        <div>
          <p class="text-sm text-gray-500">Estado Requisitos</p>
          <p class="font-medium text-green-600">Completado</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Último Pago</p>
          <p>Recibió 0c - Pago realizado</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Próximo Pago</p>
          <p class="text-yellow-600 font-semibold">Pendiente de recibir pago</p>
        </div>
      </div>
    </div>

    <!-- Tiempo -->
    <div class="p-6 space-y-4">
      <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">Tiempo</h2>
      <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800">
        <div>
          <p class="text-sm text-gray-500">Total Acumulado</p>
          <p>00:00:00</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Tiempo Restado</p>
          <p>00:00:00</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Encargado</p>
          <p class="text-gray-600 italic">Sin asignar</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Estado</p>
          <p class="text-red-600 font-semibold">Pausa</p>
        </div>
      </div>
    </div>

    <!-- Ascenso -->
    <div class="p-6 bg-gray-50 border-t border-gray-200 space-y-4">
      <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-2 mb-4">Ascenso</h2>
      <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800">
        <div>
          <p class="text-sm text-gray-500">Misión Actual</p>
          <p>Web_master</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Próximo Ascenso</p>
          <p class="text-green-600 font-semibold">Disponible ahora</p>
        </div>
        <div class="col-span-2 text-gray-700">
          <p class="text-sm font-medium">Ya puedes solicitar tu ascenso</p>
        </div>
      </div>
    </div>

    <!-- Estado -->
    <div class="p-6 space-y-4">
      <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">Estado</h2>
      <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800">
        <div>
          <p class="text-sm text-gray-500">Estado</p>
          <p class="text-yellow-600 font-semibold">En Espera</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Encargado</p>
          <p>keekit08</p>
        </div>
      </div>
    </div>

    <!-- Botón editar -->
    <div class="p-6 border-t border-gray-200">
      <button class="w-full md:w-auto px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center justify-center mx-auto">
        <i data-lucide="edit" class="w-5 h-5 mr-2"></i> Editar Perfil
      </button>
    </div>
  </div>
</div>

<script>
  lucide.createIcons();
</script>
