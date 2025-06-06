<ion-content>
    <ion-card>
        <ion-card-header>
            <ion-avatar>
                <img src="/assets/images/avatars/<?php echo $_SESSION['user_id']; ?>.jpg" alt="Avatar" 
                     onerror="this.src='/assets/images/avatars/default.jpg'">
            </ion-avatar>
            <ion-card-title><?php echo htmlspecialchars($_SESSION['username']); ?></ion-card-title>
            <ion-badge color="primary"><?php echo htmlspecialchars($controller->userRango); ?></ion-badge>
        </ion-card-header>
    </ion-card>
    
    <ion-list>
        <ion-item>
            <ion-icon name="mail" slot="start"></ion-icon>
            <ion-label>Correo Electrónico</ion-label>
            <ion-note slot="end"><?php echo htmlspecialchars($_SESSION['email'] ?? 'No disponible'); ?></ion-note>
        </ion-item>
        
        <ion-item>
            <ion-icon name="calendar" slot="start"></ion-icon>
            <ion-label>Fecha de Ingreso</ion-label>
            <ion-note slot="end">15/03/2023</ion-note>
        </ion-item>
        
        <ion-item>
            <ion-icon name="time" slot="start"></ion-icon>
            <ion-label>Tiempo Total</ion-label>
            <ion-note slot="end">245 horas</ion-note>
        </ion-item>
        
        <ion-item>
            <ion-icon name="trophy" slot="start"></ion-icon>
            <ion-label>Último Ascenso</ion-label>
            <ion-note slot="end">Hace 2 meses</ion-note>
        </ion-item>
    </ion-list>
    
    <ion-footer>
        <ion-toolbar>
            <ion-button expand="block" fill="outline" href="?page=configuracion">
                <ion-icon name="settings" slot="start"></ion-icon>
                Configuración
            </ion-button>
        </ion-toolbar>
    </ion-footer>
</ion-content>
