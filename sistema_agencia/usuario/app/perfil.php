<div class="min-h-screen bg-gradient-to-b from-indigo-100 via-purple-100 to-pink-100 p-4 md:p-8 flex flex-col justify-center antialiased font-sans">
  <div class="max-w-3xl md:max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-200
              md:flex md:flex-row md:space-x-6">

    <!-- Header -->
    <header class="bg-gradient-to-r from-pink-600 to-purple-600 p-6 text-center relative
                   md:flex md:flex-col md:items-center md:w-1/4">
      <div class="w-28 h-28 md:w-32 md:h-32 mx-auto rounded-full border-4 border-white overflow-hidden shadow-lg bg-gradient-to-tr from-yellow-400 via-red-400 to-pink-500">
        <img src="https://i.pravatar.cc/300?u=Santidemg2" alt="Foto de perfil" class="w-full h-full object-cover" />
      </div>
      <h1 class="mt-4 text-3xl font-bold text-white drop-shadow-sm tracking-wide">Santidemg2</h1>
      <span class="inline-flex items-center mt-2 bg-white text-pink-600 px-3 py-1 rounded-full text-sm font-medium shadow-md">
        <i data-lucide="activity" class="w-4 h-4 mr-1 text-pink-600"></i> Activo
      </span>
    </header>

    <!-- Contenedor de secciones (para modo horizontal, flex y que las secciones se acomoden en columnas) -->
    <div class="flex flex-col md:flex-row md:flex-1 md:basis-0 md:space-x-6">

      <!-- Información General -->
      <section class="p-6 space-y-6 md:flex-1 md:basis-0">
        <h2 class="flex items-center text-xl font-semibold text-pink-600 border-b border-pink-200 pb-2 mb-4">
          <i data-lucide="info" class="w-5 h-5 mr-2 text-pink-500"></i> Información General
        </h2>
        <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800 text-base">
          <div><p class="text-sm text-pink-500">ID</p><p class="font-medium">62</p></div>
          <div><p class="text-sm text-pink-500">Usuario</p><p class="font-medium">Santidemg2</p></div>
          <div><p class="text-sm text-pink-500">Código</p><p class="font-medium">TSZU8</p></div>
          <div><p class="text-sm text-pink-500">Rango</p><p class="font-medium">Web_master</p></div>
          <div><p class="text-sm text-pink-500">Membresía</p><p class="font-medium">Sin membresía</p></div>
          <div><p class="text-sm text-pink-500">Pagos</p><p class="font-medium">-</p></div>
        </div>
      </section>

      <!-- Estado Requisitos -->
      <section class="p-6 bg-gray-50 border-t border-gray-200 space-y-4 md:border-t-0 md:border-l md:border-gray-200 md:flex-1 md:basis-0">
        <h2 class="flex items-center text-xl font-semibold text-gray-700 border-b border-gray-300 pb-2 mb-4">
          <i data-lucide="check-circle" class="w-5 h-5 mr-2 text-green-500"></i> Estado Requisitos
        </h2>
        <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800 text-base">
          <div><p class="text-sm text-gray-500">Estado Requisitos</p><p class="font-semibold text-green-600">Completado</p></div>
          <div><p class="text-sm text-gray-500">Último Pago</p><p class="font-medium">Recibió 0c - Pago realizado</p></div>
          <div><p class="text-sm text-gray-500">Próximo Pago</p><p class="text-yellow-600 font-semibold">Pendiente de recibir pago</p></div>
        </div>
      </section>

      <!-- Tiempo -->
      <section class="p-6 space-y-4 md:flex-1 md:basis-0">
        <h2 class="flex items-center text-xl font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">
          <i data-lucide="clock" class="w-5 h-5 mr-2 text-indigo-500"></i> Tiempo
        </h2>
        <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800 text-base">
          <div><p class="text-sm text-gray-500">Total Acumulado</p><p class="font-medium">00:00:00</p></div>
          <div><p class="text-sm text-gray-500">Tiempo Restado</p><p class="font-medium">00:00:00</p></div>
          <div><p class="text-sm text-gray-500">Encargado</p><p class="italic text-gray-600">Sin asignar</p></div>
          <div><p class="text-sm text-gray-500">Estado</p><p class="text-red-600 font-semibold">Pausa</p></div>
        </div>
      </section>

      <!-- Ascenso -->
      <section class="p-6 bg-gray-50 border-t border-gray-200 space-y-4 md:border-t-0 md:border-l md:border-gray-200 md:flex-1 md:basis-0">
        <h2 class="flex items-center text-xl font-semibold text-gray-700 border-b border-gray-300 pb-2 mb-4">
          <i data-lucide="trending-up" class="w-5 h-5 mr-2 text-purple-500"></i> Ascenso
        </h2>
        <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800 text-base">
          <div><p class="text-sm text-gray-500">Misión Actual</p><p class="font-medium">Web_master</p></div>
          <div><p class="text-sm text-gray-500">Próximo Ascenso</p><p class="text-green-600 font-semibold">Disponible ahora</p></div>
          <div class="col-span-2 text-gray-700">
            <p class="text-sm font-medium">Ya puedes solicitar tu ascenso</p>
          </div>
        </div>
      </section>

      <!-- Estado -->
      <section class="p-6 space-y-4 md:flex-1 md:basis-0">
        <h2 class="flex items-center text-xl font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">
          <i data-lucide="alert-circle" class="w-5 h-5 mr-2 text-yellow-500"></i> Estado
        </h2>
        <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800 text-base">
          <div><p class="text-sm text-gray-500">Estado</p><p class="text-yellow-600 font-semibold">En Espera</p></div>
          <div><p class="text-sm text-gray-500">Encargado</p><p class="font-medium">keekit08</p></div>
        </div>
      </section>
    </div>

    <!-- Botón editar -->
    <div class="p-6 border-t border-pink-200 md:border-t-0 md:border-l md:border-pink-200 md:flex md:items-center md:justify-center md:w-1/4">
      <button class="w-full md:w-auto px-6 py-2.5 bg-pink-600 text-white rounded-lg hover:bg-pink-700 active:scale-95 transition duration-300 flex items-center justify-center mx-auto shadow-lg">
        <i data-lucide="edit-3" class="w-5 h-5 mr-2"></i> Editar Perfil
      </button>
    </div>

  </div>
</div>

<!-- Lucide Icons -->
<script>
  lucide.createIcons();
</script>
