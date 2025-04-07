<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css">
    <title>Error 404 - GEDAC</title>
</head>
<body>
    <!-- Contenedor principal de la página -->
    <div class="flex items-center justify-center min-h-screen bg-white py-48">
        <div class="flex flex-col">

            <!-- Contenedor de error -->
            <div class="flex flex-col items-center">
                <!-- Código de error 404 -->
                <div class="text-[#39A900] font-bold text-7xl">
                    404
                </div>

                <!-- Mensaje de error -->
                <div class="font-bold text-3xl xl:text-7xl lg:text-6xl md:text-5xl mt-10 text-[#39A900] text-center">
                    Página no encontrada
                </div>

                <!-- Mensaje adicional -->
                <div class="text-gray-500 font-medium text-sm md:text-xl lg:text-2xl mt-8 text-center">
                    La página que estás buscando no existe o ha sido movida.
                </div>
            </div>

            <!-- Si hay un error, se muestra aquí -->
            <?php if(isset($_GET['mensaje'])):?>
                <p class="text-red-500 mt-4 text-center"><?php echo $_GET['mensaje']; ?></p>
            <?php endif; ?>

            <!-- Continuar con opciones -->
            <div class="flex flex-col mt-48">
                <div class="text-[#39A900] font-bold uppercase text-center">
                    Continuar con
                </div>

                <div class="flex flex-col items-stretch mt-5">

                    <!-- Elementos de navegación (reutilizados con verde) -->
                    <?php
                        $opciones = [
                            ["mdi-home-outline", "Inicio", "Volver a la página principal"],
                            ["mdi-book-open-page-variant-outline", "Documentación", "Encuentra guías y ayuda"],
                            ["mdi-archive-settings-outline", "Historial", "Tus actividades recientes"],
                            ["mdi-at", "Contacto", "Escríbenos tus dudas"]
                        ];
                        foreach ($opciones as $opcion): ?>
                        <div class="flex flex-row group px-4 py-8 border-t hover:cursor-pointer transition-all duration-200 delay-100">
                            <div class="rounded-xl bg-green-100 px-3 py-2 md:py-4">
                                <i class="mdi <?= $opcion[0] ?> mx-auto text-[#2f7300] text-2xl md:text-3xl"></i>
                            </div>
                            <div class="grow flex flex-col pl-5 pt-2">
                                <div class="font-bold text-sm md:text-lg lg:text-xl group-hover:underline text-[#39A900]">
                                    <?= $opcion[1] ?>
                                </div>
                                <div class="font-semibold text-sm md:text-md lg:text-lg text-gray-400 group-hover:text-gray-500 transition-all duration-200 delay-100">
                                    <?= $opcion[2] ?>
                                </div>
                            </div>
                            <i class="mdi mdi-chevron-right text-gray-400 mdi-24px my-auto pr-2 group-hover:text-[#39A900] transition-all duration-200 delay-100"></i>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</body>
</html>