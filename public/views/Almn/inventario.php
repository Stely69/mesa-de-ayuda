<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Operaciones - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Barra lateral fija -->
        <?php include __DIR__ . '/barra.php'; ?>
        
        <!-- Contenido principal con margen izquierdo -->
        <main class="flex-1 p-6 ml-64 overflow-auto">
            <h2 class="text-3xl font-semibold text-[#39A900] mb-6">Inventario</h2>
            
            <div class="grid grid-cols-2 gap-6">
                <!-- Tarjeta de búsqueda por ambiente -->
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition-all">
                    <h3 class="text-xl font-bold text-[#39A900] mb-4">Buscar por Ambiente</h3>
                    <label for="ambiente" class="block text-gray-700 font-semibold mb-2">Selecciona un ambiente:</label>
                    <select id="ambiente" class="p-3 border rounded-md w-full bg-gray-100">
                        <option value="">-- Seleccionar --</option>
                        <option value="101">Ambiente 101</option>
                        <option value="102">Ambiente 102</option>
                        <option value="103">Ambiente 103</option>
                        <option value="104">Ambiente 104</option>
                        <option value="105">Ambiente 105</option>
                        <option value="106">Ambiente 106</option>
                        <option value="107">Ambiente 107</option>
                        <option value="108">Ambiente 108</option>
                        <option value="109">Ambiente 109</option>
                        <option value="110">Ambiente 110</option>
                    </select>
                    <button class="mt-4 bg-[#39A900] text-white px-4 py-2 rounded-md w-full font-bold hover:bg-green-700">Buscar</button>
                </div>
                
                <!-- Tarjeta de búsqueda por serial o número de placa -->
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition-all">
                    <h3 class="text-xl font-bold text-[#39A900] mb-4">Buscar por Serial / Placa</h3>
                    <label for="serial" class="block text-gray-700 font-semibold mb-2">Ingresa el número de serial o placa:</label>
                    <input type="text" id="serial" class="p-3 border rounded-md w-full bg-gray-100" placeholder="Ejemplo: 123456">
                    <button class="mt-4 bg-[#39A900] text-white px-4 py-2 rounded-md w-full font-bold hover:bg-green-700">Buscar</button>
                </div>
            </div>

            <div id="inventario" class="bg-white p-6 rounded-md shadow hidden mt-6">
                <h2 class="text-2xl font-semibold text-[#39A900] mb-4">Inventario del Ambiente <span id="num-ambiente"></span></h2>
                <div id="lista-inventario" class="grid grid-cols-3 gap-4"></div>
                <button class="mt-4 bg-[#39A900] text-white px-4 py-2 rounded-md w-full font-bold hover:bg-green-700">Inventario General del Ambiente</button>
            </div>

            <div class="flex justify-center mt-6">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition-all w-full max-w-md">
                    <h3 class="text-xl font-bold text-[#39A900] mb-4">Agregar Bienes</h3>
                    <p class="text-gray-700 mb-4">Puedes registrar nuevos bienes en el inventario.</p>
                    <button onclick="openModal()" class="block bg-[#39A900] text-white px-4 py-2 rounded-md text-center font-bold hover:bg-green-700 w-full">Agregar Bienes</button>
                </div>
            </div>


<!-- Modal responsive ancho -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 px-4">
    <div class="bg-white p-6 md:p-10 rounded-2xl shadow-2xl w-11/12 md:w-full max-w-2xl relative max-h-[90vh] overflow-y-auto transition-all duration-300 transform scale-95 opacity-0" id="modal-content">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-3xl font-bold">&times;</button>
        <h2 class="text-3xl font-bold text-[#39A900] mb-6 text-center">Agregar Bienes</h2>
        
        <form action="AddAction" method="POST" class="space-y-6">
            <div>
                <label for="ambiente" class="block text-base font-medium text-gray-700 mb-1">Ambiente:</label>
                <select id="ambiente" name="ambiente" required class="p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                    <option value="">Seleccione un ambiente</option>
                    <?php
                        require_once __DIR__ . '../../../../Controller/CasoController.php';
                        $controller = new CasoController();
                        $ambientes = $controller->allambientes();
                        foreach ($ambientes as $ambiente) {
                            echo "<option value='" . $ambiente['id'] . "'>" . $ambiente['nombre'] . "</option>";
                        }
                    ?>
                </select>
            </div>

            <div>
                <label for="clase" class="block text-base font-medium text-gray-700 mb-1">Marca:</label>
                <select id="clase" name="clase" required class="p-3 w-full border border-gray-300 rounded-md focus:ring-[#39A900] focus:border-[#39A900]">
                    <option value="">Seleccione un ambiente</option>
                    <?php
                        require_once __DIR__ . '../../../../Controller/CasoController.php';
                        $controller = new CasoController();
                        $marcas = $controller->allmarcas();
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
        </main>
    </div>
    
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
    </script>
</body>
</html>
