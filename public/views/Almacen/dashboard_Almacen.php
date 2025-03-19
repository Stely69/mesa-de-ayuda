<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Operaciones - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Barra lateral fija -->
        <?php include __DIR__ . '/barra.php'; ?>
        
        <!-- Contenido principal con margen izquierdo para que no se solape con la barra -->
        <main class="flex-1 p-6 ml-64 overflow-auto">
            <h2 class="text-3xl font-semibold text-[#39A900] mb-4">Dashboard de Almacenista</h2>
            
            <div class="grid grid-cols-3 gap-6">
                <!-- Novedades Pendientes -->
                <div class="p-6 bg-white shadow rounded-md">
                    <div class="flex items-center mb-4">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#39A900] mr-2"></span>
                        <h3 class="text-lg font-semibold text-gray-700">Novedades Pendientes</h3>
                    </div>
                    <div class="space-y-4">
                        <!-- Novedad 1 -->
                        <div class="p-4 bg-gray-100 border border-gray-300 rounded-md flex justify-between items-center">
                            <div>
                                <h4 class="text-gray-800 font-semibold text-sm">Proyector Epson</h4>
                                <p class="text-gray-600 text-xs">Ambiente 101 - Requiere Cambio</p>
                            </div>
                        </div>
                        <!-- Novedad 2 -->
                        <div class="p-4 bg-gray-100 border border-gray-300 rounded-md flex justify-between items-center">
                            <div>
                                <h4 class="text-gray-800 font-semibold text-sm">Laptop Dell</h4>
                                <p class="text-gray-600 text-xs">Ambiente 103 - Requiere Cambio</p>
                            </div>
                        </div>
                        <!-- Novedad 3 -->
                        <div class="p-4 bg-gray-100 border border-gray-300 rounded-md flex justify-between items-center">
                            <div>
                                <h4 class="text-gray-800 font-semibold text-sm">Impresora HP</h4>
                                <p class="text-gray-600 text-xs">Ambiente 105 - Requiere Cambio</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Últimas Modificaciones -->
                <div class="p-6 bg-white shadow rounded-md">
                    <div class="flex items-center mb-4">
                        <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 mr-2"></span>
                        <h3 class="text-lg font-semibold text-gray-700">Últimas Modificaciones</h3>
                    </div>
                    <div class="space-y-4">
                        <!-- Modificación 1 -->
                        <div class="p-4 bg-gray-100 border border-gray-300 rounded-md flex justify-between items-center">
                            <div>
                                <h4 class="text-gray-800 font-semibold text-sm">Mouse</h4>
                                <p class="text-gray-600 text-xs">Ambiente 102 - Modificado</p>
                            </div>
                        </div>
                        <!-- Modificación 2 -->
                        <div class="p-4 bg-gray-100 border border-gray-300 rounded-md flex justify-between items-center">
                            <div>
                                <h4 class="text-gray-800 font-semibold text-sm">Teclado</h4>
                                <p class="text-gray-600 text-xs">Ambiente 105 - Reemplazado</p>
                            </div>
                        </div>
                        <!-- Modificación 3 -->
                        <div class="p-4 bg-gray-100 border border-gray-300 rounded-md flex justify-between items-center">
                            <div>
                                <h4 class="text-gray-800 font-semibold text-sm">Pantalla</h4>
                                <p class="text-gray-600 text-xs">Ambiente 103 - Ajustada</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estado de Equipos con Gráfico -->
                <div class="p-6 bg-white shadow rounded-md">
                    <div class="flex items-center mb-4">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 mr-2"></span>
                        <h3 class="text-lg font-semibold text-gray-700">Estado de Equipos</h3>
                    </div>
                    <canvas id="estadoEquiposChart" class="w-full h-64"></canvas>
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-2 gap-6">
                <div class="p-6 bg-white shadow rounded-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Reportes</h3>
                    <button onclick="openModal('falla')" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-md">Reportar Falla</button>
                    <button onclick="openModal('faltante')" class="mt-4 ml-2 bg-yellow-500 text-white px-4 py-2 rounded-md">Reportar Faltante</button>
                </div>
                <div class="p-6 bg-white shadow rounded-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Gráfico de Uso</h3>
                    <p class="text-gray-600">Próximamente...</p>
                </div>
            </div>
        </main>
    </div>

    <div id="modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-md w-96">
            <h2 id="modal-title" class="text-xl font-semibold mb-4"></h2>
            <label class="block text-gray-700">Descripción:</label>
            <textarea class="w-full border p-2 rounded-md mt-2" rows="4"></textarea>
            <div class="mt-4 flex justify-end">
                <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancelar</button>
                <button class="bg-[#39A900] text-white px-4 py-2 rounded-md">Enviar</button>
            </div>
        </div>
    </div>

    <script>
    // Al cargar el documento
    document.addEventListener("DOMContentLoaded", function() {
        // Estado de Equipos Gráfico
        var ctx = document.getElementById('estadoEquiposChart').getContext('2d');
        var estadoEquiposChart = new Chart(ctx, {
            type: 'doughnut', // Tipo de gráfico
            data: {
                labels: ['Operativos', 'Dañados'], // Etiquetas
                datasets: [{
                    label: 'Estado de Equipos',
                    data: [95, 5], // Datos (Operativos: 95%, Dañados: 5%)
                    backgroundColor: ['#39A900', '#FF0000'], // Colores para cada categoría
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + '%'; // Mostrar porcentaje en tooltip
                            }
                        }
                    }
                }
            }
        });

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
    </script>

</body>
</html>
