DELIMITER $$
CREATE TRIGGER `updat_stock` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
   UPDATE `producto` SET `stock`= stock-New.cantidad WHERE `id_producto`= NEW.fk_id_producto;
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

DELIMITER $$
CREATE TRIGGER `Update_Habitacion` AFTER INSERT ON `hospedaje` FOR EACH ROW BEGIN
   UPDATE `habitacion` SET `estado`= 'Ocupado' WHERE `id_habitacion`= NEW.fk_id_habitacion;
IF (NEW.costo_total > 0) THEN
 INSERT INTO `auditoriahospedaje`(`id_auditoria`, `fecha`, `monto`, `fk_id_hospedaje`, `fk_id_usuario`) VALUES ('',Now(), NEW.costo_total ,NEW.id_hospedaje,NEW.fk_id_usuario);
 END IF;
END
$$
DELIMITER ;


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