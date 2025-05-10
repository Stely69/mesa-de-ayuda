<?php
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    require_once __DIR__ . '../../../../Controller/ProductoController.php';

    $ambiente_id = isset($_GET['ambiente_id']) ? $_GET['ambiente_id'] : null;
    $status = isset($_GET['status']) ? $_GET['status'] : null;
    $message = isset($_GET['message']) ? $_GET['message'] : null;
    $busqueda_placa = isset($_GET['busqueda_placa']) ? $_GET['busqueda_placa'] : '';
    $busqueda_ambiente = isset($_GET['busqueda_ambiente']) ? $_GET['busqueda_ambiente'] : '';

    $controller = new CasoController();
    $controllerP = new ProductoController();
    $ambientes = $controller->getAmbientes();
    
    // Obtener los productos según los filtros
    if ($busqueda_placa) {
        // Si hay búsqueda por placa, esto tiene prioridad
        $productos = $controllerP->getProductosByPlaca($busqueda_placa);
    } elseif ($busqueda_ambiente) {
        // Si hay búsqueda por nombre de ambiente
        $productos = $controllerP->getProductosByNombreAmbiente($busqueda_ambiente);
    } elseif ($ambiente_id) {
        // Si hay filtro por ID de ambiente
        $productos = $controllerP->getProductosByAmbiente($ambiente_id);
    } else {
        // Sin filtros
        $productos = $controllerP->getAllProductos();
    }
    
    // Aseguramos que $productos sea un array
    if (!is_array($productos)) {
        $productos = [];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Bienes - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Barra lateral fija -->
        <?php include __DIR__ . '/barra.php'; ?>
        
        <!-- Contenido principal con margen izquierdo -->
        <main class="flex-1 p-6 ml-64 overflow-auto">
            <h2 class="text-3xl font-semibold text-[#39A900] mb-6">Gestión de Bienes</h2>
            
            <?php if ($status && $message): ?>
                <div class="mb-6 p-4 rounded-lg <?php echo $status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <div class="flex flex-col md:flex-row gap-6 mb-6">
                <!-- Filtro por ambiente -->
                <div class="bg-white p-4 rounded-lg shadow md:w-1/3">
                    <h3 class="text-lg font-semibold text-[#39A900] mb-3">Filtrar por Ambiente</h3>
                    <select id="filtroAmbiente" class="p-2 border rounded w-full">
                        <option value="">Todos los ambientes</option>
                        <?php foreach ($ambientes as $ambiente): ?>
                            <option value="<?php echo $ambiente['id']; ?>" <?php echo $ambiente_id == $ambiente['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ambiente['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>







                
                
                <!-- Botón para agregar bien -->
                <?php
// Asegúrate de incluir los controladores necesarios
require_once __DIR__ . '../../../../Controller/CasoController.php';
require_once __DIR__ .'../../../../Controller/ProductoController.php';

// Inicializar controladores
$controller = new CasoController();
$controllerP = new ProductoController();

// Obtener datos
$ambientes = $controller->getAmbientes();
$marcas = $controllerP->getClase(); // Esto es para obtener las marcas/clases
?>

<div class="bg-white p-4 rounded-lg shadow md:w-1/3 flex flex-col justify-center">
    <button onclick="openModal()" class="bg-[#39A900] text-white p-2 rounded font-bold hover:bg-green-700">
        <i class="fas fa-plus mr-2"></i> Agregar Nuevo Bien
    </button>
</div>

<!-- Modal responsive ancho -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 px-4">
    <div class="bg-white p-6 md:p-10 rounded-2xl shadow-2xl w-11/12 md:w-full max-w-2xl relative max-h-[90vh] overflow-y-auto transition-all duration-300 transform scale-95 opacity-0" id="modal-content">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-3xl font-bold">&times;</button>
        <h2 class="text-3xl font-bold text-[#39A900] mb-6 text-center">Agregar Bienes</h2>
        
        <form action="AddAction.php" method="POST" class="space-y-6">
            <div>
                <label for="ambiente" class="block text-base font-medium text-gray-700 mb-1">Ambiente:</label>
                <select id="ambiente" name="ambiente" required class="p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                    <option value="">Seleccione un ambiente</option>
                    <?php
                        foreach ($ambientes as $ambiente) {
                            echo "<option value='" . $ambiente['id'] . "'>" . $ambiente['nombre'] . "</option>";
                        }
                    ?>
                </select>
            </div>

            <div>
                <label for="clase_id" class="block text-base font-medium text-gray-700 mb-1">Marca:</label>
                <select id="clase_id" name="clase_id" required class="p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                    <option value="">Seleccione una marca</option>
                    <?php
                        foreach ($marcas as $marca) {
                            echo "<option value='" . $marca['id'] . "'>" . $marca['nombre'] . "</option>";
                        }
                    ?>
                </select>
            </div>

            <div>
                <label for="numero_placa" class="block text-base font-medium text-gray-700 mb-1">Número de Placa:</label>
                <input type="text" id="numero_placa" name="numero_placa" required class="p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
            </div>

            <div>
                <label for="serial" class="block text-base font-medium text-gray-700 mb-1">Serial:</label>
                <input type="text" id="serial" name="serial" required class="p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
            </div>

            <div>
                <label for="descripcion" class="block text-base font-medium text-gray-700 mb-1">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required rows="3" class="p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]"></textarea>
            </div>

            <div>
                <label for="modelo" class="block text-base font-medium text-gray-700 mb-1">Modelo:</label>
                <input type="text" id="modelo" name="modelo" required class="p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
            </div>

            <button type="submit" class="w-full bg-[#39A900] text-white py-3 rounded-md hover:bg-green-700 transition font-semibold shadow">Agregar Producto</button>
        </form>
    </div>
</div>

<script>
    // Funciones para el modal
    function openModal() {
        const modal = document.getElementById('modal');
        const modalContent = document.getElementById('modal-content');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 50);
    }
    
    function closeModal() {
        const modalContent = document.getElementById('modal-content');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            document.getElementById('modal').classList.add('hidden');
        }, 200);
    }

    // Asegurar que el botón de cierre funcione
    document.addEventListener('DOMContentLoaded', function() {
        const closeButton = document.getElementById('closeModalBtn');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                closeModal();
            });
        }
    });
