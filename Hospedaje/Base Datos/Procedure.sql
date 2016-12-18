
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `HabitacionesEstados` ()  BEGIN
SELECT (SELECT COUNT(*) FROM habitacion WHERE estado = 'Disponible') as disponible, 
(SELECT COUNT(*) FROM reservacion re INNER JOIN habitacion ha ON ha.id_habitacion = re.fk_id_habitacion WHERE (DATEDIFF(fecha_ingreso, NOW()) = '1' OR DATEDIFF(fecha_ingreso, NOW()) = '0') AND re.estado != 'Cancelado' ) as reservado, 
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
        CASE WHEN 
        EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) = 0 THEN 1 
        WHEN 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) > 4 
        THEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))+1 
        ELSE 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))
      END
  ) * ho.precio) - ho.costo_total) AS deuda,
  (
    COALESCE(
      CASE WHEN 
        EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) = 0 THEN 1 
        WHEN 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) > 4 
        THEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))+1 
        ELSE 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))
      END
  ) * ho.precio) AS total
  FROM hospedaje ho
  INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped
  INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
  WHERE  ho.estado = 'Activo' and ha.estado = 'Ocupado' 
  ORDER BY HO.id_hospedaje DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `HabitacionesReservado` ()  BEGIN
 SELECT re.id_reservacion, fk_id_habitacion as id_habi, ha.precio, re.adelanto, ha.estado, ha.foto, ha.tipo, fecha_reser, fecha_ingreso, fecha_salida, re.descripcion, hu.id_huesped as dni, concat(hu.nombre,' ', hu.apellido) as huesped, hu.telefono FROM reservacion re INNER JOIN habitacion ha on re.fk_id_habitacion = ha.id_habitacion INNER JOIN huesped hu on re.fk_id_huesped = hu.id_huesped WHERE (DATEDIFF(re.fecha_ingreso, NOW()) = '1' OR DATEDIFF(re.fecha_ingreso, NOW()) = '0') AND re.estado != 'Cancelado';
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
      CASE WHEN 
        EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) = 0 THEN 1 
        WHEN 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) > 4 
        THEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))+1 
        ELSE 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))
      END
  ) * ho.precio) AS total,
  ho.costo_total AS adelanto,
  (
    (
      COALESCE(
        CASE WHEN 
        EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) = 0 THEN 1 
        WHEN 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) > 4 
        THEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))+1 
        ELSE 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))
      END
  ) * ho.precio) - ho.costo_total) AS deuda
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
ORDER BY id_hospedaje DESC;
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
  (
    COALESCE(
      CASE WHEN 
        EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) = 0 THEN 1 
        WHEN 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) > 4 
        THEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))+1 
        ELSE 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))
      END
  ) * ho.precio) AS total,
ho.costo_total AS adelanto,
(
  (COALESCE(
      CASE WHEN 
        EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) = 0 THEN 1 
        WHEN 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),ho.fecha_ingreso)) > 4 
        THEN
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))+1 
        ELSE 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),ho.fecha_ingreso))
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
  (
    COALESCE(
      CASE WHEN 
        EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) = 0 THEN 1 
        WHEN 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) > 4 
        THEN
          EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))+1 
        ELSE 
          EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))
      END
  ) * ho.precio) AS total,
ho.costo_total AS adelanto,
(
  (COALESCE(
      CASE WHEN 
        EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) = 0 THEN 1 
        WHEN 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) > 4 
        THEN
          EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))+1 
        ELSE 
          EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))
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
SELECT ha.id_habitacion, ha.foto, concat(hu.nombre,' ',hu.apellido) as huesped, re.fecha_ingreso,CONCAT(
  EXTRACT(day FROM TIMEDIFF(NOW(), re.fecha_reser)), ' - ', 
  EXTRACT(hour FROM TIMEDIFF(NOW(), re.fecha_reser)),':',
  EXTRACT(MINUTE FROM TIMEDIFF(NOW(), re.fecha_reser)),'m') as tiempo
FROM reservacion re 
INNER JOIN huesped hu ON re.fk_id_huesped = hu.id_huesped
INNER JOIN habitacion ha ON re.fk_id_habitacion = ha.id_habitacion
WHERE re.estado != 'Cancelado' AND (DATEDIFF(re.fecha_ingreso, NOW()) = '1' OR DATEDIFF(re.fecha_ingreso, NOW()) = '0');
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
