<?php 
    // Dirección de los archivos de configuración y controladores
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    require_once __DIR__ . '../../../../Controller/ProductoController.php';
    require_once __DIR__ . '../../../../Controller/UserController.php';
    // Instanciar los controladores
    $casos = new CasoController();
    $productos = new ProductoController();
    $usuarios = new UserController();
    // Consultas a la base de datos
    $listadecasos = $casos->getCasos();
    $productos = $productos->mostrarProductos();
    $contadorcasos = $casos->mostarcasos();
    $totaluser = $usuarios->mostarusuaruio();
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - GEDAC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!--Colores personalizadas-->
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
<body class="bg-gray-100 text-gray-900">
    <!-- Contenedor principal -->
    <div class="flex h-screen">
        <!-- Botón hamburguesa -->
        <button id="menuBtn" class="md:hidden p-4 absolute z-20 text-senaGreen ">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        
        <!-- Incluir el archivo barra.php -->
        <?php include 'barra.php'; ?>
        
        <!-- Contenido principal -->
        <main class="flex-1 p-6 md:ml-15 mt-16 md:mt-0 overflow-auto">
    <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
        <div>
            <h2 class="text-3xl font-semibold text-[#39A900]">¡Bienvenido, Admin!</h2>
            <p class="text-gray-600" id="fechaHora"></p>
        </div>
    </div>
    
    <!-- Tarjetas -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div class="p-4 bg-white shadow rounded-md">
            <h3 class="text-lg text-gray-700">Equipos Registrados</h3>
            <p class="text-2xl font-bold text-senaGreen"><?php echo $productos; ?></p>
        </div>
        <div class="p-4 bg-white shadow rounded-md">
            <h3 class="text-lg text-gray-700">Equipos en Falla</h3>
            <p class="text-2xl font-bold text-red-500"><?php echo $contadorcasos; ?></p>
        </div>
        <div class="p-4 bg-white shadow rounded-md">
            <h3 class="text-lg text-gray-700">Usuarios Activos</h3>
            <p class="text-2xl font-bold text-senaGreen"><?php echo $totaluser; ?></p>
        </div>
    </div>
            <!-- Tabla de movimientos -->
            <div class="mt-8 bg-white p-4 shadow rounded-md">
                <h3 class="text-xl text-gray-700 mb-4">Últimos Movimientos</h3>
                <div class="overflow-x-auto">
                    <?php
                    // Paginación
                    $itemsPorPagina = 10;
                    $totalItems = count($listadecasos);
                    $totalPaginas = ceil($totalItems / $itemsPorPagina);
                    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    $inicio = ($paginaActual - 1) * $itemsPorPagina;
                    $casosPaginados = array_slice($listadecasos, $inicio, $itemsPorPagina);
                    ?>
                    <table class="w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-2 border">Fecha</th>
                                <th class="p-2 border">Equipo</th>
                                <th class="p-2 border">Ubicación</th>
                                <th class="p-2 border">Estado</th>
                                <th class="p-2 border">Reportado por</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($casosPaginados as $caso): ?>
                                <tr>
                                    <td class="p-2 border"><?= $caso['fecha_creacion'] ?></td>
                                    <td class="p-2 border"><?= $caso['producto'] ?></td>
                                    <td class="p-2 border"><?= $caso['ambiente'] ?></td>
                                    <td class="p-2 border font-semibold 
                                        <?= $caso['estados_casos'] === 'Resuelto' ? 'text-green-600' : 'text-red-600'; ?>">
                                        <?= htmlspecialchars($caso['estados_casos']) ?>
                                    </td>
                                    <td class="p-2 border"><?= $caso['usuario'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <div class="mt-4 flex justify-center">
                        <?php if ($paginaActual > 1): ?>
                            <a href="?pagina=<?= $paginaActual - 1 ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Anterior</a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <a href="?pagina=<?= $i ?>" class="px-4 py-2 mx-1 <?= $i === $paginaActual ? 'bg-senaGreen text-white' : 'bg-gray-200 text-gray-700' ?> rounded hover:bg-gray-300"><?= $i ?></a>
                        <?php endfor; ?>
                        <?php if ($paginaActual < $totalPaginas): ?>
                            <a href="?pagina=<?= $paginaActual + 1 ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Siguiente</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Reportes -->
            <div class="mt-8 bg-white p-4 shadow rounded-md">
                <h3 class="text-xl text-gray-700 mb-4">Reportes Generados</h3>
                <button onclick="exportToExcel()" class="mb-4 px-4 py-2 bg-senaGreen text-white rounded hover:bg-senaGreenDark">
                    Descargar Excel
                </button>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="p-4 bg-gray-50 border-l-4 border-senaGreen shadow rounded-md">
                        <h4 class="text-lg font-semibold">Reporte de Inventario</h4>
                        <p class="text-gray-600">Última actualización: 02/03/2025</p>
                        <p class="mt-2">Se han registrado 150 nuevos equipos este mes. Reportado por: Almacén.</p>
                    </div>
                    <div class="p-4 bg-gray-50 border-l-4 border-senaGreen shadow rounded-md">
                        <h4 class="text-lg font-semibold">Reporte de Usuarios</h4>
                        <p class="text-gray-600">Última actualización: 01/03/2025</p>
                        <p class="mt-2">Se han registrado 50 nuevos usuarios. Reportado por: Administrador.</p>
                    </div>
                    <div class="p-4 bg-gray-50 border-l-4 border-senaGreen shadow rounded-md">
                        <h4 class="text-lg font-semibold">Reporte de Mantenimiento</h4>
                        <p class="text-gray-600">Última actualización: 28/02/2025</p>
                        <p class="mt-2">30 equipos han sido reparados este mes. Reportado por: Servicio Técnico.</p>
                    </div>
                    <div class="p-4 bg-gray-50 border-l-4 border-senaGreen shadow rounded-md">
                        <h4 class="text-lg font-semibold">Reporte de Uso</h4>
                        <p class="text-gray-600">Última actualización: 27/02/2025</p>
                        <p class="mt-2">Los laboratorios han sido utilizados un 80% del tiempo disponible. Reportado por: Instructores.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const closeBtn = document.getElementById('closeSidebar');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        closeBtn.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });
    </script>

    <script>
        // Mostrar la fecha y hora actual
    function actualizarFechaHora() {
        const ahora = new Date();
        const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const fecha = ahora.toLocaleDateString('es-ES', opciones);
        const hora = ahora.toLocaleTimeString('es-ES');
        document.getElementById('fechaHora').textContent = `${fecha}, ${hora}`;
    }

    actualizarFechaHora();
    setInterval(actualizarFechaHora, 1000); // Actualiza cada segundo
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
</body>
</html>
