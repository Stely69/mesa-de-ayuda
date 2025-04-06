<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('../../pictures/fondo.jpg');">
    <!-- Capa blanca semitransparente -->
    <div class="absolute inset-0 bg-white bg-opacity-40"></div>

    <div class="relative flex items-center justify-center min-h-screen  px-4">

        <div class="bg-white p-8 sm:p-10 rounded-xl shadow-2xl w-full max-w-md">
                    <!-- Logo -->
            <div class="flex justify-center mb-6">
                <a href="../">
                    <img src="../../pictures/logoSena.png" alt="Logo de la entidad" class="h-16">
                </a>
            </div>
                    
            <!-- Título -->
            <h2 class="text-3xl font-bold text-center text-[#39A900]">Iniciar Sesión</h2>
                    
            <!-- ALERTA (éxito o error) -->
            <!-- Puedes mostrar esto dinámicamente con PHP, JS, o un backend -->
            <!-- Ejemplo de error -->
            <?php if (isset($_GET['mensaje'])): ?>
                <div id="alerta" class="bg-red-100 text-red-700 p-3 mt-4 rounded-lg text-sm">
                    ⚠️ <?= htmlspecialchars($_GET['mensaje']) ?>
                </div>
            <?php endif; ?>       
                    <!-- Formulario -->
            <form action="LoginAction" method="POST" class="mt-6 space-y-5" onsubmit="return validarFormulario();">
                        
                        <!-- Documento -->
                <div>
                    <label for="cedula" class="block text-sm font-medium text-gray-700">Documento</label>
                    <input type="text" id="cedula" name="cedula" required
                        class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                </div>   
                        <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#39A900]">
                </div>
                        
                        <!-- Enlace de recuperación -->
                <div class="text-right">
                    <a href="recuperar" class="text-sm text-[#39A900] hover:underline">Olvidé mi contraseña</a>
                </div>
                <!-- Botón -->
                <button type="submit"
                    class="w-full bg-[#39A900] text-white p-3 rounded-lg hover:bg-green-700 transition">
                    Ingresar
                </button>
            </form>
        </div>
    </div>

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

    <script>
        function validarFormulario() {
            const cedula = document.getElementById("cedula").value.trim();
            const password = document.getElementById("password").value.trim();

            if (cedula === "" || password === "") {
                mostrarAlerta("Por favor completa todos los campos.");
                return false;
            }

            // Aquí puedes agregar validaciones adicionales si quieres
            return true;
        }

        // Espera 4 segundos y oculta el mensaje
        setTimeout(() => {
            const alerta = document.getElementById('alerta');
            if (alerta) {
                alerta.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => alerta.remove(), 500); // Elimina del DOM después de la transición
            }
        }, 4000); // 4 segundos
    </script>
</body>
</html>
