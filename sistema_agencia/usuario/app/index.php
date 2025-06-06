<?php
$pageTitle = "Agencia Shein APP";
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_APP_PATH . 'header_app.php');
?>


<ion-content fullscreen="true" scroll-y="true">
    <!-- Header con imagen de fondo -->
    <div class="ion-text-center ion-margin-bottom">
        <ion-avatar class="ion-margin-auto" style="width: 120px; height: 120px;">
          
        </ion-avatar>
        <ion-text color="primary">
            <h1 class="ion-no-margin">¡Bienvenido!</h1>
        </ion-text>
        <ion-text color="medium">
            <p>Gestiona tu negocio de manera eficiente</p>
        </ion-text>
    </div>

    <!-- Tarjeta de bienvenida con slider -->
    <ion-slides pager="true" [options]="{autoHeight: true}">
        <ion-slide>
            <ion-card>
                <ion-card-header>
                    <ion-card-title color="primary">Agencia Shein APP</ion-card-title>
                    <ion-card-subtitle>Tu herramienta de gestión</ion-card-subtitle>
                </ion-card-header>
                <ion-card-content>
                    <ion-text>
                        <p>Estamos encantados de tenerte aquí. Esta aplicación te ayudará a gestionar tus pedidos, clientes y actividades diarias.</p>
                    </ion-text>
                    <ion-button expand="block" color="primary" class="ion-margin-top">
                        <ion-icon slot="start" name="rocket-outline"></ion-icon>
                        Comenzar
                    </ion-button>
                </ion-card-content>
            </ion-card>
        </ion-slide>
        
        <ion-slide>
            <ion-card>
                <ion-card-header>
                    <ion-card-title color="secondary">Nuevas Funciones</ion-card-title>
                </ion-card-header>
                <ion-card-content>
                    <ion-list lines="none">
                        <ion-item>
                            <ion-icon slot="start" name="checkmark-circle" color="success"></ion-icon>
                            <ion-label>Reportes mejorados</ion-label>
                        </ion-item>
                        <ion-item>
                            <ion-icon slot="start" name="checkmark-circle" color="success"></ion-icon>
                            <ion-label>Sincronización en la nube</ion-label>
                        </ion-item>
                        <ion-item>
                            <ion-icon slot="start" name="checkmark-circle" color="success"></ion-icon>
                            <ion-label>Notificaciones push</ion-label>
                        </ion-item>
                    </ion-list>
                </ion-card-content>
            </ion-card>
        </ion-slide>
    </ion-slides>

    <!-- Sección de estadísticas rápidas -->
    <ion-grid class="ion-margin-top">
        <ion-row>
            <ion-col size="12">
                <ion-text color="medium">
                    <h2 class="ion-no-margin">Resumen</h2>
                </ion-text>
            </ion-col>
            
            <ion-col size="4" class="ion-text-center">
                <ion-chip color="primary" outline="true">
                    <ion-label>25</ion-label>
                </ion-chip>
                <ion-text>
                    <p class="ion-no-margin">Pedidos</p>
                </ion-text>
            </ion-col>
            
            <ion-col size="4" class="ion-text-center">
                <ion-chip color="secondary" outline="true">
                    <ion-label>12</ion-label>
                </ion-chip>
                <ion-text>
                    <p class="ion-no-margin">Clientes</p>
                </ion-text>
            </ion-col>
            
            <ion-col size="4" class="ion-text-center">
                <ion-chip color="tertiary" outline="true">
                    <ion-label>$8,450</ion-label>
                </ion-chip>
                <ion-text>
                    <p class="ion-no-margin">Ventas</p>
                </ion-text>
            </ion-col>
        </ion-row>
    </ion-grid>

    <!-- Sección de accesos rápidos mejorada -->
    <ion-grid class="ion-margin-top">
        <ion-row>
            <ion-col size="12">
                <ion-text color="medium">
                    <h2 class="ion-no-margin">Accesos rápidos</h2>
                </ion-text>
            </ion-col>
            
            <ion-col size="6" class="ion-text-center ion-padding">
                <ion-button expand="block" fill="clear" color="primary">
                    <ion-icon slot="icon-only" name="cart-outline" size="large"></ion-icon>
                    <ion-label class="ion-margin-top">Pedidos</ion-label>
                </ion-button>
            </ion-col>
            
            <ion-col size="6" class="ion-text-center ion-padding">
                <ion-button expand="block" fill="clear" color="secondary">
                    <ion-icon slot="icon-only" name="people-outline" size="large"></ion-icon>
                    <ion-label class="ion-margin-top">Clientes</ion-label>
                </ion-button>
            </ion-col>
            
            <ion-col size="6" class="ion-text-center ion-padding">
                <ion-button expand="block" fill="clear" color="tertiary">
                    <ion-icon slot="icon-only" name="stats-chart-outline" size="large"></ion-icon>
                    <ion-label class="ion-margin-top">Reportes</ion-label>
                </ion-button>
            </ion-col>
            
            <ion-col size="6" class="ion-text-center ion-padding">
                <ion-button expand="block" fill="clear" color="success">
                    <ion-icon slot="icon-only" name="settings-outline" size="large"></ion-icon>
                    <ion-label class="ion-margin-top">Ajustes</ion-label>
                </ion-button>
            </ion-col>
        </ion-row>
    </ion-grid>

    <!-- Notificaciones recientes -->
    <ion-list class="ion-margin-top" lines="none">
        <ion-list-header>
            <ion-label>Notificaciones recientes</ion-label>
        </ion-list-header>
        
        <ion-item>
            <ion-icon slot="start" name="notifications-outline" color="warning"></ion-icon>
            <ion-label>
                <h3>Pedido completado</h3>
                <p>El pedido #1254 ha sido entregado</p>
            </ion-label>
            <ion-note slot="end">Hoy</ion-note>
        </ion-item>
        
        <ion-item>
            <ion-icon slot="start" name="alert-circle-outline" color="danger"></ion-icon>
            <ion-label>
                <h3>Stock bajo</h3>
                <p>El producto ZX-45 está por agotarse</p>
            </ion-label>
            <ion-note slot="end">Ayer</ion-note>
        </ion-item>
        
        <ion-item>
            <ion-icon slot="start" name="checkmark-done-outline" color="success"></ion-icon>
            <ion-label>
                <h3>Pago recibido</h3>
                <p>Se ha registrado un pago de $1,250</p>
            </ion-label>
            <ion-note slot="end">2 días</ion-note>
        </ion-item>
    </ion-list>

    <!-- Banner promocional -->
    <ion-card class="ion-margin-top" color="primary">
        <ion-card-header>
            <ion-card-title class="ion-text-center" color="light">
                <ion-icon name="star-outline"></ion-icon> Pro Version
            </ion-card-title>
        </ion-card-header>
        <ion-card-content class="ion-text-center">
            <ion-text color="light">
                <p>Desbloquea todas las funciones premium</p>
            </ion-text>
            <ion-button color="light" fill="outline" size="small" class="ion-margin-top">
                Actualizar ahora
            </ion-button>
        </ion-card-content>
    </ion-card>
</ion-content>


<?php
require_once(TABS_APP_PATH . 'tab_bajos.php');
require_once(TEMPLATES_APP_PATH . 'footer_app.php');
?>
