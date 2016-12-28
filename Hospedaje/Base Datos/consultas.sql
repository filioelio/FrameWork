-- CONSULTA PARA DETERMINARA CUANTOS DE LOS QUE RESERVACION FORMALIZARON SU RESERVACION
SELECT ha.id_habitacion, ha.foto, concat(hu.nombre,' ',hu.apellido) as huesped, re.fecha_ingreso,
  CONCAT( 
    EXTRACT(day FROM TIMEDIFF(NOW(), re.fecha_reser)), ' - ', 
    EXTRACT(hour FROM TIMEDIFF(NOW(), re.fecha_reser)),':', 
    EXTRACT(MINUTE FROM TIMEDIFF(NOW(), re.fecha_reser)),'m') as tiempo 
FROM reservacion re 
INNER JOIN huesped hu ON re.fk_id_huesped = hu.id_huesped 
INNER JOIN habitacion ha ON re.fk_id_habitacion = ha.id_habitacion 
WHERE re.estado != 'Cancelado' AND (DATEDIFF(re.fecha_ingreso, NOW()) = '1' OR DATEDIFF(re.fecha_ingreso, NOW()) = '0') AND 
(
  SELECT ho.fk_id_huesped 
  FROM hospedaje ho 
  WHERE ho.fk_id_huesped = re.fk_id_huesped AND ho.fk_id_habitacion = re.fk_id_habitacion
)

-- CONSULTAS PARA DETECTAR QUE HABITACION FUE ALQUILADO CUANDO EXISTIA UNA RESERVACION PARA ESA FECHA 
SELECT ha.id_habitacion, ha.foto, concat(hu.nombre,' ',hu.apellido) as huesped, re.fecha_ingreso,
CONCAT( 
  EXTRACT(day FROM TIMEDIFF(NOW(), re.fecha_reser)), ' - ', 
  EXTRACT(hour FROM TIMEDIFF(NOW(), re.fecha_reser)),':', 
  EXTRACT(MINUTE FROM TIMEDIFF(NOW(), re.fecha_reser)),'m') as tiempo 
FROM reservacion re 
INNER JOIN huesped hu ON re.fk_id_huesped = hu.id_huesped 
INNER JOIN habitacion ha ON re.fk_id_habitacion = ha.id_habitacion 
WHERE re.estado != 'Cancelado' AND (DATEDIFF(re.fecha_ingreso, NOW()) = '1' OR DATEDIFF(re.fecha_ingreso, NOW()) = '0') AND 
re.fk_id_huesped NOT IN ( 
  SELECT ho.fk_id_huesped 
  FROM hospedaje ho 
  WHERE ho.fk_id_huesped = re.fk_id_huesped AND ho.fk_id_habitacion = re.fk_id_habitacion 
)


SELECT COALESCE(
        CASE WHEN 
          EXISTS (SELECT re.fk_id_habitacion 
                  FROM reservacion re 
                  WHERE ha.id_habitacion = re.fk_id_habitacion 
                    AND (DATEDIFF(re.fecha_ingreso, NOW()) = '1' OR DATEDIFF(re.fecha_ingreso, NOW()) = '0') 
                    AND re.estado != 'Cancelado' 
                    AND re.fk_id_huesped NOT IN ( 
                      SELECT ho.fk_id_huesped 
                      FROM hospedaje ho 
                      WHERE ho.fk_id_huesped = re.fk_id_huesped 
                        AND ho.fk_id_habitacion = re.fk_id_habitacion )
                  ) 
          THEN 'si esta reservado' 
          ELSE 
            'no esta reservado'
        END
    ) as estado 
  FROM habitacion ha
-- PODEMOS ESTABLECER HORAS FIJAS EN UN DIA

SELECT TIMESTAMP('2003-12-31','13:00:00')
SELECT TIMESTAMP(DATE(NOW()),'13:00:00')
SELECT EXTRACT(hour FROM DATEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),fecha_ingreso))  AS horas FROM hospedaje

