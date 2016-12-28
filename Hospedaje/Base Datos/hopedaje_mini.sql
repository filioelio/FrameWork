-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-12-2016 a las 01:03:18
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 7.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hopedaje_mini`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `BuscarHuespedId` (IN `patron` CHAR(8))  BEGIN

IF EXISTS (SELECT ho.id_hospedaje, ha.id_habitacion, CONCAT(hu.nombre, ' ', hu.apellido) AS huesped, ho.fecha_ingreso, ho.fecha_salida, ve.deuda FROM hospedaje ho INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion INNER JOIN venta ve ON ve.fk_id_hospedaje = ho.id_hospedaje WHERE ha.id_habitacion = patron AND ho.estado = 'Activo' AND ve.deuda>'0') THEN

SELECT ho.id_hospedaje, ha.id_habitacion, CONCAT(hu.nombre, ' ', hu.apellido) AS huesped, ho.fecha_ingreso, ho.fecha_salida, SUM(ve.deuda) as deuda FROM hospedaje ho INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion INNER JOIN venta ve ON ve.fk_id_hospedaje = ho.id_hospedaje WHERE ha.id_habitacion = patron AND ho.estado = 'Activo' AND ve.deuda>'0';

ELSE

SELECT ho.id_hospedaje, ha.id_habitacion, concat(hu.nombre,' ', hu.apellido) as huesped, ho.fecha_ingreso, ho.fecha_salida, "0.00" as deuda FROM hospedaje ho INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN habitacion ha on ho.fk_id_habitacion = ha.id_habitacion WHERE ha.id_habitacion = patron AND ho.estado = 'Activo';
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DetalleVentaGetId` (IN `idventa` INT(8))  BEGIN
SELECT pro.nombre, pro.descripcion, pro.medida, pro.precio, dv.cantidad, dv.subtotal FROM detalle_venta dv INNER JOIN producto pro on dv.fk_id_producto = pro.id_producto INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta WHERE dv.fk_id_venta = idventa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeudaHabitacionId` (IN `id_hospe` INT(8))  BEGIN
IF EXISTS (SELECT ve.deuda FROM venta ve INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje WHERE ho.id_hospedaje = id_hospe) THEN
SELECT ve.id_venta, SUM(ve.deuda) as deuda FROM venta ve INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje WHERE ho.id_hospedaje = id_hospe;
ELSE
SELECT "0.00" as deuda;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getIdReservacion` (IN `id_reser` INT(8))  BEGIN
SELECT re.id_reservacion, fk_id_habitacion as id_habi, ha.precio, re.adelanto, ha.estado, ha.foto, ha.tipo, fecha_reser, fecha_ingreso, fecha_salida, re.descripcion, hu.id_huesped as dni, concat(hu.nombre,' ', hu.apellido) as huesped, hu.telefono FROM reservacion re INNER JOIN habitacion ha on re.fk_id_habitacion = ha.id_habitacion INNER JOIN huesped hu on re.fk_id_huesped = hu.id_huesped WHERE re.id_reservacion = id_reser AND (DATEDIFF(re.fecha_ingreso, NOW()) = '1' OR DATEDIFF(re.fecha_ingreso, NOW()) = '0') AND re.estado != 'Cancelado'  AND re.fk_id_huesped NOT IN ( SELECT ho.fk_id_huesped FROM hospedaje ho WHERE ho.fk_id_huesped = re.fk_id_huesped AND ho.fk_id_habitacion = re.fk_id_habitacion );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HabitacionesEstados` ()  BEGIN
SELECT (SELECT COUNT(*) FROM habitacion WHERE estado = 'Disponible') as disponible, 
(SELECT COUNT(*) FROM reservacion re INNER JOIN habitacion ha ON ha.id_habitacion = re.fk_id_habitacion WHERE (DATEDIFF(fecha_ingreso, NOW()) = '1' OR DATEDIFF(fecha_ingreso, NOW()) = '0') AND re.estado != 'Cancelado'  AND re.fk_id_huesped NOT IN ( SELECT ho.fk_id_huesped FROM hospedaje ho WHERE ho.fk_id_huesped = re.fk_id_huesped AND ho.fk_id_habitacion = re.fk_id_habitacion ) ) as reservado, 
(SELECT COUNT(*) FROM habitacion WHERE estado = 'Ocupado') as ocupado ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HabitacionesOcupados` ()  BEGIN
  SELECT
  ho.fk_id_habitacion AS hab,
  ha.tipo AS tipo,
  CONCAT(hu.nombre,
  ' ',
  hu.apellido) AS huesped,
  hu.telefono,
  ho.fecha_ingreso,
  ho.fecha_salida,
  ha.foto,
  ho.precio,
  CONCAT(
    EXTRACT(DAY FROM TIMEDIFF(NOW(), ho.fecha_ingreso)),' Dias ',
    EXTRACT(HOUR FROM TIMEDIFF(NOW(),ho.fecha_ingreso)),':',
    EXTRACT( MINUTE FROM TIMEDIFF(NOW(),ho.fecha_ingreso)),'min'
  ) AS horas,
  ho.costo_total as adelanto,
  (
    (
      COALESCE(
    CASE
      WHEN EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 6 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 0) AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1
      WHEN 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(NOW()),'05:00:00'))) <= 0  AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
           AND EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND 
           EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(ho.fecha_ingreso),'05:00:00'))) <= 0 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) >= 5 AND 
           DATE(ho.fecha_ingreso) = DATE(NOW())) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))
    END
  ) * ho.precio) - ho.costo_total) AS deuda,
  (
    COALESCE(
    CASE
      WHEN EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 6 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 0) AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1
      WHEN 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(NOW()),'05:00:00'))) <= 0  AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
           AND EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND 
           EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(ho.fecha_ingreso),'05:00:00'))) <= 0 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) >= 5 AND 
           DATE(ho.fecha_ingreso) = DATE(NOW())) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))
    END
  ) * ho.precio) AS total,
