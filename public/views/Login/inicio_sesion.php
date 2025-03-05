<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('../../pictures/fondo.jpg');">
    <!-- Capa blanca semitransparente -->
    <div class="absolute inset-0 bg-white bg-opacity-40"></div>

    <header class="relative w-full bg-white shadow-md p-4 flex items-center">
        <a href="../../views/inicio.php" class="flex items-center">
            <span class="ml-4 text-lg font-bold text-[#39A900]">Volver a Inicio</span>
        </a>
    </header>

    <div class="relative flex items-center justify-center min-h-screen">
        <div class="bg-white p-10 rounded-lg shadow-lg w-[500px]">
            <div class="flex justify-center mb-4">
                <img src="../../pictures/logoSena.png" alt="Logo de la entidad" class="h-16">
            </div>
            <h2 class="text-3xl font-bold text-center text-[#39A900]">Iniciar Sesión</h2>
            <form action="#" method="POST" class="mt-6">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="password" name="password" required class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700">Selecciona tu rol</label>
                    <select id="role" name="role" required class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                        <option value="almacen">Almacén</option>
                        <option value="instructores">Instructores</option>
                        <option value="soporte">Soporte Técnico</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-[#39A900] text-white p-3 rounded-lg hover:bg-green-700 transition">Ingresar</button>
            </form>
        </div>
    </div>
</body>


    <footer class="bg-[#39A900] text-white text-center p-4 mt-8">
        <p>&copy; 2025 SENA - Sistema de Gestión de Inventario</p>
    </footer>
</body>
</html>
