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
    <div class="relative flex items-center justify-center min-h-screen  px-4">
        <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-xl w-full max-w-md">
            <div class="flex justify-center mb-6">
                <a href="../">
                    <img src="../../pictures/logoSena.png" alt="Logo de la entidad" class="h-16">
                </a>
            </div>
            <h2 class="text-3xl font-bold text-center text-[#39A900]">Recuperar Contraseña</h2>
            <p class="text-gray-600 text-sm text-center mb-6">Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p> 
            <!-- Alerta si hay mensaje -->
            <?php if (isset($_GET['mensaje'])): ?>
                <div id="alerta" class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <?= htmlspecialchars($_GET['mensaje']) ?>
                </div>
            <?php endif; ?>

            <form action="RecuperarAction" method="POST" class="space-y-5">
                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" required
                    class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                </div>
                <button type="submit"
                    class="w-full bg-[#39A900] text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300">
                    Enviar Enlace de Recuperación
                </button>
            </form>
        </div>
    </div>
    <!-- Footer mejorado -->
    <footer class="bg-[#39A900] text-white py-6 mt-16">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
            <!-- Texto principal -->
            <p>&copy; 2025 <strong>SENA</strong> - Sistema de Gestión de Activos. Todos los derechos reservados.</p>
            <!-- Enlaces útiles (puedes personalizarlos) -->
            <div class="flex space-x-6">
                <a href="#how-it-works" class="hover:underline">¿Cómo funciona?</a>
                <a href="#team" class="hover:underline">Nuestro equipo</a>
                <a href="#contacto" class="hover:underline">Contacto</a>
            </div>
            <!-- Redes sociales (opcionales) -->
            <div class="flex space-x-4">
                <a href="#" target="_blank" class="hover:text-gray-200"><i class="fab fa-github text-lg"></i></a>
            </div>
        </div>
    </footer>
    <!-- Script para ocultar alerta automáticamente -->
    <script>
        setTimeout(() => {
            const alerta = document.getElementById('alerta');
            if (alerta) {
                alerta.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => alerta.remove(), 500);
            }
        }, 4000);
    </script>

</body>
</html>
