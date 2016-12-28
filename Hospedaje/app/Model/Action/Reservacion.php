<?php namespace app\Model\Action;
	
	use App\Model\Clase\Reservacion as CReservacion;
	use App\Core\ModeloBase;


	class Reservacion extends ModeloBase
	{

		public function __construct()
		{
			$table = "reservacion";
			parent::__construct($table);
		}
		
		public function MSAgenda($fecha)
		{
			$run = $this->runSql("SELECT (SELECT COUNT(*) FROM eventos WHERE estart = '".$fecha."') as cant, concat(title,' ',datos) as titulo FROM `eventos` WHERE estart = '".$fecha."'");
			return $run;
		}

		function MSPermiso($fecha)
		{
			$run = $this->runSql("SELECT (SELECT COUNT(*) FROM permiso WHERE fecha_inicio = '".$fecha."') as cant, concat(per.nombre,' ',per.apellido) as personal FROM permiso pe INNER JOIN personal per ON pe.fk_id_personal = per.id_personal where pe.fecha_inicio = '".$fecha."'");
			return $run;
		}

		public function MensajeReservacion()
		{
			$run = $this->runProcedure("MensajeReservacion");
			return $run;
		}

		public function historial()
		{
			$run = $this->runProcedure("ReservacionHistorial");
			return $run;
		}

		public function save(CReservacion $reservacion)
		{
			$save = $this->runSql(
				"INSERT INTO reservacion (
					id_reservacion,
					descripcion,
					fecha_reser,
					fecha_ingreso,
					fecha_salida,
					adelanto,
					estado,
					fk_id_usuario,
					fk_id_huesped,
					fk_id_habitacion
	
				) VALUES (
					'" . $reservacion->getIdReservacion() . "',
					'" . $reservacion->getDescripcion() . "',
					'" . $reservacion->getFechaReser() . "',
					'" . $reservacion->getFechaIngreso() . "',
					'" . $reservacion->getFechaSalida() . "',
					'" . $reservacion->getAdelanto() . "',
					'" . $reservacion->getEstado() . "',
					'" . $reservacion->getFkIdUsuario() . "',
					'" . $reservacion->getFkIdHuesped() . "',
					'" . $reservacion->getFkIdHabitacion() . "'
				)"
			);

			return $save;
		}

		public function update(CReservacion $reservacion)
		{
			$update = $this->runSql(
				"UPDATE reservacion SET 
				id_reservacion 		= '" . $reservacion->getIdReservacion() . "',
				descripcion 		= '" . $reservacion->getDescripcion() . "',
				fecha_reser 		= '" . $reservacion->getFechaReser() . "',
				fecha_ingreso 		= '" . $reservacion->getFechaIngreso() . "',
				fecha_salida 		= '" . $reservacion->getFechaSalida() . "',
				adelanto	 		= '" . $reservacion->getAdelanto() . "',
				estado		 		= '" . $reservacion->getEstado() . "',
				fk_id_usuario 		= '" . $reservacion->getFkIdUsuario() . "',
				fk_id_huesped 		= '" . $reservacion->getFkIdHuesped() . "',
				fk_id_habitacion 	= '" . $reservacion->getFkIdHabitaciond() . "'
				WHERE id_reservacion = '" . $reservacion->getIdReservacion() . "'"
			);

			return $update;
		}

		public function finalizar(CReservacion $reservacion)
		{
			$update = $this->runSql(
				"UPDATE reservacion SET 
					estado	= '" . $reservacion->getEstado() . "'
				WHERE id_reservacion = '" . $reservacion->getIdReservacion() ."';"
			);

			return $update;
		}

		public function delete(CReservacion $reservacion)
		{
			$delete = $this->deleteId($reservacion->getIdReservacion());

			return $delete;
		}

	}