SELECT CONCAT( 
  EXTRACT(day FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'), fecha_ingreso)), ' : ', 
  EXTRACT(hour FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'), fecha_ingreso)),':', 
  EXTRACT(MINUTE FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'), fecha_ingreso))
  ) AS HORA FROM hospedaje



-- ESTO REGLA CUMPLE PARA LOS HUESPEDES QUE ENTRAN EN LA MADRUGA ANTENS DE LAS DE LAS 6 DE LA MADRUGADA
      COALESCE(CASE  WHEN 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(NOW()),'05:00:00'))) <= 0 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0
        THEN
          'TERMINA HOY AL MEDIO DIA OP 1'
      END)

-- ESTO ES LA REGLA PARA AQUEL HUESPED QUE ENTRO EN LA MADRUGADA Y SIGUE OCUPANDO HASTA LAS 6 DE NOCHE
      COALESCE(CASE  WHEN 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) < 7 AND 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) > 0 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0
        THEN
          'ESTAS EN TU TIEMPO EXTRA PERO TIENES QUE PAGAR OP 2'
      END)

-- SE EL CASO ES QUE TE QUEDASTE HASTA MAS DE LAS 6 DE LA NOCHE ENTONCES EL HUESPED A EMPESADO NUEVO DIA
      COALESCE(CASE  WHEN 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 6 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0
        THEN
          'USTED ACABA DE EMPESAR NUEVO DIA OP 3 FINALIZA MAÑANA AL MEDIO DIA'
      END)

-- ESTO CUMPLE PARA AQUELLOS HUESPEDES QUE ENTRARON DESDE LAS 6 EN PUNTO A MAS 
      COALESCE(CASE  WHEN 
          (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 7 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) > 0) AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) AND
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0
        THEN
          'TERMINA MAÑANA AL MEDIO DIA OP 4'
      END)

-- SI CANTIDAD DE DIAS ES MAYOR O IGUAL A 1
      COALESCE(CASE  WHEN 
          (EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) >= 7 AND DATE(ho.fecha_ingreso) = DATE(NOW())) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
        THEN
          'TERMINA HOY AL MEDIO DIA OP 5'
      END)

-- SI TIENES MAS DE UN DIA REGISTRADO Y  TE HAS EXEDIDO DE LA HORA DE SALIDA
      COALESCE(CASE  WHEN 
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) < 7 AND  
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) > 0
        THEN
          'ESTAS EN TU TIEMPO EXTRA PERO TIENES QUE PAGAR OP 6'
      END)

-- SE EL CASO ES QUE TE QUEDASTE HASTA MAS DE LAS 6 DE LA NOCHE ENTONCES EL HUESPED A EMPESADO NUEVO DIA
      COALESCE(CASE  WHEN 
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 7  
        THEN
          'USTED ACABA DE EMPESAR NUEVO DIA OP 7 f mañana'
      END)




---------------------------- SE ESTA APLICANDO ESTA OPCION EN LAS CONSULTAS DE SISTEMA---------------------------
SELECT ho.fk_id_habitacion as habi, 
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
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) > 0) AND
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
  ) as mensaje
  FROM hospedaje ho
----------------------------------------------------------------------------------------------------------------------------


----------------------------------- CONSULTA PARA LOS HOSPEDAJES FINALIZADOS------------------------------------------------
SELECT ho.fk_id_habitacion as habi, 
  COALESCE(
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
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(ho.fecha_salida),'13:00:00'))) > 0) AND
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
  ) as mensaje
  FROM hospedaje ho
  ------------------------------------------------------------------------------------------------------------




-- consultas unidas para lograr que lance el mensaje de cuanto

      COALESCE(CASE  WHEN 
          (EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(NOW()),'05:00:00'))) <= 0 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0) OR 
          ((EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) >= 7 AND DATE(ho.fecha_ingreso) = DATE(NOW())) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0)
        THEN
          'TERMINA HOY AL MEDIO DIA OP 1'
      END)

