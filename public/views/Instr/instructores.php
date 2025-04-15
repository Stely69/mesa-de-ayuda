<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $casoController = new CasoController();
    $ambientes = $casoController->getAmbientes();
    $roles = $casoController->allRoles();
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
                <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">📋 Reportar Caso</h2>

                <form id="formReporteFalla" method="POST" class="space-y-6" enctype="multipart/form-data">
                    <input type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">

                    <div class="lg:grid lg:grid-cols-2 gap-6">
                        <!-- Ambiente -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Ambiente</label>
                            <select id="selectAmbiente" name="ambiente_id" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($ambientes as $ambiente): ?>
                                    <option value="<?= $ambiente['id'] ?>"><?= $ambiente['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Producto -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Producto</label>
                            <select id="selectProducto" name="producto_id" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="">-- Seleccionar --</option>
                            </select>
                        </div>

                        <!-- Rol -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Selecciona Area </label>
                            <select name="rol" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?= $rol['id'] ?>"><?= $rol['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Estado oculto -->
                        <input type="hidden" name="estado" value="1">
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Descripción de la falla</label>
                        <textarea name="descripcion" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 resize-none" rows="4" placeholder="Describe la falla..."></textarea>
                    </div>

                    <div>
                        <label for="imagen" class="block font-semibold">Subir imagen del problema:</label>
                        <input type="file" name="imagen" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100"/>
                    </div>

                    <!-- Mensaje de éxito -->
                    <div id="mensajeExito" class="hidden text-green-600 font-medium"></div>

                    <!-- Botón -->
                    <div class="text-center">
                        <button type="submit" class="bg-[#39A900] hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow transition duration-300 ease-in-out">
                            Reportar Falla
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Cambiar productos al seleccionar ambiente
            $("#selectAmbiente").change(function () {
                let ambiente_id = $(this).val();
                $("#selectProducto").html('<option>Cargando...</option>');

                if (ambiente_id !== "") {
                    $.ajax({
                        url: "GetAmbienteAction",
                        type: "POST",
                        data: { ambiente_id },
                        dataType: "json",
                        success: function (response) {
                            let opciones = '<option value="">-- Seleccionar --</option>';
                            if (response.length > 0) {
                                response.forEach(producto => {
                                    opciones += `<option value="${producto.id}">${producto.clase_id} (Placa: ${producto.numero_placa})</option>`;
                                });
                            } else {
                                opciones = '<option>No hay productos disponibles</option>';
                            }
                            $("#selectProducto").html(opciones);
                        },
                        error: function () {
                            $("#selectProducto").html('<option>Error al cargar</option>');
                        }
                    });
                }
            });

            // Enviar formulario
            $("#formReporteFalla").submit(function (event) {
                event.preventDefault();

                $.ajax({
                    url: "ReportarFallaAction",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            $("#mensajeExito").removeClass("hidden").text("✅ Caso reportada con éxito.");
                            $("#formReporteFalla")[0].reset();
                        } else {
                            $("#mensajeExito").removeClass("hidden").text("❌ Error: " + response.message).addClass("text-red-600").removeClass("text-green-600");
                        }
                    },
                    error: function () {
                        $("#mensajeExito").removeClass("hidden").text("❌ Error al conectar con el servidor. ").addClass("text-red-600").removeClass("text-green-600");
                    }
                });
            });
        });

        function actualizarFechaHora() {
            const ahora = new Date();
            const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };
            document.getElementById('fechaHora').textContent = ahora.toLocaleDateString('es-ES', opciones);
        }
        setInterval(actualizarFechaHora, 1000);
        actualizarFechaHora();
    </script>
</body>
</html>
