<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo isset($pageTitle) ? $pageTitle : 'Agencia Shein APP'; ?></title>

  <script src="https://cdn.tailwindcss.com"></script>

  <script src="https://unpkg.com/@heroicons/vue@2.0.16/24/solid/index.js" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/lucide@latest/dist/lucide.css" rel="stylesheet" />

  <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>

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
        </div>
    </nav>

    <!-- Contenido principal con margen superior -->
    <main class="pt-4 pb-20">


