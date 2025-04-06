<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $casos = new CasoController();
    $listadecasos = $casos->getCasos();
    //var_dump($listadecasos);
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">    
    <div class="flex h-screen">
        <!-- Barra lateral fija -->
        <aside class="w-64 bg-[#39A900] text-white flex flex-col p-4 fixed h-screen">
            <h1 class="text-2xl font-bold mb-6">Admin SENA</h1>
            <nav class="flex flex-col space-y-4">
                <a href="../" class="p-2 hover:bg-white hover:text-[#39A900] rounded-md">Inicio</a>
                <a href="" class="p-2 bg-white text-[#39A900] rounded-md">Dashboard</a>
                <a href="GestiondeUsuarios" class="p-2 hover:bg-white hover:text-[#39A900] rounded-md"s>Gestión de Usuarios</a>
                <hr>
                <?php if (isset($_SESSION["id"])): ?>
                    <a href="../Perfi/perfil" class="p-2 hover:bg-white hover:text-[#39A900] rounded-md">Bienvenido, <?php echo $_SESSION["nombres"]; ?></a>
                <?php endif; ?>
                <a href="../Login/LogoutAction" class="p-2 hover:bg-white hover:text-[#39A900] rounded-md">Cerrar Sesión</a>
            </nav>

        </aside>
        
        <!-- Contenido principal con margen izquierdo -->
        <main class="flex-1 p-6 ml-64 overflow-auto">
            <h2 class="text-3xl font-semibold text-[#39A900] mb-4">Dashboard</h2>
            
            <!-- Tarjetas de métricas -->
            <div class="grid grid-cols-3 gap-6">
                <div class="p-4 bg-white shadow rounded-md">
                    <h3 class="text-lg text-gray-700">Equipos Registrados</h3>
                    <p class="text-2xl font-bold text-[#39A900]">1,200</p>
                </div>
                <div class="p-4 bg-white shadow rounded-md">
                    <h3 class="text-lg text-gray-700">Equipos en Falla</h3>
                    <p class="text-2xl font-bold text-red-500">45</p>
                </div>
                <div class="p-4 bg-white shadow rounded-md">
                    <h3 class="text-lg text-gray-700">Usuarios Activos</h3>
                    <p class="text-2xl font-bold text-[#39A900]">320</p>
                </div>
            </div>
            
            <!-- Tabla de últimos movimientos -->
            <div class="mt-6 bg-white p-4 shadow rounded-md">
                <h3 class="text-xl text-gray-700 mb-4">Últimos Movimientos</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">Fecha</th>
                            <th class="p-2 border">Equipo</th>
                            <th class="p-2 border">Ubicación</th>
                            <th class="p-2 border">Estado</th>
                            <th class="p-2 border">Reportado por</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($listadecasos as $caso): ?>
                            <tr>
                                <td class="p-2 border "><?=$caso['fecha_creacion'] ?></td>
                                <td class="p-2 border"><?=$caso['producto_id'] ?></td>
                                <td class="p-2 border"><?=$caso['ambiente_id'] ?></td>
                                <td class="p-2 border text-green-600"><?=$caso['estado_id'] ?></td>
                                <td class="p-2 border"><?=$caso['usuario_id'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>  

            <div class="mt-6 bg-white p-4 shadow rounded-md">
                <h3 class="text-xl text-gray-700 mb-4">Reportes Generados</h3>
                <button onclick="exportToExcel()" class="mb-4 px-4 py-2 bg-[#39A900] text-white rounded hover:bg-[#2f8800]">Descargar Excel</button>
                <div id="reportes" class="grid grid-cols-2 gap-6">
                    <div class="p-4 bg-gray-50 border-l-4 border-[#39A900] shadow rounded-md">
                        <h4 class="text-lg font-semibold">Reporte de Inventario</h4>
                        <p class="text-gray-600">Última actualización: 02/03/2025</p>
                        <p class="mt-2">Se han registrado 150 nuevos equipos este mes. Reportado por: Almacén.</p>
                    </div>
                    <div class="p-4 bg-gray-50 border-l-4 border-[#39A900] shadow rounded-md">
                        <h4 class="text-lg font-semibold">Reporte de Usuarios</h4>
                        <p class="text-gray-600">Última actualización: 01/03/2025</p>
                        <p class="mt-2">Se han registrado 50 nuevos usuarios en la plataforma. Reportado por: Administrador.</p>
                    </div>
                    <div class="p-4 bg-gray-50 border-l-4 border-[#39A900] shadow rounded-md">
                        <h4 class="text-lg font-semibold">Reporte de Mantenimiento</h4>
                        <p class="text-gray-600">Última actualización: 28/02/2025</p>
                        <p class="mt-2">30 equipos han sido reparados este mes. Reportado por: Servicio Técnico.</p>
                    </div>
                    <div class="p-4 bg-gray-50 border-l-4 border-[#39A900] shadow rounded-md">
                        <h4 class="text-lg font-semibold">Reporte de Uso</h4>
                        <p class="text-gray-600">Última actualización: 27/02/2025</p>
                        <p class="mt-2">Los laboratorios han sido utilizados un 80% del tiempo disponible. Reportado por: Instructores.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function exportToExcel() {
            let data = [
                ["Reporte", "Última actualización", "Detalle"],
                ["Inventario", "02/03/2025", "Se han registrado 150 nuevos equipos este mes. Reportado por: Almacén."],
                ["Usuarios", "01/03/2025", "Se han registrado 50 nuevos usuarios en la plataforma. Reportado por: Administrador."],
                ["Mantenimiento", "28/02/2025", "30 equipos han sido reparados este mes. Reportado por: Servicio Técnico."],
                ["Uso", "27/02/2025", "Los laboratorios han sido utilizados un 80% del tiempo disponible. Reportado por: Instructores."]
            ];
            let ws = XLSX.utils.aoa_to_sheet(data);
            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Reportes");
            XLSX.writeFile(wb, "reportes_sena.xlsx");
        }
    </script>

<script>
function cargarPagina(pagina) {
    fetch(pagina)  // Hace la petición AJAX
    .then(response => response.text())  // Convierte la respuesta a texto
    .then(data => {
        document.getElementById("contenido").innerHTML = data; // Inserta el contenido en <main>
    })
    .catch(error => console.error("Error al cargar la página:", error));
}
</script>

</body>
</html>
