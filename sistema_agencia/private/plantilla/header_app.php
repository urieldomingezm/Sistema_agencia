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
            --ion-color-primary: #000000;
            --ion-color-primary-rgb: 0,0,0;
            --ion-color-primary-contrast: #ffffff;
            --ion-color-primary-contrast-rgb: 255,255,255;
            --ion-color-primary-shade: #000000;
            --ion-color-primary-tint: #1a1a1a;
            
            --ion-color-secondary: #ffffff;
            --ion-color-secondary-rgb: 255,255,255;
            --ion-color-secondary-contrast: #000000;
            --ion-color-secondary-contrast-rgb: 0,0,0;
            --ion-color-secondary-shade: #e0e0e0;
            --ion-color-secondary-tint: #ffffff;
            
            --ion-background-color: #000000;
            --ion-text-color: #ffffff;
            --ion-item-background: #121212;
        }
        
        ion-tab-bar {
            --background: var(--ion-color-primary);
            --color-selected: white;
            --color: rgba(255, 255, 255, 0.7);
            border-top: 1px solid #333;
        }
        
        .custom-card {
            background: #121212;
            color: white;
            border: 1px solid #333;
        }
        
        ion-item {
            --background: #121212;
            --color: #ffffff;
            --border-color: #333;
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