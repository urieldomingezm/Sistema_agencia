<ion-app>
  <ion-header>
    <ion-toolbar color="dark">
      <ion-title>Mi Perfil</ion-title>
    </ion-toolbar>
  </ion-header>

  <ion-content color="dark">
    <ion-card color="dark">
      <ion-card-header>
        <ion-grid>
          <ion-row class="ion-justify-content-center">
            <ion-avatar>
              <img src="https://i.pravatar.cc/300" alt="Avatar de usuario">
            </ion-avatar>
          </ion-row>
          <ion-row class="ion-justify-content-center">
            <ion-card-title>Usuario Ejemplo</ion-card-title>
          </ion-row>
          <ion-row class="ion-justify-content-center">
            <ion-badge color="medium">Agente</ion-badge>
          </ion-row>
        </ion-grid>
      </ion-card-header>
    </ion-card>

    <ion-list lines="full" color="dark">
      <ion-item color="dark">
        <ion-icon name="mail" slot="start"></ion-icon>
        <ion-label>Correo Electrónico</ion-label>
        <ion-note slot="end">usuario@ejemplo.com</ion-note>
      </ion-item>

      <ion-item color="dark">
        <ion-icon name="calendar" slot="start"></ion-icon>
        <ion-label>Fecha de Ingreso</ion-label>
        <ion-note slot="end">15/03/2023</ion-note>
      </ion-item>

      <ion-item color="dark">
        <ion-icon name="time" slot="start"></ion-icon>
        <ion-label>Tiempo Total</ion-label>
        <ion-note slot="end">245 horas</ion-note>
      </ion-item>

      <ion-item color="dark">
        <ion-icon name="trophy" slot="start"></ion-icon>
        <ion-label>Último Ascenso</ion-label>
        <ion-note slot="end">Hace 2 meses</ion-note>
      </ion-item>
    </ion-list>

    <ion-grid>
      <ion-row>
        <ion-col size="12">
          <ion-button expand="block" fill="outline" color="light">
            <ion-icon name="settings" slot="start"></ion-icon>
            Configuración
          </ion-button>
        </ion-col>
      </ion-row>
    </ion-grid>
  </ion-content>

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