COALESCE(
    CASE 
      WHEN 
          (EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) < 6 AND 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) >= 0 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0)
    	THEN 'Finaliza Mañana al Medio Día'
    	WHEN
          (EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) < 6 AND  
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 0)
        THEN 'Estas en tu tiempo Extra'
      WHEN ((EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 OR 
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
          ) AND EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5) OR 
          ((EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 6 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 0) AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) AND
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0)
        THEN 'Finaliza Mañana al Medio Día'
      WHEN 
          (EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(NOW()),'05:00:00'))) <= 0 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0) OR 
          ((EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) >= 5 AND DATE(ho.fecha_ingreso) = DATE(NOW())) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0)
        THEN 'Finaliza Hoy al Medio Día'
    END
  ) as mensaje
  FROM hospedaje ho
  INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped
  INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
  WHERE  ho.estado = 'Activo' and ha.estado = 'Ocupado' 
  ORDER BY HO.id_hospedaje DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HabitacionesReservado` ()  BEGIN

 SELECT re.id_reservacion, fk_id_habitacion as id_habi, ha.precio, re.adelanto, ha.estado, ha.foto, ha.tipo, fecha_reser, fecha_ingreso, fecha_salida, re.descripcion, hu.id_huesped as dni, concat(hu.nombre,' ', hu.apellido) as huesped, hu.telefono FROM reservacion re INNER JOIN habitacion ha on re.fk_id_habitacion = ha.id_habitacion INNER JOIN huesped hu on re.fk_id_huesped = hu.id_huesped WHERE (DATEDIFF(re.fecha_ingreso, NOW()) = '1' OR DATEDIFF(re.fecha_ingreso, NOW()) = '0') AND re.estado != 'Cancelado'  AND re.fk_id_huesped NOT IN ( SELECT ho.fk_id_huesped FROM hospedaje ho WHERE ho.fk_id_huesped = re.fk_id_huesped AND ho.fk_id_habitacion = re.fk_id_habitacion );
 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HospedajeHabitacionGetId` (IN `id_habi` CHAR(8))  BEGIN
