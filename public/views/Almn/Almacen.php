<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Operaciones - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in-right {
            animation: slideInRight 0.4s ease-out;
        }
        @keyframes pulseButton {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .animate-pulse-button {
            animation: pulseButton 1.2s infinite;
        }
        @keyframes fadeInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100">
<div class="flex">
    <?php include __DIR__ . '/barra.php'; ?>

    <main class="flex-1 p-6 ml-64 overflow-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-semibold text-[#39A900]">¡Bienvenido, Almacén!</h2>
                <p class="text-gray-600" id="fechaHora"></p>
            </div>
            <div>
                <button id="notifBtn" class="relative animate-pulse-button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C8.67 6.165 8 7.388 8 8.75V14.16c0 .538-.214 1.055-.595 1.435L6 17h5m4 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span id="notifCount" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">3</span>
                </button>
            </div>
        </div>

        <!-- Panel resumen -->
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-700 text-sm">Elementos en Inventario</h3>
                <p class="text-2xl font-bold text-[#39A900]">1,250</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-700 text-sm">Casos Pendientes</h3>
                <p class="text-2xl font-bold text-yellow-500">5</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-700 text-sm">Elementos en Revisión</h3>
                <p class="text-2xl font-bold text-orange-400">8</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-gray-700 text-sm">Reposiciones Realizadas</h3>
                <p class="text-2xl font-bold text-blue-500">12</p>
            </div>
        </div>

        <!-- Accesos directos -->
        <div class="grid grid-cols-3 gap-4 mb-8">
            <button class="bg-[#39A900] text-white p-6 rounded-lg shadow hover:bg-green-700">Cambio en el inventario</button>
            <button class="bg-[#39A900] text-white p-6 rounded-lg shadow hover:bg-green-700">Consultar Historial</button>
            <button class="bg-[#39A900] text-white p-6 rounded-lg shadow hover:bg-green-700">Generar Reporte PDF</button>
        </div>

        <!-- Actividades recientes con diseño animado y color adicional -->
        <div class="bg-white p-6 shadow rounded-md">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Reemplazos Recientes</h3>
            <div class="grid gap-4">
                <div class="flex items-center bg-gray-100 p-4 rounded-lg shadow hover:bg-[#f3eaff] transition animate-fade-in-up">
                    <div class="w-12 h-12 bg-[#71277A] text-white flex items-center justify-center rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm2 2h12v12H6V6z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">Reemplazo de monitor en Ambiente 104</p>
                        <p class="text-sm text-gray-500">19/03/2025 - por Felipe M.</p>
                    </div>
                </div>
                <div class="flex items-center bg-gray-100 p-4 rounded-lg shadow hover:bg-[#e0f7ff] transition animate-fade-in-up">
                    <div class="w-12 h-12 bg-[#00304D] text-white flex items-center justify-center rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm2 2h12v12H6V6z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">Reemplazo de CPU en Ambiente 301</p>
                        <p class="text-sm text-gray-500">20/03/2025 - por Kevin C.</p>
                    </div>
                </div>
                <div class="flex items-center bg-gray-100 p-4 rounded-lg shadow hover:bg-[#f3eaff] transition animate-fade-in-up">
                    <div class="w-12 h-12 bg-[#71277A] text-white flex items-center justify-center rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm2 2h12v12H6V6z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">Reemplazo de impresora en Ambiente 205</p>
                        <p class="text-sm text-gray-500">18/03/2025 - por Steven V.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal notificaciones con animación -->
        <div id="notifModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-xl w-[450px] animate-slide-in-right">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">Notificaciones</h3>
                    <button onclick="closeNotif()" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <ul class="space-y-4 max-h-60 overflow-y-auto">
                    <li class="bg-gray-100 p-3 rounded-lg shadow-sm flex justify-between items-center">
                        <div>
                            <p class="text-gray-700 font-medium">Ambiente 104:</p>
                            <span class="text-gray-600 text-sm">Solicitud cambio de monitor — <span class="text-yellow-500 font-semibold">Pendiente</span></span>
                        </div>
                        <button class="bg-[#00304D] text-white px-3 py-1 rounded hover:opacity-90 text-sm">Ir</button>
                    </li>
                    <li class="bg-gray-100 p-3 rounded-lg shadow-sm flex justify-between items-center">
                        <div>
                            <p class="text-gray-700 font-medium">Ambiente 205:</p>
                            <span class="text-gray-600 text-sm">Ajuste de impresora — <span class="text-yellow-500 font-semibold">Pendiente</span></span>
                        </div>
                        <button class="bg-[#00304D] text-white px-3 py-1 rounded hover:opacity-90 text-sm">Ir</button>
                    </li>
                    <li class="bg-gray-100 p-3 rounded-lg shadow-sm flex justify-between items-center">
                        <div>
                            <p class="text-gray-700 font-medium">Ambiente 301:</p>
                            <span class="text-gray-600 text-sm">Cambio de CPU — <span class="text-yellow-500 font-semibold">Pendiente</span></span>
                        </div>
                        <button class="bg-[#00304D] text-white px-3 py-1 rounded hover:opacity-90 text-sm">Ir</button>
                    </li>
                </ul>
                <button onclick="closeNotif()" class="mt-6 bg-[#39A900] text-white px-4 py-2 rounded-lg hover:bg-green-700 w-full transition">Cerrar</button>
            </div>
        </div>

    </main>
</div>

<script>
    function actualizarFechaHora() {
        const ahora = new Date();
        const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };
        document.getElementById('fechaHora').textContent = ahora.toLocaleDateString('es-ES', opciones);
    }
    setInterval(actualizarFechaHora, 1000);
    actualizarFechaHora();

    const notifBtn = document.getElementById('notifBtn');
    const notifModal = document.getElementById('notifModal');
    notifBtn.addEventListener('click', () => {
        notifModal.classList.remove('hidden');
    });
    function closeNotif() {
        notifModal.classList.add('hidden');
    }
</script>
</body>
</html>
