<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Agencia Shein APP'; ?></title>
    
    <!-- Ionic CDN -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css"/>
    
    <style>
        :root {
            --ion-color-primary: #000000;  /* Negro como color primario */
            --ion-color-primary-rgb: 0,0,0;
            --ion-color-primary-contrast: #ffffff; /* Texto blanco */
            --ion-color-primary-contrast-rgb: 255,255,255;
            --ion-color-primary-shade: #000000;
            --ion-color-primary-tint: #1a1a1a;
            
            --ion-background-color: #121212; /* Fondo oscuro */
            --ion-text-color: #ffffff; /* Texto blanco */
            --ion-item-background: #1e1e1e; /* Fondo de items oscuro */
        }
        
        ion-tab-bar {
            --background: var(--ion-color-primary);
            --color-selected: white;
            --color: rgba(255, 255, 255, 0.7);
            border-top: 1px solid #333; /* Borde superior para separar */
        }
        
        .custom-card {
            margin: 16px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            background: #1e1e1e; /* Fondo de tarjetas oscuro */
            color: white; /* Texto blanco en tarjetas */
        }
        
        .avatar-large {
            width: 80px;
            height: 80px;
            border: 2px solid #333;
        }
        
        .section-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 16px 16px 8px;
            color: #ffffff; /* Texto blanco */
        }
        
        ion-item {
            --background: #1e1e1e; /* Fondo oscuro para items */
            --color: #ffffff; /* Texto blanco */
            --border-color: #333; /* Borde más suave */
        }
        
        ion-list {
            background: transparent; /* Fondo transparente para listas */
        }
    </style>
</head>
<body>
    <ion-app>
        <ion-header>
            <ion-toolbar color="primary">
                <ion-title><?php echo isset($pageTitle) ? $pageTitle : 'Agencia Shein APP'; ?></ion-title>
                <ion-buttons slot="end">
                    <ion-button>
                        <ion-icon slot="icon-only" name="notifications" color="light"></ion-icon>
                    </ion-button>
                </ion-buttons>
            </ion-toolbar>
        </ion-header>