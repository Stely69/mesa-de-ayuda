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
        <?php include __DIR__ . '/barra.php'; ?>

        <main class="flex-1 p-6 ml-64 overflow-auto">
            <h2 class="text-3xl font-semibold text-[#39A900] mb-6">Panel de Casos</h2>

            <div class="bg-white p-8 rounded-2xl shadow-2xl border border-gray-200 mb-10">
    <h3 class="text-2xl font-bold text-[#39A900] mb-6">Listado de Casos</h3>
    <div class="overflow-x-auto rounded-xl">
        <table class="min-w-full border border-gray-300 rounded-xl">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-3 px-5 text-left">Equipo</th>
                    <th class="py-3 px-5 text-left">Ubicación</th>
                    <th class="py-3 px-5 text-left">Descripción</th>
                    <th class="py-3 px-5 text-left">Serial</th>
                    <th class="py-3 px-5 text-left">Placa</th>
                    <th class="py-3 px-5 text-left">Fecha reporte</th>
                    <th class="py-3 px-5 text-left">Estado</th>
                    <th class="py-3 px-5 text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-red-50 hover:bg-red-100 transition-all">
                    <td class="py-3 px-5">Monitor</td>
                    <td class="py-3 px-5">Ambiente 101</td>
                    <td class="py-3 px-5">Pantalla dañada</td>
                    <td class="py-3 px-5">123456</td>
                    <td class="py-3 px-5">A001</td>
                    <td class="py-3 px-5">2025-03-10</td>
                    <td class="py-3 px-5 text-red-600 font-semibold">Pendiente</td>
                    <td class="py-3 px-5 text-center">
                        <a href="#" class="px-4 py-2 bg-red-500 text-white rounded-xl font-bold shadow hover:bg-red-600 transition-all">Ir</a>
                    </td>
                </tr>
                <tr class="bg-green-50 hover:bg-green-100 transition-all">
                    <td class="py-3 px-5">CPU</td>
                    <td class="py-3 px-5">Ambiente 102</td>
                    <td class="py-3 px-5">Reemplazo completo</td>
                    <td class="py-3 px-5">654321</td>
                    <td class="py-3 px-5">A004</td>
                    <td class="py-3 px-5">2025-03-05</td>
                    <td class="py-3 px-5 text-green-600 font-semibold">Cerrado</td>
                    <td class="py-3 px-5 text-center">
                        <a href="#" class="px-4 py-2 bg-green-500 text-white rounded-xl font-bold shadow hover:bg-green-600 transition-all">Ver</a>
                    </td>
                </tr>
                <tr class="bg-red-50 hover:bg-red-100 transition-all">
                    <td class="py-3 px-5">Silla</td>
                    <td class="py-3 px-5">Ambiente 105</td>
                    <td class="py-3 px-5">Rota</td>
                    <td class="py-3 px-5">No aplica</td>
                    <td class="py-3 px-5">A003</td>
                    <td class="py-3 px-5">2025-03-12</td>
                    <td class="py-3 px-5 text-red-600 font-semibold">Pendiente</td>
                    <td class="py-3 px-5 text-center">
                        <a href="#" class="px-4 py-2 bg-red-500 text-white rounded-xl font-bold shadow hover:bg-red-600 transition-all">Ir</a>
                    </td>
                </tr>
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
    <script>
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
</body>
</html>
