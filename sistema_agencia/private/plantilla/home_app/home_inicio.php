<div class="ion-padding welcome-container">
    <!-- Encabezado con logo -->
    <div class="welcome-header ion-text-center ion-margin-bottom">
        <ion-text color="primary">
            <h1 class="ion-no-margin">¡Bienvenido!</h1>
        </ion-text>
    </div>

    <!-- Tarjeta de bienvenida -->
    <ion-card class="welcome-card">
        <ion-card-header>
            <ion-card-title color="primary">Agencia Shein APP</ion-card-title>
            <ion-card-subtitle>Tu herramienta de gestión</ion-card-subtitle>
        </ion-card-header>

        <ion-card-content>
            <ion-text>
                <p>Estamos encantados de tenerte aquí. Esta aplicación te ayudará a gestionar tus pedidos, clientes y actividades diarias de manera eficiente.</p>
            </ion-text>
            
            <ion-button expand="block" color="primary" class="ion-margin-top">
                <ion-icon slot="start" name="rocket-outline"></ion-icon>
                Comenzar
            </ion-button>
        </ion-card-content>
    </ion-card>

    <!-- Sección de accesos rápidos -->
    <div class="quick-actions ion-margin-top">
        <ion-text color="medium">
            <h2 class="ion-no-margin">Accesos rápidos</h2>
        </ion-text>

        <ion-grid class="ion-margin-top">
            <ion-row>
                <ion-col size="6">
                    <ion-button expand="block" fill="outline" color="secondary">
                        <ion-icon slot="start" name="cart-outline"></ion-icon>
                        Pedidos
                    </ion-button>
                </ion-col>
                <ion-col size="6">
                    <ion-button expand="block" fill="outline" color="tertiary">
                        <ion-icon slot="start" name="people-outline"></ion-icon>
                        Clientes
                    </ion-button>
                </ion-col>
            </ion-row>
            <ion-row>
                <ion-col size="6">
                    <ion-button expand="block" fill="outline" color="success">
                        <ion-icon slot="start" name="stats-chart-outline"></ion-icon>
                        Reportes
                    </ion-button>
                </ion-col>
                <ion-col size="6">
                    <ion-button expand="block" fill="outline" color="warning">
                        <ion-icon slot="start" name="settings-outline"></ion-icon>
                        Configuración
                    </ion-button>
                </ion-col>
            </ion-row>
        </ion-grid>
    </div>

    <!-- Mensaje de actualizaciones -->
    <div class="updates-section ion-margin-top ion-padding">
        <ion-item lines="none">
            <ion-icon slot="start" name="notifications-outline" color="primary"></ion-icon>
            <ion-label class="ion-text-wrap">
                <h3>Novedades en la versión 2.1</h3>
                <p>Hemos mejorado el rendimiento y añadido nuevas funciones.</p>
            </ion-label>
        </ion-item>
    </div>
</div>

<style>
    .welcome-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .welcome-card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .updates-section {
        background: var(--ion-color-light);
        border-radius: 12px;
    }
</style>