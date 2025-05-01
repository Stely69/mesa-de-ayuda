<?php
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
    <!-- Botón hamburguesa -->
    <div class="md:hidden p-4 bg-senaGreen text-white flex justify-between items-center">
        <span class="font-bold text-lg">Admin SENA</span>
        <button id="menuButton" class="focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-senaGreen text-white w-64 p-6 space-y-4 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40 md:relative md:block">
            <div class="flex justify-end md:hidden -mt-4 -mr-4">
                <button id="closeSidebar" class="text-white p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <h1 class="text-2xl font-bold mb-6">Admin SENA</h1>
            <nav class="flex flex-col space-y-3">
                <a href="../" class="p-2 hover:bg-white hover:text-senaGreen rounded">Inicio</a>
                <a href="GestiondeAuxiliares" class="p-2 hover:bg-white hover:text-senaGreen rounded">Gestion de Auxiliares</a>
                <a href="pendientes" class="p-2 hover:bg-white hover:text-senaGreen rounded">Casos</a>
                <hr class="border-white opacity-30">
                <?php if (isset($_SESSION["id"])): ?>
                    <a href="../Perfi/perfil" class="p-2 hover:bg-white hover:text-senaGreen rounded">Bienvenido, <?php echo $_SESSION["nombres"]; ?></a>
                <?php endif; ?>
                <a href="../Login/LogoutAction" class="p-2 hover:bg-white hover:text-senaGreen rounded">Cerrar Sesión</a>
            </nav>
        </aside>

        <main class="flex-1 p-4 md:p-6 md:ml-15 overflow-auto">
          <h2 class="text-2xl md:text-3xl font-semibold text-[#39A900] mb-6">Panel de Casos</h2>


          <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-xl p-6 ">
            <h1 class="text-2xl font-bold text-[#39A900] mb-4 s">Detalle del Caso</h1>
            
            <dl class="space-y-3 text-gray-700 lg:grid lg:grid-cols-2 gap-6">
              <div class="col-span-2">
                <dt class="font-semibold">Fecha de creación:</dt>
                <dd><?= htmlspecialchars($caso['fecha_creacion']) ?></dd>
              </div>
              <div>
                <dt class="font-semibold">Ambiente:</dt>
                <dd><?= htmlspecialchars($caso['ambiente']) ?></dd>
              </div>
              <?php if ($caso['instructor']): ?>
                <div>
                  <dt class="font-semibold">Instructor:</dt>
                  <dd><?= htmlspecialchars($caso['instructor']) ?></dd>
                </div>  
              <?php elseif ($caso['usuario_id']): ?>
                <div>
                  <dt class="font-semibold">Usuario:</dt>
                  <dd><?= htmlspecialchars($caso['usuario_id']) ?></dd>
                </div>
              <?php endif; ?>
              <?php if (isset($caso['producto']) && !empty($caso['producto'])): ?>
                <div class="col-span-2">
                  <dt class="font-semibold">Producto:</dt>
                  <dd><?= htmlspecialchars($caso['producto']) ?></dd>
                </div>
              <?php endif; ?>
              <div class="col-span-2">
                <dt class="font-semibold">Descripcion:</dt>
                <dd><?= htmlspecialchars($caso['descripcion'])?></dd>
              </div>
              <div>
                <dt class="font-semibold">Imagen:</dt>
                <dd>
                  <?php if (!empty($caso['imagen'])): ?>
                    <img src="../../uploads/<?= htmlspecialchars($caso['imagen'])?>" alt="Imagen del caso" class="max-w-xs mt-2 rounded-lg shadow" />
                  <?php else: ?>
                    <span>No se cargó imagen</span>
                  <?php endif; ?>
                </dd>
              </div>
              <div>
                <dt class="font-semibold">Se le Asigno a</dt>
                <dd>
                  <?php if ($caso['auxiliar']): ?>
                    <?= htmlspecialchars($caso['auxiliar']) ?>
                  <?php else: ?>
                    <span>No asignado</span>
                  <?php endif; ?>
                </dd>
              </div>
              <!-- Puedes añadir más campos aquí -->
              <div class="col-span-2">
                <form action="UpdatestatusAction" method="POST" class="space-y-4">
                  <input type="hidden" name="caso_id" value="<?= htmlspecialchars($caso['id']) ?>">
                  <!-- Fila de Asignar a y Estado -->
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label for="usuario_id" class="block font-semibold">Asignar a:</label>
                      <select name="usuario_id" id="usuario_id" class="w-full border border-gray-300 rounded p-2" required>
                        <option value="">-- Seleccionar --</option>
                        <?php foreach ($usuarioId as $usuario): ?>
                          <option value="<?= $usuario['id'] ?>" <?= $caso['asignado_a'] == $usuario['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($usuario['nombres']) ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div>
                      <label for="estado_id" class="block font-semibold">Estado:</label>
                      <select name="estado_id" id="estado_id" class="w-full border border-gray-300 rounded p-2" required>
                        <option value="1" <?= $caso['estado_id'] == 1 ? 'selected' : '' ?>>Pendiente</option>
                        <option value="2" <?= $caso['estado_id'] == 2 ? 'selected' : '' ?>>En Proceso</option>
                        <option value="3" <?= $caso['estado_id'] == 3 ? 'selected' : '' ?>>Resuelto</option>
                        <!-- Agrega más estados si tienes -->
                      </select>
                    </div>
                  </div>

                  <!-- Observaciones -->
                  <div>
                    <label for="observaciones" class="block font-semibold">Observaciones:</label>
                    <textarea name="observaciones" id="observaciones" class="w-full border border-gray-300 rounded p-2" rows="3" placeholder="Escribe una nota..."></textarea>
                  </div>

                  <!-- Botón de Actualizar -->
                  <button type="submit" class="bg-senaGreen text-white px-4 py-2 rounded mt-2 hover:bg-senaGreenDark">Actualizar</button>
                </form>
              </div>
            </dl>
            <a href="Tics" class="inline-block mt-6 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Volver</a>
          </div>
        </div>
      </main>
</body>
</html>
