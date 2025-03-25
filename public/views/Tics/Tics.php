<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $casos = new CasoController();
    $listadecasos = $casos->getCasos();
    //var_dump($listadecasos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Casos - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#39A900] text-white flex flex-col p-4 fixed h-screen">
            <h1 class="text-2xl font-bold mb-6">Operaciones</h1>
            <nav class="flex flex-col space-y-4">
                <a href="Almacen" class="nav-link p-2 bg-white text-[#39A900] rounded-md flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"></path>
                    </svg>
                    <span>Inicio</span>
                </a>
                <hr>
                <?php session_start(); ?>
                <?php if (isset($_SESSION["id"])): ?>
                    <a href="#" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md">Bienvenido, <?php echo $_SESSION["nombres"]; ?></a>
                <?php endif; ?>
                <a href="../Login/LogoutAction" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md">Cerrar Sesión</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 ml-64 overflow-auto">
            <h2 class="text-3xl font-semibold text-[#39A900] mb-6">Panel de Casos</h2>

            <!-- Listado de Casos -->
            <div class="bg-white p-8 rounded-2xl shadow-2xl border border-gray-200 mb-10">
                <h3 class="text-2xl font-bold text-[#39A900] mb-6">Listado de Casos</h3>
                <div class="overflow-x-auto rounded-xl">
                    <table class="min-w-full border border-gray-300 rounded-xl">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-3 px-5 text-left">Equipo</th>
                                <th class="py-3 px-5 text-left">Ubicación</th>
                                <th class="py-3 px-5 text-left">Descripción</th>
                                <th class="py-3 px-5 text-left">Estado</th>
                                <th class="py-3 px-5 text-center">Fecha</th>
                                <th class="py-3 px-5 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php    
                            if (!is_array($listadecasos) || empty($listadecasos)) {
                                echo "<tr><td colspan='5' class='text-center'>No hay casos registrados</td></tr>";
                            } else {
                                foreach ($listadecasos as $caso) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($caso['case_id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($caso['']) . "</td>";
                                    echo "<td>" . htmlspecialchars($caso['descripcion']) . "</td>";
                                    if ($caso["estado_id"] == "1") {
                                        echo "<td class='text-[#39A900]'>Pendiente</td>";
                                    } else {
                                        echo "<td class='text-[#39A900]'>Resuelto</td>";
                                    }
                                    echo "<td>". htmlspecialchars($caso["fecha_creacion"]) . "</td>";
                                    echo "<td class='text-center'>";
                                    echo "<button onclick='mostrarProcedimiento(\"" . htmlspecialchars($caso['descripcion']), htmlspecialchars($caso['asignado_a']) . "\")' class='px-4 py-2 bg-[#39A900] text-white rounded-xl font-bold shadow hover:bg-green-600 transition-all'>Ver</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Buscar por Ambiente -->
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-2xl transition-all mt-10">
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
                <div id="casosAmbiente" class="mt-4 hidden">
                    <table class="min-w-full bg-white border border-gray-300 rounded-md mt-4">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 border-b">Caso</th>
                                <th class="py-2 px-4 border-b">Ubicación</th>
                                <th class="py-2 px-4 border-b">Estado</th>
                                <th class="py-2 px-4 border-b">Fecha recibido</th>
                                <th class="py-2 px-4 border-b">Fecha resuelto</th>
                            </tr>
                        </thead>
                        <tbody id="listaCasosAmbiente"></tbody>
                    </table>
                </div>
                <div id="sinCasos" class="text-gray-500 mt-4 hidden">Sin casos para este ambiente.</div>
            </div>
        </main>
    </div>

    <!-- Notificaciones y Modal -->
    <div id="notificacion" class="fixed bottom-5 right-5 bg-green-500 text-white p-4 rounded-lg shadow-lg hidden">Caso enviado a servicio técnico.</div>
    <div id="modalProcedimiento" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md">
            <h3 class="text-xl font-bold text-[#39A900] mb-4">Procedimiento Realizado</h3>
            <p id="procedimientoTexto" class="text-gray-700"></p>
            <button onclick="cerrarProcedimiento()" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-xl font-bold shadow hover:bg-gray-700 transition-all">Cerrar</button>
        </div>
    </div>








  <!--  <script>
        const casosPorAmbiente = {
            101: [
                { caso: 'Cambio de monitor', estado: 'Pendiente', fechaRecibido: '2024-03-01', fechaResuelto: '-' },
                { caso: 'Cambio de teclado', estado: 'Cerrado', fechaRecibido: '2024-02-25', fechaResuelto: '2024-02-28' }
            ],
            102: [
                { caso: 'Cambio de CPU', estado: 'Cerrado', fechaRecibido: '2024-02-20', fechaResuelto: '2024-02-22' },
                { caso: 'Cambio de mouse', estado: 'Pendiente', fechaRecibido: '2024-03-02', fechaResuelto: '-' }
            ]
        };

        document.getElementById('ambiente').addEventListener('change', function() {
            const ambiente = this.value;
            const contenedor = document.getElementById('casosAmbiente');
            const lista = document.getElementById('listaCasosAmbiente');
            const sinCasos = document.getElementById('sinCasos');

            if (casosPorAmbiente[ambiente]) {
                lista.innerHTML = '';
                casosPorAmbiente[ambiente].forEach(caso => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="py-2 px-4 border-b">${caso.caso}</td>
                        <td class="py-2 px-4 border-b">Ambiente ${ambiente}</td>
                        <td class="py-2 px-4 border-b">${caso.estado}</td>
                        <td class="py-2 px-4 border-b">${caso.fechaRecibido}</td>
                        <td class="py-2 px-4 border-b">${caso.fechaResuelto}</td>
                    `;
                    lista.appendChild(row);
                });
                sinCasos.classList.add('hidden');
                contenedor.classList.remove('hidden');
            } else {
                lista.innerHTML = '';
                contenedor.classList.add('hidden');
                sinCasos.classList.remove('hidden');
            }
        });
        document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.getElementById('modalPendientes').classList.add('hidden');
    }
});
document.getElementById('modalPendientes').addEventListener('click', (e) => {
    if (e.target.id === 'modalPendientes') {
        e.target.classList.add('hidden');
    }
});

    </script>
-->
    <script>
        function mostrarProcedimiento(texto) {
            document.getElementById('procedimientoTexto').innerText = texto;
            document.getElementById('modalProcedimiento').classList.remove('hidden');
        }

        function cerrarProcedimiento() {
            document.getElementById('modalProcedimiento').classList.add('hidden');
        }

        function enviarNotificacion() {
            let notificacion = document.getElementById('notificacion');
            notificacion.classList.remove('hidden');
            setTimeout(() => notificacion.classList.add('hidden'), 3000);
        }
    </script>
    
</body>
</html>
