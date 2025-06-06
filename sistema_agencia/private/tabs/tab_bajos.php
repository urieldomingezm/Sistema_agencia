<div class="tabs-container">
    <ion-tabs>
        <ion-tab-bar slot="bottom" class="tab-bar-custom">
            <!-- Inicio -->
            <ion-tab-button tab="inicio" href="?page=inicio">
                <ion-icon name="home"></ion-icon>
                <ion-label>Inicio</ion-label>
            </ion-tab-button>
            
            <!-- Perfil -->
            <ion-tab-button tab="perfil" href="?page=perfil">
                <ion-icon name="person"></ion-icon>
                <ion-label>Perfil</ion-label>
            </ion-tab-button>
            
            <!-- Notificaciones -->
            <ion-tab-button tab="notificaciones" href="?page=notificaciones">
                <ion-icon name="notifications"></ion-icon>
                <ion-label>Notificaciones</ion-label>
                <ion-badge color="danger">2</ion-badge>
            </ion-tab-button>
            
            <!-- Tiempos (solo para ciertos rangos) -->
            <?php if (in_array($controller->userRango, ['Logistica', 'Supervisor', 'Director'])): ?>
            <ion-tab-button tab="tiempos" href="?page=tiempos">
                <ion-icon name="time"></ion-icon>
                <ion-label>Tiempos</ion-label>
            </ion-tab-button>
            <?php endif; ?>
            
            <!-- Configuración -->
            <ion-tab-button tab="configuracion" href="?page=configuracion">
                <ion-icon name="settings"></ion-icon>
                <ion-label>Ajustes</ion-label>
            </ion-tab-button>
        </ion-tab-bar>
    </ion-tabs>
</div>

<style>
    .tabs-container {
        position: fixed;
        bottom: 0;
        width: 100%;
        z-index: 1000;
    }
    
    .tab-bar-custom {
        --background: var(--ion-color-primary);
        --color: var(--ion-color-primary-contrast);
        --color-selected: var(--ion-color-secondary);
    }
    
    ion-tab-button {
        --color-selected: #ffffff;
        --background-focused: var(--ion-color-secondary);
    }
    
    ion-tab-button.tab-selected {
        background: rgba(255, 255, 255, 0.1);
    }
    
    ion-icon {
        font-size: 24px;
    }
</style>