SELECT
  ho.id_hospedaje,
  hu.id_huesped AS dni,
  CONCAT(hu.nombre,
  ' ',
  hu.apellido) AS huesped,
  hu.procedencia,
  hu.telefono,
  ho.fecha_ingreso,
  ha.id_habitacion,
  ha.tipo,
  ho.precio,
  ha.foto,
  CONCAT(
    EXTRACT(DAY FROM TIMEDIFF(NOW(), ho.fecha_ingreso)),' Dias ',
    EXTRACT(HOUR FROM TIMEDIFF(NOW(),ho.fecha_ingreso)),':',
    EXTRACT( MINUTE FROM TIMEDIFF(NOW(),ho.fecha_ingreso)),'min'
  ) AS cant_dias,
  (
    COALESCE(
    CASE
      WHEN EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 6 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 0) AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1
      WHEN 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(NOW()),'05:00:00'))) <= 0  AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
           AND EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND 
           EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(ho.fecha_ingreso),'05:00:00'))) <= 0 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) >= 5 AND 
           DATE(ho.fecha_ingreso) = DATE(NOW())) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))

    END
  ) * ho.precio) AS total,
  ho.costo_total AS adelanto,
  (
    (
     COALESCE(
    CASE
      WHEN EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 6 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 0) AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1
      WHEN 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(NOW()),'05:00:00'))) <= 0  AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
           AND EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND 
           EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(ho.fecha_ingreso),'05:00:00'))) <= 0 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) >= 5 AND 
           DATE(ho.fecha_ingreso) = DATE(NOW())) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))

    END
  ) * ho.precio) - ho.costo_total) AS deuda,
	COALESCE(
    CASE 
      WHEN 
          (EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) < 6 AND 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) >= 0 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0)
      THEN 'Finaliza Mañana al Medio Día'
      WHEN
          (EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) < 6 AND  
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 0)
        THEN 'Estas en tu tiempo Extra'
      WHEN ((EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 OR 
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
          ) AND EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5) OR 
          ((EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 6 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 0) AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) AND
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0)
        THEN 'Finaliza Mañana al Medio Día'
      WHEN 
          (EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(NOW()),'05:00:00'))) <= 0 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0) OR 
          ((EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) >= 5 AND DATE(ho.fecha_ingreso) = DATE(NOW())) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0)
        THEN
          'Finaliza Hoy al Medio Día'
    END
  ) as mensaje
  FROM hospedaje ho
  INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
  INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped
  WHERE ha.id_habitacion = id_habi AND ho.estado = 'Activo';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HospedajeHistorial` ()  BEGIN
SELECT ho.id_hospedaje as id_hosp, ho.fk_id_habitacion AS hab, fk_id_huesped AS dni, concat(hu.nombre,' ', hu.apellido) AS huesped, hu.procedencia AS origen, motivo_visita AS motivo, fecha_ingreso, fecha_salida, u.nombre AS usuario 
FROM hospedaje ho 
INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped 
INNER JOIN usuario u ON ho.fk_id_usuario = u.id_usuario 
INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
WHERE ha.estado != 'Mantenimiento'
ORDER BY ho.estado;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HospedajeSave` (IN `motivo` VARCHAR(60), IN `f_ingreso` DATETIME, IN `f_salida` DATETIME, IN `estado` VARCHAR(30), IN `precio` DECIMAL(10,2), IN `costo` DECIMAL(10,2), IN `id_usuario` CHAR(8), IN `id_huesped` CHAR(8), IN `id_habitacion` CHAR(8))  BEGIN
IF NOT EXISTS(SELECT ho.id_hospedaje FROM hospedaje ho INNER JOIN habitacion ha ON ha.id_habitacion = ho.fk_id_habitacion WHERE ha.estado = 'Ocupado' AND ho.fk_id_habitacion = id_habitacion) THEN
INSERT INTO `hospedaje`(`id_hospedaje`, `motivo_visita`, `fecha_ingreso`, `fecha_salida`, `estado`, `precio`,`costo_total`, `fk_id_usuario`, `fk_id_huesped`, `fk_id_habitacion`) VALUES ('', motivo, f_ingreso, f_salida, estado, precio, costo,id_usuario, id_huesped, id_habitacion);
ELSE
INSERT INTO `hospedaje`(`id_hospedaje`, `motivo_visita`, `fecha_ingreso`, `fecha_salida`, `estado`, `precio`,`costo_total`, `fk_id_usuario`, `fk_id_huesped`, `fk_id_habitacion`) VALUES ('','','','','','','','','','');
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HospedajeSelectGetId` (IN `id_hosp` INT(8))  BEGIN
IF EXISTS  (SELECT id_hospedaje FROM hospedaje ho WHERE ho.id_hospedaje = id_hosp  AND ho.estado = 'Activo') THEN
SELECT
  ho.id_hospedaje,
  ha.foto,
  hu.id_huesped AS dni,
  CONCAT(hu.nombre,
  ' ',
  hu.apellido) AS huesped,
  hu.procedencia,
  hu.telefono,
  ho.fecha_ingreso,
  ho.fecha_salida,
  ha.id_habitacion,
  ha.tipo,
  ho.precio,
  CONCAT(
    EXTRACT(DAY FROM TIMEDIFF(NOW(), ho.fecha_ingreso)),' Dias ',
    EXTRACT(HOUR FROM TIMEDIFF(NOW(),ho.fecha_ingreso)),':',
    EXTRACT( MINUTE FROM TIMEDIFF(NOW(),ho.fecha_ingreso)),'min'
  ) Cant_Dias,
  (COALESCE(
    CASE
      WHEN EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 6 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 0) AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1
      WHEN 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(NOW()),'05:00:00'))) <= 0  AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
           AND EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND 
           EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(ho.fecha_ingreso),'05:00:00'))) <= 0 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) >= 5 AND 
           DATE(ho.fecha_ingreso) = DATE(NOW())) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))
    END
  )* ho.precio) AS total,
ho.costo_total AS adelanto,
(
  (COALESCE(
    CASE
      WHEN EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 6 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 0) AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1
      WHEN 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(NOW()),'05:00:00'))) <= 0  AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) 
        THEN 1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
           AND EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND 
           EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(ho.fecha_ingreso),'05:00:00'))) <= 0 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) >= 5 AND 
           DATE(ho.fecha_ingreso) = DATE(NOW())) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))
    END
  )* ho.precio) - ho.costo_total) AS deuda,
CONCAT(us.nombre,' ',us.apellido) AS usuario
FROM
  hospedaje ho
INNER JOIN
  habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
INNER JOIN
  huesped hu ON ho.fk_id_huesped = hu.id_huesped
INNER JOIN
  usuario us ON ho.fk_id_usuario = us.id_usuario
WHERE ho.id_hospedaje = id_hosp;
ELSE
SELECT
  ho.id_hospedaje,
  ha.foto,
  hu.id_huesped AS dni,
  CONCAT(hu.nombre,
  ' ',
  hu.apellido) AS huesped,
  hu.procedencia,
  hu.telefono,
  ho.fecha_ingreso,
  ho.fecha_salida,
  ha.id_habitacion,
  ha.tipo,
  ho.precio,
  CONCAT(
    EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)),' Dias ',
    EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)),':',
    EXTRACT( MINUTE FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)),'min'
  ) Cant_Dias,
  (COALESCE(
    CASE
      WHEN EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_salida,TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN
          EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),ho.fecha_ingreso)) < 6 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'))) >= 0) AND
          DATE(ho.fecha_ingreso) = DATE(ho.fecha_salida) 
        THEN 1
      WHEN 
          EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(ho.fecha_salida),'05:00:00'))) <= 0  AND
          DATE(ho.fecha_ingreso) = DATE(ho.fecha_salida) 
        THEN 1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
           AND EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_salida,TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'))) >= 5 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND 
           EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(ho.fecha_ingreso),'05:00:00'))) <= 0 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),ho.fecha_ingreso)) >= 5 AND 
           DATE(ho.fecha_ingreso) = DATE(ho.fecha_salida)) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))
    END
  )* ho.precio) AS total,
ho.costo_total AS adelanto,
(
  (COALESCE(
    CASE
      WHEN EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_salida,TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND 
            EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5 
        THEN 1
      WHEN
          EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),ho.fecha_ingreso)) < 6 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'))) >= 0) AND
          DATE(ho.fecha_ingreso) = DATE(ho.fecha_salida) 
        THEN 1
      WHEN 
          EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(ho.fecha_salida),'05:00:00'))) <= 0  AND
          DATE(ho.fecha_ingreso) = DATE(ho.fecha_salida) 
        THEN 1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
           AND EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_salida,TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'))) >= 5 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND 
           EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(ho.fecha_ingreso),'05:00:00'))) <= 0 
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))+1

      WHEN (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),ho.fecha_ingreso)) >= 5 AND 
           DATE(ho.fecha_ingreso) = DATE(ho.fecha_salida)) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
        THEN EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00')))
    END
  )* ho.precio) - ho.costo_total) AS deuda,
CONCAT(us.nombre,' ',us.apellido) AS usuario
FROM
  hospedaje ho
INNER JOIN
  habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
INNER JOIN
  huesped hu ON ho.fk_id_huesped = hu.id_huesped
INNER JOIN
  usuario us ON ho.fk_id_usuario = us.id_usuario
WHERE ho.id_hospedaje = id_hosp;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MensajeReservacion` ()  BEGIN
SELECT re.id_reservacion, ha.id_habitacion, ha.foto, concat(hu.nombre,' ',hu.apellido) as huesped, re.fecha_ingreso,CONCAT(
  EXTRACT(day FROM TIMEDIFF(NOW(), re.fecha_reser)), ' - ', 
  EXTRACT(hour FROM TIMEDIFF(NOW(), re.fecha_reser)),':',
  EXTRACT(MINUTE FROM TIMEDIFF(NOW(), re.fecha_reser)),'m') as tiempo
