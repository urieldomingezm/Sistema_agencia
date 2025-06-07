<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo isset($pageTitle) ? $pageTitle : 'Agencia Shein APP'; ?></title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://unpkg.com/@heroicons/vue@2.0.16/24/solid/index.js" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/lucide@latest/dist/lucide.css" rel="stylesheet" />

  <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>

  <style>
    html,
    body {
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
    <div class="flex items-center gap-4">
      <span class="text-xl font-bold">Agencia Shein APP</span>
    </div>
    <div class="flex items-center gap-4">
      <!-- Botón de modo oscuro (solo diseño, sin funcionalidad) -->
      <button class="flex items-center gap-2 bg-gray-800 hover:bg-gray-700 text-sm px-4 py-2 rounded-full transition select-none">
        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
          viewBox="0 0 24 24">
          <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.54 6.36l-.7-.7M6.16 6.16l-.7-.7m12.02 0l-.7.7M6.16 17.84l-.7.7" />
          <circle cx="12" cy="12" r="5" />
        </svg>
        <span>Modo Oscuro</span>
      </button>

      <!-- Botón Cambiar a escritorio -->
      <button class="flex items-center gap-2 bg-gray-800 hover:bg-gray-700 text-sm px-4 py-2 rounded-full transition select-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2"
          viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
          <path d="M16 3h-8v4h8V3z" />
        </svg>
        <span>escritorio</span>
      </button>
    </div>
  </div>
</nav>


  <!-- Contenido principal con margen superior -->
  <main class="pt-4 pb-20">