<?php
$base_path = 'tics';
require_once __DIR__ . '../../../../Controller/CasoController.php';
require_once __DIR__ . '../../../../Controller/UserController.php';
session_start();

$casoController = new CasoController();
$casoId = isset($_GET['id']) ? $_GET['id'] : null;

// Si no se encuentra como caso general, intentar obtenerlo como caso por producto
$caso = $casoController->getCaso($casoId); // Este método debe existir

$user = new UserController();
$usuarioId = $user->gettics(); // Este método debe existir

//if (!$caso) {
  //echo "Caso no encontrado.";
  //exit;
//}


?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle del Caso</title>
  <script src="https://cdn.tailwindcss.com"></script>
      <!--Colores personalizados-->
      <script>
        tailwind.config = {
        theme: {
            extend: {
            colors: {
                senaGreen: '#39A900',
                senaGreenDark: '#2f8800',
            }
            }
        }
        }
  </script>
</head>
<body class="bg-gray-100 ">
<div class="flex min-h-screen">
<!-- Sidebar separado -->
    <?php include 'barra.php'; ?>

<!-- Main Content -->
    <main class="flex-1 p-6 ml-64 overflow-auto">
          <h2 class="text-2xl md:text-3xl font-semibold text-[#39A900] mb-6">Panel de Casos</h2>


          <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-8">
            <h1 class="text-2xl font-bold text-senaGreen mb-6">Detalle del Caso</h1>
            
            <dl class="space-y-6 text-gray-700">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                  <dt class="font-semibold text-gray-600 mb-1">Fecha de creación:</dt>
                  <dd class="text-gray-800"><?= htmlspecialchars($caso['fecha_creacion']) ?></dd>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                  <dt class="font-semibold text-gray-600 mb-1">Ambiente:</dt>
                  <dd class="text-gray-800"><?= htmlspecialchars($caso['ambiente']) ?></dd>
                </div>
                <?php if ($caso['instructor']): ?>
                  <div class="bg-gray-50 p-4 rounded-lg">
                    <dt class="font-semibold text-gray-600 mb-1">Instructor:</dt>
                    <dd class="text-gray-800"><?= htmlspecialchars($caso['instructor']) ?></dd>
                  </div>  
                <?php elseif ($caso['usuario_id']): ?>
                  <div class="bg-gray-50 p-4 rounded-lg">
                    <dt class="font-semibold text-gray-600 mb-1">Usuario:</dt>
                    <dd class="text-gray-800"><?= htmlspecialchars($caso['usuario_id']) ?></dd>
                  </div>
                <?php endif; ?>
                <?php if (isset($caso['producto']) && !empty($caso['producto'])): ?>
                  <div class="bg-gray-50 p-4 rounded-lg">
                    <dt class="font-semibold text-gray-600 mb-1">Producto:</dt>
                    <dd class="text-gray-800"><?= htmlspecialchars($caso['producto']) ?></dd>
                  </div>
                <?php endif; ?>
                <div class="bg-gray-50 p-4 rounded-lg">
                  <dt class="font-semibold text-gray-600 mb-1">Se le Asigno a:</dt>
                  <dd class="text-gray-800">
                    <?php if ($caso['auxiliar']): ?>
                      <?= htmlspecialchars($caso['auxiliar']) ?>
                    <?php else: ?>
                      <span class="text-gray-500">No asignado</span>
                    <?php endif; ?>
                  </dd>
                </div>
              </div>

              <div class="bg-gray-50 p-4 rounded-lg">
                <dt class="font-semibold text-gray-600 mb-1">Descripción:</dt>
                <dd class="text-gray-800"><?= htmlspecialchars($caso['descripcion'])?></dd>
              </div>

              <?php if (!empty($caso['imagen'])): ?>
                <div class="bg-gray-50 p-4 rounded-lg">
                  <dt class="font-semibold text-gray-600 mb-1">Imagen:</dt>
                  <dd>
                    <img src="../../uploads/<?= htmlspecialchars($caso['imagen'])?>" alt="Imagen del caso" class="max-w-xs mt-2 rounded-lg shadow-md" />
                  </dd>
                </div>
              <?php endif; ?>

              <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-senaGreen mb-4">Actualizar Estado y Asignación</h3>
                <form action="UpdatestatusAction" method="POST" class="space-y-4">
                  <input type="hidden" name="caso_id" value="<?= htmlspecialchars($caso['id']) ?>">
                  
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <label for="usuario_id" class="block font-medium text-gray-700 mb-2">Asignar a:</label>
                      <select name="usuario_id" id="usuario_id" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-senaGreen focus:border-senaGreen" required>
                        <option value="">-- Seleccionar --</option>
                        <?php foreach ($usuarioId as $usuario): ?>
                          <option value="<?= $usuario['id'] ?>" <?= $caso['asignado_a'] == $usuario['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($usuario['nombres']) ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div>
                      <label for="estado_id" class="block font-medium text-gray-700 mb-2">Estado:</label>
                      <select name="estado_id" id="estado_id" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-senaGreen focus:border-senaGreen" required>
                        <option value="1" <?= $caso['estado_id'] == 1 ? 'selected' : '' ?>>Pendiente</option>
                        <option value="2" <?= $caso['estado_id'] == 2 ? 'selected' : '' ?>>En Proceso</option>
                        <option value="3" <?= $caso['estado_id'] == 3 ? 'selected' : '' ?>>Resuelto</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <label for="observaciones" class="block font-medium text-gray-700 mb-2">Observaciones:</label>
                    <textarea name="observaciones" id="observaciones" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-senaGreen focus:border-senaGreen" rows="3" placeholder="Escribe una nota..."></textarea>
                  </div>

                  <button type="submit" class="bg-senaGreen text-white px-6 py-2 rounded-lg hover:bg-senaGreenDark transition-colors duration-300 shadow-md hover:shadow-lg">
                    Actualizar
                  </button>
                </form>
              </div>
            </dl>
            <a href="Tics" class="inline-block mt-6 px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-300 shadow-md hover:shadow-lg">Volver</a>
          </div>
        </div>
      </main>
</body>
</html>
