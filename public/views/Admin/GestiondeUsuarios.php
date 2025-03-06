<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>

    <div class="relative flex items-center justify-center min-h-screen">
            <div class="bg-white p-10 rounded-lg shadow-lg w-[500px]">
                <div class="flex justify-center mb-4">
                    <img src="../../../pictures/logoSena.png" alt="Logo de la entidad" class="h-16">
                </div>
                <h2 class="text-3xl font-bold text-center text-[#39A900]">Registo</h2>
                <form action="RegistroAction.php" method="POST">
                    <label for="cedula" class="block text-sm font-medium text-gray-700">Cedula</label>
                    <input type="text" name="cedula" required>
                    <label for="email" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="email" name="nombre" required>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" name="correo" required>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" name="contraseña" required>
                    <label for="email" class="block text-sm font-medium text-gray-700">Selseciona un rol</label>
                    <select name="rol" required>
                        <option value="1">Administrador</option>
                        <option value="2">Instructor</option>
                        <option value="3">TI</option>
                        <option value="4">Almacén</option>
                    </select>
                    <button type="submit">Registrar</button>
                </form>
            </div>
    </div>

    
</body>
</html>