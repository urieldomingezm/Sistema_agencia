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
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar negro -->
    <nav class="bg-black text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <span class="text-xl font-bold">Agencia Shein</span>
            </div>
            <div class="hidden md:flex space-x-6">
                <a href="#" class="hover:text-gray-300 transition">Inicio</a>
                <a href="#" class="hover:text-gray-300 transition">Perfil</a>
                <a href="#" class="hover:text-gray-300 transition">Configuración</a>
            </div>
            <button class="md:hidden focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Contenido principal con margen superior -->
    <main class="pt-4 pb-20">


