<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $casos = new CasoController();
    $listadecasos = $casos->getCasos();
    $listadecasosgenerales = $casos->getCasosGeneral();
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Casos - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Colores personalizados -->
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

    <div class="flex min-h-screen">
        <!-- Sidebar separado -->
        <?php include 'barra.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:ml-30 mt-16 md:mt-0 overflow-auto">
            <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                <div>
                    <h2 class="text-3xl font-semibold text-[#39A900]">¡Bienvenido, Area Tics!</h2>
                    <p class="text-gray-600" id="fechaHora"></p>
                </div>
                <div>
                    <button id="notifBtn" class="relative animate-pulse-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C8.67 6.165 8 7.388 8 8.75V14.16c0 .538-.214 1.055-.595 1.435L6 17h5m4 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span id="notifCount" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">3</span>
                    </button>
                </div>
            </div>

            <!-- Modal Notificaciones -->
            <div id="notifModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50 z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                    <h3 class="text-xl font-bold text-[#39A900] mb-4">Notificaciones Recientes</h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li>Se ha creado un nuevo caso para el ambiente 101.</li>
                        <li>Se ha resuelto un caso en el ambiente 104.</li>
                        <li>Nuevo reporte de fallos en el ambiente 107.</li>
                    </ul>
                    <button onclick="closeNotif()" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-xl font-bold hover:bg-gray-700">Cerrar</button>
                </div>
            </div>

            <!-- Listado de Casos -->
            <div class="bg-white p-4 md:p-8 rounded-2xl shadow-md border border-gray-200 mb-10 overflow-x-auto">
                <h3 class="text-xl md:text-2xl font-bold text-[#39A900] mb-6">Listado de Casos</h3>
                <table class="min-w-full border border-gray-300 text-sm md:text-base">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-5 text-left">Fecha</th>
                            <th class="py-3 px-5 text-left">Ambiente</th>
                            <th class="py-3 px-5 text-left">Asunto</th>
                            <th class="py-3 px-5 text-left">Rol</th>
                            <th class="py-3 px-5 text-center">Estado</th>
                            <th class="py-3 px-5 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php    
                            $itemsPerPage = 10; // Número de casos por página
                            $totalItems = count($listadecasos);
                            $totalPages = ceil($totalItems / $itemsPerPage);
                            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $currentPage = max(1, min($currentPage, $totalPages));
                            $startIndex = ($currentPage - 1) * $itemsPerPage;

                            $paginatedCasos = array_slice($listadecasos, $startIndex, $itemsPerPage);

                            if (empty($paginatedCasos)) {
                                echo "<tr><td colspan='6' class='text-center py-4'>No hay casos registrados</td></tr>";
                            } else {
                                foreach ($paginatedCasos as $caso) {
                                    echo "<tr class='border-t'>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso["fecha_creacion"]) ."</td>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso['ambiente']) . "</td>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso['descripcion']) . "</td>";
                                    echo "<td class='py-2 px-4'>". htmlspecialchars($caso["usuario"]) . "</td>";
                                    echo "<td class='p-2 border font-semibold " . 
                                        ($caso['estados_casos'] === 'Resuelto' ? 'text-green-600' : 'text-red-600') . "'>" . 
                                        htmlspecialchars($caso['estados_casos']) . 
                                    "</td>";
                                    echo "<td class='py-2 px-4 text-center'>";
                                    echo "<a href=\"ver_caso?id=" . htmlspecialchars($caso['id']) . "\" class=\"px-4 py-2 bg-[#39A900] text-white rounded-xl font-bold shadow hover:bg-green-600 transition-all\">Ver</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>

                <!-- Paginación -->
                <div class="mt-4 flex justify-center items-center space-x-2">
                    <?php if ($currentPage > 1): ?>
                        <a href="?page=<?= $currentPage - 1 ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="px-4 py-2 <?= $i === $currentPage ? 'bg-[#39A900] text-white' : 'bg-gray-300 text-gray-700' ?> rounded-md hover:bg-gray-400"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?page=<?= $currentPage + 1 ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Siguiente</a>
                    <?php endif; ?>
                </div>

                <h3 class="text-xl md:text-2xl font-bold text-[#39A900] mb-6 py-4">Listado de Casos Generales</h3>
                <table class="min-w-full border border-gray-300 text-sm md:text-base">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-5 text-left">Fecha</th>
                            <th class="py-3 px-5 text-left">Ambiente</th>
                            <th class="py-3 px-5 text-left">Asunto</th>
                            <th class="py-3 px-5 text-left">Rol</th>
                            <th class="py-3 px-5 text-center">Estado</th>
                            <th class="py-3 px-5 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php    
                            $itemsPerPageGeneral = 10; // Número de casos generales por página
                            $totalItemsGeneral = count($listadecasosgenerales);
                            $totalPagesGeneral = ceil($totalItemsGeneral / $itemsPerPageGeneral);
                            $currentPageGeneral = isset($_GET['page_general']) ? (int)$_GET['page_general'] : 1;
                            $currentPageGeneral = max(1, min($currentPageGeneral, $totalPagesGeneral));
                            $startIndexGeneral = ($currentPageGeneral - 1) * $itemsPerPageGeneral;

                            $paginatedCasosGenerales = array_slice($listadecasosgenerales, $startIndexGeneral, $itemsPerPageGeneral);

                            if (empty($paginatedCasosGenerales)) {
                                echo "<tr><td colspan='6' class='text-center py-4'>No hay casos registrados</td></tr>";
                            } else {
                                foreach ($paginatedCasosGenerales as $caso) {
                                    echo "<tr class='border-t'>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso["fecha_creacion"]) ."</td>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso['ambiente']) . "</td>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso['asunto']) . "</td>";
                                    echo "<td class='py-2 px-4'>". htmlspecialchars($caso["instructor"]) . "</td>";
                                    echo "<td class='p-2 border font-semibold " . 
                                        ($caso['estado'] === 'Resuelto' ? 'text-green-600' : 'text-red-600') . "'>" . 
                                        htmlspecialchars($caso['estado']) . 
                                    "</td>";
                                    echo "<td class='py-2 px-4 text-center'>";
                                    echo "<a href=\"ver_casoG?id=" . htmlspecialchars($caso['id']) . "\" class=\"px-4 py-2 bg-[#39A900] text-white rounded-xl font-bold shadow hover:bg-green-600 transition-all\">Ver</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>

                <!-- Paginación -->
                <div class="mt-4 flex justify-center items-center space-x-2">
                    <?php if ($currentPageGeneral > 1): ?>
                        <a href="?page_general=<?= $currentPageGeneral - 1 ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPagesGeneral; $i++): ?>
                        <a href="?page_general=<?= $i ?>" class="px-4 py-2 <?= $i === $currentPageGeneral ? 'bg-[#39A900] text-white' : 'bg-gray-300 text-gray-700' ?> rounded-md hover:bg-gray-400"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($currentPageGeneral < $totalPagesGeneral): ?>
                        <a href="?page_general=<?= $currentPageGeneral + 1 ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Siguiente</a>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
    // Función para actualizar la fecha y hora
    function actualizarFechaHora() {
        const ahora = new Date();
        const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };
        const fechaFormateada = ahora.toLocaleDateString('es-ES', opciones);
        document.getElementById('fechaHora').textContent = fechaFormateada;
    }

    // Llamar a la función al cargar la página
    actualizarFechaHora();

    // Mostrar modal de notificaciones
    const notifBtn = document.getElementById('notifBtn');
    const notifModal = document.getElementById('notifModal');

    notifBtn.addEventListener('click', () => {
        notifModal.classList.remove('hidden');
    });

    function closeNotif() {
        notifModal.classList.add('hidden');
    }

    // Aquí también puedes agregar otras funciones necesarias
    </script>

</body>
</html>