COALESCE(CASE  WHEN 
          (EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) < 7 AND 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) > 0 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0) 
          OR 
          (EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) < 7 AND  
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) > 0)
        THEN
          'ESTAS EN TU TIEMPO EXTRA PERO TIENES QUE PAGAR OP 2'
      END)


 COALESCE(CASE  WHEN 
          ((EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 OR 
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
          ) AND EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 7) OR 
          ((EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 7 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) > 0) AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) AND
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0)
        THEN
          'USTED FINALIZA MAÑANA AL MEDIO DIA'
      END)












-- CONSULTA PARA DETERMINAR CUANDO SALE Y SI ESTA EN SU TIEMPO EXTRA

SELECT ho.fk_id_habitacion as habi, 
  COALESCE(
    CASE 
      WHEN 
          (EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) < 7 AND 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) > 0 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0) OR 
          (EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) < 7 AND  
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) > 0)
        THEN
          'Estas en tu tiempo Extra'

      WHEN ((EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 OR 
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
          ) AND EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 7) OR 
          ((EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 7 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) > 0) AND
          DATE(ho.fecha_ingreso) = DATE(NOW()) AND
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0)
        THEN
          'Finaliza Mañana al Medio Día'
      WHEN 
          (EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso, TIMESTAMP(DATE(NOW()),'05:00:00'))) <= 0 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0) OR 
          ((EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) >= 7 AND DATE(ho.fecha_ingreso) = DATE(NOW())) OR
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0)
        THEN
          'Finaliza Hoy al Medio Día'
    END
  ) as mensaje
  FROM hospedaje ho


COALESCE(
    CASE 
      WHEN 
          (EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) < 6 AND 
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) > 0 AND 
          EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0)
      THEN 'Finaliza Mañana al Medio Día'
      WHEN
          (EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0 AND
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) < 6 AND  
          EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) > 0)
        THEN 'Estas en tu tiempo Extra'
      WHEN ((EXTRACT(DAY FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) = 0 OR 
          EXTRACT(DAY FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),TIMESTAMP(DATE(ho.fecha_ingreso),'13:00:00'))) != 0
          ) AND EXTRACT(HOUR FROM TIMEDIFF(NOW(),TIMESTAMP(DATE(NOW()),'13:00:00'))) >= 5) OR 
          ((EXTRACT(HOUR FROM TIMEDIFF(TIMESTAMP(DATE(NOW()),'13:00:00'),ho.fecha_ingreso)) < 6 OR 
          EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_ingreso,TIMESTAMP(DATE(NOW()),'13:00:00'))) > 0) AND
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













consulta de hospedaje con usuario entre dos fecha
SELECT ha.id_habitacion AS hab, CONCAT(hu.nombre, ' ', hu.apellido) AS huesped, ho.fecha_ingreso, ho.fecha_salida, CONCAT( EXTRACT(day FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)), ' Dias ', EXTRACT(hour FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)),':', EXTRACT(MINUTE FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)),'min') as tiempo, ha.precio, (COALESCE(case when EXTRACT(day FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)) = 0 then 1 else EXTRACT(day FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)) end)* ha.precio) AS costo,(SELECT SUM(costo_total) FROM hospedaje ho INNER JOIN usuario us ON ho.fk_id_usuario = us.id_usuario  WHERE us.id_usuario = '".$id_usuario."' AND ho.fecha_ingreso >= '".$fecha_inicio."' AND ho.fecha_salida <= '".$fecha_fin."' AND ho.estado = 'Finalizado') as total , us.nombre AS usuario FROM hospedaje ho INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion INNER JOIN usuario us ON ho.fk_id_usuario = us.id_usuario WHERE us.id_usuario = '".$id_usuario."' AND ho.fecha_ingreso >= '".$fecha_inicio."' AND ho.fecha_salida <= '".$fecha_fin."' AND ho.estado = 'Finalizado';

