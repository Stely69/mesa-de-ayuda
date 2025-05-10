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

            <div id="mensaje-exito" style="display:none;" class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 text-center font-semibold"></div>

            <form id="formReporteFalla" method="POST" enctype="multipart/form-data" class="space-y-8">
                <input type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
                <input type="hidden" name="estado" value="1">

                <!-- Paso 1 -->
                <div id="paso1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Ambiente -->
                        <div>
                            <label class="block text-[#00304D] font-bold text-lg mb-4">Ambiente</label>
                            <select id="selectAmbiente" name="ambiente_id" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($ambientes as $ambiente): ?>
                                    <option value="<?= $ambiente['id'] ?>"><?= $ambiente['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Producto (ocupa toda la fila, diseño mejorado) -->
                        <div class="md:col-span-2">
                            <div class="rounded-2xl border border-gray-200 bg-[#F9F9F9] p-6 shadow-sm">
                                <label class="block text-[#00304D] font-bold text-lg mb-4">Producto</label>
                                <input type="text" id="buscarProducto" placeholder="Buscar por número de placa..." 
                                    class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900] mb-4 bg-white text-[#00304D] placeholder-gray-400">
                                <div class="rounded-xl overflow-x-auto w-full">
                                    <table class="w-full divide-y divide-gray-200">
                                        <thead class="bg-[#00304D]">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">Seleccionar</th>
                                                <th class="px-4 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">Placa</th>
                                                <th class="px-4 py-2 text-left text-xs font-semibold text-white uppercase tracking-wider">Clase</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaProductos" class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td colspan="3" class="px-4 py-2 text-center text-gray-500">
                                                    Seleccione un ambiente para ver los productos disponibles
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="hidden" id="producto_id" name="producto_id">
                                <div id="productoSeleccionado" class="mt-4 p-3 bg-[#E6F4EA] rounded-lg hidden flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#39A900]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                    <span class="text-sm text-[#00304D]">Producto seleccionado: </span>
                                    <span id="productoSeleccionadoInfo" class="text-sm font-semibold text-[#007832]"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Área Responsable -->
                        <div class="md:col-span-2">
                            <label class="block text-[#00304D] font-bold text-lg mb-4">Área Responsable</label>
                            <select name="rol" id="rol" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                                <option value="">-- Seleccionar --</option>
                                <option value="3">Area de Sistemas</option>
                                <option value="4">Area de Almacén</option>
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
        const producto = document.getElementById('producto_id').value;
        const rol = document.querySelector('[name="rol"]').value;

            if (ambiente && producto && rol) {
            document.getElementById('paso1').classList.add('hidden');
            document.getElementById('paso2').classList.remove('hidden');
            document.getElementById('step1Indicator').classList.remove('bg-[#39A900]', 'text-white');
            document.getElementById('step1Indicator').classList.add('bg-white', 'text-gray-500', 'border-gray-300');
            document.getElementById('step2Indicator').classList.remove('bg-white', 'text-gray-500');
            document.getElementById('step2Indicator').classList.add('bg-[#39A900]', 'text-white');
            } else {
                let mensaje = [];
                if (!ambiente) mensaje.push("Seleccione un ambiente");
                if (!producto) mensaje.push("Seleccione un producto");
                if (!rol) mensaje.push("Seleccione un área responsable");
                alert(mensaje.join("\n"));
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
            let productos = [];
            let timeout = null;

            // Función para cargar productos
            function cargarProductos(ambiente_id) {
                if (ambiente_id !== "") {
                    $.ajax({
                        url: "GetAmbienteAction",
                        type: "POST",
                        data: { ambiente_id },
                        dataType: "json",
                        success: function (response) {
                            productos = response;
                            mostrarProductos('');
                        },
                        error: function () {
                            $("#tablaProductos").html('<tr><td colspan="3" class="px-4 py-2 text-center text-red-500">Error al cargar productos</td></tr>');
                        }
                    });
                } else {
                    $("#tablaProductos").html('<tr><td colspan="3" class="px-4 py-2 text-center text-gray-500">Seleccione un ambiente para ver los productos disponibles</td></tr>');
                }
            }

            // Función para mostrar productos filtrados
            function mostrarProductos(busqueda) {
                const tabla = $("#tablaProductos");
                tabla.empty();
                
                const productosFiltrados = productos.filter(p => 
                    p.numero_placa.toLowerCase().includes(busqueda.toLowerCase())
                );

                if (productosFiltrados.length === 0) {
                    tabla.html('<tr><td colspan="3" class="px-4 py-2 text-center text-gray-500">No se encontraron productos</td></tr>');
                    return;
                }

                productosFiltrados.forEach((producto, idx) => {
                    const tr = $('<tr>').addClass('hover:bg-[#E6F4EA] cursor-pointer').css('background', idx % 2 === 0 ? '#fff' : '#F3F6F9');
                    tr.html(`
                        <td class="px-4 py-2">
                            <input type="radio" name="producto_radio" value="${producto.id}" 
                                   class="producto-radio h-4 w-4 text-[#39A900] focus:ring-[#39A900] border-gray-300">
                        </td>
                        <td class="px-4 py-2 text-sm text-[#00304D]">${producto.numero_placa}</td>
                        <td class="px-4 py-2 text-sm text-[#00304D]">${producto.clase_nombre}</td>
                    `);
                    tabla.append(tr);
                });
            }

            // Cambiar productos al seleccionar ambiente
            $("#selectAmbiente").change(function () {
                const ambiente_id = $(this).val();
                $("#buscarProducto").val('');
                $("#productoSeleccionado").addClass('hidden');
                $("#producto_id").val('');
                cargarProductos(ambiente_id);
            });

            // Búsqueda de productos
            $("#buscarProducto").on('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    const busqueda = $(this).val();
                    mostrarProductos(busqueda);
                }, 300);
            });

            // Selección de producto
            $(document).on('change', '.producto-radio', function() {
                const productoId = $(this).val();
                const producto = productos.find(p => p.id == productoId);
                if (producto) {
                    $("#producto_id").val(productoId);
                    $("#productoSeleccionadoInfo").text(`${producto.numero_placa} - ${producto.clase_nombre}`);
                    $("#productoSeleccionado").removeClass('hidden');
                        }
                    });

            // Cerrar resultados al hacer clic fuera
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#resultadosProductos').length && !$(e.target).is('#buscarProducto')) {
                    $("#resultadosProductos").addClass('hidden');
                }
            });

            // Enviar formulario
            $("#formReporteFalla").submit(function (event) {
                event.preventDefault();
                // Validar que los campos requeridos estén completos
                const ambiente = $("#selectAmbiente").val();
                const producto = $("#producto_id").val();
                const rol = $("#rol").val();
                const descripcion = $("[name='descripcion']").val();

                if (!ambiente || !producto || !rol || !descripcion) {
                    alert("Por favor complete todos los campos requeridos");
                    return;
                }

                // Crear un objeto FormData desde el formulario
                var formData = new FormData(this);
                formData.append('rol', rol); // Asegurar que el rol se envíe correctamente

                // Deshabilitar el botón de envío y mostrar indicador de carga
                const submitButton = $("button[type='submit']");
                submitButton.prop('disabled', true);
                submitButton.html(`
                    <div class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Enviando...
                    </div>
                `);

                // Enviar el formulario por AJAX con FormData
                $.ajax({
                    url: "ReportarFallaAction",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $("#mensaje-exito").text(response.message).show();
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 1500);
                        } else {
                            alert(response.message || "Error al enviar el caso");
                            submitButton.prop('disabled', false).text('Reportar Falla');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error al enviar el caso: " + (xhr.responseText ? xhr.responseText : error));
                        submitButton.prop('disabled', false).text('Reportar Falla');
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
