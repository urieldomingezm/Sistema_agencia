<div class="app-page">
    <div class="profile-header">
        <ion-avatar class="profile-avatar">
            <img src="/assets/images/avatars/<?php echo $_SESSION['user_id']; ?>.jpg" alt="Avatar" 
                 onerror="this.src='/assets/images/avatars/default.jpg'">
        </ion-avatar>
        <h2 class="profile-name"><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <ion-badge color="primary"><?php echo htmlspecialchars($controller->userRango); ?></ion-badge>
    </div>
    
    <ion-list class="profile-details">
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
    
    <div class="profile-actions">
        <ion-button expand="block" fill="outline" href="?page=configuracion">
            <ion-icon name="settings" slot="start"></ion-icon>
            Configuración
        </ion-button>
    </div>
</div>

<style>
    .profile-header {
        text-align: center;
        padding: 20px 0;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
        margin: 0 auto 10px;
    }
    
    .profile-name {
        margin: 5px 0;
        font-size: 1.4rem;
    }
    
    .profile-details {
        margin-top: 20px;
        background: transparent;
    }
    
    .profile-details ion-item {
        --padding-start: 0;
        --inner-padding-end: 0;
        --background: transparent;
    }
    
    .profile-actions {
        margin-top: 30px;
        padding: 0 16px;
    }
</style>