SELECT ha.id_habitacion AS hab, CONCAT(hu.nombre, ' ', hu.apellido) AS huesped, ho.fecha_ingreso, ho.fecha_salida, CONCAT( EXTRACT(day FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)), ' Dias ', EXTRACT(hour FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)),':', EXTRACT(MINUTE FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)),'min') as tiempo, ha.precio, (COALESCE(case when EXTRACT(day FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)) = 0 then 1 else EXTRACT(day FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)) end)* ha.precio) AS total, us.nombre AS usuario FROM hospedaje ho INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion INNER JOIN usuario us ON ho.fk_id_usuario = us.id_usuario WHERE ho.fecha_ingreso >= '".$fecha_inicio."' AND ho.fecha_salida <= '".$fecha_fin."' AND ho.estado = 'Finalizado';

SELECT ho.fk_id_habitacion as habi, concat(hu.nombre,' ',hu.apellido) as huesped, ve.fecha, ve.total as cancelo, ve.deuda, us.nombre as usuario, (SELECT SUM(ve.total) FROM venta ve WHERE ve.fecha >= '".$fecha_inicio."' AND ve.fecha <= '".$fecha_fin."') as total  FROM venta ve INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN usuario us ON ve.fk_id_usuario = us.id_usuario INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped WHERE ve.fecha >= '".$fecha_inicio."' AND ve.fecha <= '".$fecha_fin."';



-- slecciona todo los habitaciones que estan ocupados con sus respectivo huespedes

SELECT fk_id_habitacion, 
concat(hu.nombre,' ', hu.apellido) as huesped, 
fecha_ingreso, 
fecha_salida, 
ha.foto, ha.precio AS total, u.nombre 
FROM hospedaje ho 
INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped 
INNER JOIN usuario u ON ho.fk_id_usuario = u.id_usuario 
INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion

-- lista todo el hospedaje con su respectivo monto a pagar y la cantidad de dias que se quedo

SELECT (day(fecha_salida) - day(fecha_ingreso)) as dias, 
((day(fecha_salida) - day(fecha_ingreso))*ha.precio) as total 
FROM hospedaje ho 
INNER JOIN habitacion ha on ho.fk_id_habitacion = ha.id_habitacion 
WHERE day(fecha_salida) >= '19'

-- muestra el año, mes y dia 
SELECT YEAR(fecha_ingreso) as año, month(fecha_ingreso) AS mes, day(fecha_ingreso) AS dia
FROM hospedaje

-- obtnienes la hora exacta de hoy
SELECT CURTIME();

-- obtnienes la cantidad de dias entre dos fechas y costo de habitacion y monto a pagar
SELECT DATEDIFF(fecha_salida,fecha_ingreso) as Cant_Dias, precio, DATEDIFF(fecha_salida,fecha_ingreso)*ha.precio AS Total 
FROM hospedaje ho 
INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacionSELECT id_habitacion, fecha_ingreso, fecha_salida, DATEDIFF(NOW(),fecha_ingreso) as Cant_Dias, precio, DATEDIFF(NOW(),fecha_ingreso)*ha.precio AS Total FROM hospedaje ho INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion WHERE fecha_salida >= NOW()

SELECT id_habitacion, fecha_ingreso, fecha_salida, 
DATEDIFF(NOW(),fecha_ingreso) as Cant_Dias, 
precio, DATEDIFF(NOW(),fecha_ingreso)*ha.precio AS Total 
FROM hospedaje ho 
INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion 
WHERE fecha_salida >= NOW()

-- muestr casi todo para la funcion ocupado 
SELECT fk_id_habitacion as hab, concat(hu.nombre,' ', hu.apellido) as huesped, 
fecha_ingreso as ingreso, fecha_salida as salida, ha.foto, precio, 
EXTRACT(hour FROM TIMEDIFF(NOW(), fecha_ingreso)) as horas, 
DATEDIFF(fecha_salida,fecha_ingreso) as cant_dias, 
DATEDIFF(fecha_salida,fecha_ingreso)*ha.precio AS Total, u.nombre 
FROM hospedaje ho INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped 
INNER JOIN usuario u ON ho.fk_id_usuario = u.id_usuario 
INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion


