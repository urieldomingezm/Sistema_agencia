<ion-app>
  <!-- Header -->
  <ion-header>
    <ion-toolbar color="dark">
      <ion-title>Mi Perfil</ion-title>
    </ion-toolbar>
  </ion-header>

  <!-- Contenido -->
  <ion-content fullscreen="true" color="light">
    <!-- Avatar y bienvenida -->
    <div class="ion-text-center ion-padding">
      <ion-avatar style="width: 120px; height: 120px; margin: auto;">
        <img src="https://i.pravatar.cc/300" alt="Avatar de usuario">
      </ion-avatar>
      <ion-text color="primary">
        <h1 class="ion-no-margin">Usuario Ejemplo</h1>
      </ion-text>
      <ion-badge color="medium">Agente</ion-badge>
    </div>

    <!-- Datos del perfil -->
    <ion-list lines="full" color="light">
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

    <!-- Botón de configuración -->
    <ion-grid class="ion-padding">
      <ion-row>
        <ion-col size="12">
          <ion-button expand="block" fill="outline" color="primary">
            <ion-icon name="settings" slot="start"></ion-icon>
            Configuración
          </ion-button>
        </ion-col>
      </ion-row>
    </ion-grid>
  </ion-content>

  <!-- Footer con tabs -->
  <ion-footer>
    <ion-tabs>
      <ion-tab-bar slot="bottom" color="dark">
        <ion-tab-button tab="inicio" href="?page=inicio">
          <ion-icon name="home"></ion-icon>
          <ion-label>Inicio</ion-label>
        </ion-tab-button>

        <ion-tab-button tab="perfil" selected>
          <ion-icon name="person"></ion-icon>
          <ion-label>Perfil</ion-label>
        </ion-tab-button>

        <ion-tab-button tab="notificaciones" href="?page=notificaciones">
          <ion-icon name="notifications"></ion-icon>
          <ion-label>Notificaciones</ion-label>
          <ion-badge color="danger">2</ion-badge>
        </ion-tab-button>
      </ion-tab-bar>
    </ion-tabs>
  </ion-footer>
</ion-app>
