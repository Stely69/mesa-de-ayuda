<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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
            <!-- Ilustración decorativa -->
            <div class="hidden md:flex flex-col items-center justify-center bg-white relative w-1/2 p-10">
                <div class="relative flex items-center justify-center w-full h-full">
                    <div class="rounded-full bg-[#39A90011] w-60 h-60 flex items-center justify-center shadow-lg">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="User Ilustración" class="w-32 h-32 object-contain">
                    </div>
                    <!-- Elementos decorativos -->
                    <div class="absolute top-8 left-8 decor-dot"></div>
                    <div class="absolute bottom-8 right-8 decor-dot"></div>
                    <div class="absolute top-1/2 left-0 -translate-y-1/2 decor-triangle"></div>
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 decor-triangle"></div>
                </div>
            </div>
            <!-- Formulario -->
            <div class="flex-1 flex flex-col justify-center p-8 sm:p-12 bg-white">
                <div class="flex justify-center mb-6">
                    <a href="../">
                        <img src="../../pictures/logoSena.png" alt="Logo de la entidad" class="h-16 drop-shadow-md">
                    </a>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-6 text-center">Iniciar Sesión</h2>
                <form action="LoginAction" method="POST" class="space-y-5" onsubmit="return validarFormulario();">
                    <div class="relative input-group">
                        <i class="fas fa-id-card input-icon"></i>
                        <input type="text" id="cedula" name="cedula" required placeholder="Documento" class="w-full p-3 pl-10 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#39A900] bg-gray-100 text-gray-700 placeholder-gray-400 transition">
                    </div>
                    <div class="relative input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" required placeholder="Contraseña" class="w-full p-3 pl-10 rounded-full border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#39A900] bg-gray-100 text-gray-700 placeholder-gray-400 transition">
                    </div>
                    <button type="submit" class="w-full bg-[#39A900] text-white font-bold p-3 rounded-full hover:bg-green-700 transition text-lg shadow-md">LOGIN</button>
                    <div class="flex justify-between items-center text-xs mt-2">
                        <a href="recuperar" class="text-gray-500 hover:text-[#39A900] transition">¿Olvidaste tu contraseña?</a>
                    </div>
                </form>
                <?php if (isset($_GET['mensaje'])): ?>
                    <div class="bg-red-100 text-red-700 p-3 mt-4 rounded-lg text-sm text-center animate-fade-in">
                        ⚠️ <?= htmlspecialchars($_GET['mensaje']) ?>
                    </div>
                <?php elseif (isset($_GET['success'])): ?>
                    <div class="bg-green-100 text-green-700 p-3 mt-4 rounded-lg text-sm text-center animate-fade-in">
                        ✅ <?= htmlspecialchars($_GET['success']) ?>
                    </div>
                <?php endif; ?>
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
    <script>
        function validarFormulario() {
            const cedula = document.getElementById("cedula").value.trim();
            const password = document.getElementById("password").value.trim();
            if (cedula === "" || password === "") {
                alert("Por favor completa todos los campos.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