-- muestra todo los campos que necesito exepto los datos del usuario
SELECT 
  fk_id_habitacion as hab, 
  ha.tipo as tipo, 
  ha.estado as estado, 
  concat(hu.nombre,' ', hu.apellido) as huesped, 
  hu.telefono as cel, fecha_ingreso as ingreso, 
  fecha_salida as salida, 
  ha.foto, ha.precio as costo, 
  EXTRACT(hour FROM TIMEDIFF(NOW(), fecha_ingreso)) as horas, 
  DATEDIFF(fecha_salida,fecha_ingreso) as cant_dias, 
  DATEDIFF(NOW(),fecha_ingreso) * ha.precio as deuda, 
  DATEDIFF(fecha_salida,fecha_ingreso)*ha.precio AS total 
FROM hospedaje ho 
INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped 
INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion

SELECT
  id_habitacion AS habi,
  concat(nombre,' ', apellido) AS huesped,
  fecha_ingreso,
  fecha_salida,
  DATEDIFF(NOW(),
  fecha_ingreso) AS Nº_Dias,
  precio,
  DATEDIFF(NOW(),
  fecha_ingreso) * precio AS Total
FROM
  hospedaje ho
INNER JOIN
  habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
INNER JOIN 
 huesped hu ON ho.fk_id_huesped = hu.id_huesped
WHERE
  fecha_salida >= NOW()

-- muestra todo los datos necesarios para la pestaña se reverdado
SELECT fk_id_habitacion as id_habi, 
ha.precio,
ha.estado, 
ha.foto, 
ha.tipo, 
fecha_reser, 
fecha_ingreso, 
fecha_salida, 
re.descripcion, 
concat(hu.nombre,' ', hu.apellido) as huesped, 
hu.telefono 
FROM reservacion re 
INNER JOIN habitacion ha on re.fk_id_habitacion = ha.id_habitacion 
INNER JOIN huesped hu on re.fk_id_huesped = hu.id_huesped 
WHERE fecha_ingreso >= NOW()


SELECT ho.id_hospedaje, 
ha.id_habitacion, 
concat(hu.nombre,' ', hu.apellido) as huesped, 
ho.fecha_ingreso, ho.fecha_salida, 
ha.estado 
FROM hospedaje ho 
INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped 
INNER JOIN habitacion ha on ho.fk_id_habitacion = ha.id_habitacion 
WHERE ha.id_habitacion = '503' AND ho.estado = 'Activo'

DATEDIFF(ho.fecha_salida, NOW()) >= '0'







BEGIN
DECLARE idventa integer;
SELECT ve.id_venta INTO idventa FROM venta ve INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje WHERE ho.id_hospedaje = NEW.fk_id_hospedaje and ho.estado = 'Activo' AND ve.deuda>0;

IF EXISTS (SELECT ve.id_venta FROM venta ve INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje WHERE ho.id_hospedaje = NEW.fk_id_hospedaje and ho.estado = 'Activo' AND ve.deuda>0) THEN

UPDATE `venta` SET `deuda`= '0.00' WHERE `id_venta`= idventa;

END IF;
END


-- FORMAS PARA OPTENER CANTIDAD DE MINUTOS TRANSCURRIDOS
SELECT CONCAT(FLOOR((NOW()-fecha_reser) / 60) , ' Minutes') as tiempo FROM reservacion
SELECT CONCAT(FLOOR((NOW()-fecha_reser) / 3600) , ' Horas') as tiempo FROM reservacion
SELECT CONCAT(FLOOR((NOW()-fecha_reser) / 86400) , ' Dias') as tiempo FROM reservacion
  
-- JUNTAMOS PARA QUE MUESTRE HORAS Y MINUTOS
SELECT 
CONCAT(FLOOR((NOW()-fecha_reser) / 3600) , ' Horas') as horas, 
CONCAT(FLOOR(MOD((NOW()-fecha_reser), 3600)/60) , ' minutos') as minutos 
FROM reservacion

