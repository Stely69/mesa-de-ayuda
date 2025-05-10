<?php
$base_path = 'almacen';
session_start();
require_once __DIR__ . '/../../../Controller/CasoController.php';
require_once __DIR__ .'../../../../Controller/ProductoController.php';

// Depuración: guarda el POST en un archivo para verificar si llega
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    file_put_contents(__DIR__ . '/debug_post.txt', print_r($_POST, true));
}

$ambiente_id = isset($_GET['ambiente_id']) ? $_GET['ambiente_id'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;
$message = isset($_GET['message']) ? $_GET['message'] : null;
$busqueda_placa = isset($_GET['busqueda_placa']) ? $_GET['busqueda_placa'] : '';
$busqueda_ambiente = isset($_GET['busqueda_ambiente']) ? $_GET['busqueda_ambiente'] : '';

$controller = new CasoController();
$controllerP = new ProductoController();
$ambientes = $controller->getAmbientes();
$marcas = $controllerP->getClase();

// Procesar alta de producto por POST
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['numero_placa'], $_POST['serial'], $_POST['descripcion'], $_POST['modelo'], $_POST['clase_id'], $_POST['ambiente'])
) {
    try {
        $controllerP->guardarProducto(
            $_POST['numero_placa'],
            $_POST['serial'],
            $_POST['descripcion'],
            $_POST['modelo'],
            $_POST['clase_id'],
            $_POST['ambiente']
        );
        header('Location: inventario?status=success&message=Producto+agregado+correctamente');
        exit();
    } catch (Exception $e) {
        $status = 'error';
        $message = 'Error al agregar: ' . $e->getMessage();
    }
}

// Procesar eliminación de producto por POST
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['eliminar_bien_id'])
) {
    try {
        $controllerP->deleteBienes($_POST['eliminar_bien_id']);
        header('Location: inventario?status=success&message=Bien+eliminado+correctamente');
        exit();
    } catch (Exception $e) {
        $status = 'error';
        $message = 'Error al eliminar: ' . $e->getMessage();
    }
}

