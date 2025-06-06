<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación Móvil</title>
    
    <!-- Ionic CDN -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css"/>
    
    <style>
        ion-tab-bar {
            --background: #3880ff;
            --color-selected: white;
        }
    </style>
</head>
<body>
    <ion-app>
        <ion-tabs>
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
    </ion-app>
    
    <?php
    // Aquí puedes agregar lógica PHP si es necesario
    echo "<script>
        console.log('Aplicación cargada');
    </script>";
    ?>
</body>
</html>