<?php
require_once __DIR__ . '../../../../Controller/UserController.php';
$userController = new UserController();
$users = $userController->alluser();
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">    
    <div class="flex">

        <!-- Barra lateral -->
        
        <!-- Contenido principal -->
        <main class="flex-1 p-6 ml-64 overflow-auto">
            <h2 class="text-3xl font-semibold text-[#39A900] mb-4">Gestión de Usuarios</h2>
            
            <!-- Filtros -->
            <div class="bg-white p-4 shadow rounded-md mb-4">
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Filtrar Usuarios</h3>
                <div class="flex space-x-4">
                    <select id="filtroRol" class="p-2 border rounded-md" onchange="filtrarUsuarios()">
                        <option value="">Todos los Roles</option>
                        <option value="1">Administrador</option>
                        <option value="3">TICS</option>
                        <option value="2">Instructor</option>
                        <option value="4">Almacen</option>
                    </select>
                    <button onclick="mostrarFormulario()" class="bg-[#39A900] text-white px-4 py-2 rounded-md">Agregar Usuario</button>
                </div>
            </div>
            
            <!-- Modal Agregar Usuario -->
            <div id="modalAgregar" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h3 class="text-xl font-semibold mb-4">Agregar Usuario</h3>
                    <form action="RegistroAction" method="POST">
                        <label class="block mb-2">Cédula</label>
                        <input type="text" id="nuevaCedula" name="documento" class="w-full p-2 border rounded-md mb-2" placeholder="Cédula">
                        <label class="block mb-2">Nombre</label>
                        <input type="text" id="nuevoNombre" name="nombres" class="w-full p-2 border rounded-md mb-2" placeholder="Nombre">  
                        <label class="block mb-2">Apellido</label>
                        <input type="text" id="nuevoApellido" name="apellido" class="w-full p-2 border rounded-md mb-2" placeholder="apellido">
                        <label class="block mb-2">Correo</label>
                        <input type="email" id="nuevoCorreo" name="correo" class="w-full p-2 border rounded-md mb-2" placeholder="Correo">
                        <label class="block mb-2">Contraseña</label>
                        <input type="password" id="nuevaContrasena" name="contraseña" class="w-full p-2 border rounded-md mb-2" placeholder="Contraseña">
                        <label class="block mb-2">Rol</label>
                        <select id="nuevoRol" name="rol" class="w-full p-2 border rounded-md mb-4">
                            <option value="">Seleccionar Rol</option>
                            <option value="3">TICS</option>
                            <option value="4">Almacen</option>
                            <option value="2">Instructor</option>
                            <option value="1">Administrador</option>
                        </select>
                        <div class="flex justify-end space-x-2">
                            <button onclick="cerrarFormulario()" class="bg-gray-500 text-white px-3 py-1 rounded-md">Cancelar</button>
                            <button class="bg-[#39A900] text-white px-3 py-1 rounded-md">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Modal Editar Usuario -->
            <div id="modalEditar" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <h3 class="text-xl font-semibold mb-4">Editar Usuario</h3>
                    <form id="formEditar" action="UpdateAction" method="POST">
                        <input type="hidden" id="editId" name="id">
                        <label class="block mb-2">Nombre</label>
                        <input type="text" id="editNombre" name="nombres" class="w-full p-2 border rounded-md mb-2">
                        
                        <label class="block mb-2">Apellido</label>
                        <input type="text" id="editApellido" name="apellido" class="w-full p-2 border rounded-md mb-2">
                        
                        <label class="block mb-2">Correo</label>
                        <div class="flex items-center space-x-2">
                            <input type="email" id="editCorreo" name="correo" class="w-full p-2 border rounded-md mb-2" disabled>
                            <input type="hidden" id="hiddenCorreo" name="hiddenCorreo">
                            <button type="button" onclick="habilitarCorreo()" class="bg-[#39A900] text-white px-2 py-1 rounded-md">Editar Correo</button>
                        </div>
                        
                        <label class="block mb-2">Rol</label>
                        <select id="editRol" name="rol_id" class="w-full p-2 border rounded-md mb-4">
                            <option value="1">Administrador</option>
                            <option value="4">Inventario</option>
                            <option value="3">TICS</option>
                            <option value="2">Instructor</option>
                        </select>
                        
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="cerrarModal()" class="bg-gray-500 text-white px-3 py-1 rounded-md">Cancelar</button>
                            <button type="submit" class="bg-[#39A900] text-white px-3 py-1 rounded-md">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Tabla de Usuarios -->
            <div class="bg-white p-4 shadow rounded-md">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Usuarios Registrados</h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 border">Documento</th>
                            <th class="p-2 border">Nombre</th>
                            <th class="p-2 border">Apellido</th>
                            <th class="p-2 border">Correo</th>
                            <th class="p-2 border">Rol</th>
                            <th class="p-2 border">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaUsuarios">
                        <?php foreach ($users as $usuario): ?>
                            <tr class="bg-gray-100" data-rol="<?= htmlspecialchars($usuario['rol_id']) ?>">
                                <td class="p-2 border"> <?= htmlspecialchars($usuario['documento']) ?> </td>
                                <td class="p-2 border"> <?= htmlspecialchars($usuario['nombres']) ?> </td>
                                <td class="p-2 border"> <?= htmlspecialchars($usuario['apellido']) ?> </td>
                                <td class="p-2 border"> <?= htmlspecialchars($usuario['correo']) ?> </td>
                                <td class="p-2 border"> <?= htmlspecialchars($usuario['rol']) ?> </td>
                                <td class="p-2 border flex justify-center space-x-2">
                                    <button onclick="editarUsuario('<?= htmlspecialchars(openssl_encrypt($usuario['id'],AES,key)) ?>', '<?= htmlspecialchars($usuario['nombres']) ?>', '<?= htmlspecialchars($usuario['apellido']) ?>', '<?= htmlspecialchars($usuario['correo']) ?>', '<?= htmlspecialchars($usuario['rol_id']) ?>')" class="bg-blue-500 text-white px-3 py-1 rounded-md">Editar</button>
                                    <form action="UpdateStatus" method="POST">
                                        <input type="hidden" name="id" value="<?=openssl_encrypt( $usuario['id'],AES,key) ?>">
                                        <select name="status" class="border p-1 rounded" onchange="this.form.submit()">
                                            <?php if ($usuario['estado'] === 'activo'): ?>
                                                <option value="activo" <?= $usuario['estado'] == 'Activo' ? 'selected' : '' ?>>Activo</option>
                                                <option value="inactivo" <?= $usuario['estado'] == 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                                            <?php elseif($usuario['estado'] === 'inactivo'): ?>
                                                <option value="inactivo" <?= $usuario['estado'] == 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                                                <option value="activo" <?= $usuario['estado'] == 'Activo' ? 'selected' : '' ?>>Activo</option>
                                            <?php endif; ?>
                                        </select>
                                    </form>
                                    <form action="DeleteAction" method="GET" onsubmit="return confirm('¿Estás seguro de eliminar a este usuario?');">
                                        <input type="hidden" name="id" value="<?=openssl_encrypt($usuario['id'],AES , key)?>">
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                            🗑 Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        function filtrarUsuarios() {
            let rol = document.getElementById("filtroRol").value;
            let filas = document.querySelectorAll("#tablaUsuarios tr");
            filas.forEach(fila => {
                fila.style.display = rol === "" || fila.getAttribute("data-rol") === rol ? "table-row" : "none";
            });
        }

        function mostrarFormulario() { document.getElementById("modalAgregar").classList.remove("hidden"); }
        function cerrarFormulario() { document.getElementById("modalAgregar").classList.add("hidden"); }

        function editarUsuario(id, nombre, apellido, correo, rol) {
            document.getElementById("editId").value = id;
            document.getElementById("editNombre").value = nombre;
            document.getElementById("editApellido").value = apellido;
            document.getElementById("editCorreo").value = correo;
            document.getElementById("hiddenCorreo").value = correo;
            document.getElementById("editRol").value = rol;
            document.getElementById("modalEditar").classList.remove("hidden");
        }

        function habilitarCorreo() {
            let correoInput = document.getElementById("editCorreo");
            correoInput.removeAttribute("readonly");
            correoInput.setAttribute("required", "true");
        }

        document.getElementById("formEditar").addEventListener("submit", function () {
            let correoInput = document.getElementById("editCorreo");
            let hiddenCorreo = document.getElementById("hiddenCorreo");

            // Si el correo no fue editado, aseguramos que se envíe el original
            if (correoInput.value.trim() === "") {
                correoInput.value = hiddenCorreo.value;
            }
        });

        function cerrarModal() {
            document.getElementById("modalEditar").classList.add("hidden");
        }
    </script>
</body>
</html>
