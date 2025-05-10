<?php
$base_path = 'instr';
require_once __DIR__ . '../../../../Controller/CasoController.php';
session_start();
$UserCasoController = new CasoController();

// Obtener el ID del instructor de la sesión
$instructor_id = $_SESSION['id'] ?? null;

// Obtener parámetros de paginación y filtros
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$por_pagina = 8;

// Obtener tipo de caso (normal o general)
$tipo_caso = $_GET['tipo_caso'] ?? 'normal';

// Obtener filtros
$filtros = [
    'area' => $_GET['area'] ?? '',
    'estado' => $_GET['estado'] ?? '',
    'fecha_inicio' => $_GET['fecha_inicio'] ?? '',
    'fecha_fin' => $_GET['fecha_fin'] ?? ''
];

// Obtener casos según el tipo seleccionado
if ($tipo_caso === 'normal') {
    $resultado = $UserCasoController->obtenerCasosInstructor($instructor_id, $pagina_actual, $por_pagina, $filtros);
    $casos = $resultado['casos'];
} else {
    $resultado = $UserCasoController->obtenerCasosGeneralesInstructor($instructor_id, $pagina_actual, $por_pagina, $filtros);
    $casos = $resultado['casos'];
}
$total_paginas = $resultado['total_paginas'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Operaciones - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row">
        <!-- Barra lateral fija -->
        <?php include __DIR__ . '/barra.php'; ?>

        <!-- Contenido principal -->
        <main class="flex-1 p-4 sm:p-10 md:ml-64 min-h-screen bg-gradient-to-br from-white to-[#f9f9f9]">
            <div class="max-w-6xl mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-gray-200">
                <!-- Título -->
                <h2 class="text-3xl font-bold text-[#00304D] mb-8 text-center">📁 Historial de Casos</h2>

                <!-- Filtros -->
                <div class="mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <h3 class="text-lg font-semibold text-[#00304D] mb-4">Filtros de búsqueda</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        <!-- Tipo de Caso -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Caso</label>
                            <select name="tipo_caso" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#00304D] focus:ring-[#00304D] text-gray-700" onchange="aplicarFiltros()">
                                <option value="normal" <?php echo $tipo_caso === 'normal' ? 'selected' : ''; ?>>Casos Normales</option>
                                <option value="general" <?php echo $tipo_caso === 'general' ? 'selected' : ''; ?>>Casos Generales</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Área</label>
                            <select name="area" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#00304D] focus:ring-[#00304D] text-gray-700" onchange="aplicarFiltros()">
                                <option value="">Todas las áreas</option>
                                <option value="Tics" <?php echo $filtros['area'] === 'Tics' ? 'selected' : ''; ?>>Tics</option>
                                <option value="Almacen" <?php echo $filtros['area'] === 'Almacen' ? 'selected' : ''; ?>>Almacén</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                            <select name="estado" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#00304D] focus:ring-[#00304D] text-gray-700" onchange="aplicarFiltros()">
                                <option value="">Todos los estados</option>
                                <option value="Pendiente" <?php echo $filtros['estado'] === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="En Proceso" <?php echo $filtros['estado'] === 'En Proceso' ? 'selected' : ''; ?>>En Proceso</option>
                                <option value="Resuelto" <?php echo $filtros['estado'] === 'Resuelto' ? 'selected' : ''; ?>>Resuelto</option>
                                <option value="Cerrado" <?php echo $filtros['estado'] === 'Cerrado' ? 'selected' : ''; ?>>Cerrado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" value="<?php echo $filtros['fecha_inicio']; ?>" 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#00304D] focus:ring-[#00304D] text-gray-700" 
                                   onchange="aplicarFiltros()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                            <input type="date" name="fecha_fin" value="<?php echo $filtros['fecha_fin']; ?>" 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#00304D] focus:ring-[#00304D] text-gray-700" 
                                   onchange="aplicarFiltros()">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="button" onclick="limpiarFiltros()" 
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                            Limpiar filtros
                        </button>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <?php if ($tipo_caso === 'normal'): ?>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Área</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Placa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <?php else: ?>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ambiente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Área Asignada</th>
                                <?php endif; ?>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($casos)): ?>
                                <?php foreach ($casos as $caso): ?>
                                    <tr class="hover:bg-gray-50">
                                        <?php if ($tipo_caso === 'normal'): ?>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?php echo htmlspecialchars($caso['descripcion']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo htmlspecialchars($caso['area_asignada']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo htmlspecialchars($caso['numero_placa'] ?? 'N/A'); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo htmlspecialchars($caso['descripcion_producto'] ?? 'N/A'); ?>
                                        </td>
                                        <?php else: ?>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?php echo htmlspecialchars($caso['asunto']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo htmlspecialchars($caso['descripcion']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo htmlspecialchars($caso['ambiente']); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo htmlspecialchars($caso['area_asignada']); ?>
                                        </td>
                                        <?php endif; ?>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php
                                                $estadoColor = match ($caso['estado_actual']) {
                                                    'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                                    'En revisión' => 'bg-blue-100 text-blue-800',
                                                    'Resuelto' => 'bg-green-100 text-green-800',
                                                    'Repuesto' => 'bg-green-100 text-green-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $estadoColor; ?>">
                                                <?php echo htmlspecialchars($caso['estado_actual']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo date('d/m/Y H:i', strtotime($caso['fecha_creacion'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No hay casos registrados.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <?php if ($total_paginas > 1): ?>
                <div class="mt-4 flex justify-center">
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php if ($pagina_actual > 1): ?>
                            <a href="?pagina=<?php echo $pagina_actual - 1; ?>&tipo_caso=<?php echo $tipo_caso; ?>&area=<?php echo $filtros['area']; ?>&estado=<?php echo $filtros['estado']; ?>&fecha_inicio=<?php echo $filtros['fecha_inicio']; ?>&fecha_fin=<?php echo $filtros['fecha_fin']; ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Anterior</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <a href="?pagina=<?php echo $i; ?>&tipo_caso=<?php echo $tipo_caso; ?>&area=<?php echo $filtros['area']; ?>&estado=<?php echo $filtros['estado']; ?>&fecha_inicio=<?php echo $filtros['fecha_inicio']; ?>&fecha_fin=<?php echo $filtros['fecha_fin']; ?>" 
                               class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium <?php echo $i === $pagina_actual ? 'text-[#00304D] bg-gray-100' : 'text-gray-700 hover:bg-gray-50'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($pagina_actual < $total_paginas): ?>
                            <a href="?pagina=<?php echo $pagina_actual + 1; ?>&tipo_caso=<?php echo $tipo_caso; ?>&area=<?php echo $filtros['area']; ?>&estado=<?php echo $filtros['estado']; ?>&fecha_inicio=<?php echo $filtros['fecha_inicio']; ?>&fecha_fin=<?php echo $filtros['fecha_fin']; ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Siguiente</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        function aplicarFiltros() {
            const tipoCaso = document.querySelector('select[name="tipo_caso"]').value;
            const area = document.querySelector('select[name="area"]').value;
            const estado = document.querySelector('select[name="estado"]').value;
            const fechaInicio = document.querySelector('input[name="fecha_inicio"]').value;
            const fechaFin = document.querySelector('input[name="fecha_fin"]').value;
            
            // Validar que la fecha de fin no sea anterior a la fecha de inicio
            if (fechaInicio && fechaFin && new Date(fechaFin) < new Date(fechaInicio)) {
                alert('La fecha de fin no puede ser anterior a la fecha de inicio');
                return;
            }
            
            const params = new URLSearchParams();
            params.append('pagina', '1');
            params.append('tipo_caso', tipoCaso);
            if (area) params.append('area', area);
            if (estado) params.append('estado', estado);
            if (fechaInicio) params.append('fecha_inicio', fechaInicio);
            if (fechaFin) params.append('fecha_fin', fechaFin);
            
            window.location.href = `?${params.toString()}`;
        }

        function limpiarFiltros() {
            window.location.href = '?pagina=1';
        }
    </script>
</body>
</html>
