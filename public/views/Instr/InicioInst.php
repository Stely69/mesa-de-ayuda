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

    // Obtener estadísticas del instructor
    $instructor_id = $_SESSION['id'];
    $casos_enviados = $casoController->contarCasosPorInstructor($instructor_id);
    $casos_pendientes = $casoController->contarCasosPendientesPorInstructor($instructor_id);
    $casos_resueltos = $casoController->contarCasosResueltosPorInstructor($instructor_id);
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
                    <p class="text-3xl font-bold text-[#007832] mt-1"><?php echo $casos_enviados; ?></p>
                </div>
            </div>
        </div>

        <!-- Casos Pendientes -->
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-yellow-500 animate-fade-in-up delay-100">
            <div class="flex items-center gap-4">
                <div class="bg-yellow-500 p-3 rounded-full text-white">⏳</div>
                <div>
                    <h3 class="text-gray-700 text-base font-semibold">Casos Pendientes</h3>
                    <p class="text-3xl font-bold text-yellow-500 mt-1"><?php echo $casos_pendientes; ?></p>
                </div>
            </div>
        </div>

        <!-- Casos Resueltos -->
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-orange-400 animate-fade-in-up delay-200">
            <div class="flex items-center gap-4">
                <div class="bg-orange-400 p-3 rounded-full text-white">✅</div>
                <div>
                    <h3 class="text-gray-700 text-base font-semibold">Casos Resueltos</h3>
                    <p class="text-3xl font-bold text-orange-400 mt-1"><?php echo $casos_resueltos; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de acción -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="instructores" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-center text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1">
            📋 Registrar Caso General
        </a>
        <a href="RegistarCasoGeneral" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-center text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1">
            📝 Registrar Caso
        </a>
        <a href="historialcasos" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-center text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1">
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
    <?php 
    $ultimosCasos = $casoController->obtenerUltimosCasosInstructor($_SESSION['id']);
    if (!empty($ultimosCasos)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Área</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($ultimosCasos as $caso): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php 
                                    if ($caso['tipo_caso'] === 'general') {
                                        echo '📋 [Caso General] ' . htmlspecialchars($caso['descripcion']);
                                    } else {
                                        echo '🔧 ' . htmlspecialchars($caso['descripcion']);
                                    }
                                ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo htmlspecialchars($caso['area_asignada']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $estadoColor = match ($caso['estado_actual']) {
                                        'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                        'En proceso' => 'bg-blue-100 text-blue-800',
                                        'Resuelto' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $estadoColor; ?>">
                                    <?php echo htmlspecialchars($caso['estado_actual']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo date('d/m/Y H:i', strtotime($caso['fecha_creacion'])); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-500 text-sm">No hay casos registrados recientemente.</p>
    <?php endif; ?>
</div>


    </main>
</div>

</body>
</html>
