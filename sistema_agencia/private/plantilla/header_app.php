<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Agencia Shein APP'; ?></title>


    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css" />
    <style>
        ion-content {
            --overflow: auto;
            --offset-top: 56px;
            --offset-bottom: 56px;
        }

        html,
        body {
            height: 100%;
        }

        ion-app {
            min-height: 100%;
        }
    </style>
</head>

<body class="ion-padding" color="dark">
    <ion-app>

        <ion-header>
            <ion-toolbar color="dark">
                <ion-title><?php echo isset($pageTitle) ? $pageTitle : 'Agencia Shein APP'; ?></ion-title>
            </ion-toolbar>
        </ion-header>     