<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Operaciones - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-[#39A900]">Sistema de Registro</h1>
        <div class="flex space-x-4">
        <a href="../inicio.php" class="bg-blue-500 text-white px-4 py-2 rounded-md">Inicio</a>
        <select class="p-2 border rounded-md text-gray-700">
                <option>Seleccionar Rol</option>
                <option>Instructor</option>
                <option>Aprendiz</option>
                <option>Administrador</option>
            </select>
        </div>
    </header>
    
    <div class="flex h-screen">
        <aside class="w-64 bg-[#39A900] text-white flex flex-col p-4 fixed h-screen">
            <h1 class="text-2xl font-bold mb-6">Operaciones</h1>
            <nav class="flex flex-col space-y-4">
                <a href="#" class="p-2 bg-white text-[#39A900] rounded-md">Escanear Código</a>
                <a href="#" class="p-2 hover:bg-white hover:text-[#39A900] rounded-md">Historial</a>
                <a href="#" class="p-2 hover:bg-white hover:text-[#39A900] rounded-md">Reportes</a>
                <a href="#" class="p-2 hover:bg-white hover:text-[#39A900] rounded-md">Configuración</a>
            </nav>
        </aside>
        
        <main class="flex-1 p-6 ml-64 overflow-auto">
            <h2 class="text-3xl font-semibold text-[#39A900] mb-4">Dashboard de Registro</h2>
            
            <div class="grid grid-cols-3 gap-6">
                <div class="p-6 bg-white shadow rounded-md flex flex-col items-center">
                    <h3 class="text-lg text-gray-700 mb-4">Escanear Código</h3>
                    <button class="bg-[#39A900] text-white px-6 py-2 rounded-md">Escanear</button>
                </div>
                <div class="p-6 bg-white shadow rounded-md">
                    <h3 class="text-lg text-gray-700">Últimos Escaneos</h3>
                    <ul class="mt-2 text-gray-600">
                        <li>✔ Laptop Dell - 10:30 AM</li>
                        <li>✔ Proyector Epson - 9:50 AM</li>
                        <li>❌ Impresora HP - 9:30 AM</li>
                    </ul>
                </div>
                <div class="p-6 bg-white shadow rounded-md">
                    <h3 class="text-lg text-gray-700">Estado de Equipos</h3>
                    <p class="text-[#39A900] font-bold">Operativos: 95%</p>
                    <p class="text-red-500 font-bold">Dañados: 5%</p>
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-2 gap-6">
                <div class="p-6 bg-white shadow rounded-md">
                    <h3 class="text-lg text-gray-700">Reportes</h3>
                    <button onclick="openModal('falla')" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-md">Reportar Falla</button>
                    <button onclick="openModal('faltante')" class="mt-4 ml-2 bg-yellow-500 text-white px-4 py-2 rounded-md">Reportar Faltante</button>
                </div>
                <div class="p-6 bg-white shadow rounded-md">
                    <h3 class="text-lg text-gray-700">Gráfico de Uso</h3>
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
        function openModal(type) {
            document.getElementById('modal-title').innerText = type === 'falla' ? 'Reportar Falla' : 'Reportar Faltante';
            document.getElementById('modal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</body>
</html>