SELECT 
CONCAT(FLOOR((NOW()-fecha_reser) / 86400) , ' DIAS') as DIAS, 
CONCAT(FLOOR(MOD((NOW()-fecha_reser), 86400)/3600) , ' HORAS') as HORAS, 
CONCAT(FLOOR(MOD((NOW()-fecha_reser), 3600)/60) , ' minutos') as minutos 
FROM reservacion


  CONCAT(FLOOR((NOW()-fecha_reser) / 86400) , ' DIAS ', 
  FLOOR(MOD((NOW()-fecha_reser), 86400)/3600) , ' HORAS ',
  FLOOR(MOD((NOW()-fecha_reser), 3600)/60) , ' minutos') as tiempo


-- CONSULTA UTILIZADO PARA MENSJAES DE reservacion
SELECT 
ha.id_habitacion, 
ha.foto, 
concat(hu.nombre,' ',hu.apellido) as huesped, 
re.fecha_ingreso,
CONCAT(
  FLOOR((NOW()-fecha_reser) / 86400) , ' dias  ', 
  FLOOR(MOD((NOW()-fecha_reser), 86400)/3600) , ':',
  FLOOR(MOD((NOW()-fecha_reser), 3600)/60) , ' m') as tiempo
FROM reservacion re 
INNER JOIN huesped hu ON re.fk_id_huesped = hu.id_huesped
INNER JOIN habitacion ha ON re.fk_id_habitacion = ha.id_habitacion
WHERE DATEDIFF(re.fecha_ingreso, NOW()) = '1' OR DATEDIFF(re.fecha_ingreso, NOW()) = '0'

-- consultas para extraer la horas tracuridasa desde la fecha de ingreso 

SELECT EXTRACT(day FROM TIMEDIFF(NOW(), re.fecha_reser)) as dias FROM reservacion re
SELECT EXTRACT(hour FROM TIMEDIFF(NOW(), re.fecha_reser)) as horas FROM reservacion re
SELECT EXTRACT(MINUTE FROM TIMEDIFF(NOW(), re.fecha_reser)) as MINUTOS FROM reservacion re

SELECT CONCAT(
  EXTRACT(day FROM TIMEDIFF(NOW(), re.fecha_reser)), ' : ', 
  EXTRACT(hour FROM TIMEDIFF(NOW(), re.fecha_reser)),':',
  EXTRACT(MINUTE FROM TIMEDIFF(NOW(), re.fecha_reser))) AS HORA  
FROM reservacion re


SELECT ho.fk_id_habitacion, hu.id_huesped, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, pr.nombre, pr.descripcion, dv.cantidad, pr.precio, dv.subtotal
FROM detalle_venta dv
INNER JOIN producto pr ON dv.fk_id_producto = pr.id_producto
INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta
INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje
INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped  
ORDER BY `hu`.`id_huesped`  DESC



SELECT ha.id_habitacion AS hab, hu.id_huesped AS dni, CONCAT(hu.nombre, ' ', hu.apellido) AS huesped, ho.fecha_ingreso, ho.fecha_salida, CONCAT( EXTRACT(day FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)), ' Dias ', EXTRACT(hour FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)),':', EXTRACT(MINUTE FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)),'min') as tiempo, ha.precio, (dias * ha.precio) AS subtotal, ho.costo_total AS total, ho.deuda, us.nombre AS usuario FROM hospedaje ho INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion INNER JOIN usuario us ON ho.fk_id_usuario = us.id_usuario WHERE ho.estado = 'Finalizado';


-- como utilizar un if dentro de un SELECT 
SELECT 
ha.id_habitacion AS hab, 
hu.id_huesped AS dni, 
CONCAT(hu.nombre, ' ', hu.apellido) AS huesped, 
ho.fecha_ingreso, 
ho.fecha_salida, 
CONCAT( EXTRACT(day FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)), ' Dias ', 
  EXTRACT(hour FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)),':', 
  EXTRACT(MINUTE FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)),'min') as tiempo, 
