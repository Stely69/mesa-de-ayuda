<?php   
        session_start();
        require_once __DIR__ . '../../../../Controller/UserController.php';
        $userController = new UserController();
        $user = $userController->Getuser($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gray-100 text-gray-900">


<!-- Contenedor Principal -->
<div class="ml-64 max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg border">

        <!-- Encabezado con Logo -->
        <div class="flex items-center justify-between border-b pb-4">
            <img src="../../pictures/logoSena.png" alt="Logo SENA" class="w-20">
            <h2 class="text-2xl font-bold text-[#39A900]">Perfil de Usuario</h2>
        </div>

        <!-- Sección de Información del Usuario -->
        <div class="grid grid-cols-3 gap-6 mt-6">
            <!-- Tarjeta de usuario -->
            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-purple-600 text-white text-3xl font-bold flex items-center justify-center rounded-full">
                        <?= strtoupper(substr($user['nombres'], 0, 1)) ?>
                    </div>
                    <h3 class="mt-4 text-xl font-bold text-center"><?= htmlspecialchars($user['nombres'] . $user['apellido']) ?></h3>
                    <p class="text-green-600 font-semibold"><?= htmlspecialchars($user['rol_id']) ?></p>
                    <button onclick="toggleForm()" class="mt-4 bg-[#39A900] text-white py-2 px-4 rounded-md hover:bg-green-700">
                        ✏️ Editar perfil
                    </button>
                </div>
            </div>

            <!-- Detalles del usuario -->
            <div class="bg-gray-50 p-6 rounded-lg shadow col-span-2">
                <h4 class="text-lg font-semibold">Detalles de usuario</h4>
                <p><strong>Dirección de correo:</strong> <?= htmlspecialchars($user['correo']) ?></p>
                <p><strong>Documento:</strong> <?= htmlspecialchars($user['documento']) ?></p>
            </div>
        </div>

        <!-- Sección Miscelánea -->
        <div class="grid grid-cols-3 gap-6 mt-6">
            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <h4 class="text-lg font-semibold">Miscelánea</h4>
                <ul class="text-blue-600">
                    <li><a href="#" class="hover:underline">Mis novedades creadas</a></li>
                    <li><a href="#" class="hover:underline">Mis novedades pendientes</a></li>
                    <li><a href="#" class="hover:underline">Mis novedades en proceso</a></li>
                    <li><a href="#" class="hover:underline">Mis novedades cerradas</a></li>
                </ul>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <h4 class="text-lg font-semibold">Informes</h4>
                <p><a href="#" class="text-blue-600 hover:underline">Trazabilidad de casos</a></p>
                <p><a href="#" class="text-blue-600 hover:underline">Resumen de novedades</a></p>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <h4 class="text-lg font-semibold">Estado de Cuenta</h4>
                <p><strong>Estado:</strong> <?= htmlspecialchars($user['estado']) ?></p>
            </div>
        </div>

    </div>

    <!-- Formulario Emergente para Editar Perfil -->
    <div id="editForm" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4 text-center  text-black p-2 rounded">Editar Perfil</h2>
        <form action="UpdateUserAction" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars(openssl_encrypt($user['id'], AES, key)) ?>">
            <div class="mb-4">
                <label class="block font-semibold">Nombre</label>
                <input type="text" name="nombres" value="<?= htmlspecialchars($user['nombres']) ?>" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Nombre</label>
                <input type="text" name="apellido" value="<?= htmlspecialchars($user['apellido']) ?>" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Correo Electrónico</label>
                <input type="email" name="correo" value="<?= htmlspecialchars($user['correo']) ?>" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
            </div>

            <div class="mb-4">
                <label>Ingrese la contraseña actual</label>
                <input type="password" name="password_actual" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500" >

                <label>Ingrese la contraseña nueva</label>
                <input type="password" name="password_nueva" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500" >

                <label>Vuelva a ingresar la contraseña nueva</label>
                <input type="password" name="confirmar_password"class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500" >
            </div>

            <button type="submit" class="w-full bg-[#39A900] text-white py-2 px-4 rounded hover:bg-green-700">
                Guardar Cambios
            </button>

            <button type="button" onclick="toggleForm()" class="w-full mt-2 bg-[#39A900] text-white py-2 px-4 rounded hover:bg-green-700">
                Cancelar
            </button>
        </form>
    </div>
</div>

    <script>
        function toggleForm() {
            document.getElementById("editForm").classList.toggle("hidden");
        }
    </script>

</body>
</html>
