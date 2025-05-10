<?php
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    require_once __DIR__ . '../../../../Controller/UserController.php';
    session_start();

    $casos = new CasoController();
    $userController = new UserController();
    $Historial = $casos->getallcasos();
    $HistorialGenerales = $casos->getCasosGeneral();
    //var_dump($Historial);
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
        <main class="flex-1 p-6 md:ml-15 mt-16 md:mt-0 overflow-auto">

    <div class="max-w-6xl mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-gray-200">
        <!-- Título -->
        <h2 class="text-3xl font-bold text-[#00304D] mb-8 text-center">📁 Historial de Casos</h2>

        <!-- Tarjeta de Consultar caso -->
        <div class="max-w-6xl mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-gray-200 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Consultar caso</h3>
            <form id="form-consulta-caso" class="flex flex-col md:flex-row gap-4 items-center">
                <div>
                    <label for="tipo-caso" class="block text-sm font-medium text-gray-700 mb-1">Tipo de caso</label>
                    <select id="tipo-caso" name="tipo-caso" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#007832]">
                        <option value="normal">Caso normal</option>
                        <option value="general">Caso general</option>
                </select>
                </div>
                <div>
                    <label for="id-caso" class="block text-sm font-medium text-gray-700 mb-1">ID de caso</label>
                    <input type="number" id="id-caso" name="id-caso" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#007832]" min="1" required>
            </div>
                <button type="submit" class="bg-[#007832] text-white px-6 py-2 rounded font-semibold hover:bg-[#005f27] transition">Buscar</button>
            </form>
            <p id="consulta-error" class="text-red-600 mt-2 hidden"></p>
        </div>

        <!-- Tabla de Casos Específicos -->
        <div class="max-w-6xl mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-gray-200 mb-10">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Casos Específicos</h3>
        <!-- Paginación visual -->
            <div id="paginacion1" class="mb-4 flex justify-center items-center gap-2"></div>
        <!-- Tabla -->
        <div class="overflow-x-auto">
                <table id="tablaHistorial1" class="min-w-full max-w-6xl table-fixed text-sm text-left border border-gray-200 rounded-xl overflow-hidden">
                <thead class="bg-[#00304D] text-white">
                    <tr>
                        <th class="px-4 py-4 w-24">Caso</th>
                        <th class="px-4 py-4 w-56">Descripción</th>
                        <th class="px-4 py-4 w-32 truncate">Ambiente</th>
                        <th class="px-4 py-4 w-32 truncate">N° Placa</th>
                        <th class="px-4 py-4 w-28">Estado</th>
                        <th class="px-4 py-4 w-32 truncate">Reportado por</th>
                        <th class="px-4 py-4 w-40">Asignado a</th>
                        <th class="px-4 py-4 w-32">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    <?php foreach ($Historial as $caso): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-4 font-medium text-gray-800 w-24">Caso #<?= $caso['caso_id'] ?></td>
                            <td class="px-4 py-4 text-gray-600 w-56 whitespace-normal break-words"><?= htmlspecialchars($caso['descripcion_caso']) ?></td>
                            <td class="px-4 py-4 text-gray-700 w-32 truncate" title="<?= $caso['ambiente'] ?>"><?= $caso['ambiente'] ?></td>
                            <td class="px-4 py-4 text-gray-700 w-32 truncate" title="<?= htmlspecialchars($caso['producto']) ?>"><?= htmlspecialchars($caso['producto']) ?></td>
                            <td class="px-4 py-4 w-28">
                                <?php
                                    $estado = strtolower($caso['estado_actual']);
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
                                <span class="px-4 py-1 rounded-full font-semibold text-sm whitespace-nowrap <?= $color ?> <?= $bg ?>">
                                    <?= ucfirst($caso['estado_actual']) ?>
                                </span>
                            </td>
                                <td class="px-4 py-4 text-gray-700 w-32 truncate">
                                    <?php
                                        echo htmlspecialchars($caso['creado_por']);
                                    ?>
                                </td>
                            <td class="px-4 py-4 text-gray-700 w-40 whitespace-normal break-words"><?= htmlspecialchars($caso['asignado_a']) ?></td>
                            <td class="px-4 py-4 text-gray-700 w-32">
                                    <button onclick="mostrarModal1(<?= $caso['caso_id'] ?>)" class="text-blue-600 hover:text-blue-800">Ver Detalles</button>
                                <!-- Modal -->
                                    <div id="modal1-<?= $caso['caso_id'] ?>" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                                            <h3 class="text-xl font-semibold mb-4">Detalles del Caso Específico #<?= $caso['caso_id'] ?></h3>
                                        <p><strong>Descripción:</strong> <?= htmlspecialchars($caso['descripcion_caso']) ?></p>
                                        <p><strong>Ambiente:</strong> <?= $caso['ambiente'] ?></p>
                                        <p><strong>N° Placa:</strong> <?= htmlspecialchars($caso['producto']) ?></p>
                                        <p><strong>Estado:</strong> <?= $caso['estado_actual'] ?></p>
                                            <p><strong>Creado por:</strong> 
                                                <?php
                                                    echo htmlspecialchars($caso['creado_por']);
                                                ?>
                                            </p>
                                        <p><strong>Asignado a:</strong> <?= htmlspecialchars($caso['asignado_a']) ?></p>
                                        <p><strong>Fecha de Creación:</strong> <?= $caso['fecha_creacion'] ?></p>
                                        <?php if (!empty($caso['historial'])): ?>
                                            <div class="mt-4">
                                                <h4 class="font-semibold mb-2">Historial de Observaciones:</h4>
                                                <ul class="list-disc list-inside text-sm text-gray-700 space-y-1 max-h-40 overflow-y-auto pr-2">
                                                    <?php foreach ($caso['historial'] as $registro): ?>
                                                        <li>
                                                            <?= $registro['fecha_actualizacion'] ?> —
                                                                <?php
                                                                    $usuario = htmlspecialchars($registro['usuario']);
                                                                    $rol = isset($registro['rol_usuario']) ? ' (' . htmlspecialchars($registro['rol_usuario']) . ')' : '';
                                                                    $estadoAnterior = $registro['estado_anterior'];
                                                                    $estadoNuevo = $registro['estado_nuevo'];
                                                                    $observaciones = !empty($registro['observaciones']) ? '· <span class="italic">' . htmlspecialchars($registro['observaciones']) . '</span>' : '';
                                                                    if ($estadoAnterior !== $estadoNuevo) {
                                                                        echo "El usuario <strong>$usuario$rol</strong> cambió el estado del caso de <em>$estadoAnterior</em> a <em>$estadoNuevo</em> $observaciones";
                                                                    } else {
                                                                        echo "El usuario <strong>$usuario$rol</strong> tomó el caso $observaciones";
                                                                    }
                                                                ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php else: ?>
                                            <p class="mt-4 italic text-sm text-gray-500">Este caso no tiene historial aún.</p>
                                        <?php endif; ?>
                                        <div class="mt-4 flex justify-end">
                                                <button onclick="cerrarModal1(<?= $caso['caso_id'] ?>)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                                    </div>
                                </div>

        <!-- Tabla de Casos Generales -->
        <div class="max-w-6xl mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Casos Generales</h3>
            <!-- Paginación visual -->
            <div id="paginacion2" class="mb-4 flex justify-center items-center gap-2"></div>
            <!-- Tabla -->
            <div class="overflow-x-auto">
                <table id="tablaHistorial2" class="min-w-full max-w-6xl table-fixed text-sm text-left border border-gray-200 rounded-xl overflow-hidden">
                    <thead class="bg-[#00304D] text-white">
                        <tr>
                            <th class="px-4 py-4 w-24">Caso</th>
                            <th class="px-4 py-4 w-56">Descripción</th>
                            <th class="px-4 py-4 w-32 truncate">Ambiente</th>
                            <th class="px-4 py-4 w-32 whitespace-normal break-words">Asunto</th>
                            <th class="px-4 py-4 w-28">Estado</th>
                            <th class="px-4 py-4 w-32 truncate">Reportado por</th>
                            <th class="px-4 py-4 w-40">Asignado a</th>
                            <th class="px-4 py-4 w-32">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <?php foreach ($HistorialGenerales as $caso): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4 font-medium text-gray-800 w-24">Caso #<?= $caso['id'] ?></td>
                                <td class="px-4 py-4 text-gray-600 w-56 whitespace-normal break-words"><?= htmlspecialchars($caso['descripcion']) ?></td>
                                <td class="px-4 py-4 text-gray-700 w-32 truncate" title="<?= $caso['ambiente'] ?>"><?= $caso['ambiente'] ?></td>
                                <td class="px-4 py-4 text-gray-700 w-32 whitespace-normal break-words" title="<?= htmlspecialchars($caso['asunto']) ?>"><?= htmlspecialchars($caso['asunto']) ?></td>
                                <td class="px-4 py-4 w-28">
                                    <?php
                                        $estado = strtolower($caso['estado']);
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
                                    <span class="px-4 py-1 rounded-full font-semibold text-sm whitespace-nowrap <?= $color ?> <?= $bg ?>">
                                        <?= ucfirst($caso['estado']) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-gray-700 w-32 truncate">
                                    <?php
                                        echo htmlspecialchars($caso['instructor']);
                                    ?>
                                </td>
                                <td class="px-4 py-4 text-gray-700 w-40 whitespace-normal break-words"><?= htmlspecialchars($caso['nombre_asignado']) ?></td>
                                <td class="px-4 py-4 text-gray-700 w-32">
                                    <button onclick="mostrarModal2(<?= $caso['id'] ?>)" class="text-blue-600 hover:text-blue-800">Ver Detalles</button>
                                    <!-- Modal -->
                                    <div id="modal2-<?= $caso['id'] ?>" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                                        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                                            <h3 class="text-xl font-semibold mb-4">Detalles del Caso General #<?= $caso['id'] ?></h3>
                                            <p><strong>Asunto:</strong> <?= htmlspecialchars($caso['asunto']) ?></p>
                                            <p><strong>Descripción:</strong> <?= htmlspecialchars($caso['descripcion']) ?></p>
                                            <p><strong>Ambiente:</strong> <?= $caso['ambiente'] ?></p>
                                            <p><strong>Estado:</strong> <?= $caso['estado'] ?></p>
                                            <p><strong>Creado por:</strong> <?= htmlspecialchars($caso['instructor']) ?></p>
                                            <p><strong>Asignado a:</strong> <?= htmlspecialchars($caso['nombre_asignado']) ?></p>
                                            <p><strong>Fecha de Creación:</strong> <?= $caso['fecha_creacion'] ?></p>
                                            <?php if (!empty($caso['historial'])): ?>
                                                <div class="mt-4">
                                                    <h4 class="font-semibold mb-2">Historial de Observaciones:</h4>
                                                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1 max-h-40 overflow-y-auto pr-2">
                                                        <?php foreach ($caso['historial'] as $registro): ?>
                                                            <li>
                                                                <?= $registro['fecha_actualizacion'] ?> —
                                                                <?php
                                                                    $usuario = htmlspecialchars($registro['usuario']);
                                                                    $rol = isset($registro['rol_usuario']) ? ' (' . htmlspecialchars($registro['rol_usuario']) . ')' : '';
                                                                    $estadoAnterior = $registro['estado_anterior'];
                                                                    $estadoNuevo = $registro['estado_nuevo'];
                                                                    $observaciones = !empty($registro['observaciones']) ? '· <span class="italic">' . htmlspecialchars($registro['observaciones']) . '</span>' : '';
                                                                    if ($estadoAnterior !== $estadoNuevo) {
                                                                        echo "El usuario <strong>$usuario$rol</strong> cambió el estado del caso de <em>$estadoAnterior</em> a <em>$estadoNuevo</em> $observaciones";
                                                                    } else {
                                                                        echo "El usuario <strong>$usuario$rol</strong> tomó el caso $observaciones";
                                                                    }
                                                                ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php else: ?>
                                                <p class="mt-4 italic text-sm text-gray-500">Este caso no tiene historial aún.</p>
                                            <?php endif; ?>
                                            <div class="mt-4 flex justify-end">
                                                <button onclick="cerrarModal2(<?= $caso['id'] ?>)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <!-- Modal de resultado de consulta -->
    <div id="modal-consulta-caso" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full relative">
            <button onclick="cerrarModalConsulta()" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl">&times;</button>
            <div id="contenido-modal-consulta"></div>
        </div>
    </div>
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
    </script>

