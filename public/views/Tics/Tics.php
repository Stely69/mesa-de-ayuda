<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $casos = new CasoController();
    $listadecasos = $casos->getCasos();
    // var_dump($listadecasos);
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Casos - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!--Colores personalizados-->
    <script>
        tailwind.config = {
        theme: {
            extend: {
            colors: {
                senaGreen: '#39A900',
                senaGreenDark: '#2f8800',
            }
            }
        }
        }
    </script>
</head>
<body class="bg-gray-100">
    <!-- Botón hamburguesa -->
    <div class="md:hidden p-4 bg-senaGreen text-white flex justify-between items-center">
        <span class="font-bold text-lg">Admin SENA</span>
        <button id="menuButton" class="focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-senaGreen text-white w-64 p-6 space-y-4 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40 md:relative md:block">
            <div class="flex justify-end md:hidden -mt-4 -mr-4">
                <button id="closeSidebar" class="text-white p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <h1 class="text-2xl font-bold mb-6">Admin SENA</h1>
            <nav class="flex flex-col space-y-3">
                <a href="../" class="p-2 hover:bg-white hover:text-senaGreen rounded">Inicio</a>
                <a href="instructores" class="p-2 hover:bg-white hover:text-senaGreen rounded">Instructores</a>
                <a href="pendientes" class="p-2 hover:bg-white hover:text-senaGreen rounded">Casos</a>
                <hr class="border-white opacity-30">
                <?php if (isset($_SESSION["id"])): ?>
                    <a href="../Perfi/perfil" class="p-2 hover:bg-white hover:text-senaGreen rounded">Bienvenido, <?php echo $_SESSION["nombres"]; ?></a>
                <?php endif; ?>
                <a href="../Login/LogoutAction" class="p-2 hover:bg-white hover:text-senaGreen rounded">Cerrar Sesión</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 md:ml-15 overflow-auto">
            <h2 class="text-2xl md:text-3xl font-semibold text-[#39A900] mb-6">Panel de Casos</h2>

            <!-- Listado de Casos -->
            <div class="bg-white p-4 md:p-8 rounded-2xl shadow-md border border-gray-200 mb-10 overflow-x-auto">
                <h3 class="text-xl md:text-2xl font-bold text-[#39A900] mb-6">Listado de Casos</h3>
                <table class="min-w-full border border-gray-300 text-sm md:text-base">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-5 text-left">Equipo</th>
                            <th class="py-3 px-5 text-left">Ubicación</th>
                            <th class="py-3 px-5 text-left">Descripción</th>
                            <th class="py-3 px-5 text-left">Estado</th>
                            <th class="py-3 px-5 text-center">Fecha</th>
                            <th class="py-3 px-5 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php    
                            if (!is_array($listadecasos) || empty($listadecasos)) {
                                echo "<tr><td colspan='6' class='text-center py-4'>No hay casos registrados</td></tr>";
                            } else {
                                foreach ($listadecasos as $caso) {
                                    echo "<tr class='border-t'>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso['producto_id']) . "</td>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso['ambiente_id']) . "</td>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso['descripcion']) . "</td>";
                                    if ($caso["estado_id"] == "1") {
                                        echo "<td class='text-[#39A900] py-2 px-4'>Pendiente</td>";
                                    } else {
                                        echo "<td class='text-red-600 py-2 px-4'>Resuelto</td>";
                                    }
                                    echo "<td class='py-2 px-4 text-center'>" . htmlspecialchars($caso["fecha_creacion"]) . "</td>";
                                    echo "<td class='py-2 px-4 text-center'>";
                                    echo "<a href=\"ver_caso?id=" . htmlspecialchars($caso['id']) . "\" class=\"px-4 py-2 bg-[#39A900] text-white rounded-xl font-bold shadow hover:bg-green-600 transition-all\">Ver</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Buscar por Ambiente -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition-all mt-10">
                <h3 class="text-xl font-bold text-[#39A900] mb-4">Buscar por Ambiente</h3>
                <label for="ambiente" class="block text-gray-700 font-semibold mb-2">Selecciona un ambiente:</label>
                <select id="ambiente" class="p-3 border rounded-md w-full bg-gray-100">
                    <option value="">-- Seleccionar --</option>
                    <?php for ($i = 101; $i <= 110; $i++): ?>
                        <option value="<?= $i ?>">Ambiente <?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <div id="casosAmbiente" class="mt-4 hidden overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-md mt-4 text-sm md:text-base">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 border-b">Caso</th>
                                <th class="py-2 px-4 border-b">Ubicación</th>
                                <th class="py-2 px-4 border-b">Estado</th>
                                <th class="py-2 px-4 border-b">Fecha recibido</th>
                                <th class="py-2 px-4 border-b">Fecha resuelto</th>
                            </tr>
                        </thead>
                        <tbody id="listaCasosAmbiente"></tbody>
                    </table>
                </div>
                <div id="sinCasos" class="text-gray-500 mt-4 hidden">Sin casos para este ambiente.</div>
            </div>
        </main>
    </div>

    <!-- Modal procedimiento -->
    <div id="modalProcedimiento" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md">
            <h3 class="text-xl font-bold text-[#39A900] mb-4">Detalles de la Falla</h3>
            <p id="procedimientoTexto" class="text-gray-700"></p>
            <button onclick="cerrarProcedimiento()" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-xl font-bold hover:bg-gray-700">Cerrar</button>
        </div>
    </div>

    <script>
        function mostrarProcedimiento(texto) {
            document.getElementById('procedimientoTexto').innerText = texto;
            document.getElementById('modalProcedimiento').classList.remove('hidden');
        }

        function cerrarProcedimiento() {
            document.getElementById('modalProcedimiento').classList.add('hidden');
        }

        // Sidebar control
        const sidebar = document.getElementById('sidebar');
        const closeSidebarButton = document.getElementById('closeSidebar');
        const menuButton = document.getElementById('menuButton');

        closeSidebarButton.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });

        menuButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>
