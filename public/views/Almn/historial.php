<?php
require_once __DIR__ . '../../../../Controller/CasoController.php';
$casoController = new CasoController();
$casos = $casoController->getCasosPorRol(4);
// Estadísticas rápidas
$total = count($casos);
$pendientes = count(array_filter($casos, fn($c) => $c['estados_casos'] === 'Pendiente'));
$enProceso = count(array_filter($casos, fn($c) => $c['estados_casos'] === 'En proceso'));
$resueltos = count(array_filter($casos, fn($c) => $c['estados_casos'] === 'Resuelto'));
$ambientes = array_unique(array_column($casos, 'ambiente'));
$estados = array_unique(array_column($casos, 'estados_casos'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Cambios - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="flex flex-col md:flex-row min-h-screen">
    <?php include __DIR__ . '/barra.php'; ?>
    <main class="flex-1 p-6 md:ml-64 overflow-auto pt-16">
        <!-- Encabezado -->
        <div class="flex items-center gap-3 mb-4">
            <svg class="w-10 h-10 text-[#39A900]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h2 class="text-3xl font-bold text-[#39A900]">Historial de Cambios</h2>
        </div>
        <!-- Tarjetas resumen -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center">
                <span class="text-2xl font-bold text-gray-700"><?= $total ?></span>
                <span class="text-gray-500">Total</span>
            </div>
            <div class="bg-green-100 shadow rounded-lg p-4 flex flex-col items-center">
                <span class="text-2xl font-bold text-green-700"><?= $pendientes ?></span>
                <span class="text-green-700">Pendientes</span>
            </div>
            <div class="bg-yellow-100 shadow rounded-lg p-4 flex flex-col items-center">
                <span class="text-2xl font-bold text-yellow-700"><?= $enProceso ?></span>
                <span class="text-yellow-700">En proceso</span>
            </div>
            <div class="bg-blue-100 shadow rounded-lg p-4 flex flex-col items-center">
                <span class="text-2xl font-bold text-blue-700"><?= $resueltos ?></span>
                <span class="text-blue-700">Resueltos</span>
            </div>
        </div>
        <!-- Filtros -->
        <div class="bg-white p-4 shadow rounded-md mb-4 flex flex-col md:flex-row md:items-center md:gap-4 gap-2">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6.414 6.414A1 1 0 0013 13.414V19a1 1 0 01-1.447.894l-2-1A1 1 0 019 18v-4.586a1 1 0 00-.293-.707L2.293 6.707A1 1 0 012 6V4z"/></svg>
                <select id="filtroAmbiente" class="p-2 border rounded-md">
                    <option value="">Todos los Ambientes</option>
                    <?php foreach ($ambientes as $amb): ?>
                        <option value="<?= htmlspecialchars($amb) ?>"><?= htmlspecialchars($amb) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <select id="filtroEstado" class="p-2 border rounded-md">
                    <option value="">Todos los Estados</option>
                    <?php foreach ($estados as $est): ?>
                        <option value="<?= htmlspecialchars($est) ?>"><?= htmlspecialchars($est) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button onclick="filtrarHistorial()" class="bg-[#39A900] text-white p-2 rounded-md flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Aplicar Filtro
            </button>
        </div>
        <!-- Tabla -->
        <div class="bg-white p-4 shadow rounded-md overflow-x-auto">
            <table class="w-full border-collapse min-w-max">
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
                </tbody>
            </table>
        </div>
        <!-- Paginación -->
        <div id="paginacion" class="flex justify-center items-center gap-2 mt-4 mb-6"></div>
        <!-- Botón Exportar a Excel -->
        <div class="flex justify-center mt-4 mb-6">
            <button id="btnExportarExcel" class="bg-green-600 hover:bg-green-800 text-white px-4 py-2 rounded shadow flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16v6M8 16v6M12 12v10M4 4h16v4H4V4z" /></svg>
                Exportar a Excel
            </button>
        </div>
        <!-- Modal Detalles -->
        <div id="modalDetalles" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg relative">
                <button onclick="cerrarModal()" class="absolute top-2 right-2 text-gray-400 hover:text-red-600 text-2xl">&times;</button>
                <h3 class="text-2xl font-bold mb-4 text-[#39A900] flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Detalles del Caso
                </h3>
                <div id="contenidoModal">
                    <div class="text-center text-gray-500">Cargando detalles...</div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    // Datos de casos en JS
    const casos = <?php echo json_encode($casos); ?>;
    const filasPorPagina = 10;
    let paginaActual = 1;
    let casosFiltrados = [...casos];

    function renderTabla() {
        const tbody = document.getElementById('tablaHistorial');
        tbody.innerHTML = '';
        if (casosFiltrados.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center py-4">No hay casos en inventario.</td></tr>`;
            document.getElementById('paginacion').innerHTML = '';
            return;
        }
        const inicio = (paginaActual - 1) * filasPorPagina;
        const fin = inicio + filasPorPagina;
        const paginaCasos = casosFiltrados.slice(inicio, fin);
        paginaCasos.forEach(caso => {
            let color = '';
            switch (caso.estados_casos) {
                case 'Cerrado': color = 'bg-green-100 text-green-800'; break;
                case 'Pendiente': color = 'bg-yellow-100 text-yellow-800'; break;
                case 'Resuelto': color = 'bg-blue-100 text-blue-800'; break;
                default: color = 'bg-gray-200 text-gray-700';
            }
            tbody.innerHTML += `
                <tr class="even:bg-gray-50 odd:bg-white">
                    <td class="p-2 border font-semibold text-gray-700">${caso.producto}</td>
                    <td class="p-2 border"><span class="px-2 py-1 rounded text-xs font-bold ${color}">${caso.estados_casos}</span></td>
                    <td class="p-2 border text-gray-600">${caso.ambiente}</td>
                    <td class="p-2 border text-gray-500 text-sm">${caso.fecha_creacion}</td>
                    <td class="p-2 border">
                        <button class="verDetallesBtn bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded flex items-center gap-1" data-id="${caso.id}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Ver más detalles
                        </button>
                    </td>
                </tr>
            `;
        });
        renderPaginacion();
        // Reasignar eventos a los botones de detalles
        document.querySelectorAll('.verDetallesBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                abrirModal(id);
            });
        });
    }
    function renderPaginacion() {
        const totalPaginas = Math.ceil(casosFiltrados.length / filasPorPagina);
        const pagDiv = document.getElementById('paginacion');
        pagDiv.innerHTML = '';
        if (totalPaginas <= 1) return;
        // Botón anterior
        pagDiv.innerHTML += `<button onclick="cambiarPagina(${paginaActual-1})" class="px-3 py-1 rounded ${paginaActual===1?'bg-gray-200 text-gray-400':'bg-white text-gray-700 hover:bg-gray-100'}">&lt;</button>`;
        // Números de página
        for (let i = 1; i <= totalPaginas; i++) {
            pagDiv.innerHTML += `<button onclick="cambiarPagina(${i})" class="px-3 py-1 rounded mx-1 ${paginaActual===i?'bg-[#39A900] text-white font-bold':'bg-white text-gray-700 hover:bg-gray-100'}">${i}</button>`;
        }
        // Botón siguiente
        pagDiv.innerHTML += `<button onclick="cambiarPagina(${paginaActual+1})" class="px-3 py-1 rounded ${paginaActual===totalPaginas?'bg-gray-200 text-gray-400':'bg-white text-gray-700 hover:bg-gray-100'}">&gt;</button>`;
    }
    function cambiarPagina(nuevaPag) {
        const totalPaginas = Math.ceil(casosFiltrados.length / filasPorPagina);
        if (nuevaPag < 1 || nuevaPag > totalPaginas) return;
        paginaActual = nuevaPag;
        renderTabla();
    }
    function filtrarHistorial() {
        let ambiente = document.getElementById("filtroAmbiente").value;
        let estado = document.getElementById("filtroEstado").value;
        casosFiltrados = casos.filter(caso => {
            return (ambiente === "" || caso.ambiente === ambiente) && (estado === "" || caso.estados_casos === estado);
        });
        paginaActual = 1;
        renderTabla();
    }
    function abrirModal(id) {
        const caso = casos.find(c => c.id == id);
        if (!caso) return;
        document.getElementById('modalDetalles').classList.remove('hidden');
        let color = '';
        switch (caso.estados_casos) {
            case 'Cerrado': color = 'bg-green-100 text-green-800'; break;
            case 'Pendiente': color = 'bg-yellow-100 text-yellow-800'; break;
            case 'Resuelto': color = 'bg-blue-100 text-blue-800'; break;
            default: color = 'bg-gray-200 text-gray-700';
        }
        let imagenHtml = '';
        if (caso.imagen && caso.imagen !== '') {
            imagenHtml = `<img src="/uploads/${caso.imagen}" alt="Imagen del caso" class="max-w-full max-h-60 rounded-lg border mx-auto">`;
        } else {
            imagenHtml = `<div class='text-red-600 font-semibold text-center'>No se subió ninguna imagen para este caso.</div>`;
        }
        document.getElementById('contenidoModal').innerHTML = `
            <div class='space-y-2'>
                <div class='flex justify-between items-center'>
                    <span class='font-bold text-lg'>Caso #${caso.id}</span>
                    <button onclick="generarPDF(${caso.id})" class="bg-red-600 hover:bg-red-800 text-white px-3 py-1 rounded flex items-center gap-1" title="Generar PDF">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        PDF
                    </button>
                </div>
                <div><span class='font-bold'>Fecha:</span> ${caso.fecha_creacion}</div>
                <div><span class='font-bold'>Ambiente:</span> ${caso.ambiente}</div>
                <div><span class='font-bold'>Elemento:</span> ${caso.producto}</div>
                <div><span class='font-bold'>Estado:</span> <span class="px-2 py-1 rounded text-xs font-bold ${color}">${caso.estados_casos}</span></div>
                <div class='mt-4'>${imagenHtml}</div>
            </div>
        `;
    }
    function generarPDF(id) {
        // Por ahora, usa window.print() para imprimir solo el modal
        const modal = document.getElementById('contenidoModal').innerHTML;
        const win = window.open('', '', 'width=800,height=600');
        win.document.write('<html><head><title>PDF Caso</title><link rel="stylesheet" href="https://cdn.tailwindcss.com"></head><body>' + modal + '</body></html>');
        win.document.close();
        win.print();
        win.close();
    }
    function cerrarModal() {
        document.getElementById('modalDetalles').classList.add('hidden');
    }
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('btnExportarExcel').addEventListener('click', function() {
            var wb = XLSX.utils.table_to_book(document.querySelector('table'), {sheet:"Historial"});
            XLSX.writeFile(wb, 'historial_almacen.xlsx');
        });
        renderTabla();
    });
</script>
</body>
</html>
