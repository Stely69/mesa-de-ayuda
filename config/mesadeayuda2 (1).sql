-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2025 a las 01:07:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mesadeayuda2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambientes`
--

CREATE TABLE `ambientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `ambientes`
--

INSERT INTO `ambientes` (`id`, `nombre`) VALUES
(1, 'Ambiente 101'),
(3, 'Ambiente 102'),
(4, 'Ambiente 103'),
(5, 'Ambiente 104'),
(6, 'Ambiente 105'),
(7, 'Ambiente 106'),
(8, 'Ambiente 107'),
(9, 'Ambiente 108'),
(10, 'Ambiente 109'),
(11, 'Ambiente 110');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambiente_productos`
--

CREATE TABLE `ambiente_productos` (
  `id` int(11) NOT NULL,
  `ambiente_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `ambiente_productos`
--

INSERT INTO `ambiente_productos` (`id`, `ambiente_id`, `producto_id`, `cantidad`) VALUES
(8, 3, 26, 1),
(12, 3, 33, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casos`
--

CREATE TABLE `casos` (
  `id` int(11) NOT NULL,
  `ambiente_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `asignado_a` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `auxiliar_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `casos`
--

INSERT INTO `casos` (`id`, `ambiente_id`, `instructor_id`, `producto_id`, `estado_id`, `asignado_a`, `descripcion`, `imagen`, `fecha_creacion`, `auxiliar_id`) VALUES
(12, 3, 1, 26, 1, 3, 'Falla al iniciar Windows', 'img_6812f188b9bd0.png', '2025-05-01 03:59:04', NULL),
(14, 3, 1, 26, 1, 3, 'Prueba de Correo ', 'img_6812f7ed9b75a.png', '2025-05-01 04:26:21', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `casos_generales`
--

CREATE TABLE `casos_generales` (
  `id` int(11) NOT NULL,
  `ambiente_id` int(11) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `estado_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `area_asignada` int(11) DEFAULT NULL,
  `asignado_a` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `casos_generales`
--

INSERT INTO `casos_generales` (`id`, `ambiente_id`, `asunto`, `descripcion`, `estado_id`, `instructor_id`, `area_asignada`, `asignado_a`, `fecha_creacion`) VALUES
(19, 3, 'Instalar Progrmamas', 'Nesecito que me instalen VS Code para todo los computadores del ambiente', 1, 3, 3, NULL, '2025-04-16 16:38:48'),
(24, 3, 'INSTALAR PROGRAMAS', 'INSTALAR XAMMP', 1, 1, 3, NULL, '2025-04-30 22:36:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases_producto`
--

CREATE TABLE `clases_producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `clases_producto`
--

INSERT INTO `clases_producto` (`id`, `nombre`) VALUES
(1, 'Pantallas'),
(2, 'PC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_casos`
--

CREATE TABLE `estados_casos` (
  `id` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `estados_casos`
--

INSERT INTO `estados_casos` (`id`, `estado`) VALUES
(4, 'Cerrado'),
(2, 'En Proceso'),
(1, 'Pendiente'),
(3, 'Resuelto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_casos`
--

CREATE TABLE `historial_casos` (
  `id` int(11) NOT NULL,
  `tipo_caso` enum('caso','caso_general') NOT NULL,
  `caso_id` int(11) NOT NULL,
  `estado_anterior_id` int(11) DEFAULT NULL,
  `estado_nuevo_id` int(11) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `password_reset`
--

INSERT INTO `password_reset` (`id`, `email`, `token`, `expires_at`) VALUES
(11, 'williamsteven237g@gmail.com', '59d0cfa0bc53147a5d2a89ea652f6f2247b968ba20450a6f735dd91cf093cabc903021dad19ce8e3671d65d903f1c611d721', '2025-04-15 20:09:06'),
(12, 'williamsteven237g@gmail.com', '8fbf97c52631ca9aad0645ef4b85e5078e702b4b0283a735e7916dad1be24f15cd384892e75885c31e5aeadc04448cf2c5c3', '2025-04-15 20:09:32'),
(13, 'williamsteven237g@gmail.com', '9a3e9b4e2e6dbf52022eeea0ad7223e4510575e513024d3c16ffcb523f26fff6be914b58eb92abca724f9736a2b61a69063f', '2025-04-23 19:58:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `numero_placa` varchar(50) NOT NULL,
  `serial` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `clase_id` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `numero_placa`, `serial`, `descripcion`, `modelo`, `clase_id`, `fecha_creacion`, `fecha_modificacion`) VALUES
(26, '950910182864', 'V5ZL4120', 'PC', 'asdasdvvx', 2, '2025-03-25 00:06:58', '2025-03-25 00:06:58'),
(33, '950910182867', 'MJ0EPSLA', 'adadada', '30DJS4S800', 2, '2025-03-26 17:40:02', '2025-03-26 17:40:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Administrador', ''),
(2, 'Instructor', ''),
(3, 'Tics', ''),
(4, 'Almacen', ''),
(5, 'Auxiliar Tics ', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `documento`, `nombres`, `apellido`, `correo`, `contraseña`, `rol_id`, `estado`) VALUES
(1, 1021663105, 'william Steven ', 'Vanegas Gomez', 'williamsteven237g@gmail.com', '$2y$10$S0.4UHBALATVCZ7yCXYSreLGfOdTNUip7UelT1GheNV/czA2FsL.G', 3, 'activo'),
(2, 12345678, 'felipe ', 'Muños', 'felipe@gmail.com', '$2y$10$d5Oq9Xw79yD.il84v2qBV.6igSt2p3JbcGG9FeXwYXATv565eYmm.', 4, 'activo'),
(3, 1234567899, 'julian ', 'Rivera', 'adadad@gamil.com', '$2y$10$ghMa6nDb29ypEJxvBZugSuR3Rj1KzWOBR5CavjkCH5OtShLa9ck0e', 2, 'activo'),
(10, 1234567, 'Kevin ', 'Chavez', 'kevin@gmail.com', '$2y$10$ZtbH5oP7PnDEmj3EgtAsrumWnZmeDaTfi3TG4qgQtodAyATzQODVm', 3, 'activo'),
(11, 12345, 'Wilson ', 'M', 'wilson@gmil.com', '$2y$10$Clp2NcB3YJVC3PRozB5xGO0BL8SpsBvFJoPc1HxzukcboMQEFssXK', 5, 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ambientes`
--
ALTER TABLE `ambientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ambiente_productos`
--
ALTER TABLE `ambiente_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ambiente_id` (`ambiente_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `casos`
--
ALTER TABLE `casos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_casos_ambiente` (`ambiente_id`),
  ADD KEY `fk_casos_usuario` (`instructor_id`),
  ADD KEY `fk_casos_producto` (`producto_id`),
  ADD KEY `fk_casos_estado` (`estado_id`),
  ADD KEY `fk_casos_asignado` (`asignado_a`),
  ADD KEY `fk_axiliar_id` (`auxiliar_id`);

--
-- Indices de la tabla `casos_generales`
--
ALTER TABLE `casos_generales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ambiente_id` (`ambiente_id`),
  ADD KEY `estado_id` (`estado_id`),
  ADD KEY `area_asignada` (`area_asignada`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `asignado_a` (`asignado_a`);

--
-- Indices de la tabla `clases_producto`
--
ALTER TABLE `clases_producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `estados_casos`
--
ALTER TABLE `estados_casos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `estado` (`estado`);

--
-- Indices de la tabla `historial_casos`
--
ALTER TABLE `historial_casos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estado_anterior_id` (`estado_anterior_id`),
  ADD KEY `estado_nuevo_id` (`estado_nuevo_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_placa` (`numero_placa`),
  ADD UNIQUE KEY `unique_serial` (`serial`),
  ADD KEY `fk_clase` (`clase_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ambientes`
--
ALTER TABLE `ambientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `ambiente_productos`
--
ALTER TABLE `ambiente_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `casos`
--
ALTER TABLE `casos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `casos_generales`
--
ALTER TABLE `casos_generales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `clases_producto`
--
ALTER TABLE `clases_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estados_casos`
--
ALTER TABLE `estados_casos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historial_casos`
--
ALTER TABLE `historial_casos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ambiente_productos`
--
ALTER TABLE `ambiente_productos`
  ADD CONSTRAINT `ambiente_productos_ibfk_1` FOREIGN KEY (`ambiente_id`) REFERENCES `ambientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ambiente_productos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `casos`
--
ALTER TABLE `casos`
  ADD CONSTRAINT `fk_axiliar_id` FOREIGN KEY (`auxiliar_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `fk_casos_ambiente` FOREIGN KEY (`ambiente_id`) REFERENCES `ambientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_casos_asignado` FOREIGN KEY (`asignado_a`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_casos_estado` FOREIGN KEY (`estado_id`) REFERENCES `estados_casos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_casos_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_casos_usuario` FOREIGN KEY (`instructor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `casos_generales`
--
ALTER TABLE `casos_generales`
  ADD CONSTRAINT `casos_generales_ibfk_1` FOREIGN KEY (`ambiente_id`) REFERENCES `ambientes` (`id`),
  ADD CONSTRAINT `casos_generales_ibfk_2` FOREIGN KEY (`estado_id`) REFERENCES `estados_casos` (`id`),
  ADD CONSTRAINT `casos_generales_ibfk_3` FOREIGN KEY (`area_asignada`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `casos_generales_ibfk_4` FOREIGN KEY (`instructor_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `casos_generales_ibfk_5` FOREIGN KEY (`asignado_a`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `historial_casos`
--
ALTER TABLE `historial_casos`
  ADD CONSTRAINT `historial_casos_ibfk_1` FOREIGN KEY (`estado_anterior_id`) REFERENCES `estados_casos` (`id`),
  ADD CONSTRAINT `historial_casos_ibfk_2` FOREIGN KEY (`estado_nuevo_id`) REFERENCES `estados_casos` (`id`),
  ADD CONSTRAINT `historial_casos_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
