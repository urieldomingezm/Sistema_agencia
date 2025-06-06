<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Agencia Shein APP'; ?></title>

    <!-- Framework7 CSS -->
    <link rel="stylesheet" href="https://unpkg.com/framework7@6.3.14/framework7-bundle.min.css">

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- Estilos personalizados -->
    <style>
        :root {
            --ion-color-primary: #3880ff;
            --ion-color-secondary: #3dc2ff;
            --ion-background-color: #f8f9fa;
            --ion-toolbar-background: var(--ion-color-primary);
            --ion-toolbar-color: white;
        }

        .inner-scroll {
            padding-bottom: 60px;
        }

        .page-transition {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-loader {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .loader-content {
            text-align: center;
        }

        .loader-content ion-spinner {
            width: 48px;
            height: 48px;
            --color: var(--ion-color-primary);
        }

        .loader-content p {
            margin-top: 16px;
            color: var(--ion-color-primary);
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="navbar">
            <div class="navbar-inner">
                <div class="title"><?php echo isset($pageTitle) ? $pageTitle : 'Agencia Shein APP'; ?></div>
            </div>
        </div>
