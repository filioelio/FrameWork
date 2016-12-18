-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2016 a las 16:09:25
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.21
CREATE DATABASE IF NOT EXISTS hospedaje;
USE hospedaje;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hopedaje`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_personal`
--

CREATE TABLE `control_personal` (
  `id_control` int(8) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `calificacion` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT 'Bueno',
  `fk_id_personal` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id_venta` int(8) NOT NULL,
  `cantidad` int(8) NOT NULL DEFAULT '1',
  `fk_id_producto` int(8) NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_hopedaje` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `id_habitacion` char(8) COLLATE utf8_bin NOT NULL,
  `tipo` varchar(20) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_bin NOT NULL,
  `estado` varchar(14) COLLATE utf8_bin NOT NULL DEFAULT 'Disponible',
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `foto` varchar(10) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`id_habitacion`, `tipo`, `descripcion`, `estado`, `precio`, `foto`) VALUES
('201', 'Doble', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '60.00', '201.jpg'),
('202', 'Doble', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '50.00', '202.png'),
('203', 'Matrimonial', 'baño privado, doble cama, agua caliente, tv cable', 'Ocupado', '60.00', '203.png'),
('204', 'Individual', 'baño privado, doble cama, tv cable, agua caliente', 'Reservado', '40.00', '204.jpg'),
('205', 'Individual', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '70.00', '205.jpg'),
('301', 'Familiar', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '70.00', '301.jpg'),
('302', 'Doble', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '80.00', '302.jpg'),
('303', 'Individual', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '60.00', '303.jpg'),
('304', 'Familiar', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '90.00', '304.jpg'),
('305', 'Matrimonial', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '90.00', '305.jpg'),
('306', 'Matrimonial', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '100.00', '306.jpg'),
('401', 'Familiar', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '80.00', '401.jpg'),
('402', 'Doble', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '80.00', '402.jpg'),
('403', 'Doble', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '70.00', '403.jpg'),
('404', 'Matrimonial', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '90.00', '404.jpg'),
('405', 'Individual', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '70.00', '405.jpg'),
('501', 'Familiar', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '70.00', '501.jpg'),
('502', 'Familiar', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '90.00', '502.jpg'),
('503', 'Matrimonial', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '100.00', '503.jpg'),
('504', 'Doble', 'Baño compartido, doble cama, agua caliente', 'Ocupado', '45.00', '504.jpg'),
('505', 'Matrimonial', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '100.00', '505.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospedaje`
--
UPDATE `habitacion` SET `id_habitacion`=NEW.fk_id_habitacion,`tipo`=OLD.tipo,`descripcion`=OLD.descripcion,`estado`=OLD.estado,`precio`=OLD.precio,`foto`=OLD.foto WHERE `id_habitacion`=NEW.fk_id_habitacion

CREATE TABLE `hospedaje_cop` (
  `id_hospedaje_cop` int(8) NOT NULL,
  `procedencia_cop` varchar(100) COLLATE utf8_bin NOT NULL,
  `motivo_visita_cop_cop` varchar(100) COLLATE utf8_bin NOT NULL,
  `fecha_ingreso_cop` datetime NOT NULL,
  `fecha_salida_cop` datetime NOT NULL,
  `fk_id_usuario_cop` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_huesped_cop` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_habitacion_cop` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `hospedaje`
--

INSERT INTO `hospedaje` (`id_hospedaje`, `procedencia`, `motivo_visita`, `fecha_ingreso`, `fecha_salida`, `fk_id_usuario`, `fk_id_huesped`, `fk_id_habitacion`) VALUES
(2, 'Lima', 'Trabajo', '2016-10-14 14:08:27', '2016-10-16 00:00:00', '47050254', '47050230', '202'),
(3, 'Arequipa', 'Trabajo', '2016-10-14 20:16:42', '2016-10-17 00:00:00', '47050254', '47050231', '303'),
(4, 'Cusco', 'Turismo', '2016-10-14 20:18:17', '2016-10-21 00:00:00', '47050254', '47050232', '201'),
(5, 'Tumbes', 'Trabajo', '2016-10-14 20:19:54', '2016-10-20 00:00:00', '47050254', '47050233', '301'),
(6, 'Cusco', 'Turismo', '2016-10-14 20:21:19', '2016-10-20 00:00:00', '47050254', '47050234', '302'),
(7, 'Lima', 'Trabajo', '2016-10-14 20:22:35', '2016-10-22 00:00:00', '47050254', '47050235', '401'),
(8, 'Juliaca', 'Trabajo', '2016-10-14 20:47:39', '2016-10-16 00:00:00', '47050254', '47050236', '305'),
(9, 'Tumbes', 'Trabajo', '2016-10-14 20:48:47', '2016-10-18 00:00:00', '47050254', '47050237', '501'),
(10, 'Andahuaylas', 'Turismo', '2016-10-14 20:49:50', '2016-10-18 00:00:00', '47050254', '47050238', '405'),
(11, 'Trujillo', 'Turismo', '2016-10-14 20:51:15', '2016-10-20 00:00:00', '47050254', '47050239', '404'),
(12, 'Ayacucho', 'Visita', '2016-10-14 20:53:20', '2016-10-16 00:00:00', '47050254', '47050240', '402'),
(13, 'Arica', 'Turismo', '2016-10-14 20:55:08', '2016-10-19 00:00:00', '47050254', '47050241', '403'),
(14, 'Puno', 'Visita', '2016-10-14 21:05:23', '2016-10-19 00:00:00', '47050254', '47050242', '505'),
(15, 'Puno', 'Visita', '2016-10-14 21:08:04', '2016-10-19 00:00:00', '47050254', '47050242', '505'),
(16, 'Ica', 'Turismo', '2016-10-14 21:09:13', '2016-10-20 00:00:00', '47050254', '47050243', '505'),
(17, 'Madre de Dios', 'Turismo', '2016-10-14 21:12:00', '2016-10-23 00:00:00', '47050254', '47050244', '505'),
(18, 'Quillabamba', 'Turismo', '2016-10-14 21:16:29', '2016-10-25 00:00:00', '47050254', '47050245', '505'),
(19, 'Tumbes', 'Trabajo', '2016-10-14 22:45:14', '2016-10-22 00:00:00', '47050254', '47050237', '305'),
(20, 'Cajamarca', 'Trabajo', '2016-10-14 22:48:45', '2016-10-18 00:00:00', '47050254', '47050246', '503');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `huesped`
--

CREATE TABLE `huesped` (
  `id_huesped` char(8) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(60) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(80) COLLATE utf8_bin NOT NULL,
  `procedencia` varchar(30) COLLATE utf8_bin NOT NULL,
  `telefono` char(9) COLLATE utf8_bin NOT NULL,
  `conducta` varchar(150) COLLATE utf8_bin NOT NULL DEFAULT 'Bueno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `huesped`
--

INSERT INTO `huesped` (`id_huesped`, `nombre`, `apellido`, `procedencia`, `telefono`, `conducta`) VALUES
('47050230', 'Fredy', 'Cardenas Cruz', 'Lima', '983457898', 'Bueno'),
('47050231', 'Ana Maria', 'Quispe Ramos', 'Arequipa', '962846003', 'Buena'),
('47050232', 'Kenny', 'Ramos Vilcas', 'Cusco', '985613245', 'Bueno'),
('47050233', 'Rossmin', 'Vilcas Hurtado', 'Tumbes', '985613245', 'Bueno'),
('47050234', 'Filio', 'Vilcas Hurtado', 'Cusco', '983457898', 'Bueno'),
('47050235', 'Maria', 'Condori Ancco', 'Lima', '962458795', 'Buena'),
('47050236', 'Ana', 'Sulivan Quispe', 'Juliaca', '954395349', 'Buena'),
('47050237', 'Jhon', 'Huaman Rojas', 'Tumbes', '983423748', 'Bueno'),
('47050238', 'Julian', 'Villegas Quispe', 'Andahuaylas', '983423748', 'Bueno'),
('47050239', 'Rojer', 'Connor Quispe', 'Trujillo', '983696939', 'Bueno'),
('47050240', 'Eva', 'Montaner Quispe', 'Ayacucho', '983457898', 'Buena'),
('47050241', 'Georgina', 'Contreras Muños', 'Arica', '983696939', 'Buena'),
('47050242', 'Felicia', 'Rodrigues Ramos', 'Puno', '962846003', 'Buena'),
('47050243', 'Rodrigo', 'Gomes Gonzales', 'Ica', '983423748', 'Bueno'),
('47050244', 'Brahan', 'Roman Condori', 'Madre de Dios', '962458795', 'Bueno'),
('47050245', 'Nora', 'Gonzales Ramos', 'Quillabamba', '985613245', 'Bueno'),
('47050246', 'Ronald', 'Rios Contreras', 'Cajamarca', '983696939', 'Bueno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id_personal` char(8) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(100) COLLATE utf8_bin NOT NULL,
  `telefono` char(9) COLLATE utf8_bin NOT NULL,
  `direccion` varchar(100) COLLATE utf8_bin NOT NULL,
  `estado` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(8) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_bin NOT NULL,
  `medida` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 'Unidad',
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock` int(10) NOT NULL DEFAULT '0',
  `foto` varchar(30) COLLATE utf8_bin DEFAULT 'NULL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `descripcion`, `medida`, `precio`, `stock`, `foto`) VALUES
(1, 'Inca Kola', '2.25', 'Litros', '5.00', 6, 'Inca Kola.png'),
(2, 'Coca Cola', '1.25', 'Litros', '3.00', 6, 'Inca Cola.png'),
(3, 'Agua Cielo', '1', 'Litro', '1.00', 12, 'Agua Mineral.png'),
(4, 'Charada', 'galleta', 'Unidad', '1.00', 24, 'Charada.png'),
(5, 'Casino', 'Galleta', 'Unidad', '1.00', 24, 'Casino .png'),
(6, 'Morochas', 'Galleta', 'Unidad', '1.00', 24, 'morochas.png'),
(7, 'Morochas snack', 'Galleta', 'Unidad', '2.00', 24, 'Morochas snack.png'),
(8, 'Frugos Durasno', '1', 'Litro', '3.50', 12, 'Frugos .png'),
(9, 'Fanta', '500', 'ml', '2.00', 24, 'Fanta.png'),
(10, 'Colgate', 'Colinos', 'Unidad', '8.00', 24, 'Colgate.png'),
(11, 'Kolynos', 'colinos', 'Unidad', '5.00', 24, 'Kolynos.png'),
(12, 'Cepillo Dental', 'Colgate', 'Unidad', '2.50', 12, 'Cepillo Dental.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservacion`
--

CREATE TABLE `reservacion` (
  `id_reservacion` int(8) NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_bin NOT NULL,
  `fecha_reser` datetime NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `fk_id_usuario` int(8) NOT NULL,
  `fk_id_huesped` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_habitacion` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `reservacion`
--

INSERT INTO `reservacion` (`id_reservacion`, `descripcion`, `fecha_reser`, `fecha_ingreso`, `fecha_salida`, `fk_id_usuario`, `fk_id_huesped`, `fk_id_habitacion`) VALUES
(1, 'Falta pagar', '2016-10-15 08:53:22', '2016-10-16 00:00:00', '2016-10-18 00:00:00', 47050254, '47050232', '501');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  `email` varchar(75) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(60) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(80) COLLATE utf8_bin NOT NULL,
  `telefono` char(9) COLLATE utf8_bin NOT NULL,
  `contrasena` varchar(48) COLLATE utf8_bin NOT NULL,
  `foto` varchar(60) CHARACTER SET latin1 DEFAULT NULL,
  `tipo` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT 'Normal',
  `estado` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `email`, `nombre`, `apellido`, `telefono`, `contrasena`, `foto`, `tipo`, `estado`) VALUES
('47050251', 'yessy@framawork.com', 'Yessy', 'Contreras Sierra', '849254528', '1dd3780be29e4eaeedf59f796bca3bfb', 'Yessy.jpg', 'Normal', 'Activo'),
('47050252', 'pepo@framawork.com', 'Roberth', 'Huaman Caceres', '962458795', '1dd3780be29e4eaeedf59f796bca3bfb', 'Roberth.jpg', 'Normal', 'Activo'),
('47050253', 'maxi@framework.com', 'Maximiliana', 'Sauñe Arostegui', '985613245', '1dd3780be29e4eaeedf59f796bca3bfb', 'Maximiliana .jpg', 'Normal', 'Activo'),
('47050254', 'filio@framework.com', 'Filio Elio', 'Carrasco Sauñe', '962846003', '1dd3780be29e4eaeedf59f796bca3bfb', 'Filio Elio.jpg', 'Admin', 'Activo'),
('47050255', 'silvia@framework.com', 'Silvia', 'Carrasco Sauñe', '983423748', '1dd3780be29e4eaeedf59f796bca3bfb', 'Silvia.jpg', 'Normal', 'Activo'),
('47050256', 'andy@framework.com', 'Andy Ismael', 'Carrasco Sauñe', '968574152', '1dd3780be29e4eaeedf59f796bca3bfb', 'Andy Ismael.jpg', 'Normal', 'Activo'),
('47050257', 'abigail@framework.com', 'Abigail', 'Taipe Ccana', '983457898', '1dd3780be29e4eaeedf59f796bca3bfb', 'Abigail.jpg', 'Normal', 'Activo'),
('47050258', 'nilton@framawork.com', 'Nilton', 'Hurtado Mendoza', '954395349', '1dd3780be29e4eaeedf59f796bca3bfb', 'Nilton.jpg', 'Normal', 'Activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `control_personal`
--
ALTER TABLE `control_personal`
  ADD PRIMARY KEY (`id_control`),
  ADD KEY `fk_id_personal` (`fk_id_personal`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fk_id_producto` (`fk_id_producto`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`),
  ADD KEY `fk_id_hopedaje` (`fk_id_hopedaje`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`id_habitacion`),
  ADD UNIQUE KEY `id_habitacion` (`id_habitacion`);

--
-- Indices de la tabla `hospedaje`
--
ALTER TABLE `hospedaje`
  ADD PRIMARY KEY (`id_hospedaje`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`),
  ADD KEY `fk_id_huesped` (`fk_id_huesped`),
  ADD KEY `fk_id_habitacion` (`fk_id_habitacion`);

--
-- Indices de la tabla `huesped`
--
ALTER TABLE `huesped`
  ADD PRIMARY KEY (`id_huesped`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id_personal`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `reservacion`
--
ALTER TABLE `reservacion`
  ADD PRIMARY KEY (`id_reservacion`),
  ADD KEY `fk_id_huesped` (`fk_id_huesped`),
  ADD KEY `fk_id_habitacion` (`fk_id_habitacion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `dni` (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `control_personal`
--
ALTER TABLE `control_personal`
  MODIFY `id_control` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id_venta` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `hospedaje`
--
ALTER TABLE `hospedaje`
  MODIFY `id_hospedaje` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `reservacion`
--
ALTER TABLE `reservacion`
  MODIFY `id_reservacion` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `control_personal`
--
ALTER TABLE `control_personal`
  ADD CONSTRAINT `control_personal_ibfk_1` FOREIGN KEY (`fk_id_personal`) REFERENCES `personal` (`id_personal`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`fk_id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `detalle_venta_ibfk_3` FOREIGN KEY (`fk_id_hopedaje`) REFERENCES `hospedaje` (`id_hospedaje`);

--
-- Filtros para la tabla `hospedaje`
--
ALTER TABLE `hospedaje`
  ADD CONSTRAINT `hospedaje_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `hospedaje_ibfk_2` FOREIGN KEY (`fk_id_huesped`) REFERENCES `huesped` (`id_huesped`),
  ADD CONSTRAINT `hospedaje_ibfk_3` FOREIGN KEY (`fk_id_habitacion`) REFERENCES `habitacion` (`id_habitacion`);

--
-- Filtros para la tabla `reservacion`
--
ALTER TABLE `reservacion`
  ADD CONSTRAINT `reservacion_ibfk_1` FOREIGN KEY (`fk_id_huesped`) REFERENCES `huesped` (`id_huesped`),
  ADD CONSTRAINT `reservacion_ibfk_2` FOREIGN KEY (`fk_id_habitacion`) REFERENCES `habitacion` (`id_habitacion`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
