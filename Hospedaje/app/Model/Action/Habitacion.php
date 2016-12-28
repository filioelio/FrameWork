<?php namespace app\Model\Action;
	
	use App\Model\Clase\Habitacion as CHabitacion;
	use App\Core\ModeloBase;


	class Habitacion extends ModeloBase
	{

		public function __construct()
		{
			$table = "habitacion";
			parent::__construct($table);
		}

		public function MensajeAlert($id_habitacion)
		{
			$run = $this->runSql("
				SELECT (SELECT re.id_reservacion FROM reservacion re WHERE ha.id_habitacion = re.fk_id_habitacion AND (DATEDIFF(re.fecha_ingreso, NOW()) = '1' OR DATEDIFF(re.fecha_ingreso, NOW()) = '0') AND re.estado != 'Cancelado' AND re.fk_id_huesped NOT IN ( SELECT ho.fk_id_huesped FROM hospedaje ho WHERE ho.fk_id_huesped = re.fk_id_huesped AND ho.fk_id_habitacion = re.fk_id_habitacion )) as id, COALESCE( CASE WHEN EXISTS (SELECT re.fk_id_habitacion FROM reservacion re WHERE ha.id_habitacion = re.fk_id_habitacion AND (DATEDIFF(re.fecha_ingreso, NOW()) = '1' OR DATEDIFF(re.fecha_ingreso, NOW()) = '0') AND re.estado != 'Cancelado' AND re.fk_id_huesped NOT IN ( SELECT ho.fk_id_huesped FROM hospedaje ho WHERE ho.fk_id_huesped = re.fk_id_huesped AND ho.fk_id_habitacion = re.fk_id_habitacion )) THEN 1 ELSE 0 END ) as mensaje FROM habitacion ha WHERE ha.id_habitacion = '".$id_habitacion."'
				");
			return $run;
		}

		public function Estado()
		{
			$run = $this->runProcedure("HabitacionesEstados");

			return $run;
		}

		public function Ocupado()
		{
			$run = $this->runProcedure("HabitacionesOcupados");

			return $run;
		}

		public function Reservado()
		{
			$run = $this->runProcedure("HabitacionesReservado");

			return $run;
		}

		public function getIdReservacion($id_reservacion)
		{
			$run = $this->runProcedure("getIdReservacion($id_reservacion)");

			return $run;
		}

		public function save(CHabitacion $habitacion)
		{
			$foto = ($habitacion->getFoto() == NULL) ? "NULL" : "'" . $habitacion->getFoto() . "'";
			$save = $this->runSql(
				"INSERT INTO habitacion (
					id_habitacion,
					tipo,
					descripcion,
					estado,
					precio,
					foto
	
				) VALUES (
					'" . $habitacion->getIdHabitacion()."',
					'" . $habitacion->getTipo()."',
					'" . $habitacion->getDescripcion()."',
					'" . $habitacion->getEstado()."',			
					'" . $habitacion->getPrecio()."',
					$foto
				)"
			);

			return $save;
		}

		public function update_estado(CHabitacion $habitacion)
		{
			$update = $this->runSql(
				"UPDATE habitacion SET 
				estado 			= '" . $habitacion->getEstado()."'
				WHERE id_habitacion = '" . $habitacion->getIdHabitacion() ."'"
			);

			return $update;
		}

		public function update(CHabitacion $habitacion)
		{
			$foto = ($habitacion->getFoto() == NULL) ? "NULL" : "'" . $habitacion->getFoto() . "'";
			$update = $this->runSql(
				"UPDATE habitacion SET 
				id_habitacion 	= '" . $habitacion->getIdHabitacion()."',
				tipo 			= '" . $habitacion->getTipo()."',
				descripcion 	= '" . $habitacion->getDescripcion()."',
				estado 			= '" . $habitacion->getEstado()."',	
				precio 			= '" . $habitacion->getPrecio()."',
				foto 			= $foto
				WHERE id_habitacion = '" . $habitacion->getIdHabitacion() ."'"
			);

			return $update;
		}

		public function delete(CHabitacion $habitacion)
		{
			$delete = $this->deleteId($habitacion->getIdHabitacion());

			return $delete;
		}

	}