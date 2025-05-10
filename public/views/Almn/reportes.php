<?php
session_start();
require_once __DIR__ . '../../../../Controller/CasoController.php';
$casoController = new CasoController();

// Constante para el ID del rol de almacén
define('ROL_ALMACEN', 4);

// Obtener los casos asignados al área de almacén
$casos = $casoController->getCasosPorRol(ROL_ALMACEN);

// Estados de los casos para código de colores
$estados = [
    1 => ['nombre' => 'Pendiente', 'color' => 'bg-blue-100 text-blue-800'],
    2 => ['nombre' => 'En proceso', 'color' => 'bg-yellow-100 text-yellow-800'],
    3 => ['nombre' => 'Resuelto', 'color' => 'bg-green-100 text-green-800']
];

// Obtener filtros desde GET
$filtroEstado = isset($_GET['estado']) ? $_GET['estado'] : 'todos';
$filtroFecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$filtroBuscar = isset($_GET['buscar']) ? strtolower(trim($_GET['buscar'])) : '';

// Filtrar los casos según los filtros
$casosFiltrados = array_filter($casos, function($caso) use ($filtroEstado, $filtroFecha, $filtroBuscar, $estados) {
    $match = true;
    if ($filtroEstado !== 'todos' && isset($estados[$filtroEstado])) {
        $match = $match && (strtolower($caso['estados_casos']) == strtolower($estados[$filtroEstado]['nombre']));
    }
    if ($filtroFecha) {
        $match = $match && (date('Y-m-d', strtotime($caso['fecha_creacion'])) == $filtroFecha);
    }
    if ($filtroBuscar) {
        $texto = strtolower($caso['descripcion'] . ' ' . $caso['producto'] . ' ' . $caso['ambiente']);
        $match = $match && (strpos($texto, $filtroBuscar) !== false);
    }
    return $match;
});

// --- PAGINACIÓN ---
$totalCasos = count($casosFiltrados);
$casosPorPagina = 10;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$totalPaginas = ceil($totalCasos / $casosPorPagina);
$inicio = ($paginaActual - 1) * $casosPorPagina;
$casosPagina = array_slice(array_values($casosFiltrados), $inicio, $casosPorPagina);

