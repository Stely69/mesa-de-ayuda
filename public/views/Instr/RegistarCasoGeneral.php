<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $casoController = new CasoController();
    session_start();
    //if (!isset($_SESSION['id'])) {
        //echo "Error: No hay usuario en la sesión.";
        //exit;
   // }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Caso General - GEDAC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 overflow-x-hidden">
    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include __DIR__ . '/barra.php'; ?>

        <main class="flex-1 p-6 md:ml-64 min-h-screen bg-gradient-to-br from-white to-[#f9f9f9]">
            <div class="max-w-3xl mx-auto bg-white p-6 md:p-10 rounded-2xl shadow-xl border border-gray-200">
                <!-- Título -->
                <h2 class="text-3xl font-bold text-[#00304D] mb-10 text-center">📋 Reportar Caso General</h2>

                <form id="formCasoGeneral" action="CasoGeneralAction" method="POST" class="space-y-8">
                    <input type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
                    <input type="hidden" name="estado" value="1">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Ambiente -->
                        <div class="md:col-span-2">
                            <label class="block text-[#00304D] font-bold text-lg mb-4">Ambiente:</label>
                            <select name="ambiente_id" id="ambiente_id" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                                <option value="">Selecciona un ambiente</option>
                                <?php foreach ($casoController->getAmbientes() as $ambiente): ?>
                                    <option value="<?= $ambiente['id'] ?>"><?= $ambiente['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Asunto -->
                        <div class="md:col-span-2">
                            <label class="block text-[#00304D] font-bold text-lg mb-4">Asunto:</label>
                            <input type="text" name="asunto" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900]" placeholder="Escribe el asunto del caso...">
                        </div>

                        <!-- Descripción -->
                        <div class="md:col-span-2">
                            <label class="block text-[#00304D] font-bold text-lg mb-4">Descripción:</label>
                            <textarea name="descripcion" rows="4" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900] resize-none" placeholder="Escribe la descripción del caso..."></textarea>
                        </div>

                        <!-- Área Responsable -->
                        <div class="md:col-span-2">
                            <label class="block text-[#00304D] font-bold text-lg mb-4">Área Responsable:</label>
                            <select name="area_asignada" id="area_asignada" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                                <option value="">Selecciona un área</option>
                                <option value="3">Tics</option>
                            </select>
                        </div>
                    </div>

                    <!-- Alerta -->
                    <div id="alerta" class="hidden fixed top-4 right-4 p-4 rounded-lg shadow-lg max-w-sm z-50">
                        <div class="flex items-center justify-between">
                            <span id="mensajeAlerta" class="text-sm font-medium"></span>
                            <button onclick="cerrarAlerta()" class="ml-4 text-lg font-bold leading-none">&times;</button>
                        </div>
                    </div>

                    <!-- Botón -->
                    <div class="text-center mt-8">
                        <button type="submit" id="submitButton" class="bg-[#007832] hover:bg-[#00304D] text-white px-6 py-3 rounded-2xl shadow-md hover:shadow-xl text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1 w-full md:w-auto">
                            Reportar Caso
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            $("#formCasoGeneral").submit(function(e) {
                e.preventDefault();

                // Validar campos requeridos
                const ambiente = $("#ambiente_id").val();
                const asunto = $("[name='asunto']").val();
                const descripcion = $("[name='descripcion']").val();
                const area = $("#area_asignada").val();

                if (!ambiente || !asunto || !descripcion || !area) {
                    mostrarAlerta('error', 'Por favor complete todos los campos requeridos');
                    return;
                }

                // Cambiar el botón a estado de carga
                const submitButton = $("#submitButton");
                submitButton.prop('disabled', true);
                const originalText = submitButton.text();
                submitButton.html(`
                    <div class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Enviando...
                    </div>
                `);

                // Enviar el formulario
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            mostrarAlerta('success', response.message);
                            setTimeout(function() {
                                window.location.href = response.redirect + "?t=" + new Date().getTime();
                            }, 1500);
                        } else {
                            mostrarAlerta('error', response.message);
                            submitButton.prop('disabled', false);
                            submitButton.text(originalText);
                        }
                    },
                    error: function() {
                        mostrarAlerta('error', 'Error al enviar el caso. Por favor, intente nuevamente.');
                        submitButton.prop('disabled', false);
                        submitButton.text(originalText);
                    }
                });
            });
        });

        function mostrarAlerta(tipo, mensaje) {
            const alerta = document.getElementById('alerta');
            const mensajeAlerta = document.getElementById('mensajeAlerta');

            // Remover clases anteriores
            alerta.className = 'fixed top-4 right-4 p-4 rounded-lg shadow-lg max-w-sm z-50 flex items-center';

            if (tipo === 'success') {
                alerta.classList.add('bg-green-100', 'text-green-700', 'border', 'border-green-300');
            } else if (tipo === 'error') {
                alerta.classList.add('bg-red-100', 'text-red-700', 'border', 'border-red-300');
            }

            mensajeAlerta.textContent = mensaje;
            alerta.classList.remove('hidden');

            // Auto ocultar después de 5 segundos
            setTimeout(() => {
                alerta.classList.add('hidden');
            }, 5000);
        }

        function cerrarAlerta() {
            document.getElementById('alerta').classList.add('hidden');
        }

        // Mostrar alerta si viene por URL
        window.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const tipo = params.get('alert');
            const mensaje = params.get('mensaje');

            if (tipo && mensaje) {
                mostrarAlerta(tipo, decodeURIComponent(mensaje));
                // Limpia los parámetros de la URL sin recargar
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>
</body>
</html>
