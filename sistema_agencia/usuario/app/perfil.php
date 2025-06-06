<ion-content fullscreen="true" scroll-y="true" color="dark">
  <!-- Avatar y bienvenida -->
  <div class="ion-text-center ion-margin-top">
    <ion-avatar class="ion-margin-auto" style="width: 120px; height: 120px;">
      <img src="https://i.pravatar.cc/300" alt="Avatar de usuario">
    </ion-avatar>
    <ion-text color="primary">
      <h2 class="ion-no-margin">Usuario Ejemplo</h2>
    </ion-text>
    <ion-badge color="medium">Agente</ion-badge>
  </div>

  <!-- Tarjeta de datos del usuario -->
  <ion-card class="ion-margin-top" color="dark">
    <ion-card-header>
      <ion-card-title color="primary">Datos de Perfil</ion-card-title>
    </ion-card-header>
    <ion-card-content>
      <ion-list lines="full" color="dark">
        <ion-item color="dark">
          <ion-icon name="mail-outline" slot="start"></ion-icon>
          <ion-label>Correo Electrónico</ion-label>
          <ion-note slot="end">usuario@ejemplo.com</ion-note>
        </ion-item>

        <ion-item color="dark">
          <ion-icon name="calendar-outline" slot="start"></ion-icon>
          <ion-label>Fecha de Ingreso</ion-label>
          <ion-note slot="end">15/03/2023</ion-note>
        </ion-item>

        <ion-item color="dark">
          <ion-icon name="time-outline" slot="start"></ion-icon>
          <ion-label>Tiempo Total</ion-label>
          <ion-note slot="end">245 horas</ion-note>
        </ion-item>

        <ion-item color="dark">
          <ion-icon name="trophy-outline" slot="start"></ion-icon>
          <ion-label>Último Ascenso</ion-label>
          <ion-note slot="end">Hace 2 meses</ion-note>
        </ion-item>
      </ion-list>
    </ion-card-content>
  </ion-card>

  <!-- Accesos rápidos estilo botón -->
  <ion-grid class="ion-margin-top">
    <ion-row>
      <ion-col size="12" class="ion-text-center">
        <ion-text color="medium">
          <h2 class="ion-no-margin">Accesos rápidos</h2>
        </ion-text>
      </ion-col>

      <ion-col size="6" class="ion-text-center ion-padding">
        <ion-button expand="block" fill="clear" color="primary">
          <ion-icon slot="icon-only" name="settings-outline" size="large"></ion-icon>
          <ion-label class="ion-margin-top">Configuración</ion-label>
        </ion-button>
      </ion-col>

      <ion-col size="6" class="ion-text-center ion-padding">
        <ion-button expand="block" fill="clear" color="warning">
          <ion-icon slot="icon-only" name="log-out-outline" size="large"></ion-icon>
          <ion-label class="ion-margin-top">Cerrar Sesión</ion-label>
        </ion-button>
      </ion-col>
    </ion-row>
  </ion-grid>

  <!-- Footer con navegación -->
  <ion-footer>
    <ion-tabs>
      <ion-tab-bar slot="bottom" color="dark">
        <ion-tab-button tab="inicio" href="?page=inicio">
          <ion-icon name="home-outline"></ion-icon>
          <ion-label>Inicio</ion-label>
        </ion-tab-button>

        <ion-tab-button tab="perfil" selected>
          <ion-icon name="person-outline"></ion-icon>
          <ion-label>Perfil</ion-label>
        </ion-tab-button>

        <ion-tab-button tab="notificaciones" href="?page=notificaciones">
          <ion-icon name="notifications-outline"></ion-icon>
          <ion-label>Notificaciones</ion-label>
          <ion-badge color="danger">2</ion-badge>
        </ion-tab-button>
      </ion-tab-bar>
    </ion-tabs>
  </ion-footer>
</ion-content>
