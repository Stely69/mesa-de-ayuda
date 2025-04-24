<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Casos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="max-w-7xl mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6">Historial del Caso</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-200 text-left text-sm font-semibold uppercase text-gray-600">
                        <th class="py-3 px-4">Fecha</th>
                        <th class="py-3 px-4">Estado Anterior</th>
                        <th class="py-3 px-4">Estado Nuevo</th>
                        <th class="py-3 px-4">Observaciones</th>
                        <th class="py-3 px-4">Actualizado por</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí iría el foreach de PHP para recorrer el historial -->
                    <?php foreach ($historial as $registro): ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4 text-sm"><?= $registro['fecha_actualizacion'] ?></td>
                        <td class="py-3 px-4 text-sm"><?= $registro['estado_anterior'] ?></td>
                        <td class="py-3 px-4 text-sm text-blue-600 font-semibold"><?= $registro['estado_nuevo'] ?></td>
                        <td class="py-3 px-4 text-sm text-gray-700"><?= $registro['observaciones'] ?></td>
                        <td class="py-3 px-4 text-sm">Usuario #<?= $registro['usuario_id'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="javascript:window.print()" class="inline-block px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Imprimir</a>
        </div>
    </div>
</body>
</html>
