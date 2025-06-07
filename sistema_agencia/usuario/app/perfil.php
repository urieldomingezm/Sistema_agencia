<div class="flex-1 p-4">
    <div class="bg-white rounded-lg shadow-md p-6 text-center mb-6">
        <div class="w-32 h-32 mx-auto rounded-full border-4 border-blue-500 overflow-hidden mb-4">
            <img src="https://i.pravatar.cc/300" alt="Avatar" class="w-full h-full object-cover">
        </div>
        <h1 class="text-2xl font-bold text-blue-600 mb-2">Usuario Ejemplo</h1>
        <span class="inline-block bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">Agente</span>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex items-center py-3 border-b border-gray-100">
            <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <div>
                <p class="text-gray-500 text-sm">Correo Electrónico</p>
                <p class="font-medium">usuario@ejemplo.com</p>
            </div>
        </div>
        <!-- Más elementos del perfil aquí -->
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
