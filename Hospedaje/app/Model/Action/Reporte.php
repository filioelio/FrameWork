<?php namespace app\Model\Action;
	
	use App\Core\ModeloBase;


	class Reporte extends ModeloBase
	{
		public function __construct()
		{
			$table = "hospedaje";
			parent::__construct($table);
		}

		
		public function RFRepote($fecha)
		{
			// "REPORTE DE RESERVACIONES DE UNA FECHA UNICA"
			$run = $this->runSql("SELECT res.fk_id_habitacion as habi, concat(hu.nombre,' ',hu.apellido) as huesped, res.fecha_reser, res.fecha_ingreso, res.descripcion, res.adelanto, us.nombre, (SELECT SUM(res.adelanto) FROM reservacion res WHERE res.fecha_reser > '".$fecha."') as total FROM reservacion res INNER JOIN huesped hu ON res.fk_id_huesped = hu.id_huesped INNER JOIN usuario us ON res.fk_id_usuario = us.id_usuario WHERE res.fecha_reser > '".$fecha."'");
			return $run;
		}


		public function RDFRepote($fecha_inicio, $fecha_fin)
		{
			// "REPORTE ENTRE DOS FECHAS DE RESERVACIONES";
			$run = $this->runSql("");
			return $run;
		}

		public function RGRepote()
		{
			// "REPORTE GENERAL DE RESERVACIONES";
			$run = $this->runSql("");
			return $run;
		}

		public function HFReporte($fecha)
		{
			// "REPORTE DE HOSPEDAJE DE UNA SOLA FECHA"
			$run = $this->runSql("SELECT ho.fk_id_habitacion AS hab, hu.id_huesped as dni, CONCAT(hu.nombre, ' ', hu.apellido) AS huesped, ah.fecha, ah.monto, us.nombre AS usuario, (SELECT SUM(ah.monto) FROM auditoriahospedaje ah WHERE ah.fecha > '".$fecha."') as total FROM auditoriahospedaje ah INNER JOIN hospedaje ho ON ah.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN usuario us ON ah.fk_id_usuario = us.id_usuario WHERE ah.fecha > '".$fecha."' AND ah.monto != 0 ORDER BY hu.id_huesped DESC");
			return $run;
		}

		public function VPReporteHoy($fecha)
		{
			$run = $this->runSql("SELECT ho.fk_id_habitacion as habi, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, pr.nombre, dv.cantidad as cant, pr.precio, dv.subtotal, us.nombre as usuario, (SELECT SUM(dv.subtotal) FROM detalle_venta dv INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta WHERE ve.fecha > '".$fecha."') as total, (SELECT SUM(monto) FROM auditoriaventa av WHERE av.fecha > '".$fecha."') as ingresoneto FROM detalle_venta dv INNER JOIN producto pr ON dv.fk_id_producto = pr.id_producto INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN usuario us ON ve.fk_id_usuario = us.id_usuario WHERE ve.fecha > '".$fecha."' ORDER BY `hu`.`id_huesped` DESC");
			return $run;
		}
		

		public function HUReporte($id_usuario,$fecha_inicio, $fecha_fin)
		{
			$run = $this->runSql("SELECT ha.id_habitacion AS hab, CONCAT(hu.nombre,' ',hu.apellido) AS huesped,ho.fecha_ingreso,ho.fecha_salida,
			    (COALESCE(
			    	CASE WHEN EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) = 0 THEN 1
			        WHEN EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))> 4 
			        THEN EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))+1
			        ELSE EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) END
			    )) AS dias, ha.precio, ho.costo_total AS costo,
			  	(SELECT SUM(costo_total) 
			  		FROM hospedaje ho 
			  		INNER JOIN usuario us on ho.fk_id_usuario = us.id_usuario 
			  		WHERE us.id_usuario = '".$id_usuario."' AND ho.estado = 'Finalizado' AND  
			  		ho.fecha_salida BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'
			  	)as total, us.nombre AS usuario
				FROM hospedaje ho
				INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped
				INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
				INNER JOIN usuario us ON ho.fk_id_usuario = us.id_usuario
				WHERE us.id_usuario = '".$id_usuario."' AND ho.estado = 'Finalizado' and ho.fecha_salida BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'");

			return $run;
		} 

		public function HReporte($fecha_inicio, $fecha_fin)
		{
			$run = $this->runSql("SELECT ha.id_habitacion AS hab, CONCAT(hu.nombre,' ',hu.apellido) AS huesped,ho.fecha_ingreso,ho.fecha_salida,
			    (COALESCE(
			    	CASE WHEN EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) = 0 THEN 1
			        WHEN EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))> 4 
			        THEN EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))+1
			        ELSE EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) END
			    )) AS dias, ha.precio, ho.costo_total AS costo,
			  	(SELECT SUM(costo_total) 
			  		FROM hospedaje ho 
			  		WHERE ho.estado = 'Finalizado' AND  
			  		ho.fecha_salida BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'
			  	)as total, us.nombre AS usuario
				FROM hospedaje ho
				INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped
				INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
				INNER JOIN usuario us ON ho.fk_id_usuario = us.id_usuario
				WHERE ho.estado = 'Finalizado' and ho.fecha_salida BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."'");
			return $run;	
		}
		public function PUReporte($id_usuario,$fecha_inicio, $fecha_fin)
		{
			$run = $this->runSql("SELECT ho.fk_id_habitacion as habi, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, pr.nombre, dv.cantidad as cant, pr.precio, dv.subtotal, us.nombre as usuario, (SELECT SUM(dv.subtotal) FROM detalle_venta dv INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta WHERE ve.fk_id_usuario = '".$id_usuario."' and ve.fecha BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."') as total, (SELECT SUM(av.monto) FROM auditoriaventa av WHERE av.fk_id_usuario = '".$id_usuario."' AND av.fecha BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."') as ingresoneto FROM detalle_venta dv INNER JOIN producto pr ON dv.fk_id_producto = pr.id_producto INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN usuario us ON ve.fk_id_usuario = us.id_usuario WHERE ve.fk_id_usuario = '".$id_usuario."' and ve.fecha BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."' ORDER BY hu.id_huesped DESC");

			return $run;	
		}
		public function PReporte($fecha_inicio, $fecha_fin)
		{

			$run = $this->runSql("SELECT ho.fk_id_habitacion as habi, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, pr.nombre, dv.cantidad as cant, pr.precio, dv.subtotal, us.nombre as usuario, (SELECT SUM(dv.subtotal) FROM detalle_venta dv INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta WHERE ve.fecha BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."') as total, (SELECT SUM(av.monto) FROM auditoriaventa av WHERE av.fecha BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."') as ingresoneto FROM detalle_venta dv INNER JOIN producto pr ON dv.fk_id_producto = pr.id_producto INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN usuario us ON ve.fk_id_usuario = us.id_usuario WHERE ve.fecha BETWEEN '".$fecha_inicio."' AND '".$fecha_fin."' ORDER BY hu.id_huesped DESC");

			return $run;
		}

		public function PUDVReporte($id_usuario,$fecha_inicio, $fecha_fin)
		{
			$run = $this->runSql("SELECT ho.fk_id_habitacion as habi, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, pr.nombre, dv.cantidad as cant, pr.precio, dv.subtotal, us.nombre as usuario, (SELECT SUM(dv.subtotal) FROM detalle_venta dv INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta WHERE ve.fk_id_usuario = '".$id_usuario."' AND ve.fecha >= '".$fecha_inicio."' and ve.fecha<= '".$fecha_fin."')as total FROM detalle_venta dv INNER JOIN producto pr ON dv.fk_id_producto = pr.id_producto INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN usuario us ON ve.fk_id_usuario = us.id_usuario WHERE ve.fecha >= '".$fecha_inicio."' and ve.fecha<= '".$fecha_fin."' AND us.id_usuario = '".$id_usuario."' ORDER BY `hu`.`id_huesped` DESC");
			return $run;	
		}
		public function PDVReporte($fecha_inicio, $fecha_fin)
		{
			$run = $this->runSql("SELECT ho.fk_id_habitacion as habi, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, pr.nombre, dv.cantidad as cant, pr.precio, dv.subtotal, us.nombre as usuario, (SELECT SUM(dv.subtotal) FROM detalle_venta dv INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta WHERE ve.fecha >= '".$fecha_inicio."' and ve.fecha<= '".$fecha_fin."') as total FROM detalle_venta dv INNER JOIN producto pr ON dv.fk_id_producto = pr.id_producto INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN usuario us ON ve.fk_id_usuario = us.id_usuario WHERE ve.fecha >= '".$fecha_inicio."' and ve.fecha<= '".$fecha_fin."' ORDER BY `hu`.`id_huesped` DESC");
			return $run;
		}

		public function HGReporte()
		{
			$run = $this->runSql("SELECT ha.id_habitacion AS hab, CONCAT(hu.nombre,' ',hu.apellido) AS huesped,ho.fecha_ingreso,ho.fecha_salida,
			    (COALESCE(
			    	CASE WHEN EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) = 0 THEN 1
			        WHEN EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))> 4 
			        THEN EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))+1
			        ELSE EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) END
			    )) AS dias, ha.precio, ho.costo_total AS costo,
			  	(SELECT SUM(costo_total) 
			  		FROM hospedaje ho 
			  		WHERE ho.estado = 'Finalizado'
			  	)as total, us.nombre AS usuario
				FROM hospedaje ho
				INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped
				INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
				INNER JOIN usuario us ON ho.fk_id_usuario = us.id_usuario
				WHERE  ho.estado = 'Finalizado' ");
			return $run;			
		}

		public function VGReporte()
		{
			$run = $this->runSql("SELECT ho.fk_id_habitacion as habi, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, pr.nombre, dv.cantidad as cant, pr.precio, dv.subtotal, us.nombre as usuario, (SELECT SUM(subtotal) FROM detalle_venta dv INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje WHERE ho.estado = 'Finalizado') as total FROM detalle_venta dv INNER JOIN producto pr ON dv.fk_id_producto = pr.id_producto INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN usuario us ON ve.fk_id_usuario = us.id_usuario WHERE ho.estado = 'Finalizado' ORDER BY `hu`.`id_huesped` DESC");
			return $run;
		}

		public function VPReporte($fecha)
		{
			$run = $this->runSql("SELECT ho.fk_id_habitacion as habi, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, pr.nombre, dv.cantidad as cant, pr.precio, dv.subtotal, us.nombre as usuario, (SELECT SUM(dv.subtotal) FROM detalle_venta dv INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta WHERE ve.fecha LIKE concat('".$fecha."','%')) as total, (SELECT SUM(monto) FROM auditoriaventa av WHERE av.fecha LIKE concat('".$fecha."','%')) as ingresoneto FROM detalle_venta dv INNER JOIN producto pr ON dv.fk_id_producto = pr.id_producto INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN usuario us ON ve.fk_id_usuario = us.id_usuario WHERE ve.fecha LIKE concat('".$fecha."','%') ORDER BY `hu`.`id_huesped` DESC");
			return $run;
		}
				// "SELECT ho.fk_id_habitacion as habi, concat(hu.nombre,' ', hu.apellido) as huesped, ve.fecha, pr.nombre, dv.cantidad as cant, pr.precio, dv.subtotal, us.nombre as usuario, (SELECT SUM(dv.subtotal) FROM detalle_venta dv INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta WHERE ve.fecha LIKE '".$fecha."%') as total  FROM detalle_venta dv INNER JOIN producto pr ON dv.fk_id_producto = pr.id_producto INNER JOIN venta ve ON dv.fk_id_venta = ve.id_venta INNER JOIN hospedaje ho ON ve.fk_id_hospedaje = ho.id_hospedaje INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped INNER JOIN usuario us ON ve.fk_id_usuario = us.id_usuario WHERE ve.fecha LIKE '".$fecha."%' ORDER BY `hu`.`id_huesped` DESC"
	}


	// SELECT ha.id_habitacion AS hab, CONCAT(hu.nombre,' ',hu.apellido) AS huesped,ho.fecha_ingreso,ho.fecha_salida,
 //    (COALESCE(
 //    	CASE WHEN EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) = 0 THEN 1
 //        WHEN EXTRACT(HOUR FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))> 4 
 //        THEN EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso))+1
 //        ELSE EXTRACT(DAY FROM TIMEDIFF(ho.fecha_salida,ho.fecha_ingreso)) END
 //    )) AS dias, ha.precio, ho.costo_total AS costo,
 //  	(SELECT SUM(costo_total) 
 //  		FROM hospedaje ho 
 //  		INNER JOIN usuario us on ho.fk_id_usuario = us.id_usuario 
 //  		WHERE us.id_usuario = '47050254' AND ho.fecha_salida AND ho.estado = 'Finalizado'
 //  		BETWEEN '2016-12-12' AND '2016-12-14'
 //  	)as total, us.nombre AS usuario
	// FROM hospedaje ho
	// INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped
	// INNER JOIN habitacion ha ON ho.fk_id_habitacion = ha.id_habitacion
	// INNER JOIN usuario us ON ho.fk_id_usuario = us.id_usuario
	// WHERE us.id_usuario = '47050254' AND ho.estado = 'Finalizado' and ho.fecha_salida BETWEEN '2016-12-12' AND '2016-12-14'