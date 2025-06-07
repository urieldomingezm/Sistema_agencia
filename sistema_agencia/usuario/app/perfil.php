<div class="min-h-screen bg-gray-50 p-4 md:p-8">
    <!-- Sección de perfil -->
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header del perfil -->
        <div class="bg-blue-600 p-6 text-center">
            <div class="w-24 h-24 md:w-32 md:h-32 mx-auto rounded-full border-4 border-white overflow-hidden">
                <img src="https://i.pravatar.cc/300" alt="Avatar" class="w-full h-full object-cover">
            </div>
            <h1 class="mt-4 text-xl md:text-2xl font-bold text-white">Usuario Ejemplo</h1>
            <span class="inline-block mt-2 bg-blue-500 text-white px-3 py-1 rounded-full text-xs md:text-sm">Agente</span>
        </div>

        <!-- Información del usuario -->
        <div class="p-6 space-y-4">
            <!-- Item de información -->
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0 text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Correo Electrónico</p>
                    <p class="text-gray-800">usuario@ejemplo.com</p>
                </div>
            </div>

            <!-- Más items de información aquí -->
            
            <!-- Botón de acción -->
            <div class="pt-4">
                <button class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Editar Perfil
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CSS personalizado solo para el perfil -->
<style>
  .perfil-content {
    --background: #fefefe;
    font-family: 'Segoe UI', sans-serif;
  }

  .perfil-header {
    background: linear-gradient(to bottom right, #f0f4ff, #dbeafe);
    border-radius: 0 0 20px 20px;
    padding-bottom: 2rem;
  }

  .perfil-avatar {
    width: 120px;
    height: 120px;
    border: 4px solid #3b82f6;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin: auto;
  }

  .perfil-badge {
    margin-top: 0.5rem;
    font-size: 14px;
    padding: 6px 12px;
    border-radius: 20px;
  }

  .perfil-list ion-item {
    --padding-start: 16px;
    --inner-padding-end: 12px;
    --min-height: 56px;
  }

  .perfil-list ion-icon {
    font-size: 22px;
    color: #3b82f6;
  }

  .perfil-grid ion-button {
    border-radius: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
  }
</style>
