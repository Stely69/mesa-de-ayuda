<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $casos = new CasoController();
    $listadecasos = $casos->getCasos();
    $listadecasosgenerales = $casos->getCasosGeneral();
    $ambientes = $casos->getAmbientes();
    session_start();

    // Estados de los casos para código de colores
    $estados = [
        1 => ['nombre' => 'Pendiente', 'color' => 'bg-blue-100 text-blue-800'],
        2 => ['nombre' => 'En proceso', 'color' => 'bg-yellow-100 text-yellow-800'],
        3 => ['nombre' => 'Resuelto', 'color' => 'bg-green-100 text-green-800']
    ];

    $colorEstado = function($estado) {
        if (strtolower($estado) === 'resuelto') return 'text-green-600';
        if (strtolower($estado) === 'pendiente') return 'text-red-600';
        if (strtolower($estado) === 'en proceso') return 'text-orange-500';
        return 'text-gray-600';
    };
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
        <main class="flex-1 p-6 ml-64 overflow-auto">
            <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                <div>
                    <h2 class="text-3xl font-semibold text-[#39A900]">¡Bienvenido, Area Tics!</h2>
                </div>
            </div>

            <!-- Listado de Casos -->
            <div class="bg-white p-4 md:p-8 rounded-2xl shadow-md border border-gray-200 mb-10 overflow-x-auto">
                <h3 class="text-xl md:text-2xl font-bold text-[#00304D] mb-6">Listado de Casos</h3>
                
                <!-- Filtros para Casos Normales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="filtro_ambiente" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por Ambiente:</label>
                        <select id="filtro_ambiente" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-senaGreen">
                            <option value="">Todos los ambientes</option>
                            <?php foreach ($ambientes as $ambiente): ?>
                                <option value="<?= htmlspecialchars($ambiente['nombre']) ?>"><?= htmlspecialchars($ambiente['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="filtro_estado" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por Estado:</label>
                        <select id="filtro_estado" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-senaGreen">
                            <option value="">Todos los estados</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Resuelto">Resuelto</option>
                        </select>
                    </div>
                </div>

                <table class="min-w-full border border-gray-300 text-sm md:text-base">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-5 text-left">Fecha</th>
                            <th class="py-3 px-5 text-left">Ambiente</th>
                            <th class="py-3 px-5 text-left">Asunto</th>
                            <th class="py-3 px-5 text-left">Instructor</th>
                            <th class="py-3 px-5 text-left">Asignado a</th>
                            <th class="py-3 px-5 text-center">Estado</th>
                            <th class="py-3 px-5 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_casos">
                        <?php    
                            $itemsPerPage = 10;
                            $totalItems = count($listadecasos);
                            $totalPages = ceil($totalItems / $itemsPerPage);
                            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $currentPage = max(1, min($currentPage, $totalPages));
                            $startIndex = ($currentPage - 1) * $itemsPerPage;

                            $paginatedCasos = array_slice($listadecasos, $startIndex, $itemsPerPage);

                            if (empty($paginatedCasos)) {
                                echo "<tr><td colspan='7' class='text-center py-4'>No hay casos registrados</td></tr>";
                            } else {
                                foreach ($paginatedCasos as $caso) {
                                    echo "<tr class='border-t caso-fila' data-ambiente='" . htmlspecialchars($caso['ambiente']) . "' data-estado='" . htmlspecialchars($caso['estados_casos']) . "'>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso["fecha_creacion"]) ."</td>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso['ambiente']) . "</td>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso['descripcion']) . "</td>";
                                    echo "<td class='py-2 px-4'>". htmlspecialchars($caso["instructor"] ?? 'No asignado') . "</td>";
                                    echo "<td class='py-2 px-4'>". htmlspecialchars($caso["nombre_asignado"]) . "</td>";
                                    echo "<td class='p-2 border font-semibold " . $colorEstado($caso['estados_casos']) . "'>" . 
                                        htmlspecialchars($caso['estados_casos']) . 
                                    "</td>";
                                    echo "<td class='py-2 px-4 text-center'>";
                                    echo "<a href=\"ver_caso?id=" . htmlspecialchars($caso['id']) . "\" class=\"bg-[#007832] hover:bg-[#00304D] text-white px-4 py-2 rounded-xl shadow-md hover:shadow-xl text-sm font-semibold transition-all duration-300 transform hover:-translate-y-1\">Ver</a>";
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
                        <a href="?page=<?= $i ?>" class="px-4 py-2 <?= $i === $currentPage ? 'bg-[#00304D] text-white' : 'bg-gray-300 text-gray-700' ?> rounded-md hover:bg-gray-400"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?page=<?= $currentPage + 1 ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Siguiente</a>
                    <?php endif; ?>
                </div>

                <h3 class="text-xl md:text-2xl font-bold text-[#00304D] mb-6 py-4">Listado de Casos Generales</h3>
                
                <!-- Filtros para Casos Generales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="filtro_ambiente_general" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por Ambiente:</label>
                        <select id="filtro_ambiente_general" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-senaGreen">
                            <option value="">Todos los ambientes</option>
                            <?php foreach ($ambientes as $ambiente): ?>
                                <option value="<?= htmlspecialchars($ambiente['nombre']) ?>"><?= htmlspecialchars($ambiente['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="filtro_estado_general" class="block text-sm font-medium text-gray-700 mb-1">Filtrar por Estado:</label>
                        <select id="filtro_estado_general" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-senaGreen">
                            <option value="">Todos los estados</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Resuelto">Resuelto</option>
                        </select>
                    </div>
                </div>

                <table class="min-w-full border border-gray-300 text-sm md:text-base">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-5 text-left">Fecha</th>
                            <th class="py-3 px-5 text-left">Ambiente</th>
                            <th class="py-3 px-5 text-left">Asunto</th>
                            <th class="py-3 px-5 text-left">Instructor</th>
                            <th class="py-3 px-5 text-left">Asignado a</th>
                            <th class="py-3 px-5 text-center">Estado</th>
                            <th class="py-3 px-5 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_casos_generales">
                        <?php    
                            $itemsPerPageGeneral = 10;
                            $totalItemsGeneral = count($listadecasosgenerales);
                            $totalPagesGeneral = ceil($totalItemsGeneral / $itemsPerPageGeneral);
                            $currentPageGeneral = isset($_GET['page_general']) ? (int)$_GET['page_general'] : 1;
                            $currentPageGeneral = max(1, min($currentPageGeneral, $totalPagesGeneral));
                            $startIndexGeneral = ($currentPageGeneral - 1) * $itemsPerPageGeneral;

                            $paginatedCasosGenerales = array_slice($listadecasosgenerales, $startIndexGeneral, $itemsPerPageGeneral);

                            if (empty($paginatedCasosGenerales)) {
                                echo "<tr><td colspan='7' class='text-center py-4'>No hay casos registrados</td></tr>";
                            } else {
                                foreach ($paginatedCasosGenerales as $caso) {
                                    echo "<tr class='border-t caso-general-fila' data-ambiente='" . htmlspecialchars($caso['ambiente']) . "' data-estado='" . htmlspecialchars($caso['estado']) . "'>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso["fecha_creacion"]) ."</td>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso['ambiente']) . "</td>";
                                    echo "<td class='py-2 px-4'>" . htmlspecialchars($caso['asunto']) . "</td>";
                                    echo "<td class='py-2 px-4'>". htmlspecialchars($caso["instructor"] ?? 'No asignado') . "</td>";
                                    echo "<td class='py-2 px-4'>". htmlspecialchars($caso["nombre_asignado"]) . "</td>";
                                    echo "<td class='p-2 border font-semibold " . $colorEstado($caso['estado']) . "'>" . 
                                        htmlspecialchars($caso['estado']) . 
                                    "</td>";
                                    echo "<td class='py-2 px-4 text-center'>";
                                    echo "<a href=\"ver_casoG?id=" . htmlspecialchars($caso['id']) . "\" class=\"bg-[#007832] hover:bg-[#00304D] text-white px-4 py-2 rounded-xl shadow-md hover:shadow-xl text-sm font-semibold transition-all duration-300 transform hover:-translate-y-1\">Ver</a>";
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
                        <a href="?page_general=<?= $i ?>" class="px-4 py-2 <?= $i === $currentPageGeneral ? 'bg-[#00304D] text-white' : 'bg-gray-300 text-gray-700' ?> rounded-md hover:bg-gray-400"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($currentPageGeneral < $totalPagesGeneral): ?>
                        <a href="?page_general=<?= $currentPageGeneral + 1 ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Siguiente</a>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Función para filtrar casos normales
        function filtrarCasos() {
            const filtroAmbiente = document.getElementById('filtro_ambiente').value.toLowerCase();
            const filtroEstado = document.getElementById('filtro_estado').value.toLowerCase();
            const filas = document.querySelectorAll('#tabla_casos .caso-fila');

            filas.forEach(fila => {
                const ambiente = fila.dataset.ambiente.toLowerCase();
                const estado = fila.dataset.estado.toLowerCase();
                const mostrar = 
                    (filtroAmbiente === '' || ambiente.includes(filtroAmbiente)) &&
                    (filtroEstado === '' || estado.includes(filtroEstado));
                
                fila.style.display = mostrar ? '' : 'none';
            });
        }

        // Función para filtrar casos generales
        function filtrarCasosGenerales() {
            const filtroAmbiente = document.getElementById('filtro_ambiente_general').value.toLowerCase();
            const filtroEstado = document.getElementById('filtro_estado_general').value.toLowerCase();
            const filas = document.querySelectorAll('#tabla_casos_generales .caso-general-fila');

            filas.forEach(fila => {
                const ambiente = fila.dataset.ambiente.toLowerCase();
                const estado = fila.dataset.estado.toLowerCase();
                const mostrar = 
                    (filtroAmbiente === '' || ambiente.includes(filtroAmbiente)) &&
                    (filtroEstado === '' || estado.includes(filtroEstado));
                
                fila.style.display = mostrar ? '' : 'none';
            });
        }

        // Event listeners para los filtros de casos normales
        document.getElementById('filtro_ambiente').addEventListener('change', filtrarCasos);
        document.getElementById('filtro_estado').addEventListener('change', filtrarCasos);

        // Event listeners para los filtros de casos generales
        document.getElementById('filtro_ambiente_general').addEventListener('change', filtrarCasosGenerales);
        document.getElementById('filtro_estado_general').addEventListener('change', filtrarCasosGenerales);
    </script>
</body>
</html>
