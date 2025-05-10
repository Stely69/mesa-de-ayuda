<?php
$base_path = 'almacen';
require_once __DIR__ . '/../../../Controller/ProductoController.php';
require_once __DIR__ . '/../../../Controller/CasoController.php';
session_start();

// Instanciar controladores
$productoController = new ProductoController();
$casoController = new CasoController();

// Contador: Elementos en Inventario
$totalInventario = $productoController->mostrarProductos();

// Contador: Casos Pendientes (estado_id = 1)
$casos = $casoController->getCasos();
$casosPendientes = 0;
$casosRevision = 0;
$casosReposiciones = 0;
$ultimosCasos = [];
foreach ($casos as $caso) {
    // Ajusta los nombres de estado según tu base de datos
    if (isset($caso['estados_casos'])) {
        if (strtolower($caso['estados_casos']) === 'pendiente' || strtolower($caso['estados_casos']) === 'nuevo') {
            $casosPendientes++;
        } elseif (strtolower($caso['estados_casos']) === 'en revisión' || strtolower($caso['estados_casos']) === 'en revision') {
            $casosRevision++;
        } elseif (strtolower($caso['estados_casos']) === 'resuelto' || strtolower($caso['estados_casos']) === 'reposición' || strtolower($caso['estados_casos']) === 'repuesto') {
            $casosReposiciones++;
        }
    }
}
// Obtener los últimos 3 casos por fecha de creación descendente
usort($casos, function($a, $b) {
    return strtotime($b['fecha_creacion']) - strtotime($a['fecha_creacion']);
});
$ultimosCasos = array_slice($casos, 0, 3);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Operaciones - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in-right {
            animation: slideInRight 0.4s ease-out;
        }
        @keyframes pulseButton {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .animate-pulse-button {
            animation: pulseButton 1.2s infinite;
        }
        @keyframes fadeInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100">
<div class="flex flex-col md:flex-row">
    <?php include __DIR__ . '/barra.php'; ?>

    <main class="flex-1 p-6 md:ml-64 mt-16 md:mt-0 overflow-auto">
        <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
            <div>
                <h2 class="text-3xl font-semibold text-[#39A900]">¡Bienvenido, Almacén!</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

            <!-- Elementos en Inventario -->
            <div class="bg-white p-4 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-[#007832] animate-fade-in-up">
                <div class="flex items-center gap-4">
                    <div class="bg-[#007832] p-2 rounded-full text-white flex items-center justify-center">📦</div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-gray-700 text-sm font-semibold">Bienes Inventario</h3>
                        <p class="text-2xl font-bold text-[#007832] mt-1"><?php echo $totalInventario; ?></p>
                    </div>
                </div>
            </div>

            <!-- Casos Pendientes -->
            <div class="bg-white p-4 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-yellow-500 animate-fade-in-up delay-100">
                <div class="flex items-center gap-4">
                    <div class="bg-yellow-500 p-2 rounded-full text-white flex items-center justify-center">⏳</div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-gray-700 text-sm font-semibold">Casos Pendientes</h3>
                        <p class="text-2xl font-bold text-yellow-500 mt-1"><?php echo $casosPendientes; ?></p>
                    </div>
                </div>
            </div>

            <!-- Elementos en Revisión -->
            <div class="bg-white p-4 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-orange-400 animate-fade-in-up delay-200">
                <div class="flex items-center gap-4">
                    <div class="bg-orange-400 p-2 rounded-full text-white flex items-center justify-center">🔍</div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-gray-700 text-sm font-semibold">Elementos en Revisión</h3>
                        <p class="text-2xl font-bold text-orange-400 mt-1"><?php echo $casosRevision; ?></p>
                    </div>
                </div>
            </div>

            <!-- Reposiciones Realizadas -->
            <div class="bg-white p-4 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-blue-500 animate-fade-in-up delay-300">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-500 p-2 rounded-full text-white flex items-center justify-center">✅</div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-gray-700 text-sm font-semibold">Reposiciones Realizadas</h3>
                        <p class="text-2xl font-bold text-blue-500 mt-1"><?php echo $casosReposiciones; ?></p>
                    </div>
                </div>
            </div>


</div>



<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8"> 
    <!-- Inventario (Caja) -->
    <a href="inventario" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-center text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12V7a2 2 0 00-2-2H6a2 2 0 00-2 2v5m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4" />
        </svg>
        Cambio en el inventario
    </a>

    <!-- Historial (Reloj) -->
    <a href="historial" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-center text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Consultar Historial
    </a>

    <!-- Casos (Panel/Tablero) -->
    <a href="casos" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-center text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M10 14h10M10 18h10" />
        </svg>
        Panel de Casos
    </a>
</div>





        <div class="bg-white p-6 shadow rounded-md">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Reemplazos Recientes</h3>
            <div class="grid gap-4">
            <?php 
            $reemplazos = array_filter($casos, function($caso) {
                return isset($caso['estados_casos']) && (strtolower($caso['estados_casos']) === 'resuelto' || strtolower($caso['estados_casos']) === 'reposición' || strtolower($caso['estados_casos']) === 'repuesto');
            });
            usort($reemplazos, function($a, $b) {
                return strtotime($b['fecha_creacion']) - strtotime($a['fecha_creacion']);
            });
            $reemplazos = array_slice($reemplazos, 0, 3);
            ?>
            <?php foreach ($reemplazos as $caso): ?>
                <div class="flex items-center bg-gray-100 p-4 rounded-lg shadow hover:bg-[#f3eaff] transition animate-fade-in-up">
                    <div class="w-12 h-12 bg-[#71277A] text-white flex items-center justify-center rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm2 2h12v12H6V6z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">
                            <?php echo htmlspecialchars($caso['descripcion']); ?> en <?php echo htmlspecialchars($caso['ambiente']); ?>
                        </p>
                        <p class="text-sm text-gray-500">
                            <?php echo date('d/m/Y', strtotime($caso['fecha_creacion'])); ?> - por <?php echo isset($caso['instructor']) ? htmlspecialchars($caso['instructor']) : 'No asignado'; ?>
                        </p>
                        <?php if (!empty($caso['imagen'])): ?>
                            <a href="/uploads/<?php echo htmlspecialchars($caso['imagen']); ?>" target="_blank">
                                <img src="/uploads/<?php echo htmlspecialchars($caso['imagen']); ?>" alt="Evidencia" style="max-width: 80px; max-height: 80px; cursor: pointer; border: 1px solid #ccc; border-radius: 4px; margin-top: 8px;" title="Haz clic para ver en grande">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (count($reemplazos) === 0): ?>
                <div class="text-gray-500">No hay reemplazos recientes.</div>
            <?php endif; ?>
            </div>
        </div>

        <div id="notifModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-xl w-[90%] md:w-[450px] animate-slide-in-right">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-2xl font-bold text-gray-800">Notificaciones</h3>
            <button onclick="closeNotif()" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <ul class="space-y-4 max-h-60 overflow-y-auto">
            <?php foreach ($ultimosCasos as $caso): ?>
                <li class="bg-gray-100 p-3 rounded-lg shadow-sm flex justify-between items-center">
                    <div>
                        <p class="text-gray-700 font-medium">Ambiente <?php echo htmlspecialchars($caso['ambiente']); ?>:</p>
                        <span class="text-gray-600 text-sm">
                            <?php echo htmlspecialchars($caso['descripcion']); ?> —
                            <span class="text-yellow-500 font-semibold"><?php echo htmlspecialchars($caso['estados_casos']); ?></span>
                        </span>
                    </div>
                    <button class="bg-[#00304D] text-white px-3 py-1 rounded hover:opacity-90 text-sm">Ir</button>
                </li>
            <?php endforeach; ?>
        </ul>
        <button onclick="closeNotif()" class="mt-6 bg-[#39A900] text-white px-4 py-2 rounded-lg hover:bg-green-700 w-full transition">Cerrar</button>
    </div>
</div>

    </main>
</div>


</body>
</html>