ha.precio, 
(
  COALESCE(case when EXTRACT(day FROM TIMEDIFF(fecha_salida, fecha_ingreso)) = 0 then
    1 
  else 
    EXTRACT(day FROM TIMEDIFF(fecha_salida, fecha_ingreso)) 
  end
)* ha.precio) AS subtotal, 
ho.costo_total AS total, 
ho.deuda, 
us.nombre AS usuario 
FROM hospedaje ho 
INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped 
INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion 
INNER JOIN usuario us ON ho.fk_id_usuario = us.id_usuario 
WHERE ho.estado = 'Finalizado'


SELECT COALESCE(case when EXTRACT(day FROM TIMEDIFF(fecha_salida, fecha_ingreso)) = 0 
  then 1 else EXTRACT(day FROM TIMEDIFF(fecha_salida, fecha_ingreso)) end) as dias 
FROM hospedaje


COALESCE(case when EXTRACT(day FROM TIMEDIFF(NOW(), ho.fecha_ingreso)) = 0 
  then 1 else EXTRACT(day FROM TIMEDIFF(NOW(), ho.fecha_ingreso)) end)


-- ultimono valor insertado
SELECT id_hospedaje FROM hospedaje ORDER BY id_hospedaje DESC LIMIT 1

SELECT ha.id_habitacion AS hab, CONCAT(hu.nombre, ' ', hu.apellido) AS huesped, ho.fecha_ingreso, ho.fecha_salida, CONCAT( EXTRACT(day FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)), ' Dias ', EXTRACT(hour FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)),':', EXTRACT(MINUTE FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)),'min') as tiempo, ha.precio, (COALESCE(case when EXTRACT(day FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)) = 0 then 1 else EXTRACT(day FROM TIMEDIFF(ho.fecha_salida, ho.fecha_ingreso)) end)* ha.precio) AS total, us.nombre AS usuario FROM hospedaje ho INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion INNER JOIN usuario us ON ho.fk_id_usuario = us.id_usuario WHERE (ho.estado = 'Finalizado' OR ho.estado = 'Activo') AND ho.fecha_salida <= NOW();

SELECT
  (
    COALESCE(
      CASE WHEN EXTRACT(
        DAY
      FROM TIMEDIFF
        (NOW(),
        ho.fecha_ingreso)) = 0 THEN 1 
         WHEN EXTRACT(
              HOUR
            FROM TIMEDIFF
              (NOW(),
              ho.fecha_ingreso)) > 0 THEN 
              EXTRACT(
                DAY
              FROM TIMEDIFF
                (NOW(),
                ho.fecha_ingreso))+1
        ELSE  EXTRACT(
          DAY
        FROM TIMEDIFF
          (NOW(),
          ho.fecha_ingreso))
        END
      ) * ha.precio
    ) AS total
  FROM
    hospedaje ho
  INNER JOIN
    habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
  INNER JOIN
    huesped hu ON ho.fk_id_huesped = hu.id_huesped
  WHERE
    ha.id_habitacion = '503' AND ho.estado = 'Activo'


-- CONSULTA PARA HUESPES QUE SE RETIRARON


    SELECT
  (
    COALESCE(
      CASE WHEN EXTRACT(
        DAY
      FROM TIMEDIFF
        (ho.fecha_salida,
        ho.fecha_ingreso)) = 0 THEN 1 
         WHEN EXTRACT(
        HOUR
      FROM TIMEDIFF
        (ho.fecha_salida,
        ho.fecha_ingreso)) > 5 THEN 
        EXTRACT(
          DAY
        FROM TIMEDIFF
          (ho.fecha_salida,
          ho.fecha_ingreso))+1
        ELSE  EXTRACT(
          DAY
        FROM TIMEDIFF
          (ho.fecha_salida,
          ho.fecha_ingreso))
        END
      ) * ha.precio
    ) AS total
  FROM
    hospedaje ho
  INNER JOIN
    habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
  INNER JOIN
    huesped hu ON ho.fk_id_huesped = hu.id_huesped
  WHERE
    ho.id_hospedaje = '8'