</script>





                
                
                <!-- Estadísticas -->
                <div class="bg-white p-4 rounded-lg shadow md:w-1/3">
                    <h3 class="text-lg font-semibold text-[#39A900] mb-3">Estadísticas</h3>
                    <p class="text-gray-700">Total de bienes: <span class="font-bold"><?php echo count($productos); ?></span></p>
                    <?php if ($ambiente_id): ?>
                        <p class="text-gray-700">Bienes en este ambiente: <span class="font-bold"><?php echo count($productos); ?></span></p>
                    <?php endif; ?>
                    <?php if ($busqueda_placa): ?>
                        <p class="text-gray-700">Resultados para placa "<?php echo htmlspecialchars($busqueda_placa); ?>": <span class="font-bold"><?php echo count($productos); ?></span></p>
                    <?php endif; ?>
                    <?php if ($busqueda_ambiente): ?>
                        <p class="text-gray-700">Resultados para ambiente "<?php echo htmlspecialchars($busqueda_ambiente); ?>": <span class="font-bold"><?php echo count($productos); ?></span></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Opciones de búsqueda -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold text-[#39A900] mb-3">Búsqueda</h3>
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Búsqueda por número de placa -->
                    <div class="flex-1">
                        <form action="" method="GET" class="flex items-center">
                            <input type="text" name="busqueda_placa" placeholder="Buscar por número de placa" 
                                class="p-2 border rounded flex-1" value="<?php echo htmlspecialchars($busqueda_placa); ?>">
                            <button type="submit" class="ml-2 bg-[#39A900] text-white p-2 rounded hover:bg-green-700">
                                <i class="fas fa-search"></i>
                            </button>
                            <?php if ($busqueda_placa): ?>
                                <a href="bienes.php" class="ml-2 bg-gray-300 text-gray-700 p-2 rounded hover:bg-gray-400">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                            <!-- Mantener el filtro de ambiente si está activo -->
                            <?php if ($ambiente_id): ?>
                                <input type="hidden" name="ambiente_id" value="<?php echo $ambiente_id; ?>">
                            <?php endif; ?>
                        </form>
                    </div>
                    
                    <!-- Búsqueda por nombre de ambiente -->
                    <div class="flex-1">
                        <form action="" method="GET" class="flex items-center">
                            <input type="text" name="busqueda_ambiente" placeholder="Buscar por nombre de ambiente" 
                                class="p-2 border rounded flex-1" value="<?php echo htmlspecialchars($busqueda_ambiente); ?>">
                            <button type="submit" class="ml-2 bg-[#39A900] text-white p-2 rounded hover:bg-green-700">
                                <i class="fas fa-search"></i>
                            </button>
                            <?php if ($busqueda_ambiente): ?>
                                <a href="bienes.php" class="ml-2 bg-gray-300 text-gray-700 p-2 rounded hover:bg-gray-400">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Tabla de bienes -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ambiente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clase/Marca</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número Placa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modelo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (count($productos) > 0): ?>
                            <?php foreach ($productos as $producto): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $producto['id']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($producto['nombre_ambiente']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($producto['nombre_clase']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($producto['numero_placa']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($producto['serial']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($producto['modelo']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button onclick="verDetalle(<?php echo $producto['id']; ?>)" class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="confirmarEliminar(<?php echo $producto['id']; ?>)" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No hay bienes registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Modal de confirmación para eliminar -->
            <div id="modal-eliminar" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                    <h3 class="text-lg font-bold text-red-600 mb-4">Confirmar eliminación</h3>
                    <p class="mb-6">¿Está seguro que desea eliminar este bien? Esta acción no se puede deshacer.</p>
                    <div class="flex justify-end gap-4">
                        <button onclick="closeModal('modal-eliminar')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancelar</button>
                        <button id="btn-eliminar" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
                    </div>
                </div>
            </div>
            
            <!-- Modal de detalles -->
            <div id="modal-detalle" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                    <h3 class="text-lg font-bold text-[#39A900] mb-4">Detalles del bien</h3>
                    <div id="detalle-contenido" class="mb-6">
                        <!-- El contenido se llenará con JavaScript -->
                    </div>
                    <div class="flex justify-end">
                        <button onclick="closeModal('modal-detalle')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cerrar</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Redireccionar al cambiar el filtro de ambiente
        document.getElementById('filtroAmbiente').addEventListener('change', function() {
            window.location.href = 'bienes.php' + (this.value ? '?ambiente_id=' + this.value : '');
        });
        
        // Función para confirmar eliminación
        function confirmarEliminar(id) {
            document.getElementById('modal-eliminar').classList.remove('hidden');
            document.getElementById('btn-eliminar').onclick = function() {
                window.location.href = 'DeleteBien.php?id=' + id;
            };
        }
        
        // Función para ver detalles
        function verDetalle(id) {
            // Aquí se podría hacer una petición AJAX para obtener los detalles
            // Por ahora simularemos que obtenemos los datos
            fetch('GetProductoDetails.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let producto = data.producto;
                        let contenido = `
                            <div class="grid grid-cols-2 gap-2">
                                <div class="font-semibold">ID:</div>
                                <div>${producto.id}</div>
                                <div class="font-semibold">Ambiente:</div>
                                <div>${producto.nombre_ambiente}</div>
                                <div class="font-semibold">Clase/Marca:</div>
                                <div>${producto.nombre_clase}</div>
                                <div class="font-semibold">Número Placa:</div>
                                <div>${producto.numero_placa}</div>
                                <div class="font-semibold">Serial:</div>
                                <div>${producto.serial}</div>
                                <div class="font-semibold">Modelo:</div>
                                <div>${producto.modelo}</div>
                                <div class="font-semibold">Descripción:</div>
                                <div>${producto.descripcion}</div>
                                <div class="font-semibold">Fecha Creación:</div>
                                <div>${producto.fecha_creacion}</div>
                            </div>
                        `;
                        document.getElementById('detalle-contenido').innerHTML = contenido;
                        document.getElementById('modal-detalle').classList.remove('hidden');
                    } else {
                        alert('Error al obtener detalles del producto');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al comunicarse con el servidor');
                });
        }
        
        // Función para cerrar modales
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
        
        // Función para limpiar todos los filtros y búsquedas
        function limpiarFiltros() {
            window.location.href = 'bienes.php';
        }
        
        // Si hay búsquedas activas, mostrar un botón para limpiar todos los filtros
        if (document.querySelector('input[name="busqueda_placa"]')?.value || 
            document.querySelector('input[name="busqueda_ambiente"]')?.value || 
            document.getElementById('filtroAmbiente').value) {
            
            // Crear botón de limpiar filtros
            const limpiarBtn = document.createElement('button');
            limpiarBtn.className = 'mt-4 mb-4 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600';
            limpiarBtn.innerHTML = '<i class="fas fa-filter"></i> Limpiar todos los filtros';
            limpiarBtn.onclick = limpiarFiltros;
            
            // Añadir al DOM antes de la tabla
            document.querySelector('.bg-white.rounded-lg.shadow.overflow-hidden').before(limpiarBtn);
        }
    </script>
</body>
</html>