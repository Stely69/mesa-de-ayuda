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
        <?php
    include __DIR__ . '/barra.php';
    ?>
        
        <!-- Contenido principal -->
        <main class="flex-1 p-6 ml-64 overflow-auto">
            <h2 class="text-3xl font-semibold text-[#39A900] mb-4">Historial de Cambios</h2>
            
            <!-- Filtros -->
            <div class="bg-white p-4 shadow rounded-md mb-4">
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Filtrar Historial</h3>
                <div class="flex space-x-4">
                    <select id="filtroAmbiente" class="p-2 border rounded-md">
                        <option value="">Todos los Ambientes</option>
                        <option value="Aula 101">Aula 101</option>
                        <option value="Aula 102">Aula 102</option>
                        <option value="Aula 103">Aula 103</option>
                    </select>
                    <select id="filtroEstado" class="p-2 border rounded-md">
                        <option value="">Todos los Estados</option>
                        <option value="Agregado">Agregado</option>
                        <option value="Eliminado">Eliminado</option>
                        <option value="Modificado">Modificado</option>
                    </select>
                    <button onclick="filtrarHistorial()" class="bg-[#39A900] text-white p-2 rounded-md">Aplicar Filtro</button>
                </div>
            </div>
            
            <!-- Tabla de historial -->
            <div class="bg-white p-4 shadow rounded-md">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Historial de Cambios</h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 border">Elemento</th>
                            <th class="p-2 border">Estado</th>
                            <th class="p-2 border">Ambiente</th>
                            <th class="p-2 border">Fecha</th>
                            <th class="p-2 border">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaHistorial">
                        <tr class="bg-gray-100">
                            <td class="p-2 border">Laptop Dell</td>
                            <td class="p-2 border text-green-500">Agregado</td>
                            <td class="p-2 border">Aula 101</td>
                            <td class="p-2 border">2025-03-14</td>
                            <td class="p-2 border"><button class="bg-blue-500 text-white px-3 py-1 rounded-md">Ver más detalles</button></td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td class="p-2 border">Proyector Epson</td>
                            <td class="p-2 border text-red-500">Eliminado</td>
                            <td class="p-2 border">Aula 102</td>
                            <td class="p-2 border">2025-03-14</td>
                            <td class="p-2 border"><button class="bg-blue-500 text-white px-3 py-1 rounded-md">Ver más detalles</button></td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td class="p-2 border">Pantalla LED</td>
                            <td class="p-2 border text-yellow-500">Modificado</td>
                            <td class="p-2 border">Aula 103</td>
                            <td class="p-2 border">2025-03-13</td>
                            <td class="p-2 border"><button class="bg-blue-500 text-white px-3 py-1 rounded-md">Ver más detalles</button></td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td class="p-2 border">Silla Ergonómica</td>
                            <td class="p-2 border text-green-500">Agregado</td>
                            <td class="p-2 border">Aula 101</td>
                            <td class="p-2 border">2025-03-12</td>
                            <td class="p-2 border"><button class="bg-blue-500 text-white px-3 py-1 rounded-md">Ver más detalles</button></td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td class="p-2 border">Laptop HP</td>
                            <td class="p-2 border text-red-500">Eliminado</td>
                            <td class="p-2 border">Aula 102</td>
                            <td class="p-2 border">2025-03-10</td>
                            <td class="p-2 border"><button class="bg-blue-500 text-white px-3 py-1 rounded-md">Ver más detalles</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll(".nav-link");
            const currentPath = window.location.pathname.split("/").pop();

            links.forEach(link => {
                const linkPath = link.getAttribute("href").split("/").pop();

                if (linkPath === currentPath) {
                    link.classList.add("bg-white", "text-[#39A900]", "font-bold");
                    link.classList.remove("hover:bg-white", "hover:text-[#39A900]");
                } else {
                    link.classList.remove("bg-white", "text-[#39A900]", "font-bold");
                    link.classList.add("hover:bg-white", "hover:text-[#39A900]");
                }
            });
        });

        function filtrarHistorial() {
            let ambiente = document.getElementById("filtroAmbiente").value;
            let estado = document.getElementById("filtroEstado").value;
            let filas = document.querySelectorAll("#tablaHistorial tr");
            
            filas.forEach(fila => {
                let ambienteFila = fila.cells[2].innerText;
                let estadoFila = fila.cells[1].innerText;
                
                if ((ambiente === "" || ambienteFila === ambiente) && (estado === "" || estadoFila === estado)) {
                    fila.style.display = "table-row";
                } else {
                    fila.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>