<script>
    // Paginación para tabla 1 (casos específicos)
    document.addEventListener("DOMContentLoaded", function () {
        const filas1 = Array.from(document.querySelectorAll("#tablaHistorial1 tbody tr"));
        const filasPorPagina1 = 5;
        const paginacion1 = document.getElementById("paginacion1");
        let paginaActual1 = 1;
        let filasFiltradas1 = [...filas1];

        function mostrarPagina1(pagina) {
            const totalPaginas = Math.ceil(filasFiltradas1.length / filasPorPagina1);
            if (pagina < 1) pagina = 1;
            if (pagina > totalPaginas) pagina = totalPaginas;
            paginaActual1 = pagina;

            filas1.forEach(fila => fila.style.display = "none");
            filasFiltradas1.forEach((fila, index) => {
                fila.style.display = (index >= (pagina - 1) * filasPorPagina1 && index < pagina * filasPorPagina1) ? "" : "none";
            });
            renderizarControles1(pagina, totalPaginas);
        }

        function renderizarControles1(pagina, totalPaginas) {
            paginacion1.innerHTML = "";
            if (totalPaginas <= 1) return;
            const btnAnterior = document.createElement("button");
            btnAnterior.innerHTML = "&larr;";
            btnAnterior.className = botonEstilo1(false, true);
            btnAnterior.disabled = pagina === 1;
            btnAnterior.onclick = () => mostrarPagina1(pagina - 1);
            paginacion1.appendChild(btnAnterior);
            for (let i = 1; i <= totalPaginas; i++) {
                const btn = document.createElement("button");
                btn.textContent = i;
                btn.className = botonEstilo1(i === pagina);
                btn.onclick = () => mostrarPagina1(i);
                paginacion1.appendChild(btn);
            }
            const btnSiguiente = document.createElement("button");
            btnSiguiente.innerHTML = "&rarr;";
            btnSiguiente.className = botonEstilo1(false, true);
            btnSiguiente.disabled = pagina === totalPaginas;
            btnSiguiente.onclick = () => mostrarPagina1(pagina + 1);
            paginacion1.appendChild(btnSiguiente);
        }

        function botonEstilo1(activo = false, flecha = false) {
            return `${flecha ? 'w-8 h-8' : 'w-8 h-8'} flex items-center justify-center rounded-full border transition-all duration-300 shadow-md focus:outline-none ${activo ? 'bg-[#007832] text-white border-[#007832]' : 'bg-white text-[#007832] border-[#007832] hover:bg-[#007832] hover:text-white'} ${flecha ? 'font-bold text-lg' : 'font-semibold'}`;
        }

        mostrarPagina1(1);
    });

    // Paginación para tabla 2 (casos generales)
    document.addEventListener("DOMContentLoaded", function () {
        const filas2 = Array.from(document.querySelectorAll("#tablaHistorial2 tbody tr"));
        const filasPorPagina2 = 5;
        const paginacion2 = document.getElementById("paginacion2");
        let paginaActual2 = 1;
        let filasFiltradas2 = [...filas2];

        function mostrarPagina2(pagina) {
            const totalPaginas = Math.ceil(filasFiltradas2.length / filasPorPagina2);
            if (pagina < 1) pagina = 1;
            if (pagina > totalPaginas) pagina = totalPaginas;
            paginaActual2 = pagina;

            filas2.forEach(fila => fila.style.display = "none");
            filasFiltradas2.forEach((fila, index) => {
                fila.style.display = (index >= (pagina - 1) * filasPorPagina2 && index < pagina * filasPorPagina2) ? "" : "none";
            });
            renderizarControles2(pagina, totalPaginas);
        }

        function renderizarControles2(pagina, totalPaginas) {
            paginacion2.innerHTML = "";
            if (totalPaginas <= 1) return;
            const btnAnterior = document.createElement("button");
            btnAnterior.innerHTML = "&larr;";
            btnAnterior.className = botonEstilo2(false, true);
            btnAnterior.disabled = pagina === 1;
            btnAnterior.onclick = () => mostrarPagina2(pagina - 1);
            paginacion2.appendChild(btnAnterior);
            for (let i = 1; i <= totalPaginas; i++) {
                const btn = document.createElement("button");
                btn.textContent = i;
                btn.className = botonEstilo2(i === pagina);
                btn.onclick = () => mostrarPagina2(i);
                paginacion2.appendChild(btn);
            }
            const btnSiguiente = document.createElement("button");
            btnSiguiente.innerHTML = "&rarr;";
            btnSiguiente.className = botonEstilo2(false, true);
            btnSiguiente.disabled = pagina === totalPaginas;
            btnSiguiente.onclick = () => mostrarPagina2(pagina + 1);
            paginacion2.appendChild(btnSiguiente);
        }

        function botonEstilo2(activo = false, flecha = false) {
            return `${flecha ? 'w-8 h-8' : 'w-8 h-8'} flex items-center justify-center rounded-full border transition-all duration-300 shadow-md focus:outline-none ${activo ? 'bg-[#007832] text-white border-[#007832]' : 'bg-white text-[#007832] border-[#007832] hover:bg-[#007832] hover:text-white'} ${flecha ? 'font-bold text-lg' : 'font-semibold'}`;
        }

        mostrarPagina2(1);
    });

    // Modales independientes para cada tabla
    function mostrarModal1(id) {
        document.getElementById(`modal1-${id}`).classList.remove('hidden');
    }
    function cerrarModal1(id) {
        document.getElementById(`modal1-${id}`).classList.add('hidden');
    }
    function mostrarModal2(id) {
        document.getElementById(`modal2-${id}`).classList.remove('hidden');
    }
    function cerrarModal2(id) {
        document.getElementById(`modal2-${id}`).classList.add('hidden');
    }

    // Consulta de caso por ID
    document.getElementById('form-consulta-caso').addEventListener('submit', function(e) {
        e.preventDefault();
        const tipo = document.getElementById('tipo-caso').value;
        const id = document.getElementById('id-caso').value;
        const error = document.getElementById('consulta-error');
        error.classList.add('hidden');
        error.textContent = '';
        fetch('consulta_caso?tipo=' + tipo + '&id=' + id)
            .then(res => res.text())
            .then(text => {
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    error.textContent = 'Respuesta inválida del servidor: ' + text;
                    error.classList.remove('hidden');
                    return;
                }
                if (data.error) {
                    error.textContent = data.error;
                    error.classList.remove('hidden');
                } else {
                    mostrarModalConsulta(data, tipo);
                }
            })
            .catch(() => {
                error.textContent = 'Error al consultar el caso.';
                error.classList.remove('hidden');
            });
    });

    function mostrarModalConsulta(caso, tipo) {
        const modal = document.getElementById('modal-consulta-caso');
        const contenido = document.getElementById('contenido-modal-consulta');
        let html = '';
        if (tipo === 'normal') {
            html += `<h3 class="text-xl font-semibold mb-4">Detalles del Caso Específico #${caso.caso_id}</h3>`;
            html += `<p><strong>Descripción:</strong> ${caso.descripcion_caso}</p>`;
            html += `<p><strong>Ambiente:</strong> ${caso.ambiente}</p>`;
            html += `<p><strong>N° Placa:</strong> ${caso.producto}</p>`;
            html += `<p><strong>Estado:</strong> ${caso.estado_actual}</p>`;
            html += `<p><strong>Creado por:</strong> ${caso.creado_por}</p>`;
            html += `<p><strong>Asignado a:</strong> ${caso.asignado_a}</p>`;
            html += `<p><strong>Fecha de Creación:</strong> ${caso.fecha_creacion}</p>`;
            if (caso.historial && caso.historial.length > 0) {
                html += `<div class="mt-4"><h4 class="font-semibold mb-2">Historial de Observaciones:</h4><ul class="list-disc list-inside text-sm text-gray-700 space-y-1 max-h-40 overflow-y-auto pr-2">`;
                caso.historial.forEach(registro => {
                    const usuario = registro.usuario;
                    const rol = registro.rol_usuario ? ` (${registro.rol_usuario})` : '';
                    const estadoAnterior = registro.estado_anterior;
                    const estadoNuevo = registro.estado_nuevo;
                    const observaciones = registro.observaciones ? `· <span class='italic'>${registro.observaciones}</span>` : '';
                    if (estadoAnterior !== estadoNuevo) {
                        html += `<li>${registro.fecha_actualizacion} — El usuario <strong>${usuario}${rol}</strong> cambió el estado del caso de <em>${estadoAnterior}</em> a <em>${estadoNuevo}</em> ${observaciones}</li>`;
                    } else {
                        html += `<li>${registro.fecha_actualizacion} — El usuario <strong>${usuario}${rol}</strong> tomó el caso ${observaciones}</li>`;
                    }
                });
                html += `</ul></div>`;
            } else {
                html += `<p class="mt-4 italic text-sm text-gray-500">Este caso no tiene historial aún.</p>`;
            }
        } else {
            html += `<h3 class="text-xl font-semibold mb-4">Detalles del Caso General #${caso.id}</h3>`;
            html += `<p><strong>Asunto:</strong> ${caso.asunto}</p>`;
            html += `<p><strong>Descripción:</strong> ${caso.descripcion}</p>`;
            html += `<p><strong>Ambiente:</strong> ${caso.ambiente}</p>`;
            html += `<p><strong>Estado:</strong> ${caso.estado}</p>`;
            html += `<p><strong>Creado por:</strong> ${caso.instructor}</p>`;
            html += `<p><strong>Asignado a:</strong> ${caso.nombre_asignado}</p>`;
            html += `<p><strong>Fecha de Creación:</strong> ${caso.fecha_creacion}</p>`;
            if (caso.historial && caso.historial.length > 0) {
                html += `<div class="mt-4"><h4 class="font-semibold mb-2">Historial de Observaciones:</h4><ul class="list-disc list-inside text-sm text-gray-700 space-y-1 max-h-40 overflow-y-auto pr-2">`;
                caso.historial.forEach(registro => {
                    const usuario = registro.usuario;
                    const rol = registro.rol_usuario ? ` (${registro.rol_usuario})` : '';
                    const estadoAnterior = registro.estado_anterior;
                    const estadoNuevo = registro.estado_nuevo;
                    const observaciones = registro.observaciones ? `· <span class='italic'>${registro.observaciones}</span>` : '';
                    if (estadoAnterior !== estadoNuevo) {
                        html += `<li>${registro.fecha_actualizacion} — El usuario <strong>${usuario}${rol}</strong> cambió el estado del caso de <em>${estadoAnterior}</em> a <em>${estadoNuevo}</em> ${observaciones}</li>`;
                    } else {
                        html += `<li>${registro.fecha_actualizacion} — El usuario <strong>${usuario}${rol}</strong> tomó el caso ${observaciones}</li>`;
                    }
                });
                html += `</ul></div>`;
            } else {
                html += `<p class="mt-4 italic text-sm text-gray-500">Este caso no tiene historial aún.</p>`;
            }
        }
        contenido.innerHTML = html;
        modal.classList.remove('hidden');
    }
    function cerrarModalConsulta() {
        document.getElementById('modal-consulta-caso').classList.add('hidden');
    }
</script>
</main>

</body>
</html>
