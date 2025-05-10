<?php
require_once __DIR__ . '../../../../Controller/CasoController.php';
$casoController = new CasoController();

// Obtener el ID del caso por GET
$casoId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$caso = null;
if ($casoId > 0) {
    $caso = $casoController->getCasoPorId($casoId); // Debes tener este método en tu controlador
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Caso - Almacén</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include __DIR__ . '/barra.php'; ?>
        <main class="flex-1 p-6 md:ml-64 min-h-screen bg-gradient-to-br from-white to-[#f9f9f9]">
            <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-md p-8 mt-8">
                <h1 class="text-3xl font-bold text-[#00304D] mb-6 flex items-center gap-2">
                    <i class="fas fa-box"></i> Detalle del Caso
                </h1>
                <?php if ($caso): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-gray-500 text-sm mb-1">ID</p>
                            <p class="font-semibold text-lg"><?= htmlspecialchars($caso['id']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Fecha de creación</p>
                            <p class="font-semibold text-lg"><?= htmlspecialchars($caso['fecha_creacion']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Ambiente</p>
                            <p class="font-semibold text-lg"><?= htmlspecialchars($caso['ambiente']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Producto</p>
                            <p class="font-semibold text-lg"><?= htmlspecialchars($caso['producto']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Estado</p>
                            <?php
                                $estado = $caso['estado'];
                                $color = 'text-gray-600';
                                if (strtolower($estado) === 'resuelto') $color = 'text-green-600';
                                elseif (strtolower($estado) === 'pendiente') $color = 'text-red-600';
                                elseif (strtolower($estado) === 'en proceso') $color = 'text-yellow-600';
                            ?>
                            <span class="font-semibold <?= $color ?>"><?= htmlspecialchars($estado) ?></span>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Descripción</p>
                            <p class="font-semibold text-lg"><?= htmlspecialchars($caso['descripcion']) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Usuario solicitante</p>
                            <p class="font-semibold text-lg"><?= htmlspecialchars($caso['usuario'] ?? 'No disponible') ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm mb-1">Imagen</p>
                            <?php if (!empty($caso['imagen'])): ?>
                                <a href="/uploads/<?= htmlspecialchars($caso['imagen']) ?>" target="_blank" class="inline-block mt-2">
                                    <img src="/uploads/<?= htmlspecialchars($caso['imagen']) ?>" alt="Imagen del caso" class="w-40 h-40 object-contain rounded-lg border">
                                </a>
                            <?php else: ?>
                                <span class="text-gray-400">Sin imagen</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center text-red-600 font-semibold py-8">
                        No se encontró el caso solicitado.
                    </div>
                <?php endif; ?>
                <div class="mt-8">
                    <a href="Ver_Casos_Almn?id=<?= $caso['id'] ?>" class="inline-block bg-[#00304D] hover:bg-[#39A900] text-white px-6 py-2 rounded shadow transition-colors duration-200"><i class="fas fa-arrow-left mr-2"></i>Volver a reportes</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
