<?php
session_start();

// Datos simulados (normalmente vienen de una base de datos)
$user = [
    'nombre' => 'Kevin Alexis Chavez Ballesteros',
    'correo' => 'kevin.chavez@sena.edu.co',
    'rol' => 'Instructor',
    'pais' => 'Colombia',
    'ciudad' => 'La Vega',
    'zona_horaria' => 'America/Bogota',
    'fecha_creacion' => '2024-02-02',
    'ultimo_acceso' => '2025-03-21 08:24',
    'contraseña_actual' => 'kevin1234',
];

$roles = ['Instructor', 'Funcionario TICS', 'Funcionario ALMACÉN', 'Administrador'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<p class='text-green-600 font-bold'>Datos actualizados correctamente.</p>";
}
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
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg border">

        <!-- Encabezado con Logo -->
        <div class="flex items-center justify-between border-b pb-4">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/0d/Logo_SENA.svg" alt="Logo SENA" class="w-20">
            <h2 class="text-2xl font-bold text-green-700">Perfil de Usuario</h2>
        </div>

        <!-- Sección de Información del Usuario -->
        <div class="grid grid-cols-3 gap-6 mt-6">
            <!-- Tarjeta de usuario -->
            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-purple-600 text-white text-3xl font-bold flex items-center justify-center rounded-full">
                        <?= strtoupper(substr($user['nombre'], 0, 1)) ?>
                    </div>
                    <h3 class="mt-4 text-xl font-bold text-center"><?= htmlspecialchars($user['nombre']) ?></h3>
                    <p class="text-green-600 font-semibold"><?= htmlspecialchars($user['rol']) ?></p>
                    <button onclick="toggleForm()" class="mt-4 bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700">
                        ✏️ Editar perfil
                    </button>
                </div>
            </div>

            <!-- Detalles del usuario -->
            <div class="bg-gray-50 p-6 rounded-lg shadow col-span-2">
                <h4 class="text-lg font-semibold">Detalles de usuario</h4>
                <p><strong>Dirección de correo:</strong> <?= htmlspecialchars($user['correo']) ?></p>
                <p><strong>País:</strong> <?= htmlspecialchars($user['pais']) ?></p>
                <p><strong>Ciudad/Pueblo:</strong> <?= htmlspecialchars($user['ciudad']) ?></p>
                <p><strong>Zona horaria:</strong> <?= htmlspecialchars($user['zona_horaria']) ?></p>
                <p><strong>Fecha de Creación:</strong> <?= htmlspecialchars($user['fecha_creacion']) ?></p>
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
                <h4 class="text-lg font-semibold">Actividad de accesos</h4>
                <p><strong>Último acceso:</strong> <?= htmlspecialchars($user['ultimo_acceso']) ?></p>
            </div>
        </div>

    </div>

    <!-- Formulario Emergente para Editar Perfil -->
    <div id="editForm" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4 text-center text-green-700">Editar Perfil</h2>
            <form action="" method="POST">
                <div class="mb-4">
                    <label class="block font-semibold">Nombre</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Correo Electrónico</label>
                    <input type="email" name="correo" value="<?= htmlspecialchars($user['correo']) ?>" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Cambio de contraseña</label>
                    <label class="font-serif ...">Ingrese la contraseña actual</label>
                        <input type="password" namespace="contraseña" value="<?= htmlspecialchars($user['contraseña_actual']) ?>"class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
                    <label class="font-serif ...">Ingrese la contraseña nueva</label>
                    <input type="password" namespace="contraseña" value="" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
                    <label class="font-serif ...">Vuelva a ingresar la contraseña nueva </label>
                    <input type="password" namespace="contraseña" value="" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">

                    
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                    Guardar Cambios
                </button>

                <button type="button" onclick="toggleForm()" class="w-full mt-2 bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">
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
