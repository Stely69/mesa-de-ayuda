<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $casoController = new CasoController();
    $ambientes = $casoController->getAmbientes();
    $roles = $casoController->allRoles();
    session_start();
    //if (!isset($_SESSION['id'])) {
       // echo "Error: No hay usuario en la sesión.";
      //  exit;
    // }
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

    <main class="flex-1 p-6 md:ml-64 overflow-auto">
    <!-- Encabezado de bienvenida -->
    <div class="mb-6">
        <h2 class="text-3xl font-semibold text-[#39A900]">
            ¡Bienvenido, <?php echo $_SESSION["nombres"]; ?>!
        </h2>
    </div>

    <!-- Tarjetas resumen -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Casos Enviados -->
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-[#007832] animate-fade-in-up">
            <div class="flex items-center gap-4">
                <div class="bg-[#007832] p-3 rounded-full text-white">📤</div>
                <div>
                    <h3 class="text-gray-700 text-base font-semibold">Casos Enviados</h3>
                    <p class="text-3xl font-bold text-[#007832] mt-1">1,250</p>
                </div>
            </div>
        </div>

        <!-- Casos Pendientes -->
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-yellow-500 animate-fade-in-up delay-100">
            <div class="flex items-center gap-4">
                <div class="bg-yellow-500 p-3 rounded-full text-white">⏳</div>
                <div>
                    <h3 class="text-gray-700 text-base font-semibold">Casos Pendientes</h3>
                    <p class="text-3xl font-bold text-yellow-500 mt-1">5</p>
                </div>
            </div>
        </div>

        <!-- Casos Resueltos -->
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-orange-400 animate-fade-in-up delay-200">
            <div class="flex items-center gap-4">
                <div class="bg-orange-400 p-3 rounded-full text-white">✅</div>
                <div>
                    <h3 class="text-gray-700 text-base font-semibold">Casos Resueltos</h3>
                    <p class="text-3xl font-bold text-orange-400 mt-1">8</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="inventario" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-center text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1">
            📋 Registrar Caso General
        </a>
        <a href="RegistarCasoGeneral" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-center text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1">
            📝 Registrar Caso
        </a>
        <a href="reporte_pdf.php" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-center text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1">
            📑 Historial Casos
        </a>
    </div>

<!-- Animación personalizada opcional -->
<style>
@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in-up {
    animation: fade-in-up 0.5s ease-out both;
}
</style>


<div class="bg-white rounded-lg shadow p-4 mb-8">
    <h3 class="text-xl font-semibold text-[#00304D] mb-4">🔔 Últimas novedades de tus casos</h3>
    <?php if (!empty($novedades)): ?>
        <ul class="space-y-2">
            <?php foreach ($novedades as $novedad): ?>
                <li class="border-b pb-2">
                    <p class="text-sm text-gray-700">
                        <strong>Caso #<?= $novedad['id'] ?>:</strong> <?= htmlspecialchars($novedad['descripcion']) ?>
                    </p>
                    <p class="text-xs text-gray-500 flex justify-between">
                        <span>Estado: 
                            <?php
                                $estadoColor = match ($novedad['estado']) {
                                    'Pendiente' => 'text-yellow-500',
                                    'Resuelto' => 'text-green-600',
                                    'En proceso' => 'text-blue-600',
                                    default => 'text-gray-500'
                                };
                            ?>
                            <span class="<?= $estadoColor ?>"><?= $novedad['estado'] ?></span>
                        </span>
                        <span><?= date('d/m/Y', strtotime($novedad['fecha_reporte'])) ?></span>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-gray-500 text-sm">No hay novedades recientes.</p>
    <?php endif; ?>
</div>


    </main>
</div>

</body>
</html>
