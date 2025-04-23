<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
    
    <!-- Barra lateral fija -->
    <?php include __DIR__ . '/barra.php'; ?>    

    <!-- Contenido principal -->
    <main class="flex-1 p-6 ml-64">
        <h2 class="text-3xl font-semibold text-[#39A900] mb-6 text-left">Agregar Producto</h2>

        <form action="AddAction" method="POST" class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow space-y-6">
            
            <div>
                <label for="ambiente" class="block text-sm font-medium text-gray-700 mb-1">Ambiente:</label>
                <select id="ambiente" name="ambiente" required class="mt-1 p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                    <option value="">Seleccione un ambiente</option>
                    <?php
                        require_once __DIR__ . '../../../../Controller/CasoController.php';
                        $controller = new CasoController();
                        //$ambientes = $controller->allambientes();
                        
                        foreach ($ambientes as $ambiente) {
                            echo "<option value='" . $ambiente['id'] . "'>" . $ambiente['nombre'] . "</option>";
                        }
                    ?>
                </select>
            </div>

            <div>
                <label for="numero_placa" class="block text-sm font-medium text-gray-700 mb-1">Número de Placa:</label>
                <input type="text" id="numero_placa" name="numero_placa" required class="mt-1 p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
            </div>

            <div>
                <label for="serial" class="block text-sm font-medium text-gray-700 mb-1">Serial:</label>
                <input type="text" id="serial" name="serial" required class="mt-1 p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required rows="3" class="mt-1 p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]"></textarea>
            </div>

            <div>
                <label for="modelo" class="block text-sm font-medium text-gray-700 mb-1">Modelo:</label>
                <input type="text" id="modelo" name="modelo" required class="mt-1 p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
            </div>

            <button type="submit" class="w-full bg-[#39A900] text-white py-3 rounded-md hover:bg-green-700 transition font-semibold shadow">Agregar Producto</button>
        </form>
    </main>

</body>
</html>
