<?php namespace app\Model\Action;
	
	use App\Model\Clase\Hospedaje as CHospedaje;
	use App\Core\ModeloBase;


	class Hospedaje extends ModeloBase
	{

		public function __construct()
		{
			$table = "hospedaje";
			parent::__construct($table);
		}

		public function SearchHospedaje($id_habi)
		{
			$run = $this->runSql("SELECT ho.fk_id_habitacion AS hab, hu.id_huesped AS dni, CONCAT(hu.nombre, ' ', hu.nombre) AS huesped, ah.fecha, ah.monto, CONCAT(usu.nombre, ' ', usu.apellido) AS usuario FROM auditoriahospedaje ah INNER JOIN hospedaje ho ON ah.fk_id_hospedaje = ho.id_hospedaje INNER JOIN usuario usu ON ah.fk_id_usuario = usu.id_usuario INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped WHERE  ho.estado = 'Activo' AND ho.fk_id_habitacion = (SELECT id_habitacion FROM habitacion WHERE estado = 'Ocupado' AND id_habitacion = '".$id_habi."')");
			return $run;
		}

		public function IngresoTotal($fecha)
		{
			$run = $this->runSql("SELECT
			  (SELECT SUM(monto) FROM `auditoriahospedaje`WHERE fecha >='".$fecha."') as hospedaje,
			  (SELECT SUM(monto) FROM auditoriaventa av WHERE av.fecha > '".$fecha."') as ventas,
			  (SELECT SUM(adelanto) FROM `reservacion`WHERE fecha_reser >='".$fecha."') as reservacion,
			  (SELECT SUM(monto) FROM `gasto` WHERE fecha >='".$fecha."') as gasto;");
			return $run;
		}

		public function IngresoToday($fecha)
		{
			$run = $this->runSql("SELECT ho.fk_id_habitacion as hab, hu.id_huesped as dni, concat(hu.nombre,' ', hu.nombre) as huesped, ah.fecha, ah.monto, concat(usu.nombre,' ',usu.apellido) as usuario FROM auditoriahospedaje ah INNER JOIN hospedaje ho ON ah.fk_id_hospedaje = ho.id_hospedaje INNER JOIN usuario usu ON ah.fk_id_usuario = usu.id_usuario INNER JOIN huesped hu ON ho.fk_id_huesped = hu.id_huesped WHERE ah.fecha >= '".$fecha."'");
			return $run;
		}

		public function HospedajeSelect($id_hospedaje)
		{
			$run = $this->runProcedure("HospedajeSelectGetId($id_hospedaje)");
			return $run;
		}

		public function getDataHospedaje($id_habitacion)
		{
			$run = $this->runProcedure("HospedajeHabitacionGetId($id_habitacion)");
			return $run;
		}

		public function BuscarHuespedId($id_habitacion)
		{
			$run = $this->runProcedure("BuscarHuespedId($id_habitacion)");
			return $run;
		}

		public function historial()
		{
			$run = $this->runProcedure("HospedajeHistorial");
			return $run;
		}

		public function save(CHospedaje $hospedaje)
		{
			$save = $this->runProcedure("HospedajeSave(
					'".$hospedaje->getMotivoVisita()."',
					'".$hospedaje->getFechaIngreso()."',
					'".$hospedaje->getFechaSalida()."',
					'".$hospedaje->getEstado()."',
					'".$hospedaje->getPrecio()."',
					'".$hospedaje->getCostoTotal()."',
					'".$hospedaje->getFkIdUsuario()."',
					'".$hospedaje->getFkIdHuesped()."',
					'".$hospedaje->getFkIdHabitacion()."'
				)"
			);
	
			return $save;
		}

		public function update_salida(CHospedaje $hospedaje)
		{
			$update = $this->runSql(
				"UPDATE hospedaje SET 
				fecha_salida 		= '" . $hospedaje->getFechaSalida() . "',
				estado				= '" . $hospedaje->getEstado() . "'
				WHERE id_hospedaje 	= '" . $hospedaje->getIdHospedaje() . "'"
			);
			return $update;
		}

		public function update(CHospedaje $hospedaje)
		{
			$update = $this->runSql(
				"UPDATE hospedaje SET 
				costo_total			= '" . $hospedaje->getCostoTotal() . "'
				WHERE id_hospedaje 	= '" . $hospedaje->getIdHospedaje() . "'"
			);

			return $update;
		}

		public function delete(Chospedaje $hospedaje)
		{
			$delete = $this->deleteId($hospedaje->getIdHospedaje());

			return $delete;
		}

	}