// Obtener los productos según los filtros
if ($busqueda_placa) {
    $productos = $controllerP->getProductosByPlaca($busqueda_placa);
} elseif ($busqueda_ambiente) {
    $productos = $controllerP->getProductosByNombreAmbiente($busqueda_ambiente);
} elseif ($ambiente_id) {
    $productos = $controllerP->getProductosByAmbiente($ambiente_id);
} else {
    $productos = $controllerP->getAllProductos();
}
if (!is_array($productos)) {
    $productos = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Agrega la librería SheetJS -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Barra lateral fija -->
        <?php include __DIR__ . '/barra.php'; ?>
        
        <!-- Contenido principal con margen izquierdo -->
        <main class="flex-1 p-6 ml-64 overflow-auto">
        <h2 class="text-3xl font-bold text-[#00304D] mb-8 text-center">📦Inventario</h2>
            <?php if ($status && $message): ?>
                <div class="mb-6 p-4 rounded-lg <?php echo $status === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            <div class="flex flex-col md:flex-row gap-6 mb-6">
                <div class="bg-white p-4 rounded-lg shadow md:w-1/3">
                    <h3 class="text-lg font-semibold text-[#007832] mb-3">Filtrar por Ambiente</h3>
                    <select id="filtroAmbiente" class="p-2 border rounded w-full">
                        <option value="">Todos los ambientes</option>
                        <?php foreach ($ambientes as $ambiente): ?>
                            <option value="<?php echo $ambiente['id']; ?>" <?php echo $ambiente_id == $ambiente['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ambiente['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="bg-white p-4 rounded-lg shadow md:w-1/3 flex flex-col justify-center gap-2">
                    <button onclick="openModalAgregar()" class="bg-[#007832] hover:bg-[#00304D] text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl text-center text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-plus mr-2"></i> Agregar Nuevo Bien
                    </button>
                    <a href="../../plantilla_bienes.xlsx" class="bg-blue-600 hover:bg-blue-800 text-white py-3 px-6 rounded-2xl shadow-md text-center text-lg font-semibold transition-all duration-300" download>
                        <i class="fas fa-file-excel mr-2"></i> Descargar Plantilla CSV
                    </a>
                    <form id="form-carga-excel" action="CargarBienesExcel" method="POST" enctype="multipart/form-data" class="mt-2 flex flex-col gap-2">
                        <label for="archivo_excel" class="text-sm font-medium text-gray-700">Cargar bienes por Excel:</label>
                        <input type="file" name="archivo_excel" id="archivo_excel" accept=".xlsx" required class="border rounded p-2">
                        <button type="submit" class="bg-[#39A900] hover:bg-[#007832] text-white py-2 px-4 rounded shadow font-semibold">Subir y Agregar Bienes</button>
                    </form>
                </div>
                <div class="bg-white p-4 rounded-lg shadow md:w-1/3">
                    <h3 class="text-lg font-semibold text-[#007832] mb-3">Estadísticas</h3>
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
            <!-- Modal para agregar producto -->
            <div id="modal-agregar" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white p-8 rounded-2xl shadow-xl max-w-lg w-full">
                    <h3 class="text-2xl font-bold text-[#39A900] mb-6">Agregar Nuevo Bien</h3>
                    <form action="AddAction" method="POST" class="space-y-4">
                        <div>
                            <label for="ambiente_modal" class="block text-sm font-medium text-gray-700 mb-1">Ambiente:</label>
                            <select id="ambiente_modal" name="ambiente" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                                <option value="">Seleccione un ambiente</option>
                                <?php foreach ($ambientes as $ambiente): ?>
                                    <option value="<?php echo $ambiente['id']; ?>"><?php echo htmlspecialchars($ambiente['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="clase_id" class="block text-sm font-medium text-gray-700 mb-1">Clase/Marca:</label>
                            <select id="clase_id" name="clase_id" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                                <option value="">Seleccione una clase/marca</option>
                                <?php foreach ($marcas as $marca): ?>
                                    <option value="<?php echo $marca['id']; ?>"><?php echo htmlspecialchars($marca['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="numero_placa" class="block text-sm font-medium text-gray-700 mb-1">Número de Placa:</label>
                            <input type="text" id="numero_placa" name="numero_placa" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                        </div>
                        <div>
                            <label for="serial" class="block text-sm font-medium text-gray-700 mb-1">Serial:</label>
                            <input type="text" id="serial" name="serial" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                        </div>
                        <div>
                            <label for="modelo" class="block text-sm font-medium text-gray-700 mb-1">Modelo:</label>
                            <input type="text" id="modelo" name="modelo" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                        </div>
                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción:</label>
                            <textarea id="descripcion" name="descripcion" required rows="2" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]"></textarea>
                        </div>
                        <div class="flex justify-end gap-4">
                            <button type="button" onclick="closeModalAgregar()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-[#007832] hover:bg-[#00304D] text-white rounded-2xl shadow-md hover:shadow-xl font-semibold transition-all duration-300 transform hover:-translate-y-1">
                                Agregar
                            </button>

                        </div>
                    </form>
                </div>
            </div>
            <!-- Opciones de búsqueda -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold text-[#007832] mb-3">Búsqueda</h3>
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <form action="" method="GET" class="flex items-center">
                            <input type="text" name="busqueda_placa" placeholder="Buscar por número de placa" class="p-2 border rounded flex-1" value="<?php echo htmlspecialchars($busqueda_placa); ?>">
                            <button type="submit" class="bg-[#007832] hover:bg-[#00304D] text-white p-2 px-3 rounded-2xl shadow-md hover:shadow-xl text-base font-semibold transition-all duration-300 transform hover:-translate-y-1">
                                <i class="fas fa-search"></i>
                            </button>

                            <?php if ($busqueda_placa): ?>
                                <a href="inventario" class="ml-2 bg-gray-300 text-gray-700 p-2 rounded hover:bg-gray-400">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($ambiente_id): ?>
                                <input type="hidden" name="ambiente_id" value="<?php echo $ambiente_id; ?>">
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="flex-1">
                        <form action="" method="GET" class="flex items-center">
                            <input type="text" name="busqueda_ambiente" placeholder="Buscar por nombre de ambiente" class="p-2 border rounded flex-1" value="<?php echo htmlspecialchars($busqueda_ambiente); ?>">
                            <button type="submit" class="bg-[#007832] hover:bg-[#00304D] text-white p-2 px-3 rounded-2xl shadow-md hover:shadow-xl text-base font-semibold transition-all duration-300 transform hover:-translate-y-1">
                                <i class="fas fa-search"></i>
                            </button>
                            <?php if ($busqueda_ambiente): ?>
                                <a href="inventario" class="ml-2 bg-gray-300 text-gray-700 p-2 rounded hover:bg-gray-400">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal de confirmación para eliminar -->
            <div id="modal-eliminar" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                    <h3 class="text-lg font-bold text-red-600 mb-4">Confirmar eliminación</h3>
                    <p class="mb-6">¿Está seguro que desea eliminar este bien? Esta acción no se puede deshacer.</p>
                    <form id="form-eliminar-bien" method="POST" action="EliminarBienAction" class="flex justify-end gap-4">
                        <input type="hidden" name="eliminar_bien_id" id="eliminar_bien_id">
                        <button type="button" onclick="closeModal('modal-eliminar')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
                    </form>
                </div>
            </div>
            <!-- Modal de detalles -->
            <div id="modal-detalle" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
                    <h3 class="text-lg font-bold text-[#39A900] mb-4">Detalles del bien</h3>
                    <div id="detalle-contenido" class="mb-6"></div>
                    <div class="flex justify-end">
                        <button onclick="closeModal('modal-detalle')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cerrar</button>
                    </div>
                </div>
            </div>
            <!-- Modal de edición para editar bien -->
            <div id="modal-editar" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white p-8 rounded-2xl shadow-xl max-w-lg w-full">
                    <h3 class="text-2xl font-bold text-[#39A900] mb-6">Editar Bien</h3>
                    <form id="form-editar-bien" action="EditarBienAction" method="POST" class="space-y-4">
                        <input type="hidden" name="editar_bien_id" id="editar_bien_id">
                        <div>
                            <label for="editar_numero_placa" class="block text-sm font-medium text-gray-700 mb-1">Número de Placa:</label>
                            <input type="text" id="editar_numero_placa" name="editar_numero_placa" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                        </div>
                        <div>
                            <label for="editar_serial" class="block text-sm font-medium text-gray-700 mb-1">Serial:</label>
                            <input type="text" id="editar_serial" name="editar_serial" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                        </div>
                        <div>
                            <label for="editar_modelo" class="block text-sm font-medium text-gray-700 mb-1">Modelo:</label>
                            <input type="text" id="editar_modelo" name="editar_modelo" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                        </div>
                        <div>
                            <label for="editar_descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción:</label>
                            <textarea id="editar_descripcion" name="editar_descripcion" required rows="2" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]"></textarea>
                        </div>
                        <div>
                            <label for="editar_ambiente" class="block text-sm font-medium text-gray-700 mb-1">Ambiente:</label>
                            <select id="editar_ambiente" name="editar_ambiente" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                                <option value="">Seleccione un ambiente</option>
                                <?php foreach ($ambientes as $ambiente): ?>
                                    <option value="<?php echo $ambiente['id']; ?>"><?php echo htmlspecialchars($ambiente['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="editar_clase_id" class="block text-sm font-medium text-gray-700 mb-1">Clase/Marca:</label>
                            <select id="editar_clase_id" name="editar_clase_id" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                                <option value="">Seleccione una clase/marca</option>
                                <?php foreach ($marcas as $marca): ?>
                                    <option value="<?php echo $marca['id']; ?>"><?php echo htmlspecialchars($marca['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="flex justify-end gap-4">
                            <button type="button" onclick="closeModal('modal-editar')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-[#007832] hover:bg-[#00304D] text-white rounded-2xl shadow-md hover:shadow-xl font-semibold transition-all duration-300 transform hover:-translate-y-1">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
                                        <button onclick="verDetalle(<?php echo htmlspecialchars(json_encode($producto)); ?>)" class="text-blue-600 hover:text-blue-900 mr-3">
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
        </main>
    </div>
    
    <div id="mensaje-exito" style="display:none;" class="fixed top-6 right-6 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50"></div>
    
    <script>
        document.getElementById("ambiente").addEventListener("change", function() {
            const ambienteSeleccionado = this.value;
            const inventarioDiv = document.getElementById("inventario");
            const listaInventario = document.getElementById("lista-inventario");
            const numAmbiente = document.getElementById("num-ambiente");

            if (ambienteSeleccionado) {
                numAmbiente.textContent = ambienteSeleccionado;
                listaInventario.innerHTML = "";
                
                const elementos = ["Pantallas", "Escritorios", "Mouse", "Teclado", "Videobeam", "Sillas", "Televisores", "Tablero"];
                
                elementos.forEach(item => {
                    const cantidad = Math.floor(Math.random() * 10) + 1;
                    const div = document.createElement("div");
                    div.className = "p-4 bg-gray-50 border border-gray-200 shadow rounded-md flex flex-col items-center hover:shadow-lg transition-all";
                    div.innerHTML = `<h3 class='text-lg text-gray-700 font-bold'>${item}</h3>
                                     <p class='text-gray-600'>Cantidad: ${cantidad}</p>
                                     <button class='mt-2 bg-blue-500 text-white px-4 py-2 rounded-md font-bold hover:bg-blue-700'>Ver Todo</button>`;
                    listaInventario.appendChild(div);
                });
                
                inventarioDiv.classList.remove("hidden");
            } else {
                inventarioDiv.classList.add("hidden");
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll(".nav-link");
            const currentPath = window.location.pathname.split("/").pop();
            
            links.forEach(link => {
                const linkPath = link.getAttribute("href").split("/").pop();
                if (linkPath === currentPath) {
                    link.classList.add("bg-white", "text-[#39A900]", "font-bold", "shadow-md");
                    link.classList.remove("hover:bg-white", "hover:text-[#39A900]");
                } else {
                    link.classList.remove("bg-white", "text-[#39A900]", "font-bold", "shadow-md");
                    link.classList.add("hover:bg-white", "hover:text-[#39A900]");
                }
            });
        });
    //MODAL AGREGAR BIENES
        function openModal() {
                const modal = document.getElementById('modal-agregar');
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
        function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
        } else {
            console.error(`No se encontró el modal con id "${id}"`);
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('hidden');
        } else {
            console.error(`No se encontró el modal con id "${id}"`);
        }
    }  

    </script>
    <script>
        document.getElementById("filtroAmbiente").addEventListener("change", function() {
            let ambiente_id = this.value;
            window.location.href = "?ambiente_id=" + ambiente_id;
        });
    </script>
    <script>
    function openModalAgregar() {
        document.getElementById('modal-agregar').classList.remove('hidden');
    }
    function closeModalAgregar() {
        document.getElementById('modal-agregar').classList.add('hidden');
    }
    </script>
    <script>
    function confirmarEliminar(id) {
        document.getElementById('modal-eliminar').classList.remove('hidden');
        document.getElementById('eliminar_bien_id').value = id;
    }
    </script>
    <script>
    function verDetalle(producto) {
        if (typeof producto === 'string') {
            producto = JSON.parse(producto);
        }
        document.getElementById('modal-editar').classList.remove('hidden');
        document.getElementById('editar_bien_id').value = producto.id;
        document.getElementById('editar_numero_placa').value = producto.numero_placa;
        document.getElementById('editar_serial').value = producto.serial;
        document.getElementById('editar_modelo').value = producto.modelo;
        document.getElementById('editar_descripcion').value = producto.descripcion;
        document.getElementById('editar_ambiente').value = producto.ambiente_id || '';
        document.getElementById('editar_clase_id').value = producto.clase_id || '';
    }
    </script>
    <script>
    function mostrarMensajeExito(mensaje) {
        const div = document.getElementById('mensaje-exito');
        div.textContent = mensaje;
        div.style.display = 'block';
        setTimeout(() => {
            div.style.display = 'none';
            location.reload();
        }, 1500);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Eliminar bien con AJAX
        const formEliminar = document.getElementById('form-eliminar-bien');
        if (formEliminar) {
            formEliminar.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch('EliminarBienAction', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        mostrarMensajeExito('Bien eliminado correctamente');
                    } else {
                        alert(data.message || 'Error al eliminar bien');
                    }
                })
                .catch(err => alert('Error al eliminar bien'));
            });
        }

        // Editar bien con AJAX
        const formEditar = document.getElementById('form-editar-bien');
        if (formEditar) {
            formEditar.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch('EditarBienAction', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        mostrarMensajeExito('Bien editado correctamente');
                    } else {
                        alert(data.message || 'Error al editar bien');
                    }
                })
                .catch(err => alert('Error al editar bien'));
            });
        }
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const formCarga = document.getElementById('form-carga-excel');
        const inputArchivo = document.getElementById('archivo_excel');

        if (formCarga && inputArchivo) {
            formCarga.addEventListener('submit', function(e) {
                e.preventDefault();
                const archivo = inputArchivo.files[0];
                if (!archivo) return;

                // Si es CSV, envía normalmente
                if (archivo.name.endsWith('.csv')) {
                    const formData = new FormData(this);
                    fetch('CargarBienesExcel', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.text())
                    .then(data => {
                        alert('Carga masiva finalizada. Si hubo errores, revisa los mensajes en la página.');
                        location.reload();
                    })
                    .catch(err => alert('Error al subir el archivo CSV.'));
                    return;
                }

                // Si es Excel, conviértelo a CSV antes de enviar
                if (archivo.name.endsWith('.xlsx') || archivo.name.endsWith('.xls')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const data = new Uint8Array(e.target.result);
                        const workbook = XLSX.read(data, {type: 'array'});
                        const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                        const csv = XLSX.utils.sheet_to_csv(firstSheet);
                        // Crear un blob CSV y enviarlo como FormData
                        const csvBlob = new Blob([csv], {type: 'text/csv'});
                        const formData = new FormData();
                        formData.append('archivo_excel', csvBlob, 'convertido.csv');
                        fetch('CargarBienesExcel', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.text())
                        .then(data => {
                            alert('Carga masiva finalizada. Si hubo errores, revisa los mensajes en la página.');
                            location.reload();
                        })
                        .catch(err => alert('Error al subir el archivo Excel.'));
                    };
                    reader.readAsArrayBuffer(archivo);
                    return;
                }

                alert('Formato de archivo no soportado. Usa .csv o .xlsx');
            });
        }
    });
    </script>
</body>
</html>
