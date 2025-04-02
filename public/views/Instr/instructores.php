<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $casoController = new CasoController();
    $ambientes = $casoController->getAmbientes();
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
    <title>Registro de Novedad</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Barra Lateral -->
        <div class="w-64 bg-[#39A900] text-white p-5 flex flex-col justify-between">
            <div>
                <h1 class="text-2xl font-bold">Operaciones</h1>
                <nav class="mt-4">
                    <ul>
                        <li class="mb-2"><a href="#" class="block py-2 px-4 bg-green-800 rounded">Inventario</a></li>
                        <li class="mb-2"><a href="#" class="block py-2 px-4">Historial</a></li>
                        <li class="mb-2"><a href="#" class="block py-2 px-4">Reportes</a></li>
                    </ul>
                </nav>
            </div>
            <button class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Cerrar Sesión</button>
        </div>
        
        <!-- Contenido Principal -->
        <div class="flex-1 p-10 relative">
            <!-- Botón Perfil -->
            <a href="perfil.php" class="absolute top-0 right-0 mt-4 mr-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Mi Perfil</a>
            
            <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Seleccionar un ambiente</h2>
                <form id="formReporteFalla" method="POST">
                    <input type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
                    
                    <!-- Selección de ambiente -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold">Selecciona un ambiente:</label>
                        <select id="selectAmbiente" name="ambiente_id" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Seleccionar --</option>
                            <?php foreach ($ambientes as $ambiente) { ?>
                                <option value="<?= $ambiente['id'] ?>"><?= $ambiente['nombre'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Selección de producto -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold">Selecciona un producto:</label>
                        <select id="selectProducto" name="producto_id" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Seleccionar --</option>
                        </select>
                    </div>

                    <!-- Selección de rol -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold">Selecciona tu rol:</label>
                        <select name="rol" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Seleccionar --</option>
                            <option value="3">Tics</option>
                            <option value="4">Almacen</option>
                        </select>
                    </div>

                    <!-- Descripción de la falla -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold">Descripción de la falla:</label>
                        <textarea name="descripcion" class="w-full p-2 border border-gray-300 rounded" rows="4" placeholder="Describe la falla..."></textarea>
                    </div>

                    <!-- Estado de la falla -->
                    <input type="hidden" name="estado" value="1">

                    <!-- Botón de envío -->
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Reportar Falla</button>
                </form>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function () {
                        // Cargar productos cuando se selecciona un ambiente
                        $("#selectAmbiente").change(function () {
                            var ambiente_id = $(this).val();
                            $("#selectProducto").html('<option value="">-- Seleccionar --</option>');

                            if (ambiente_id !== "") {
                                $.ajax({
                                    url: "GetAmbienteAction",
                                    type: "POST",
                                    data: { ambiente_id: ambiente_id },
                                    dataType: "json",
                                    success: function (response) {
                                        if (response.length > 0) {
                                            $.each(response, function (index, producto) {
                                                $("#selectProducto").append(
                                                    `<option value="${producto.id}">${producto.nombre} (Placa: ${producto.numero_placa})</option>`
                                                );
                                            });
                                        } else {
                                            $("#selectProducto").html('<option value="">No hay productos disponibles</option>');
                                        }
                                    },
                                    error: function () {
                                        alert("Error al obtener los productos.");
                                    }
                                });
                            }
                        });

                        // Enviar reporte de falla
                        $("#formReporteFalla").submit(function (event) {
                            event.preventDefault(); // Evita que la página se recargue

                            $.ajax({
                                url: "ReportarFallaAction",
                                type: "POST",
                                data: $(this).serialize(),
                                dataType: "json",
                                success: function (response) {
                                    if (response.success) {
                                        alert("Falla reportada con éxito.");
                                        $("#formReporteFalla")[0].reset(); // Limpia el formulario
                                    } else {
                                        alert("Error al reportar la falla: " + response.message);
                                    }
                                },
                                error: function () {
                                    alert("Error en la conexión con el servidor.");
                                }
                            });
                        });
                    });
                </script>

            </div>
        </div>
    </div>
</body>
</html>
