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
    <title>Registro de Novedad - GEDAC</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 overflow-x-hidden">
    <div class="flex flex-col lg:flex-row min-h-screen">
        <?php include __DIR__ . '/barra.php'; ?>

        <main class="flex-1 p-6 md:ml-64 min-h-screen bg-gradient-to-br from-white to-[#f9f9f9]">
            <div class="max-w-3xl mx-auto bg-white p-6 md:p-10 rounded-2xl shadow-xl border border-gray-200">
                <!-- Título -->
                <h2 class="text-3xl font-bold text-[#00304D] mb-10 text-center">📋 Reportar Caso general</h2>

                <form action="CasoGeneralAction" method="POST" class="space-y-8">
                    <input type="hidden" name="usuario_id" value="<?= $_SESSION['id'] ?>">
                    <input type="hidden" name="estado" value="1">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Ambiente -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Ambiente:</label>
                            <select name="ambiente_id" id="ambiente_id" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#007832]">
                                <option value="">Selecciona un ambiente</option>
                                <?php foreach ($casoController->getAmbientes() as $ambiente): ?>
                                    <option value="<?= $ambiente['id'] ?>"><?= $ambiente['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Asunto -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Asunto:</label>
                            <input type="text" name="asunto" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#007832]" placeholder="Escribe el asunto del caso...">
                        </div>

                        <!-- Descripción -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Descripción:</label>
                            <input type="text" name="descripcion" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#007832]" placeholder="Escribe la descripción del caso...">
                        </div>

                        <!-- Rol -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-semibold mb-2">Área Responsable:</label>
                            <select name="area_asignada" id="area_asignada" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#007832]">
                                <option value="">Selecciona un rol</option>
                                <option value="3">Tics</option>
                                <option value="4">Almacén</option>
                            </select>
                        </div>
                    </div>

                    <!-- Alerta -->
                    <div id="alerta" class="hidden text-green-600 font-medium">
                        <span id="mensajeAlerta"></span>
                        <button onclick="cerrarAlerta()" class="ml-4 font-bold text-lg leading-none focus:outline-none">&times;</button>
                    </div>

                    <!-- Botón -->
                    <div class="text-center mt-8">
                        <button type="submit" class="bg-[#007832] hover:bg-[#00304D] text-white px-6 py-3 rounded-2xl shadow-md hover:shadow-xl text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1">
                            Reportar Caso
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>



    <script>
        function mostrarAlerta(tipo, mensaje) {
            const alerta = document.getElementById('alerta');
            const mensajeAlerta = document.getElementById('mensajeAlerta');

            alerta.className = 'p-4 mb-4 rounded-lg text-sm flex items-center justify-between';

            if (tipo === 'success') {
                alerta.classList.add('bg-green-100', 'text-green-700', 'border', 'border-green-300');
            } else if (tipo === 'error') {
                alerta.classList.add('bg-red-100', 'text-red-700', 'border', 'border-red-300');
            }

            mensajeAlerta.textContent = mensaje;
            alerta.classList.remove('hidden');

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