FROM reservacion re 
INNER JOIN huesped hu ON re.fk_id_huesped = hu.id_huesped
INNER JOIN habitacion ha ON re.fk_id_habitacion = ha.id_habitacion
WHERE re.estado != 'Cancelado'  AND re.fk_id_huesped NOT IN ( SELECT ho.fk_id_huesped FROM hospedaje ho WHERE ho.fk_id_huesped = re.fk_id_huesped AND ho.fk_id_habitacion = re.fk_id_habitacion ) AND (DATEDIFF(re.fecha_ingreso, NOW()) = '1' OR DATEDIFF(re.fecha_ingreso, NOW()) = '0');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ReservacionHistorial` ()  BEGIN
SELECT fk_id_habitacion AS hab, fk_id_huesped AS dni, concat(hu.nombre, ' ', hu.apellido) AS huesped, descripcion, fecha_reser AS fecha_reserva, fecha_ingreso, fecha_salida, re.adelanto, u.nombre as usuario FROM reservacion re INNER JOIN huesped hu ON re.fk_id_huesped = hu.id_huesped INNER JOIN usuario u ON re.fk_id_usuario = u.id_usuario ORDER by id_reservacion DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `VentaHabitacionId` (IN `id_habi` CHAR(8))  BEGIN
SELECT ha.id_habitacion, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, ve.total, ve.deuda, u.nombre as usuario, ve.id_venta as idventa FROM venta ve INNER JOIN usuario u on ve.fk_id_usuario = u.id_usuario INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN habitacion ha ON ha.id_habitacion = ho.fk_id_habitacion 
WHERE ha.id_habitacion = id_habi AND ho.estado = 'Activo'
ORDER by ve.fecha DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `VentasAll` ()  BEGIN
SELECT ha.id_habitacion, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, ve.total, ve.deuda, u.nombre as usuario, ve.id_venta as idventa FROM venta ve INNER JOIN usuario u on ve.fk_id_usuario = u.id_usuario INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN habitacion ha ON ha.id_habitacion = ho.fk_id_habitacion ORDER by ve.deuda ASC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `VentaSelectId` (IN `select_idventa` INT(8))  BEGIN
SELECT ve.id_venta, ha.id_habitacion, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, ve.total, ve.deuda, concat(u.nombre,' ',u.apellido) as usuario FROM venta ve INNER JOIN usuario u on ve.fk_id_usuario = u.id_usuario INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN habitacion ha ON ha.id_habitacion = ho.fk_id_habitacion  WHERE ve.id_venta = select_idventa ORDER by ve.fecha DESC;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoriahospedaje`
--

