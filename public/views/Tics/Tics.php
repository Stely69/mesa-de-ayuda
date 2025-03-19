<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de TICS - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-[#39A900]">Panel de TICS</h1>
        <div>
            <a href="#" class="text-[#39A900] hover:underline mr-4">Volver a Inicio</a>
            <?php if (isset($_SESSION["user_cedula"])): ?>
                <span class="text-gray-500">Bienvenido, <?php echo $_SESSION["nombre"]; ?></span>
            <?php endif; ?>
            <a href="../Login/LogoutAction" class="text-red-500 hover:underline">Cerrar Sesión</a>
        </div>
    </header>
    
    <div class="flex h-screen">
        <!-- Barra lateral fija -->
        <aside class="w-64 bg-[#39A900] text-white flex flex-col p-4 fixed h-screen">
            <h1 class="text-2xl font-bold mb-6">Admin TICS</h1>
            <nav class="flex flex-col space-y-4">
            <button onclick="cargarSeccion('pendientes.php')" class="p-2 bg-white text-[#39A900] rounded-md">Pendientes</button>

                <button onclick="cargarSeccion('reportes.php')" class="p-2 bg-white text-[#39A900] rounded-md">Reportes</button>
            </nav>
        </aside>
        
        <!-- Contenido principal -->
        <main class="flex-1 p-6 ml-64 overflow-auto">
            <h2 class="text-3xl font-semibold text-[#39A900] mb-4">Reportes de Problemas</h2>
            
            <!-- Filtros -->
            <div class="bg-white p-4 shadow rounded-md mb-4">
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Filtrar Reportes</h3>
                <div class="flex space-x-4">
                    <select id="filtroAmbiente" class="p-2 border rounded-md">
                        <option value="">Todos los Ambientes</option>
                        <option value="Aula 101">Aula 101</option>
                        <option value="Aula 102">Aula 102</option>
                        <option value="Aula 103">Aula 103</option>
                    </select>
                    <select id="filtroEstado" class="p-2 border rounded-md">
                        <option value="">Todos los Estados</option>
                        <option value="Bueno">Bueno</option>
                        <option value="Falla">Falla</option>
                        <option value="Desaparecido">Desaparecido</option>
                    </select>
                    <button onclick="filtrarReportes()" class="bg-[#39A900] text-white p-2 rounded-md">Aplicar Filtro</button>
                </div>
            </div>
            
            <!-- Tabla de reportes -->
            <div class="bg-white p-4 shadow rounded-md">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Historial de Reportes</h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 border">Elemento</th>
                            <th class="p-2 border">Estado</th>
                            <th class="p-2 border">Encargado</th>
                            <th class="p-2 border">Ambiente</th>
                            <th class="p-2 border">Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="tablaReportes">
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <tr class="bg-gray-100">
                                <td class="p-2 border">Equipo <?php echo $i; ?></td>
                                <td class="p-2 border text-yellow-500">Falla</td>
                                <td class="p-2 border">Instructor <?php echo $i; ?></td>
                                <td class="p-2 border">Aula 10<?php echo $i % 3; ?></td>
                                <td class="p-2 border">2025-03-14</td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <script>
        function filtrarReportes() {
            let ambiente = document.getElementById("filtroAmbiente").value;
            let estado = document.getElementById("filtroEstado").value;
            let filas = document.querySelectorAll("#tablaReportes tr");
            
            filas.forEach(fila => {
                let ambienteFila = fila.cells[3].innerText;
                let estadoFila = fila.cells[1].innerText;
                
                if ((ambiente === "" || ambienteFila === ambiente) && (estado === "" || estadoFila === estado)) {
                    fila.style.display = "table-row";
                } else {
                    fila.style.display = "none";
                }
            });
        }
    </script>

    <script>
        function cargarSeccion(url) {
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al cargar la sección');
                    }
                    return response.text();
                })
                .then(data => {
                    document.querySelector("main").innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.querySelector("main").innerHTML = "<p class='text-red-500'>No se pudo cargar la sección.</p>";
                });
        }
    </script>

</body>
</html>