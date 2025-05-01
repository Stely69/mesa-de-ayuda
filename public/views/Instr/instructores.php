<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $casoController = new CasoController();
    $ambientes = $casoController->getAmbientes();
    $roles = $casoController->allRoles();
    session_start();
    //if (!isset($_SESSION['id'])) {
       // echo "Error: No hay usuario en la sesión.";
       // exit;
    //}
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

    <main class="flex-1 p-6 md:ml-64 min-h-screen bg-gradient-to-br from-white to-[#f9f9f9]">
        <div class="max-w-3xl mx-auto bg-white p-6 md:p-10 rounded-2xl shadow-xl border border-gray-200">
            <h2 class="text-3xl font-bold text-[#00304D] mb-10 text-center">Reportar un Caso</h2>

            <!-- Indicador de pasos -->
            <div class="flex justify-center space-x-6 mb-12">
                <div id="step1Indicator" class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-[#39A900] bg-[#39A900] text-white font-semibold shadow transition">1</div>
                <div id="step2Indicator" class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-gray-300 bg-white text-gray-500 font-semibold shadow transition">2</div>
            </div>

            <form id="formReporteFalla" method="POST" enctype="multipart/form-data" class="space-y-8">
                <input type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
                <input type="hidden" name="estado" value="1">

                <!-- Paso 1 -->
                <div id="paso1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Ambiente -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Ambiente</label>
                            <select id="selectAmbiente" name="ambiente_id" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($ambientes as $ambiente): ?>
                                    <option value="<?= $ambiente['id'] ?>"><?= $ambiente['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Producto -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Producto</label>
                            <select id="selectProducto" name="producto_id" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                                <option value="">-- Seleccionar --</option>
                            </select>
                        </div>

                        <!-- Área Responsable -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Área Responsable</label>
                            <select name="rol" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                                <option value="">-- Seleccionar --</option>
                                <option value="3">Area de Sistemas</option>
                                <option value="4">Area de Almacen</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botón Siguiente -->
                    <div class="text-right mt-10">
                        <button type="button" id="btnSiguiente" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1">
                            Siguiente →
                        </button>
                    </div>
                </div>

                <!-- Paso 2 -->
                <div id="paso2" class="hidden">
                    <div class="space-y-6">
                        <!-- Descripción -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Descripción de la falla</label>
                            <textarea name="descripcion" rows="4" class="w-full p-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900] resize-none shadow-sm"></textarea>
                        </div>

                        <!-- Imagen -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Subir Imagen</label>
                            <input type="file" name="imagen" accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-semibold file:bg-[#E6F4EA] file:text-[#007832] hover:file:bg-[#C9E8D4] transition"/>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between mt-10">
                        <button type="button" id="btnVolver" class="bg-white hover:bg-[#00304D] text-[#00304D] py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 hover:text-white">
                            ← Volver
                        </button>
                        <button type="submit" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1">
                            Reportar Falla
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
         //formulario dos pasos 
        document.getElementById('btnSiguiente').addEventListener('click', () => {
        const ambiente = document.getElementById('selectAmbiente').value;
        const producto = document.getElementById('selectProducto').value;
        const rol = document.querySelector('[name="rol"]').value;

            if (ambiente && producto && rol) {
            document.getElementById('paso1').classList.add('hidden');
            document.getElementById('paso2').classList.remove('hidden');
            document.getElementById('step1Indicator').classList.remove('bg-[#39A900]', 'text-white');
            document.getElementById('step1Indicator').classList.add('bg-white', 'text-gray-500', 'border-gray-300');
            document.getElementById('step2Indicator').classList.remove('bg-white', 'text-gray-500');
            document.getElementById('step2Indicator').classList.add('bg-[#39A900]', 'text-white');
            } else {
            alert('Por favor completa todos los campos del paso 1.');
            }
        });

        document.getElementById('btnVolver').addEventListener('click', () => {
            document.getElementById('paso2').classList.add('hidden');
            document.getElementById('paso1').classList.remove('hidden');
            document.getElementById('step2Indicator').classList.remove('bg-[#39A900]', 'text-white');
            document.getElementById('step2Indicator').classList.add('bg-white', 'text-gray-500');
            document.getElementById('step1Indicator').classList.remove('bg-white', 'text-gray-500');
            document.getElementById('step1Indicator').classList.add('bg-[#39A900]', 'text-white');
        });

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

                // Crear un objeto FormData desde el formulario
                var formData = new FormData(this);

                $.ajax({
                    url: "ReportarFallaAction",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false, // ⛔ No procesar los datos (porque es FormData)
                    contentType: false, // ⛔ No establecer tipo de contenido (deja que el navegador lo haga)
                    success: function (response) {
                        if (response.success) {
                            $("#mensajeExito")
                                .removeClass("hidden text-red-600")
                                .addClass("text-green-600")
                                .text("✅ Caso reportado con éxito.");
                            $("#formReporteFalla")[0].reset();
                        } else {
                            $("#mensajeExito")
                                .removeClass("hidden text-green-600")
                                .addClass("text-red-600")
                                .text("❌ Error: " + response.message);
                        }
                    },
                    error: function () {
                        $("#mensajeExito")
                            .removeClass("hidden text-green-600")
                            .addClass("text-red-600")
                            .text("❌ Error al conectar con el servidor.");
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
