<ion-tabs>

  <ion-tab-bar slot="bottom" translucent="true" class="custom-tab-bar">
    
    <ion-tab-button tab="inicio" href="?page=inicio">
      <ion-icon name="home-outline" class="tab-icon"></ion-icon>
      <ion-label>Inicio</ion-label>
    </ion-tab-button>

    <ion-tab-button tab="perfil" href="?page=perfil">
      <ion-icon name="person-circle-outline" class="tab-icon"></ion-icon>
      <ion-label>Perfil</ion-label>
    </ion-tab-button>

    <ion-tab-button tab="tiempos" href="?page=tiempos">
      <ion-icon name="hourglass-outline" class="tab-icon"></ion-icon>
      <ion-label>Tiempos</ion-label>
    </ion-tab-button>

    <ion-tab-button tab="configuracion" href="?page=configuracion">
      <ion-icon name="settings-outline" class="tab-icon"></ion-icon>
      <ion-label>Ajustes</ion-label>
    </ion-tab-button>

  </ion-tab-bar>
</ion-tabs>

<style>
  ion-tab-bar.custom-tab-bar {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(8px);
    border-top: 1px solid #ddd;
    --color: #666;
    --color-selected: #3b82f6;
    --background: #fff;
  }

  ion-tab-button {
    transition: all 0.3s ease;
  }

  ion-tab-button.ion-selected {
    transform: scale(1.1);
    font-weight: bold;
  }

  .tab-icon {
    transition: transform 0.3s ease;
  }

  ion-tab-button.ion-selected .tab-icon {
    transform: scale(1.3) rotate(10deg);
    color: #3b82f6;
  }
</style>
