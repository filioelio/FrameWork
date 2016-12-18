CREATE DATABASE IF NOT EXISTS hospedaje;
USE hospedaje;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";



CREATE TABLE `usuario` (
  `id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  `email` varchar(75) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(60) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(80) COLLATE utf8_bin NOT NULL,
  `telefono` char(9) COLLATE utf8_bin NOT NULL,
  `contrasena` varchar(48) COLLATE utf8_bin NOT NULL,
  `foto` varchar(60) CHARACTER SET latin1 DEFAULT NULL,
  `tipo` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT 'Normal',
  `estado` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `eventos` (
  `id_eventos` int(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `estart` date NOT NULL,
  `ennd` date NOT NULL,
  `background` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '#0073b7',
  `datos` varchar(50) COLLATE utf8_bin NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (id_eventos),
  FOREIGN KEY (fk_id_usuario) REFERENCES usuario (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `gasto` (
  `id_gasto` int(8) NOT NULL AUTO_INCREMENT,
  `recibe` varchar(60) COLLATE utf8_bin NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (id_gasto),
  FOREIGN KEY (fk_id_usuario) REFERENCES usuario (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `jornada` (
  `id_jornada` int(8) NOT NULL AUTO_INCREMENT,
  `fecha_ingreso` datetime NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (id_hornada),
  FOREIGN KEY (fk_id_usuario) REFERENCES usuario (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `personal` (
  `id_personal` char(8) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(40) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(40) COLLATE utf8_bin NOT NULL,
  `telefono` char(9) COLLATE utf8_bin NOT NULL,
  `direccion` varchar(50) COLLATE utf8_bin NOT NULL,
  `fecha_inicio` date NOT NULL,
  `labor` varchar(60) COLLATE utf8_bin NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (id_personal),
  FOREIGN KEY (fk_id_usuario) REFERENCES usuario (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `permiso` (
  `id_permiso` int(8) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_bin NOT NULL,
  `backgroundColor` varchar(25) COLLATE utf8_bin NOT NULL,
  `fk_id_personal` char(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (id_permiso),
  FOREIGN KEY (fk_id_personal) REFERENCES personal (id_personal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `salario` (
  `id_salario` int(8) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `tipo` varchar(50) COLLATE utf8_bin NOT NULL,
  `backgroundColor` varchar(25) COLLATE utf8_bin NOT NULL,
  `fk_id_personal` char(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (id_salario),
  FOREIGN KEY (fk_id_personal) REFERENCES personal (id_personal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `habitacion` (
  `id_habitacion` char(8) COLLATE utf8_bin NOT NULL,
  `tipo` varchar(20) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_bin NOT NULL,
  `estado` varchar(14) COLLATE utf8_bin NOT NULL DEFAULT 'Disponible',
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `foto` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (id_habitacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `huesped` (
  `id_huesped` char(8) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(60) COLLATE utf8_bin NOT NULL,
  `apellido` varchar(80) COLLATE utf8_bin NOT NULL,
  `procedencia` varchar(30) COLLATE utf8_bin NOT NULL,
  `telefono` char(9) COLLATE utf8_bin NOT NULL,
  `conducta` varchar(150) COLLATE utf8_bin NOT NULL DEFAULT 'Bueno',
  PRIMARY KEY (id_huesped)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



CREATE TABLE `hospedaje` (
  `id_hospedaje` int(8) NOT NULL AUTO_INCREMENT,
  `motivo_visita` varchar(60) COLLATE utf8_bin NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `estado` varchar(30) COLLATE utf8_bin NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `costo_total` decimal(10,2) NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_huesped` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_habitacion` char(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (id_hospedaje),
  FOREIGN KEY (fk_id_usuario) REFERENCES usuario (id_usuario),
  FOREIGN KEY (fk_id_huesped) REFERENCES huesped (id_huesped),
  FOREIGN KEY (fk_id_habitacion) REFERENCES habitacion (id_habitacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `auditoriahospedaje` (
  `id_auditoria` int(8) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `monto` decimal(10,0) NOT NULL DEFAULT '0',
  `fk_id_hospedaje` int(8) NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (id_auditoria),
  FOREIGN KEY (fk_id_usuario) REFERENCES usuario (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `venta` (
  `id_venta` int(8) NOT NULL AUTO_INCREMENT,
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha` datetime NOT NULL,
  `deuda` decimal(10,2) NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_hospedaje` int(8) DEFAULT NULL,
   PRIMARY KEY (id_venta),
   FOREIGN KEY (fk_id_usuario) REFERENCES usuario (id_usuario),
  FOREIGN KEY (fk_id_hospedaje) REFERENCES hospedaje (id_hospedaje)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `producto` (
  `id_producto` int(8) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_bin NOT NULL,
  `medida` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 'Unidad',
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock` int(10) NOT NULL DEFAULT '0',
  `foto` varchar(30) COLLATE utf8_bin DEFAULT 'NULL',
  PRIMARY KEY (id_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `auditoriaventa` (
  `id_auditoria` int(8) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fk_id_venta` int(8) NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL,
   PRIMARY KEY (id_auditoria),
  FOREIGN KEY (fk_id_usuario) REFERENCES usuario (id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `detalle_venta` (
  `id_detalle_venta` int(8) NOT NULL AUTO_INCREMENT,
  `cantidad` int(3) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fk_id_venta` int(8) NOT NULL,
  `fk_id_producto` int(8) NOT NULL,
  PRIMARY KEY (id_detalle_venta),
  FOREIGN KEY (fk_id_venta) REFERENCES venta (id_venta),
  FOREIGN KEY (fk_id_producto) REFERENCES producto (id_producto)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


CREATE TABLE `reservacion` (
  `id_reservacion` int(8) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) COLLATE utf8_bin NOT NULL,
  `fecha_reser` datetime NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `adelanto` decimal(10,2) NOT NULL,
  `estado` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  `fk_id_usuario` int(8) NOT NULL,
  `fk_id_huesped` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_habitacion` char(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (id_reservacion),
  FOREIGN KEY (fk_id_huesped) REFERENCES huesped (id_huesped),
  FOREIGN KEY (fk_id_habitacion) REFERENCES habitacion ( id_habitacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

