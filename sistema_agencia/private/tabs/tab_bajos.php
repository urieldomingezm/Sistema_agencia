<ion-tabs>
    <!-- Tab de Inicio -->
    <ion-tab tab="inicio">
        <ion-router-outlet name="inicio"></ion-router-outlet>
    </ion-tab>

    <!-- Tab de Perfil -->
    <ion-tab tab="perfil">
        <ion-router-outlet name="perfil"></ion-router-outlet>
    </ion-tab>

    <!-- Tab de Configuración -->
    <ion-tab tab="config">
        <ion-router-outlet name="config"></ion-router-outlet>
    </ion-tab>

    <ion-tab-bar slot="bottom">
        <ion-tab-button tab="inicio">
            <ion-icon name="home"></ion-icon>
            <ion-label>Inicio</ion-label>
        </ion-tab-button>
        
        <ion-tab-button tab="perfil">
            <ion-icon name="person"></ion-icon>
            <ion-label>Perfil</ion-label>
        </ion-tab-button>
        
        <ion-tab-button tab="config">
            <ion-icon name="settings"></ion-icon>
            <ion-label>Configuración</ion-label>
        </ion-tab-button>
    </ion-tab-bar>
</ion-tabs>