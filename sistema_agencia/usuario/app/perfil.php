<ion-app>
  <ion-content fullscreen="true" color="light" class="perfil-content">
    <!-- Avatar y bienvenida -->
    <div class="ion-text-center ion-padding perfil-header">
      <ion-avatar class="perfil-avatar">
        <img src="https://i.pravatar.cc/300" alt="Avatar de usuario">
      </ion-avatar>
      <ion-text color="primary">
        <h1 class="ion-no-margin">Usuario Ejemplo</h1>
      </ion-text>
      <ion-badge color="medium" class="perfil-badge">Agente</ion-badge>
    </div>

    <!-- Datos del perfil -->
    <ion-list lines="full" class="perfil-list">
      <ion-item>
        <ion-icon name="mail" slot="start" color="primary"></ion-icon>
        <ion-label>Correo Electrónico</ion-label>
        <ion-note slot="end">usuario@ejemplo.com</ion-note>
      </ion-item>

      <ion-item>
        <ion-icon name="calendar" slot="start" color="primary"></ion-icon>
        <ion-label>Fecha de Ingreso</ion-label>
        <ion-note slot="end">15/03/2023</ion-note>
      </ion-item>

      <ion-item>
        <ion-icon name="time" slot="start" color="primary"></ion-icon>
        <ion-label>Tiempo Total</ion-label>
        <ion-note slot="end">245 horas</ion-note>
      </ion-item>

      <ion-item>
        <ion-icon name="trophy" slot="start" color="primary"></ion-icon>
        <ion-label>Último Ascenso</ion-label>
        <ion-note slot="end">Hace 2 meses</ion-note>
      </ion-item>
    </ion-list>

  </ion-content>
</ion-app>

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
