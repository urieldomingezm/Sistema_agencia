<?php
require_once(VER_PERFIL_PATCH . 'mostrar_todo.php');
$userProfileData = new UserProfileData();

$personalData = $userProfileData->getPersonalData();
$membresiaData = $userProfileData->getMembresiaData();
$ascensoData = $userProfileData->getAscensoData();
$tiempoData = $userProfileData->getTiempoData();
$requisitosData = $userProfileData->getRequisitosData();
$pagasData = $userProfileData->getPagasData();

$ultimaPagaUsuario = !empty($pagasData) ? $pagasData[0] : null;
$siguienteAscenso = $ascensoData['fecha_disponible_ascenso'] ?? 'No disponible';
$descripcionTiempo = $ascensoData['fecha_disponible_ascenso'] === '00:00:00' ? 
    'Ya puedes solicitar tu ascenso' : 'Faltan ' . formatEstimatedTime($siguienteAscenso);
?>

<div class="min-h-screen bg-gradient-to-b from-blue-100 via-blue-50 to-white dark:from-gray-800 dark:via-gray-700 dark:to-gray-900 p-4 md:p-8 flex flex-col justify-center antialiased font-sans">
  <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden border border-blue-200 dark:border-gray-700">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-center relative">
      <div class="w-28 h-28 md:w-32 md:h-32 mx-auto rounded-full border-4 border-white overflow-hidden shadow-lg bg-gradient-to-tr from-blue-300 via-indigo-400 to-blue-500">
        <img src="https://i.pravatar.cc/300?u=<?= htmlspecialchars($personalData['nombre_habbo'] ?? '') ?>" 
             alt="Foto de perfil" class="w-full h-full object-cover" />
      </div>
      <h1 class="mt-4 text-3xl font-bold text-white drop-shadow-sm tracking-wide">
        <?= htmlspecialchars($personalData['nombre_habbo'] ?? '') ?>
      </h1>
      <span class="inline-flex items-center mt-2 bg-white text-blue-600 px-3 py-1 rounded-full text-sm font-medium shadow-md">
        <i data-lucide="activity" class="w-4 h-4 mr-1 text-blue-600"></i> Activo
      </span>
    </header>

    <!-- Información General -->
    <section class="p-6 space-y-6">
      <h2 class="flex items-center text-xl font-semibold text-blue-600 border-b border-blue-200 pb-2 mb-4">
        <i data-lucide="info" class="w-5 h-5 mr-2 text-blue-500"></i> Información General
      </h2>
      <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800 text-base">
        <div><p class="text-sm text-blue-500">ID</p><p class="font-medium"><?= htmlspecialchars($personalData['id'] ?? 'N/A') ?></p></div>
        <div><p class="text-sm text-blue-500">Usuario</p><p class="font-medium"><?= htmlspecialchars($personalData['nombre_habbo'] ?? 'N/A') ?></p></div>
        <div><p class="text-sm text-blue-500">Código</p><p class="font-medium"><?= htmlspecialchars($personalData['codigo_time'] ?? 'N/A') ?></p></div>
        <div><p class="text-sm text-blue-500">Rango</p><p class="font-medium"><?= htmlspecialchars($ascensoData['rango_actual'] ?? 'N/A') ?></p></div>
        <div><p class="text-sm text-blue-500">Membresía</p>
          <p class="font-medium">
            <?= isset($membresiaData['venta_titulo']) ? 
              htmlspecialchars("{$membresiaData['venta_titulo']} - {$membresiaData['venta_estado']}") : 
              'Sin membresía' ?>
          </p>
        </div>
      </div>
    </section>

    <!-- Estado Requisitos -->
    <section class="p-6 bg-blue-50 border-t border-blue-200 space-y-4">
      <h2 class="flex items-center text-xl font-semibold text-blue-700 border-b border-blue-300 pb-2 mb-4">
        <i data-lucide="check-circle" class="w-5 h-5 mr-2 text-green-500"></i> Estado Requisitos
      </h2>
      <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800 text-base">
        <div><p class="text-sm text-blue-500">Estado Requisitos</p>
          <p class="font-semibold <?= !empty($requisitosData) && $requisitosData[0]['is_completed'] ? 'text-green-600' : 'text-yellow-600' ?>">
            <?= !empty($requisitosData) ? ($requisitosData[0]['is_completed'] ? 'Completado' : 'Pendiente') : 'Sin requisitos' ?>
          </p>
        </div>
        <div><p class="text-sm text-blue-500">Último Pago</p>
          <p class="font-medium">
            <?= !empty($pagasData) ? 
              "Recibió {$pagasData[0]['pagas_recibio']}c - {$pagasData[0]['pagas_motivo']}" : 
              'Sin pagos previos' ?>
          </p>
        </div>
        <div><p class="text-sm text-blue-500">Próximo Pago</p>
          <p class="text-yellow-600 font-semibold">
            <?= !empty($requisitosData) && $requisitosData[0]['is_completed'] ? 
              'Pendiente de recibir pago' : 'Complete los requisitos' ?>
          </p>
        </div>
      </div>
    </section>

    <!-- Tiempo -->
    <section class="p-6 space-y-4">
      <h2 class="flex items-center text-xl font-semibold text-blue-700 border-b border-blue-200 pb-2 mb-4">
        <i data-lucide="clock" class="w-5 h-5 mr-2 text-indigo-500"></i> Tiempo
      </h2>
      <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800 text-base">
        <div><p class="text-sm text-blue-500">Total Acumulado</p><p class="font-medium"><?= $tiempoData['tiempo_acumulado'] ?? '00:00:00' ?></p></div>
        <div><p class="text-sm text-blue-500">Tiempo Restado</p><p class="font-medium"><?= $tiempoData['tiempo_restado'] ?? '00:00:00' ?></p></div>
        <div><p class="text-sm text-blue-500">Encargado</p>
          <p class="italic <?= $tiempoData['tiempo_encargado_usuario'] ? 'text-gray-800' : 'text-gray-600' ?>">
            <?= $tiempoData['tiempo_encargado_usuario'] ?? 'Sin asignar' ?>
          </p>
        </div>
        <div><p class="text-sm text-blue-500">Estado</p>
          <p class="font-semibold <?= getStatusColorClass($tiempoData['tiempo_status'] ?? 'inactivo') ?>">
            <?= ucfirst($tiempoData['tiempo_status'] ?? 'inactivo') ?>
          </p>
        </div>
      </div>
    </section>

    <!-- Ascenso -->
    <section class="p-6 bg-blue-50 border-t border-blue-200 space-y-4">
      <h2 class="flex items-center text-xl font-semibold text-blue-700 border-b border-blue-300 pb-2 mb-4">
        <i data-lucide="trending-up" class="w-5 h-5 mr-2 text-indigo-500"></i> Ascenso
      </h2>
      <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-gray-800 text-base">
        <div><p class="text-sm text-blue-500">Misión Actual</p><p class="font-medium"><?= $ascensoData['mision_actual'] ?? 'Sin misión' ?></p></div>
        <div><p class="text-sm text-blue-500">Próximo Ascenso</p>
          <p class="font-semibold <?= $siguienteAscenso === 'Disponible ahora' ? 'text-green-600' : 'text-blue-600' ?>">
            <?= $siguienteAscenso ?>
          </p>
        </div>
        <div class="col-span-2 text-gray-700">
          <p class="text-sm font-medium"><?= $descripcionTiempo ?></p>
        </div>
      </div>
    </section>

  </div>
</div>

<?php
function getStatusColorClass($status) {
    switch (strtolower($status)) {
        case 'pausa':
        case 'inactivo': return 'text-yellow-600';
        case 'activo': return 'text-green-600';
        case 'completado': return 'text-green-600';
        default: return 'text-gray-600';
    }
}

function formatEstimatedTime($time) {
    if (empty($time)) return 'No disponible';
    
    try {
        $parts = explode(':', $time);
        $output = [];
        
        if ($parts[0] > 0) $output[] = $parts[0] . ' hora' . ($parts[0] > 1 ? 's' : '');
        if ($parts[1] > 0) $output[] = $parts[1] . ' minuto' . ($parts[1] > 1 ? 's' : '');
        if ($parts[2] > 0) $output[] = $parts[2] . ' segundo' . ($parts[2] > 1 ? 's' : '');
        
        return empty($output) ? '0 minutos' : implode(', ', $output);
    } catch (Exception $e) {
        return 'Formato de fecha inválido';
    }
}
?>
