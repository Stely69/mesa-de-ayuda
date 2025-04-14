<?php
require_once __DIR__ . '../../../../Controller/CasoController.php';
session_start();

$casoController = new CasoController();
$casoId = isset($_GET['id']) ? $_GET['id'] : null;
$caso = $casoController->getCaso($casoId); // Este método debe existir

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
</head>
<body class="bg-gray-100 p-6">
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
      <div>
        <dt class="font-semibold">Remite:</dt>
        <dd><?= htmlspecialchars($caso['usuario_id']) ?></dd>
      </div>
      <div>
        <dt class="font-semibold">Estado:</dt>
        <dd>
        <form action="">
          <select name="" id="">
            <option value=""><?= htmlspecialchars($caso['estado_id']) ?></option>
          </select>
          <!--Se muestra Los estados-->
        </form>
        </dd>
      </div>
      <div>
        <dt class="font-semibold lg:col-span-2">Asunto:</dt>
        <dd>
          <!--Aqui se muestra el Asunto  -->
          <p>Falta Asunto</p>          
        </dd>
      </div>
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
            </select>
          </form>
        </dd>
      </div>
    </dl>

    <a href="Tics" class="inline-block mt-6 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Volver</a>
  </div>
</body>
</html>