CREATE TABLE `auditoriahospedaje` (
  `id_auditoria` int(8) NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` decimal(10,0) NOT NULL DEFAULT '0',
  `fk_id_hospedaje` int(8) NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `auditoriahospedaje`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoriaventa`
--

CREATE TABLE `auditoriaventa` (
  `id_auditoria` int(8) NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fk_id_venta` int(8) NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `auditoriaventa`
--
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id_detalle_venta` int(8) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fk_id_venta` int(8) NOT NULL,
  `fk_id_producto` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `detalle_venta`
--


--
-- Disparadores `detalle_venta`
--
DELIMITER $$
CREATE TRIGGER `updat_stock` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
   UPDATE `producto` SET `stock`= stock-New.cantidad WHERE `id_producto`= NEW.fk_id_producto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_eventos` int(8) NOT NULL,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `estart` date NOT NULL,
  `ennd` date NOT NULL,
  `background` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '#0073b7',
  `datos` varchar(50) COLLATE utf8_bin NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `eventos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gasto`
--

CREATE TABLE `gasto` (
  `id_gasto` int(8) NOT NULL,
  `recibe` varchar(60) COLLATE utf8_bin NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `gasto`
--

INSERT INTO `gasto` (`id_gasto`, `recibe`, `fecha`, `monto`, `descripcion`, `fk_id_usuario`) VALUES
(1, 'Filio Carrasco Sauñe', '2016-12-19 16:18:19', '1000.00', 'Pago del Sistema', '47050254'),
(2, 'Alejandro Bernales Gomez', '2016-12-19 16:19:52', '100.00', 'llegara para las 4pm', '47050254');

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
('200', 'Individual', 'Agua caliente, tv cable y baño compartido', 'Mantenimiento', '0.00', '200.jpg'),
('201', 'Doble', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '60.00', '201.jpg'),
('202', 'Doble', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '50.00', '202.png'),
('203', 'Matrimonial', 'baño privado, doble cama, agua caliente, tv cable', 'Disponible', '60.00', '203.png'),
('204', 'Individual', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '40.00', '204.jpg'),
('205', 'Individual', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '70.00', '205.jpg'),
('301', 'Familiar', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '70.00', '301.jpg'),
('302', 'Doble', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '80.00', '302.jpg'),
('303', 'Individual', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '60.00', '303.jpg'),
('304', 'Familiar', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '90.00', '304.jpg'),
('305', 'Matrimonial', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '90.00', '305.jpg'),
('306', 'Matrimonial', 'baño privado, doble cama, tv cable, agua caliente', 'Ocupado', '100.00', '306.jpg'),
('401', 'Familiar', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '80.00', '401.jpg'),
('402', 'Doble', 'baño privado, doble cama, tv cable, agua caliente', 'Ocupado', '80.00', '402.jpg'),
('403', 'Doble', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '70.00', '403.jpg'),
('404', 'Matrimonial', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '90.00', '404.jpg'),
('405', 'Individual', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '70.00', '405.jpg'),
('501', 'Familiar', 'baño privado, doble cama, tv cable, agua caliente', 'Disponible', '70.00', '501.jpg'),
('502', 'Familiar', 'baño privado, doble cama, tv cable, agua caliente', 'Ocupado', '90.00', '502.jpg'),
('503', 'Matrimonial', 'baño privado, doble cama, tv cable, agua caliente', 'Ocupado', '100.00', '503.jpg'),
('504', 'Doble', 'Baño compartido, doble cama, agua caliente', 'Disponible', '45.00', '504.jpg'),
('505', 'Matrimonial', 'baño privado, doble cama, tv cable, agua caliente', 'Ocupado', '100.00', '505.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hospedaje`
--

CREATE TABLE `hospedaje` (
  `id_hospedaje` int(8) NOT NULL,
  `motivo_visita` varchar(60) COLLATE utf8_bin NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `estado` varchar(30) COLLATE utf8_bin NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `costo_total` decimal(10,2) NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_huesped` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_habitacion` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `hospedaje`
--
--
-- Disparadores `hospedaje`
--
DELIMITER $$
CREATE TRIGGER `InsetarHospedaje` AFTER INSERT ON `hospedaje` FOR EACH ROW BEGIN
DECLARE monto decimal(10,2);
SELECT adelanto INTO monto FROM reservacion WHERE fk_id_huesped = NEW.fk_id_huesped AND fk_id_habitacion = NEW.fk_id_habitacion ORDER BY id_reservacion DESC LIMIT 1; 
UPDATE `habitacion` SET `estado`= 'Ocupado' WHERE `id_habitacion`= NEW.fk_id_habitacion;
IF (NEW.costo_total > 0) THEN
	IF monto > 0 THEN
   		INSERT INTO `auditoriahospedaje`(`id_auditoria`, `fecha`, `monto`, `fk_id_hospedaje`, `fk_id_usuario`) VALUES ('',Now(), NEW.costo_total - monto, NEW.id_hospedaje,NEW.fk_id_usuario);
   	ELSE
   		INSERT INTO `auditoriahospedaje`(`id_auditoria`, `fecha`, `monto`, `fk_id_hospedaje`, `fk_id_usuario`) VALUES ('',Now(), NEW.costo_total ,NEW.id_hospedaje,NEW.fk_id_usuario);
   	END IF;
 END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateHospedaje` AFTER UPDATE ON `hospedaje` FOR EACH ROW BEGIN
IF (NEW.costo_total-OLD.costo_total>0) THEN
	 INSERT INTO `auditoriahospedaje`(`id_auditoria`, `fecha`, `monto`, `fk_id_hospedaje`, `fk_id_usuario`) VALUES ('',Now(), NEW.costo_total-OLD.costo_total ,OLD.id_hospedaje,NEW.fk_id_usuario);
 END IF;
 IF (NEW.costo_total-OLD.costo_total = 0 AND NEW.estado = 'Finalizado') THEN
 UPDATE `habitacion` SET `estado`= 'Disponible' WHERE `id_habitacion`= NEW.fk_id_habitacion;
 END IF;
END
$$
DELIMITER ;

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
('47050220', 'Vanesa Vane', 'Sanchez Valensuela', 'Abancay', '963654645', 'Agradable'),
('47050221', 'Maria Alberta', 'Chuquipay Ramirez', 'Ayacucho', '983646545', 'Agradable'),
('47050222', 'Adrian Romero', 'Romero Gomez', 'Grau - Apurimac', '963258745', 'Agradable'),
('47050223', 'Marivel', 'Gutierrez Quispe', 'Lima', '958445453', 'Agradable'),
('47050224', 'Mayumi', 'Pampañaupa Ramires', 'Arequipa', '983658578', 'Agradable'),
('47050225', 'Santos', 'Damian Rojas', 'Lambrama', '965874562', 'Agradable'),
('47050226', 'Juan Carlos', 'Rojas Carrasco', 'Junin', '983658749', 'Agradable'),
('47050227', 'Ciro', 'Gomes Alegria', 'Cusco', '965844654', 'Agradable'),
('47050228', 'Ramiro', 'Belasques Sauñe', 'Huancarama', '987456213', 'Agradable'),
('47050229', 'Manuel', 'Gonzales Segundo', 'Lambayeque', '987456233', 'Agradable'),
('47050230', 'Fredy', 'Cardenas Cruz', 'Lima', '983457898', 'Agradable'),
('47050231', 'Ana Maria', 'Quispe Ramos', 'Arequipa', '962846003', 'Agradable'),
('47050232', 'Kenny', 'Ramos Vilcas', 'Cusco', '985613245', 'Agradable'),
('47050233', 'Rossmin', 'Vilcas Hurtado', 'Tumbes', '985613245', 'Agradable'),
('47050234', 'Filio', 'Vilcas Hurtado', 'Cusco', '983457898', 'Agradable'),
('47050235', 'Maria', 'Condori Ancco', 'Lima', '962458795', 'Agradable'),
('47050236', 'Ana', 'Sulivan Quispe', 'Juliaca', '954395349', 'Agradable'),
('47050237', 'Jhon', 'Huaman Rojas', 'Tumbes', '983423748', 'Agradable'),
('47050238', 'Julian', 'Villegas Quispe', 'Andahuaylas', '983423748', 'Agradable'),
('47050239', 'Rojer', 'Connor Quispe', 'Trujillo', '983696939', 'Agradable'),
('47050240', 'Eva', 'Montaner Quispe', 'Ayacucho', '983457898', 'Agradable'),
('47050241', 'Georgina', 'Contreras Muños', 'Arica', '983696939', 'Agradable'),
('47050242', 'Felicia', 'Rodrigues Ramos', 'Puno', '962846003', 'Agradable'),
('47050243', 'Rodrigo', 'Gomes Gonzales', 'Ica', '983423748', 'Agradable'),
('47050244', 'Brahan', 'Roman Condori', 'Madre de Dios', '962458795', 'Agradable'),
('47050245', 'Nora', 'Gonzales Ramos', 'Quillabamba', '985613245', 'Agradable'),
('47050246', 'Ronald', 'Rios Contreras', 'Cajamarca', '983696939', 'Agradable'),
('47050247', 'Robeto', 'Gomes Gonzales', 'Loreto', '983423748', 'Agradable'),
('47050248', 'Felipe', 'Melendez Rios', 'Nasca', '952345676', 'Agradable'),
('47050249', 'Jhojan', 'serrano Quispè', 'Cajamarca', '962458795', 'Agradable'),
('47050279', 'Nefri', 'Toledo Gomes', 'Ucayali', '952345676', 'Desagradable'),
('88888888', 'Venta', 'Libre', 'Hostal', '083-32123', 'Agradable');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada`
--

CREATE TABLE `jornada` (
  `id_jornada` int(8) NOT NULL,
  `fecha_ingreso` datetime NOT NULL,
  `fecha_salida` datetime DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `jornada`
--
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id_permiso` int(8) NOT NULL,
  `fecha` datetime NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_bin NOT NULL,
  `backgroundColor` varchar(25) COLLATE utf8_bin NOT NULL,
  `fk_id_personal` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `permiso`
--
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

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
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `personal`
--
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
(1, 'Inca Kola', '2.25', 'Litros', '5.00', 218, 'Inca Kola.png'),
(2, 'Coca Cola', '1.25', 'Litros', '3.00', 209, 'Inca Cola.png'),
(3, 'Agua Cielo', '1', 'Litros', '1.00', 153, 'Agua Mineral.png'),
(4, 'Charada', 'galleta', 'Unidad', '1.00', 105, 'Charada.png'),
(5, 'Casino', 'Galleta', 'Unidad', '1.00', 125, 'Casino .png'),
(6, 'Morochas', 'Galleta', 'Unidad', '1.00', 141, 'morochas.png'),
(7, 'Morochas snack', 'Galleta', 'Unidad', '2.00', 78, 'Morochas snack.png'),
(8, 'Frugos Durasno', '1', 'Litros', '3.50', 210, 'Frugos .png'),
(9, 'Fanta', '500', 'ML', '2.00', 155, 'Fanta.png'),
(10, 'Colgate', 'Colinos', 'Unidad', '8.00', 81, 'Colgate.png'),
(11, 'Kolynos', 'colinos', 'Unidad', '5.00', 190, 'Kolynos.png'),
(12, 'Cepillo Dental', 'Colgate', 'Unidad', '2.50', 197, 'Cepillo Dental.png'),
(13, 'Prestobarba', 'Gillette Prestobarba  para afeitar', 'Unidad', '3.50', 165, 'Prestobarba.png'),
(14, 'Kotex', 'kotes contra fugas', 'Unidad', '5.50', 135, 'Kotex.png'),
(15, 'Protex', 'para la buena salud', 'Unidad', '2.00', 196, 'Protex.jpg'),
(16, 'Peine', 'Peine par Cabello', 'Unidad', '1.00', 179, 'Peine.png'),
(17, 'Power', 'Bebida Power', 'Unidad', '2.50', 151, 'Power.jpg'),
(18, 'Vinos', 'Vinos de Mesa', 'Unidad', '20.00', 123, 'Vinos.jpg'),
(19, 'heard shoulders', 'shampoo HS', 'Unidad', '2.00', 107, 'heard shoulders.jpg'),
(20, 'Condones Piel', 'Condones Piel', 'Unidad', '3.50', 338, 'condon Piel.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservacion`
--

CREATE TABLE `reservacion` (
  `id_reservacion` int(8) NOT NULL,
  `descripcion` varchar(60) COLLATE utf8_bin NOT NULL,
  `fecha_reser` datetime NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `adelanto` decimal(10,2) NOT NULL,
  `estado` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT 'Activo',
  `fk_id_usuario` int(8) NOT NULL,
  `fk_id_huesped` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_habitacion` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `reservacion`
--
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salario`
--

CREATE TABLE `salario` (
  `id_salario` int(8) NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `tipo` varchar(50) COLLATE utf8_bin NOT NULL,
  `backgroundColor` varchar(25) COLLATE utf8_bin NOT NULL,
  `fk_id_personal` char(8) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
('47050251', 'yessy@framawork.com', 'Yessy', 'Contreras Sierra', '849254528', '1dd3780be29e4eaeedf59f796bca3bfb', 'Yessy.jpg', 'Normal', 'Inactivo'),
('47050252', 'pepo@framawork.com', 'Roberth', 'Huaman Caceres', '962458795', '1dd3780be29e4eaeedf59f796bca3bfb', 'Roberth.jpg', 'Normal', 'Inactivo'),
('47050253', 'maxi@framework.com', 'Maximiliana', 'Sauñe Arostegui', '985613245', '1dd3780be29e4eaeedf59f796bca3bfb', 'Maximiliana .jpg', 'Normal', 'Inactivo'),
('47050254', 'filio@framework.com', 'Filio Elio', 'Carrasco Sauñe', '962846003', '1dd3780be29e4eaeedf59f796bca3bfb', 'Filio Elio.PNG', 'Admin', 'Activo'),
('47050255', 'silvia@framework.com', 'Silvia', 'Carrasco Sauñe', '983423748', '1dd3780be29e4eaeedf59f796bca3bfb', 'Silvia.jpg', 'Normal', 'Inactivo'),
('47050256', 'andy@framework.com', 'Andy Ismael', 'Carrasco Sauñe', '968574152', '1dd3780be29e4eaeedf59f796bca3bfb', 'Andy Ismael.jpg', 'Normal', 'Activo'),
('47050257', 'abigail@framework.com', 'Abigail', 'Taipe Ccana', '983457898', '1dd3780be29e4eaeedf59f796bca3bfb', 'Abigail.jpg', 'Normal', 'Inactivo'),
('47050258', 'nilton@framawork.com', 'Nilton', 'Hurtado Mendoza', '954395349', '1dd3780be29e4eaeedf59f796bca3bfb', 'Nilton.jpg', 'Normal', 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_venta` int(8) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha` datetime NOT NULL,
  `deuda` decimal(10,2) NOT NULL,
  `fk_id_usuario` char(8) COLLATE utf8_bin NOT NULL,
  `fk_id_hospedaje` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `venta`
--

--
-- Disparadores `venta`
--
DELIMITER $$
CREATE TRIGGER `InsertarAuditoriaVenta` AFTER INSERT ON `venta` FOR EACH ROW BEGIN
INSERT INTO `auditoriaventa`(`id_auditoria`, `fecha`, `monto`, `fk_id_venta`, `fk_id_usuario`) VALUES ('',NOW(),NEW.total-NEW.deuda, NEW.id_venta, NEW.fk_id_usuario);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateAuditoriaVenta` AFTER UPDATE ON `venta` FOR EACH ROW BEGIN
INSERT INTO `auditoriaventa`(`id_auditoria`, `fecha`, `monto`, `fk_id_venta`, `fk_id_usuario`) VALUES ('',NOW(),OLD.deuda-NEW.deuda, OLD.id_venta, NEW.fk_id_usuario);
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoriahospedaje`
--
ALTER TABLE `auditoriahospedaje`
  ADD PRIMARY KEY (`id_auditoria`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`);

--
-- Indices de la tabla `auditoriaventa`
--
ALTER TABLE `auditoriaventa`
  ADD PRIMARY KEY (`id_auditoria`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id_detalle_venta`),
  ADD KEY `fk_id_venta` (`fk_id_venta`),
  ADD KEY `fk_id_producto` (`fk_id_producto`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_eventos`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`);

--
-- Indices de la tabla `gasto`
--
ALTER TABLE `gasto`
  ADD PRIMARY KEY (`id_gasto`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`id_habitacion`);

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
-- Indices de la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD PRIMARY KEY (`id_jornada`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id_permiso`),
  ADD KEY `fk_id_personal` (`fk_id_personal`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id_personal`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`);

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
-- Indices de la tabla `salario`
--
ALTER TABLE `salario`
  ADD PRIMARY KEY (`id_salario`),
  ADD KEY `fk_id_personal` (`fk_id_personal`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fk_id_usuario` (`fk_id_usuario`),
  ADD KEY `fk_id_hospedaje` (`fk_id_hospedaje`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoriahospedaje`
--
ALTER TABLE `auditoriahospedaje`
  MODIFY `id_auditoria` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT de la tabla `auditoriaventa`
--
ALTER TABLE `auditoriaventa`
  MODIFY `id_auditoria` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id_detalle_venta` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_eventos` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `gasto`
--
ALTER TABLE `gasto`
  MODIFY `id_gasto` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `hospedaje`
--
ALTER TABLE `hospedaje`
  MODIFY `id_hospedaje` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT de la tabla `jornada`
--
ALTER TABLE `jornada`
  MODIFY `id_jornada` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id_permiso` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `reservacion`
--
ALTER TABLE `reservacion`
  MODIFY `id_reservacion` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT de la tabla `salario`
--
ALTER TABLE `salario`
  MODIFY `id_salario` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id_venta` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auditoriahospedaje`
--
ALTER TABLE `auditoriahospedaje`
  ADD CONSTRAINT `auditoriahospedaje_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `auditoriaventa`
--
ALTER TABLE `auditoriaventa`
  ADD CONSTRAINT `auditoriaventa_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`fk_id_venta`) REFERENCES `venta` (`id_venta`),
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`fk_id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `gasto`
--
ALTER TABLE `gasto`
  ADD CONSTRAINT `gasto_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `hospedaje`
--
ALTER TABLE `hospedaje`
  ADD CONSTRAINT `hospedaje_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `hospedaje_ibfk_2` FOREIGN KEY (`fk_id_huesped`) REFERENCES `huesped` (`id_huesped`),
  ADD CONSTRAINT `hospedaje_ibfk_3` FOREIGN KEY (`fk_id_habitacion`) REFERENCES `habitacion` (`id_habitacion`);

--
-- Filtros para la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD CONSTRAINT `jornada_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`fk_id_personal`) REFERENCES `personal` (`id_personal`);

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `reservacion`
--
ALTER TABLE `reservacion`
  ADD CONSTRAINT `reservacion_ibfk_1` FOREIGN KEY (`fk_id_huesped`) REFERENCES `huesped` (`id_huesped`),
  ADD CONSTRAINT `reservacion_ibfk_2` FOREIGN KEY (`fk_id_habitacion`) REFERENCES `habitacion` (`id_habitacion`);

--
-- Filtros para la tabla `salario`
--
ALTER TABLE `salario`
  ADD CONSTRAINT `salario_ibfk_1` FOREIGN KEY (`fk_id_personal`) REFERENCES `personal` (`id_personal`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`fk_id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`fk_id_hospedaje`) REFERENCES `hospedaje` (`id_hospedaje`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
