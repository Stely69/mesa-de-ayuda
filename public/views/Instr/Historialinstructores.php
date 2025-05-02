<?php
require_once __DIR__ . '../../../../Controller/CasoController.php';
session_start();
$UserCasoController = new CasoController();
$userId = isset($_GET['id']) ? $_GET['id'] : null;

$HistorialUser = $UserCasoController->getCaso($userId);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Operaciones - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row">
        <!-- Barra lateral fija -->
        <?php include __DIR__ . '/barra.php'; ?>

        <!-- Contenido principal -->
        <main class="flex-1 p-4 sm:p-10 md:ml-64 min-h-screen bg-gradient-to-br from-white to-[#f9f9f9]">

    <div class="max-w-6xl mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-gray-200">
        <!-- Título -->
        <h2 class="text-3xl font-bold text-[#00304D] mb-8 text-center">📁 Historial de Casos</h2>

        <!-- Filtros -->
        <div class="bg-white p-6 mb-8 rounded-xl shadow border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">🔎 Filtrar Historial</h3>
            <div class="flex flex-col md:flex-row md:space-x-6 space-y-4 md:space-y-0">
                <select id="filtroEstado" class="p-3 border border-gray-300 rounded-xl w-full md:w-auto focus:ring-[#007832] focus:outline-none">
                    <option value="">Todos los Estados</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="En Proceso">En Proceso</option>
                    <option value="Cerrado">Cerrado</option>
                </select>
                <input type="date" id="filtroFecha" class="p-3 border border-gray-300 rounded-xl w-full md:w-auto focus:ring-[#007832] focus:outline-none">
                <button type="submit" class="bg-[#007832] hover:bg-[#00304D] text-white px-6 py-3 rounded-2xl shadow-md hover:shadow-xl text-lg font-semibold transition-all duration-300 transform hover:-translate-y-1">
                    Aplicar Filtro
                </button>
            </div>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border border-gray-200 rounded-xl overflow-hidden">

                <thead class="bg-[#00304D] text-white">
                    <tr>
                        <th class="px-6 py-4">Título</th>
                        <th class="px-6 py-4">Descripción</th>
                        <th class="px-6 py-4">Ambiente</th>
                        <th class="px-6 py-4">N° Placa</th>
                        <th class="px-6 py-4">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">Pantalla LED</td>
                        <td class="px-6 py-4 text-gray-600">Pantalla con problemas de encendido</td>
                        <td class="px-6 py-4 text-gray-700">Ambiente 101</td>
                        <td class="px-6 py-4 text-gray-700">PL-9834</td>
                        <td class="px-6 py-4">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Pendiente</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">Proyector Epson</td>
                        <td class="px-6 py-4 text-gray-600">Lámpara fundida, requiere reemplazo</td>
                        <td class="px-6 py-4 text-gray-700">Ambiente 202</td>
                        <td class="px-6 py-4 text-gray-700">PL-4721</td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">En Proceso</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">Laptop Dell</td>
                        <td class="px-6 py-4 text-gray-600">Se reemplazó el disco duro</td>
                        <td class="px-6 py-4 text-gray-700">Ambiente 303</td>
                        <td class="px-6 py-4 text-gray-700">PL-1187</td>
                        <td class="px-6 py-4">
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Cerrado</span>
                        </td>
                    </tr>
                    <tr>
                        <?php 
                            foreach ($HistorialUser as $caso) {
                                // Procesar cada caso
                                $imagen = $caso['imagen'] ?? 'Imagen no disponible';
                                $auxiliar_id = $caso['auxiliar_id'] ?? 'No asignado';
                            
                                echo "<p>ID: {$caso['id']}, Imagen: {$imagen}, Auxiliar: {$auxiliar_id}</p>";
                            }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Controles de paginación -->
<div id="paginacion" class="mt-8 flex justify-center space-x-4 text-[#00304D] font-semibold"></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const filas = Array.from(document.querySelectorAll("#tablaHistorial tr"));
        const filasPorPagina = 5;
        const paginacion = document.getElementById("paginacion");
        let paginaActual = 1;

        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * filasPorPagina;
            const fin = inicio + filasPorPagina;

            filas.forEach((fila, index) => {
                fila.style.display = (index >= inicio && index < fin) ? "" : "none";
            });

            renderizarControles(pagina);
        }

        function renderizarControles(pagina) {
            const totalPaginas = Math.ceil(filas.length / filasPorPagina);
            paginacion.innerHTML = "";

            if (totalPaginas <= 1) return;

            // Botón Anterior
            if (pagina > 1) {
                const btnAnterior = document.createElement("button");
                btnAnterior.textContent = "Anterior";
                btnAnterior.className = botonEstilo();
                btnAnterior.onclick = () => mostrarPagina(pagina - 1);
                paginacion.appendChild(btnAnterior);
            }

            // Botones numerados
            for (let i = 1; i <= totalPaginas; i++) {
                const btn = document.createElement("button");
                btn.textContent = i;
                btn.className = botonEstilo(i === pagina);
                btn.onclick = () => mostrarPagina(i);
                paginacion.appendChild(btn);
            }

            // Botón Siguiente
            if (pagina < totalPaginas) {
                const btnSiguiente = document.createElement("button");
                btnSiguiente.textContent = "Siguiente";
                btnSiguiente.className = botonEstilo();
                btnSiguiente.onclick = () => mostrarPagina(pagina + 1);
                paginacion.appendChild(btnSiguiente);
            }
        }

        function botonEstilo(activo = false) {
            return `px-4 py-2 rounded-xl transition-all duration-300 shadow-md ${
                activo ? "bg-[#007832] text-white" : "bg-gray-200 hover:bg-gray-300"
            }`;
        }

        mostrarPagina(paginaActual);
    });
</script>

</main>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
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

        function filtrarHistorial() {
            let estado = document.getElementById("filtroEstado").value;
            let fecha = document.getElementById("filtroFecha").value;
            let filas = document.querySelectorAll("#tablaHistorial tr");

            filas.forEach(fila => {
                let estadoFila = fila.cells[1].innerText;
                let fechaFila = fila.cells[2].innerText;

                if ((estado === "" || estadoFila.includes(estado)) && (fecha === "" || fechaFila === fecha)) {
                    fila.style.display = "table-row";
                } else {
                    fila.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>