-- HOSPEDAJE ACTIDO CONSULTA
if  (SELECT id_hospedaje FROM hospedaje ho WHERE ho.id_hospedaje =  AND ho.estado = 'Activo')
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
  ha.precio,
  ha.foto,
  CONCAT(
    EXTRACT(
      DAY
    FROM TIMEDIFF
      (NOW(),
      ho.fecha_ingreso)),
      ' Dias ',
      EXTRACT(
        HOUR
      FROM TIMEDIFF
        (NOW(),
        ho.fecha_ingreso)),
        ':',
        EXTRACT(
          MINUTE
        FROM TIMEDIFF
          (NOW(),
          ho.fecha_ingreso)),
          'min'
        ) AS cant_dias,
        (
          COALESCE(
            CASE WHEN EXTRACT(
              DAY
            FROM TIMEDIFF
              (NOW(),
              ho.fecha_ingreso)) = 0 THEN 1 WHEN EXTRACT(
                HOUR
              FROM TIMEDIFF
                (NOW(),
                ho.fecha_ingreso)) > 5 THEN EXTRACT(
                  DAY
                FROM TIMEDIFF
                  (NOW(),
                  ho.fecha_ingreso)) +1 ELSE EXTRACT(
                    DAY
                  FROM TIMEDIFF
                    (NOW(),
                    ho.fecha_ingreso))
                  END
                ) * ha.precio
              ) AS total,
              ho.costo_total AS adelanto,
              (
                (
                  COALESCE(
                    CASE WHEN EXTRACT(
                      DAY
                    FROM TIMEDIFF
                      (NOW(),
                      ho.fecha_ingreso)) = 0 THEN 1 WHEN EXTRACT(
                        HOUR
                      FROM TIMEDIFF
                        (NOW(),
                        ho.fecha_ingreso)) > 0 THEN EXTRACT(
                          DAY
                        FROM TIMEDIFF
                          (NOW(),
                          ho.fecha_ingreso)) +1 ELSE EXTRACT(
                            DAY
                          FROM TIMEDIFF
                            (NOW(),
                            ho.fecha_ingreso))
                          END
                        ) * ha.precio
                      ) - ho.costo_total
                    ) AS deuda
                  FROM
                    hospedaje ho
                  INNER JOIN
                    habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
                  INNER JOIN
                    huesped hu ON ho.fk_id_huesped = hu.id_huesped
                  WHERE

  -- para il ingreso hal hospedaje
  SELECT
  (SELECT SUM(monto) FROM `auditoriaventa`WHERE fecha LIKE CONCAT(fech,"%")) as hospedaje,
  (SELECT SUM(monto) FROM `auditoriahospedaje`WHERE fecha LIKE CONCAT(fech,"%")) as ventas,
  (SELECT SUM(adelanto) FROM `reservacion`WHERE fecha_reser LIKE CONCAT(fech,"%")) as reservacion,
  (SELECT SUM(monto) FROM `gasto`WHERE fecha LIKE CONCAT(fech,"%")) as gasto

  SELECT
  (SELECT SUM(monto) FROM `auditoriaventa`WHERE fecha LIKE CONCAT(fech,'%')) as hospedaje,
  (SELECT SUM(monto) FROM `auditoriahospedaje`WHERE fecha LIKE CONCAT(fech,'%')) as ventas,
  (SELECT SUM(adelanto) FROM `reservacion`WHERE fecha_reser LIKE CONCAT(fech,'%')) as reservacion,
  (SELECT SUM(monto) FROM `gasto` WHERE fecha LIKE CONCAT(fech,'%')) as gasto;


-- CONSULTA PARA HOSPEDAJE ACTIVO 
BEGIN
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
    ha.precio,
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
    ) * ha.precio) AS total,
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
    )* ha.precio) - ho.costo_total) AS deuda,
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
END
-- CONSULTA PARA HOSPEDAJE Finalizado
BEGIN
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
    ha.precio,
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
    ) * ha.precio) AS total,
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
    )* ha.precio) - ho.costo_total) AS deuda,
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
END