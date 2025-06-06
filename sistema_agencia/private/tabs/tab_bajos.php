<ion-tabs>

  <ion-tab-bar slot="bottom" class="custom-tab-bar">
    
    <ion-tab-button tab="inicio" href="?page=inicio">
      <div class="tab-container">
        <ion-icon name="home-outline" class="tab-icon"></ion-icon>
        <ion-label>Inicio</ion-label>
      </div>
    </ion-tab-button>

    <ion-tab-button tab="perfil" href="?page=perfil">
      <div class="tab-container">
        <ion-icon name="person-circle-outline" class="tab-icon"></ion-icon>
        <ion-label>Perfil</ion-label>
      </div>
    </ion-tab-button>

    <ion-tab-button tab="tiempos" href="?page=tiempos">
      <div class="tab-container">
        <ion-icon name="hourglass-outline" class="tab-icon"></ion-icon>
        <ion-label>Tiempos</ion-label>
      </div>
    </ion-tab-button>

    <ion-tab-button tab="configuracion" href="?page=configuracion">
      <div class="tab-container">
        <ion-icon name="settings-outline" class="tab-icon"></ion-icon>
        <ion-label>Ajustes</ion-label>
      </div>
    </ion-tab-button>

  </ion-tab-bar>
</ion-tabs>

<style>
  ion-tab-bar.custom-tab-bar {
    --background: linear-gradient(145deg, #ffffff, #f0f0f0);
    --color: #777;
    --color-selected: #007aff;
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
    padding-bottom: env(safe-area-inset-bottom);
  }

  ion-tab-button {
    transition: transform 0.3s ease, background 0.3s ease;
    border-radius: 14px;
    margin: 4px 8px;
  }

  .tab-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 6px;
    border-radius: 12px;
    transition: all 0.3s ease-in-out;
  }

  ion-tab-button.ion-selected .tab-container {
    background: rgba(0, 122, 255, 0.1);
    box-shadow: 0 2px 8px rgba(0, 122, 255, 0.2);
    transform: scale(1.1);
  }

  .tab-icon {
    font-size: 24px;
    transition: transform 0.3s ease, color 0.3s ease;
    color: inherit;
  }

  ion-tab-button.ion-selected .tab-icon {
    transform: scale(1.3) rotate(5deg);
    color: #007aff;
  }

  ion-label {
    font-size: 12px;
    margin-top: 4px;
    transition: color 0.3s ease;
  }

  ion-tab-button.ion-selected ion-label {
    color: #007aff;
    font-weight: 600;
  }
</style>
