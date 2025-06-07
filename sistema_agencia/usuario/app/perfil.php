<div class="min-h-screen bg-gray-50 p-4 md:p-8 flex flex-col justify-between">
  <!-- Contenedor de perfil -->
  <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden flex-1">
    <!-- Encabezado del perfil -->
    <div class="bg-blue-600 p-6 text-center">
      <div class="w-24 h-24 md:w-32 md:h-32 mx-auto rounded-full border-4 border-white overflow-hidden">
        <img src="https://i.pravatar.cc/300" alt="Avatar" class="w-full h-full object-cover" />
      </div>
      <h1 class="mt-4 text-xl md:text-2xl font-bold text-white">Usuario Ejemplo</h1>
      <span class="inline-block mt-2 bg-blue-500 text-white px-3 py-1 rounded-full text-xs md:text-sm">Agente</span>
    </div>

    <!-- Detalles del perfil -->
    <div class="p-6 space-y-4">
      <!-- Correo Electrónico -->
      <div class="flex items-start space-x-4">
        <i data-lucide="mail" class="w-6 h-6 text-blue-500 mt-1"></i>
        <div>
          <p class="text-sm text-gray-500">Correo Electrónico</p>
          <p class="text-gray-800">usuario@ejemplo.com</p>
        </div>
      </div>

      <!-- Teléfono -->
      <div class="flex items-start space-x-4">
        <i data-lucide="phone" class="w-6 h-6 text-blue-500 mt-1"></i>
        <div>
          <p class="text-sm text-gray-500">Teléfono</p>
          <p class="text-gray-800">+52 123 456 7890</p>
        </div>
      </div>

      <!-- Ubicación -->
      <div class="flex items-start space-x-4">
        <i data-lucide="map-pin" class="w-6 h-6 text-blue-500 mt-1"></i>
        <div>
          <p class="text-sm text-gray-500">Ubicación</p>
          <p class="text-gray-800">Ciudad de México</p>
        </div>
      </div>

      <!-- Botón -->
      <div class="pt-4">
        <button class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
          <i data-lucide="edit" class="inline-block w-5 h-5 mr-2 -mt-1"></i>Editar Perfil
        </button>
      </div>
    </div>
  </div>

</div>

<script>
  lucide.createIcons();
</script>
