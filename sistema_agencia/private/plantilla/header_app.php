<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Agencia Shein APP'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html, body {
            height: 100%;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <header class="bg-blue-600 text-white p-4 shadow-md">
            <h1 class="text-xl font-bold">
                <?php echo isset($pageTitle) ? $pageTitle : 'Agencia Shein APP'; ?>
            </h1>
        </header>

        <!-- Aquí puedes agregar el contenido principal -->
        <main class="flex-1 p-4">
            <!-- Contenido -->
        </main>

        <footer class="bg-blue-600 text-white p-4 text-center">
            &copy; <?php echo date("Y"); ?> Agencia Shein APP
        </footer>
    </div>
</body>

</html>
