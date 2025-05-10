<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .decor-dot {
            width: 10px; height: 10px; border-radius: 50%; background: #39A90022;
        }
        .decor-triangle {
            width: 0; height: 0; border-left: 10px solid transparent; border-right: 10px solid transparent; border-bottom: 18px solid #39A90022;
        }
        .input-icon {
            position: absolute; left: 1.1rem; top: 50%; transform: translateY(-50%); color: #39A900;
        }
        .input-group input {
            padding-left: 2.5rem;
        }
        .footer-link {
            position: relative; transition: color 0.3s;
        }
        .footer-link::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px; background: #39A900; transition: width 0.3s;
        }
        .footer-link:hover::after { width: 100%; }
    </style>
</head>
<body class="min-h-screen bg-white flex flex-col justify-between relative overflow-x-hidden">
    <!-- Fondo decorativo con logo SENA -->
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-white to-gray-50"></div>
        <div class="absolute inset-0 bg-[url('../../pictures/logoSena.png')] bg-no-repeat bg-center bg-[length:30%] opacity-[0.06]"></div>
    </div>
    <main class="flex flex-1 items-center justify-center min-h-screen px-2 py-8">
        <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl flex flex-col md:flex-row overflow-hidden">
            <!-- Formulario -->
            <div class="flex-1 flex flex-col justify-center p-8 sm:p-12 bg-white">
                <div class="flex justify-center mb-6">
                    <a href="../">
                        <img src="../../pictures/logoSena.png" alt="Logo de la entidad" class="h-16 drop-shadow-md">
                    </a>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-2 text-center">Recuperar Contraseña</h2>
                <p class="text-gray-600 text-sm text-center mb-6">Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
                <!-- Alerta si hay mensaje -->
                <?php if (isset($_GET['mensaje'])): ?>
                    <div id="alerta" class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4 text-sm text-center">
                        <?= htmlspecialchars($_GET['mensaje']) ?>
                    </div>
                <?php endif; ?>
                <form action="RecuperarAction" method="POST" class="space-y-5">
                    <div class="relative input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="correo" name="correo" required placeholder="Correo Electrónico"
                        class="w-full p-3 pl-10 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#39A900] bg-gray-100 text-gray-700 placeholder-gray-400 transition">
                    </div>
                    <button type="submit"
                        class="w-full bg-[#39A900] text-white py-3 rounded-full font-semibold hover:bg-green-700 transition duration-300 text-lg shadow-md">
                        Enviar Enlace de Recuperación
                    </button>
                </form>
                <!-- Botón de volver -->
                <div class="mt-4 flex justify-center">
                    <a href="inicio_sesion" class="inline-block px-6 py-2 rounded-full border border-[#39A900] text-[#39A900] font-semibold hover:bg-[#39A900] hover:text-white transition-all duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>
            <!-- Ilustración decorativa a la derecha -->
            <div class="hidden md:flex flex-col items-center justify-center bg-white relative w-1/2 p-10">
                <div class="relative flex items-center justify-center w-full h-full">
                    <div class="rounded-full bg-[#39A90011] w-60 h-60 flex items-center justify-center shadow-lg">
                        <img src="https://cdn-icons-png.flaticon.com/512/3064/3064197.png" alt="Candado Ilustración" class="w-32 h-32 object-contain">
                    </div>
                    <!-- Elementos decorativos -->
                    <div class="absolute top-8 left-8 decor-dot"></div>
                    <div class="absolute bottom-8 right-8 decor-dot"></div>
                    <div class="absolute top-1/2 right-0 -translate-y-1/2 decor-triangle"></div>
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 decor-triangle"></div>
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-white border-t border-[#39A900]/20 text-gray-600 py-6">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4 text-sm">
            <div class="flex items-center gap-2">
                <img src="../../pictures/logoSena.png" alt="SENA Logo" class="h-6 opacity-80">
                <span>&copy; 2025 <strong class="text-[#39A900]">SENA</strong> - GEDAC</span>
            </div>
            <div class="flex flex-wrap gap-4">
                <a href="../../#how-it-works" class="footer-link hover:text-[#39A900]">¿Cómo funciona?</a>
                <a href="../../#team" class="footer-link hover:text-[#39A900]">Nuestro equipo</a>
                <a href="mailto:contacto@gedac.com" class="footer-link hover:text-[#39A900]">Contacto</a>
            </div>
            <div class="flex space-x-4">
                <a href="#" target="_blank" class="hover:text-[#39A900] transition"><i class="fab fa-github text-lg"></i></a>
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
