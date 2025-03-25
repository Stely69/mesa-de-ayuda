<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('../../pictures/fondo.jpg');">
    <!-- Capa blanca semitransparente -->
    <div class="absolute inset-0 bg-white bg-opacity-40"></div>

    <div class="relative flex items-center justify-center min-h-screen">
        <div class="bg-white p-10 rounded-lg shadow-lg w-[500px]">
            <div class="flex justify-center mb-4">
                <a href="../">
                    <img src="../../pictures/logoSena.png" alt="Logo de la entidad" class="h-16">
                </a>
            </div>
            <h2 class="text-3xl font-bold text-center text-[#39A900]">Recuperar Contraseña</h2>
            <p class="text-gray-600 text-sm text-center mb-4">Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
            <form action="" method="POST" class="mt-6">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required 
                        class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                </div>
                <button type="submit" 
                    class="w-full bg-[#39A900] text-white p-3 rounded-lg hover:bg-green-700 transition">
                    Enviar Enlace de Recuperación
                </button>
            </form>
        </div>
    </div>

    <footer class="bg-[#39A900] text-white text-center p-4 mt-8">
        <p>&copy; 2025 SENA - Sistema de Gestión de Inventario</p>
    </footer>
</body>
</html>
