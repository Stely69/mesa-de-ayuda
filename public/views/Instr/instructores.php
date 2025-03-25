<?php 
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    $controller = new CasoController();
    $ambientes = $controller->allambientes();
    $productos = $controller->getambientesP('ambiente_id');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Novedad</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Barra Lateral -->
        <div class="w-64 bg-[#39A900] text-white p-5 flex flex-col justify-between">
            <div>
                <h1 class="text-2xl font-bold">Operaciones</h1>
                <nav class="mt-4">
                    <ul>
                        <li class="mb-2"><a href="#" class="block py-2 px-4 bg-green-800 rounded">Inventario</a></li>
                        <li class="mb-2"><a href="#" class="block py-2 px-4">Historial</a></li>
                        <li class="mb-2"><a href="#" class="block py-2 px-4">Reportes</a></li>
                    </ul>
                </nav>
            </div>
            <button class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Cerrar Sesión</button>
        </div>
        
        <!-- Contenido Principal -->
        <div class="flex-1 p-10 relative">
            <!-- Botón Perfil -->
            <a href="perfil.php" class="absolute top-0 right-0 mt-4 mr-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Mi Perfil</a>
            
            <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Seleccionar un ambiente</h2>

                <form action="GetAmbienteAction" method="POST">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold">Selecciona un ambiente:</label>
                        <select name="ambiente_id" class="w-full p-2 border border-gray-300 rounded" onchange="this.form.submit()">
                            <option value="">-- Seleccionar --</option>
                            <?php foreach ($ambientes as $ambiente) { ?>
                                <option value="<?= $ambiente['id'] ?>" <?= (isset($_POST['ambiente_id']) && $_POST['ambiente_id'] == $ambiente['id']) ? 'selected' : '' ?>>
                                    <?= $ambiente['nombre'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </form>

                <?php if (!empty($productos)) { ?>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold">Selecciona un producto:</label>
                        <select name="producto_id" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">-- Seleccionar --</option>
                            <?php foreach ($productos as $producto) { ?>
                                <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?> (Placa: <?= $producto['numero_placa'] ?>)</option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>

                <form action="/casos/registrarCaso" method="POST">
                    <input type="hidden" name="ambiente_id" value="<?= $_POST['ambiente_id'] ?? '' ?>">
                    <input type="hidden" name="producto_id" value="<?= $_POST['producto_id'] ?? '' ?>">

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold">Descripción de la novedad:</label>
                        <textarea name="descripcion" class="w-full p-2 border border-gray-300 rounded" rows="4"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold">Enviar a departamento:</label>
                        <select name="asignado_a" class="w-full p-2 border border-gray-300 rounded">
                            <option value="3">Soporte Técnico TICS</option>
                            <option value="4">Almacén</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-[#39A900] hover:bg-green-800 text-white font-bold py-2 px-4 rounded">Registrar Novedad</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
