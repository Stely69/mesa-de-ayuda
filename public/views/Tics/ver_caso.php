<?php
require_once __DIR__ . '../../../../Controller/CasoController.php';
require_once __DIR__ . '../../../../Controller/UserController.php';
session_start();

$casoController = new CasoController();
$casoId = isset($_GET['id']) ? $_GET['id'] : null;

// Intentar obtener el caso como caso general
$caso = $casoController->getcasogeneral($casoId); // Este método debe existir

// Si no se encuentra como caso general, intentar obtenerlo como caso por producto
if (!$caso) {
  $caso = $casoController->getCaso($casoId); // Este método debe existir
}

$user = new UserController();
$usuarioId = $user->gettics(); // Este método debe existir

if (!$caso) {
  echo "Caso no encontrado.";
  exit;
}


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
              <div>
                <dt class="font-semibold">Fecha de creación:</dt>
                <dd><?= htmlspecialchars($caso['fecha_creacion']) ?></dd>
              </div>
              <div>
                <dt class="font-semibold">Ambiente:</dt>
                <dd><?= htmlspecialchars($caso['ambiente_id']) ?></dd>
              </div>
              <?php if ($caso['instructor_id']): ?>
                <div>
                  <dt class="font-semibold">Instructor:</dt>
                  <dd><?= htmlspecialchars($caso['instructor_id']) ?></dd>
                </div>  
              <?php elseif ($caso['usuario_id']): ?>
                <div>
                  <dt class="font-semibold">Usuario:</dt>
                  <dd><?= htmlspecialchars($caso['usuario_id']) ?></dd>
                </div>
              <?php endif; ?>
              <div>
                <dt class="font-semibold">Estado:</dt>
                <dd>
                <form action="">
                  <select name="" id="">
                    <option value="<?= htmlspecialchars($caso['estado_id']) ?>">Pendiente</option>
                    <option value="2">En Proceso</option>
                  </select>
                  <!--Se muestra Los estados-->
                </form>
                </dd>
              </div>
              <?php if (isset($caso['asunto']) && !empty($caso['asunto'])): ?>
                <div class="col-span-2">
                  <dt class="font-semibold">Asunto:</dt>
                  <dd><?= htmlspecialchars($caso['asunto']) ?></dd>
                </div>
              <?php endif; ?>
              <div>
                <dt class="font-semibold">Descripcion:</dt>
                <dd><?= htmlspecialchars($caso['descripcion'])?></dd>
              </div>
              <div>
                <dt class="font-semibold">Imagen:</dt>
                <dd><?= !empty($caso['imagen']) ? htmlspecialchars($caso['imagen']) : 'No se cargo imagen' ?></dd>
              </div>
              <!-- Puedes añadir más campos aquí -->
              <div>
                <dt class="font-semibold">Asignar:</dt>
                <dd>
                  <form action="">
                    <select name="" id="">Selecciona un usuario
                      <option value="">-- Seleccionar --</option>
                      <!-- Aquí deberías cargar los usuarios desde la base de datos -->
                      <?php foreach ($usuarioId as $usuario): ?>
                        <option value="<?= htmlspecialchars($usuario['id']) ?>"><?= htmlspecialchars($usuario['nombres']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </form>
                </dd>
              </div>
            </dl>
            <a href="Tics" class="inline-block mt-6 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Volver</a>
          </div>
        </div>
      </main>
</body>
</html>
