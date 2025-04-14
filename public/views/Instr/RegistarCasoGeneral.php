<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $casoController = new CasoController();
    session_start();
    if (!isset($_SESSION['id'])) {
        echo "Error: No hay usuario en la sesión.";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Novedad - GEDAC</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col lg:flex-row h-full min-h-screen">
        <?php include __DIR__ . '/barra.php'; ?>

        <div class="flex-1 p-4 sm:p-10">
            <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                <div>
                    <h2 class="text-3xl font-semibold text-[#39A900]">¡Bienvenido, <?php echo $_SESSION["nombres"]; ?>!</h2>
                    <p class="text-gray-600" id="fechaHora"></p>
                </div>
            </div>
            <div class="max-w-3xl mx-auto bg-white p-6 sm:p-10 rounded-2xl shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">📋 Reportar Caso general</h2>

                <form id="CasoGeneralAction" method="POST" class="space-y-6" enctype="multipart/form-data">
                    <input type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">

                    <div class="lg:grid lg:grid-cols-1 gap-6">
                        <!-- Ambiente -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1 ">Asunto: </label>
                            <input type="text" name="asunto" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" placeholder="Escribe el asunto del caso...">
                        </div>

                        <!-- Producto -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Descripción: </label>
                            <input type="text" name="descripcion" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" placeholder="Escribe la descripción del caso...">
                        </div>

                        <!-- Rol -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Imagen:(Opcional)</label>
                            <input type="file" name="imagen" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100"/>
                        </div>

                        <!-- Estado oculto -->
                        <input type="hidden" name="estado" value="1">
                    </div>

                    <!-- Mensaje de éxito -->
                    <div id="mensajeExito" class="hidden text-green-600 font-medium"></div>

                    <!-- Botón -->
                    <div class="text-center">
                        <button type="submit" class="bg-[#39A900] hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow transition duration-300 ease-in-out">
                            Reportar Caso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
