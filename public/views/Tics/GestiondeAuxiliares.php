<?php
$base_path = 'tics';
    require_once __DIR__ . '../../../../Controller/UserController.php';
    $userController = new UserController();
    $users = $userController->getUserAuxiliar();
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - GEDAC</title>
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
<body class="bg-gray-100">
    <div class="flex min-h-screen">
<!-- Sidebar separado -->
    <?php include 'barra.php'; ?>

<!-- Main Content -->
    <main class="flex-1 p-6 ml-64 overflow-auto">
   
            <h2 class="text-2xl sm:text-3xl font-semibold text-[#39A900] mb-4">Gestión de Auxiliares</h2>

            <!-- Alerta dinámica -->
            <div id="alerta" class="hidden p-4 mb-4 rounded-lg text-sm flex items-center justify-between" role="alert">
                <span id="mensajeAlerta"></span>
                <button onclick="cerrarAlerta()" class="ml-4 font-bold text-lg leading-none focus:outline-none">&times;</button>
            </div>

            <!-- Filtros -->
            <div class="bg-white p-4 shadow rounded-md mb-4">
                <div class="flex flex-col sm:flex-row gap-2">
                    <button onclick="mostrarFormulario()" class="bg-[#39A900] text-white px-4 py-2 rounded-md w-full sm:w-auto">Agregar Usuario</button>
                </div>
            </div>

            <!-- Modal Agregar Usuario -->
            <div id="modalAgregar" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden px-4">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                    <h3 class="text-xl font-semibold mb-4">Agregar Usuario</h3>
                    <form action="RegistroActionG" method="POST" class="space-y-3">
                        <div>
                            <label class="block mb-1 font-medium">Cédula</label>
                            <input type="text" name="documento" class="w-full p-2 border rounded-md" placeholder="Cédula">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Nombre</label>
                            <input type="text" name="nombres" class="w-full p-2 border rounded-md" placeholder="Nombre">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Apellido</label>
                            <input type="text" name="apellido" class="w-full p-2 border rounded-md" placeholder="Apellido">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Correo</label>
                            <input type="email" name="correo" class="w-full p-2 border rounded-md" placeholder="Correo">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Contraseña</label>
                            <input type="password" name="contraseña" class="w-full p-2 border rounded-md" placeholder="Contraseña">
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Rol</label>
                            <select name="rol" class="w-full p-2 border rounded-md">
                                <option value="">Seleccionar Rol</option>
                                <option value="5">Auxiliar Tics</option>
                            </select>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="cerrarFormulario()" class="bg-gray-500 text-white px-4 py-1 rounded-md">Cancelar</button>
                            <button type="submit" class="bg-[#39A900] text-white px-4 py-1 rounded-md">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Tabla de Usuarios -->
            <div class="bg-white p-4 shadow rounded-md overflow-x-auto">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Auxiliares Registrados</h3>
                <table class="min-w-full text-sm text-left border">
                    <thead class="bg-gray-200 text-xs sm:text-sm">
                        <tr>
                            <th class="p-2 border">Documento</th>
                            <th class="p-2 border">Nombre</th>
                            <th class="p-2 border">Apellido</th>
                            <th class="p-2 border">Correo</th>
                            <th class="p-2 border">Rol</th>
                            <th class="p-2 border text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaUsuarios">
                        <?php foreach ($users as $usuario): ?>
                            <tr class="bg-gray-100" data-rol="<?= htmlspecialchars($usuario['rol_id']) ?>">
                                <td class="p-2 border"><?= htmlspecialchars($usuario['documento']) ?></td>
                                <td class="p-2 border"><?= htmlspecialchars($usuario['nombres']) ?></td>
                                <td class="p-2 border"><?= htmlspecialchars($usuario['apellido']) ?></td>
                                <td class="p-2 border"><?= htmlspecialchars($usuario['correo']) ?></td>
                                <td class="p-2 border"><?= htmlspecialchars($usuario['rol_id']) ?></td>
                                <td class="p-2 border text-center">
                                    <div class="flex flex-col sm:flex-row gap-2 items-center justify-center">
                                        <button onclick="editarUsuario('<?= htmlspecialchars(openssl_encrypt($usuario['id'], AES, key)) ?>', '<?= htmlspecialchars($usuario['nombres']) ?>', '<?= htmlspecialchars($usuario['apellido']) ?>', '<?= htmlspecialchars($usuario['correo']) ?>', '<?= htmlspecialchars($usuario['rol_id']) ?>')" class="bg-blue-500 text-white px-2 py-1 rounded">Editar</button>
                                        
                                        <form action="UpdateStatusA" method="POST">
                                            <input type="hidden" name="id" value="<?= openssl_encrypt($usuario['id'], AES, key) ?>">
                                            <select name="status" class="border p-1 rounded text-sm" onchange="this.form.submit()">
                                                <option value="activo" <?= $usuario['estado'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                                                <option value="inactivo" <?= $usuario['estado'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                                            </select>
                                        </form>

                                        <form action="DeleteActionA" method="GET" onsubmit="return confirm('¿Estás seguro de eliminar a este usuario?');">
                                            <input type="hidden" name="id" value="<?= openssl_encrypt($usuario['id'], AES , key) ?>">
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded">🗑</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                   <!-- Modal Editar Usuario -->
                <div id="modalEditar" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden px-4">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                        <h3 class="text-xl font-semibold mb-4">Editar Usuario</h3>
                        <form action="EditarUsuarioAuxiliar" method="POST" class="space-y-3">
                            <!-- Campos ocultos -->
                            <input type="hidden" name="id" id="editId">
                            <input type="hidden" name="hiddenCorreo" id="hiddenCorreo">

                            <div>
                                <label class="block mb-1 font-medium">Nombre</label>
                                <input type="text" name="nombres" id="editNombre" class="w-full p-2 border rounded-md" placeholder="Nombre" required>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Apellido</label>
                                <input type="text" name="apellido" id="editApellido" class="w-full p-2 border rounded-md" placeholder="Apellido" required>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Correo</label>
                                <input type="email" name="correo" id="editCorreo" class="w-full p-2 border rounded-md" placeholder="Correo" required disabled>
                                <button type="button" onclick="habilitarCorreo()" class="text-sm text-blue-600 underline mt-1">Editar correo</button>
                            </div>
                            <div>
                                <label class="block mb-1 font-medium">Rol</label>
                                <select name="rol" id="editRol" class="w-full p-2 border rounded-md" required>
                                    <option value="">Seleccionar Rol</option>
                                    <option value="5">Auxiliar Tics</option>
                                </select>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="cerrarModal()" class="bg-gray-500 text-white px-4 py-1 rounded-md">Cancelar</button>
                                <button type="submit" class="bg-[#39A900] text-white px-4 py-1 rounded-md">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </main>
    </div>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const closeSidebar = document.getElementById('closeSidebar');
        const modalAgregar = document.getElementById('modalAgregar');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
        });

        closeSidebar?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });

        function mostrarFormulario() {
            modalAgregar.classList.remove('hidden');
        }

        function cerrarFormulario() {
            modalAgregar.classList.add('hidden');
        }

        function filtrarUsuarios() {
            const filtro = document.getElementById('filtroRol').value;
            const filas = document.querySelectorAll('#tablaUsuarios tr');
            filas.forEach(fila => {
                const rol = fila.getAttribute('data-rol');
                fila.style.display = !filtro || rol === filtro ? '' : 'none';
            });
        }

        function editarUsuario(id, nombre, apellido, correo, rol_id) {
            const modalEditar = document.getElementById('modalEditar');
            document.getElementById('editId').value = id;
            document.getElementById('editNombre').value = nombre;
            document.getElementById('editApellido').value = apellido;
            document.getElementById('editCorreo').value = correo;
            document.getElementById('hiddenCorreo').value = correo;
            document.getElementById('editRol').value = rol_id;
            modalEditar.classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modalEditar').classList.add('hidden');
        }

        function habilitarCorreo() {
            document.getElementById('editCorreo').disabled = false;
        }
    </script>

    <script>
        function mostrarAlerta(tipo, mensaje) {
            const alerta = document.getElementById('alerta');
            const mensajeAlerta = document.getElementById('mensajeAlerta');

            alerta.className = 'p-4 mb-4 rounded-lg text-sm flex items-center justify-between';

            if (tipo === 'success') {
                alerta.classList.add('bg-green-100', 'text-green-700', 'border', 'border-green-300');
            } else if (tipo === 'error') {
                alerta.classList.add('bg-red-100', 'text-red-700', 'border', 'border-red-300');
            }

            mensajeAlerta.textContent = mensaje;
            alerta.classList.remove('hidden');

            setTimeout(() => {
                alerta.classList.add('hidden');
            }, 5000);
        }

        function cerrarAlerta() {
            document.getElementById('alerta').classList.add('hidden');
        }

        // Mostrar alerta si viene por URL
        window.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const tipo = params.get('alert');
            const mensaje = params.get('mensaje');

            if (tipo && mensaje) {
                mostrarAlerta(tipo, decodeURIComponent(mensaje));
                // Limpia los parámetros de la URL sin recargar
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>


</body>
</html>
