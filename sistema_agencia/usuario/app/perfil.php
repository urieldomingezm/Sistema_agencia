<div class="page-content">
    <!-- Avatar y bienvenida -->
    <div class="text-align-center padding">
        <div class="avatar" style="width: 120px; height: 120px; margin: 0 auto;">
            <img src="https://i.pravatar.cc/300" alt="Avatar de usuario">
        </div>
        <h1 class="no-margin">Usuario Ejemplo</h1>
        <span class="badge">Agente</span>
    </div>

    <!-- Datos del perfil -->
    <div class="list">
        <div class="item-content">
            <div class="item-inner">
                <div class="item-title">Correo Electrónico</div>
                <div class="item-after">usuario@ejemplo.com</div>
            </div>
        </div>
        
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
    </div>
</div>

<style>
/* Mantener los estilos personalizados pero adaptar selectores */
.page-content {
    background: #fefefe;
    font-family: 'Segoe UI', sans-serif;
}

.avatar {
    border: 4px solid #3b82f6;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 50%;
}
</style>
