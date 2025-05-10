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
    // Paginado para la tabla de movimientos
    $casosPorPagina = 10;
    $totalCasos = count($listadecasos);
    $totalPaginas = ceil($totalCasos / $casosPorPagina);
    $paginaActual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
    $inicio = ($paginaActual - 1) * $casosPorPagina;
    $casosPagina = array_slice($listadecasos, $inicio, $casosPorPagina);
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
        </div>
    </div>
    
    <!-- Tarjetas -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"> 
    <!-- Equipos Registrados -->
    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-[#007832] animate-fade-in-up">
        <div class="flex items-center gap-4">
            <div class="bg-[#007832] p-3 rounded-full text-white">📦</div>
            <div>
                <h3 class="text-gray-700 text-base font-semibold">Bienes Registrados</h3>
                <p class="text-3xl font-bold text-[#007832] mt-1"><?php echo $productos; ?></p>
            </div>
        </div>
    </div>

    <!-- Equipos en Falla -->
    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-red-500 animate-fade-in-up delay-100">
        <div class="flex items-center gap-4">
            <div class="bg-red-500 p-3 rounded-full text-white">⚠️</div>
            <div>
                <h3 class="text-gray-700 text-base font-semibold">Equipos en Falla</h3>
                <p class="text-3xl font-bold text-red-500 mt-1"><?php echo $contadorcasos; ?></p>
            </div>
        </div>
    </div>

    <!-- Usuarios Activos -->
    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 border-l-4 border-[#39A900] animate-fade-in-up delay-200">
        <div class="flex items-center gap-4">
            <div class="bg-[#39A900] p-3 rounded-full text-white">👥</div>
            <div>
                <h3 class="text-gray-700 text-base font-semibold">Usuarios Activos</h3>
                <p class="text-3xl font-bold text-[#39A900] mt-1"><?php echo $totaluser; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de movimientos -->
<div class="mt-8 bg-white p-4 shadow rounded-md">
    <h3 class="text-xl text-gray-700 mb-4">Últimos Movimientos</h3>
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300">
            <thead>
                <tr class="bg-[#00304D] text-white">
                    <th class="p-2 border">Fecha</th>
                    <th class="p-2 border">Equipo</th>
                    <th class="p-2 border">Ubicación</th>
                    <th class="p-2 border">Estado</th>
                    <th class="p-2 border">Reportado por</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($casosPagina as $caso): ?>
                    <tr>
                        <td class="p-2 border"><?= $caso['fecha_creacion'] ?></td>
                        <td class="p-2 border"><?= $caso['clase_equipo'] ?></td>
                        <td class="p-2 border"><?= $caso['ambiente'] ?></td>
                        <td class="p-2 border">
                            <?php
                                $estado = strtolower($caso['estados_casos']);
                                $color = '';
                                $bg = '';
                                if ($estado === 'pendiente') {
                                    $color = 'text-red-700';
                                    $bg = 'bg-red-100';
                                } elseif ($estado === 'en proceso') {
                                    $color = 'text-yellow-800';
                                    $bg = 'bg-yellow-100';
                                } elseif ($estado === 'resuelto') {
                                    $color = 'text-green-700';
                                    $bg = 'bg-green-100';
                                } else {
                                    $color = 'text-gray-700';
                                    $bg = 'bg-gray-100';
                                }
                            ?>
                            <span class="px-4 py-1 rounded-full font-semibold text-sm <?= $color ?> <?= $bg ?>">
                                <?= ucfirst($caso['estados_casos']) ?>
                            </span>
                        </td>
                        <td class="p-2 border"><?= $caso['reportado_por'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <!-- Controles de paginado -->
    <div class="flex justify-center mt-4 gap-2">
        <?php if ($paginaActual > 1): ?>
            <a href="?pagina=<?= $paginaActual - 1 ?>" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Anterior</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?pagina=<?= $i ?>" class="px-3 py-1 rounded <?php if ($i == $paginaActual) echo 'bg-[#39A900] text-white font-bold'; else echo 'bg-gray-200 hover:bg-gray-300'; ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($paginaActual < $totalPaginas): ?>
            <a href="?pagina=<?= $paginaActual + 1 ?>" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Siguiente</a>
        <?php endif; ?>
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
