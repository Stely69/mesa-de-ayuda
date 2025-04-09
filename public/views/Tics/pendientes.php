<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendientes - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <main class="flex-1 p-6 ml-64 overflow-auto">
        <h2 class="text-3xl font-semibold text-[#39A900] mb-4">Pendientes de Aulas</h2>    
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <div class="p-4 bg-white shadow rounded-md">
                    <h3 class="text-lg font-semibold text-gray-700">Pendiente <?php echo $i; ?></h3>
                    <p class="text-gray-600">Descripción del problema en Aula <?php echo rand(100, 110); ?></p>
                    <p class="text-gray-500 text-sm">Estado: <span class="font-semibold text-red-500">Sin resolver</span></p>
                    <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Ver Detalles</button>
                </div>
            <?php endfor; ?>
        </div>
    </main>
</body>
</html>