// Mostrar mensaje de éxito/error si viene por GET
?>
<?php if (isset($_GET['alert'], $_GET['mensaje'])): ?>
    <div class="<?= $_GET['alert'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?> p-2 rounded mb-4">
        <?= htmlspecialchars(urldecode($_GET['mensaje'])) ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casos de Almacén - GEDAC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in-right {
            animation: slideInRight 0.4s ease-out;
        }
        @keyframes fadeInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col lg:flex-row h-full min-h-screen">
        <?php include __DIR__ . '/barra.php'; ?>

        <main class="flex-1 p-6 md:ml-64 min-h-screen bg-gradient-to-br from-white to-[#f9f9f9]">
            <!-- Encabezado -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-3">
                    <svg class="w-10 h-10 text-[#39A900]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                <h1 class="text-3xl font-bold text-[#00304D]">Gestión de Casos - Área de Almacén</h1>
                </div>
                <div class="flex items-center space-x-2">
                    <span id="fechaHora" class="text-gray-600"></span>
                </div>
            </div>

            <!-- Filtros -->
            <div class="mb-6 animate-fade-in-up">
                <form method="GET" id="formFiltros">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Ambiente:</label>
                            <select id="filtroAmbiente" name="ambiente" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#39A900]" onchange="document.getElementById('formFiltros').submit()">
                                <option value="todos">Todos los ambientes</option>
                                <?php
                                // Obtener ambientes únicos de los casos
                                $ambientes = array_unique(array_map(function($caso) { return $caso['ambiente']; }, $casos));
                                foreach ($ambientes as $ambiente): ?>
                                    <option value="<?= htmlspecialchars($ambiente) ?>"<?= (isset($_GET['ambiente']) && $_GET['ambiente'] == $ambiente) ? ' selected' : '' ?>><?= htmlspecialchars($ambiente) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Estado:</label>
                            <select id="filtroEstado" name="estado" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#39A900]" onchange="document.getElementById('formFiltros').submit()">
                                <option value="todos"<?= $filtroEstado === 'todos' ? ' selected' : '' ?>>Todos los estados</option>
                                <?php foreach ($estados as $id => $estado): ?>
                                    <option value="<?= $id ?>"<?= $filtroEstado == $id ? ' selected' : '' ?>><?= $estado['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Mensaje de alerta -->
            <?php if (isset($_GET['alert'], $_GET['mensaje'])): ?>
                <div class="<?= $_GET['alert'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?> p-4 rounded-xl mb-6 animate-fade-in-up">
                    <div class="flex items-center">
                        <i class="fas <?= $_GET['alert'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?> mr-2"></i>
                        <?= htmlspecialchars(urldecode($_GET['mensaje'])) ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tabla de casos -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden animate-fade-in-up">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ambiente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (empty($casosPagina)): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center py-8">
                                            <i class="fas fa-inbox text-4xl text-gray-400 mb-2"></i>
                                            <p>No hay casos registrados para el área de almacén</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($casosPagina as $caso): ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $caso['id'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $caso['ambiente'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $caso['producto'] ?></td>
                                        <td class="px-6 py-4">
                                            <div class="line-clamp-2 text-sm text-gray-900"><?= $caso['descripcion'] ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                            <?php
                                                $estadoNombre = $caso['estados_casos'];
                                                $estadoColor = '';
                                                if (strtolower($estadoNombre) === 'resuelto') {
                                                    $estadoColor = 'text-green-600';
                                                } elseif (strtolower($estadoNombre) === 'pendiente') {
                                                    $estadoColor = 'text-red-600';
                                                } elseif (strtolower($estadoNombre) === 'en proceso') {
                                                    $estadoColor = 'text-yellow-600';
                                                } else {
                                                    $estadoColor = 'text-gray-600';
                                                }
                                            ?>
                                            <span class="<?= $estadoColor ?>">
                                                <?= htmlspecialchars($estadoNombre) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if (!empty($caso['imagen'])): ?>
                                                <button onclick="verImagen('<?= htmlspecialchars($caso['imagen']) ?>')" 
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                    <i class="fas fa-image mr-1"></i> Ver imagen
                                                </button>
                                            <?php else: ?>
                                                <span class="text-gray-400 text-sm">Sin imagen</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?= date('d/m/Y', strtotime($caso['fecha_creacion'])) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="Ver_Casos_Almn?id=<?= $caso['id'] ?>" class="bg-green-600 hover:bg-green-800 text-white px-4 py-2 rounded shadow transition-colors duration-200">Ver más detalles</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            <?php if ($totalPaginas > 1): ?>
                <div class="flex justify-center mt-6">
                    <nav class="inline-flex rounded-md shadow-sm" aria-label="Pagination">
                        <?php if ($paginaActual > 1): ?>
                            <a href="?pagina=<?= $paginaActual - 1 ?>" 
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-l-md transition-colors duration-200">
                                <i class="fas fa-chevron-left mr-2"></i> Anterior
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <a href="?pagina=<?= $i ?>" 
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium <?= $i == $paginaActual ? 'bg-[#39A900] text-white' : 'bg-white text-gray-700 hover:bg-gray-50' ?> transition-colors duration-200">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($paginaActual < $totalPaginas): ?>
                            <a href="?pagina=<?= $paginaActual + 1 ?>" 
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-r-md transition-colors duration-200">
                                Siguiente <i class="fas fa-chevron-right ml-2"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        </main>
            </div>

            <!-- Modal Ver Detalle -->
            <div id="modalDetalle" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-fade-in-up">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-[#00304D]">Detalle del Caso</h3>
                <button onclick="cerrarModal('modalDetalle')" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <div id="contenidoDetalle" class="space-y-4"></div>
                </div>
            </div>

            <!-- Modal Actualizar Estado -->
            <div id="modalEstado" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full animate-fade-in-up">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-[#00304D]">Actualizar Estado</h3>
                <button onclick="cerrarModal('modalEstado')" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <form id="formActualizarEstado" class="space-y-6">
                        <input type="hidden" id="casoId" name="caso_id">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Estado</label>
                    <select id="nuevoEstado" name="estado" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900] transition-all duration-200">
                                <?php foreach ($estados as $id => $estado): ?>
                                    <option value="<?= $id ?>"><?= $estado['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Comentario</label>
                    <textarea name="comentario" rows="3" class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#39A900] resize-none transition-all duration-200"></textarea>
                        </div>
                        <div class="text-right">
                    <button type="submit" class="bg-[#39A900] hover:bg-[#2d7a00] text-white py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal para ver imagen -->
            <div id="modalImagen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl p-8 max-w-lg w-full flex flex-col items-center animate-fade-in-up">
            <button onclick="cerrarModal('modalImagen')" class="self-end text-gray-500 hover:text-gray-700 transition-colors duration-200 mb-4">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    <div id="contenidoImagen" class="w-full flex flex-col items-center"></div>
                </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
            // Actualizar fecha y hora
            function actualizarFechaHora() {
                const ahora = new Date();
                const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };
                document.getElementById('fechaHora').textContent = ahora.toLocaleDateString('es-ES', opciones);
            }
            setInterval(actualizarFechaHora, 1000);
            actualizarFechaHora();

        // Funciones para los modales
        function cerrarModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function verDetalle(casoId) {
            const modal = document.getElementById('modalDetalle');
            const contenido = document.getElementById('contenidoDetalle');
            
            contenido.innerHTML = '<div class="flex justify-center py-4"><i class="fas fa-spinner fa-spin text-3xl text-[#39A900]"></i></div>';
            modal.classList.remove('hidden');

            // Aquí iría tu lógica AJAX para cargar los detalles
        }

        function actualizarEstado(casoId) {
            const modal = document.getElementById('modalEstado');
            document.getElementById('casoId').value = casoId;
            modal.classList.remove('hidden');
        }

        function verImagen(imagen) {
            const modal = document.getElementById('modalImagen');
            const contenido = document.getElementById('contenidoImagen');
            
            contenido.innerHTML = `
                <img src="/uploads/${imagen}" alt="Imagen del caso" 
                    class="max-w-full max-h-96 rounded-lg cursor-pointer hover:opacity-90 transition-opacity duration-200"
                    onclick="window.open(this.src, '_blank')">
            `;
            modal.classList.remove('hidden');
        }

        function confirmarEliminar(casoId) {
            if (confirm('¿Está seguro que desea eliminar este caso? Esta acción no se puede deshacer.')) {
                // Aquí iría tu lógica para eliminar el caso
            }
        }

        // Manejar el formulario de actualización de estado
        document.getElementById('formActualizarEstado').addEventListener('submit', function(e) {
            e.preventDefault();
            // Aquí iría tu lógica AJAX para actualizar el estado
        });
    </script>
</body>
</html>