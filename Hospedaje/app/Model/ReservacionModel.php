<?php namespace App\Model;

	use App\Model\Clase\Reservacion as CReservacion;
	use App\Model\Action\Reservacion as AReservacion;

	class ReservacionModel
	{

		const RESERVACION_NAMESPACE = 'App\Model\Clase\Reservacion';

		public function __construct()
		{}

		function MSAgenda($fecha)
		{
			$a_reservacion = new AReservacion();
			$msagenda = $a_reservacion -> MSAgenda($fecha);
			if(isset($msagenda) && (is_array($msagenda) || is_object($msagenda)))
			{
				if(is_object($msagenda))
				{
					$msagenda = array($msagenda);
				}
				$msagenda = $msagenda;
			}
			return $msagenda;
		}

		function MSPermiso($fecha)
		{
			$a_reservacion = new AReservacion();
			$mspermiso = $a_reservacion -> MSPermiso($fecha);
			if(isset($mspermiso) && (is_array($mspermiso) || is_object($mspermiso)))
			{
				if(is_object($mspermiso))
				{
					$mspermiso = array($mspermiso);
				}
				$mspermiso = $mspermiso;
			}
			return $mspermiso;
		}


		public function historial()
		{
			$a_reservacion = new AReservacion();
			$reservacion = $a_reservacion -> historial();
			if(isset($reservacion) && (is_array($reservacion) || is_object($reservacion)))
			{
				if(is_object($reservacion))
				{
					$reservacion = array($reservacion);
				}
				$reservacion = $reservacion;
			}
			return $reservacion;
		}

		public function MensajeReservacion()
		{
			$a_reservacion = new AReservacion();
			$reservacion = $a_reservacion->MensajeReservacion();
			if(isset($reservacion) && (is_array($reservacion) || is_object($reservacion)))
			{
				if(is_object($reservacion))
				{
					$reservacion = array($reservacion);
				}
				$reservacion = $reservacion;
			}
			return $reservacion;
		}

		// public function all()
		// {
		// 	$a_reservacion = new AReservacion();
		// 	$reservacion = $a_reservacion->getAll(self::RESERVACION_NAMESPACE);
		// 	if (! isset($reservacion)) return NULL;
		// 	return $reservacion;
		// }

		public function save($descripcion, $fecha_reser, $ingreso, $salida, $adelanto, $id_usuario, $id_huesped, $id_habitacion)
		{
			$estado = "";
			$c_reservacion = new CReservacion();
			$a_reservacion = new AReservacion();

			$c_reservacion->setDescripcion($descripcion);
			$c_reservacion->setFechaReser($fecha_reser);
			$c_reservacion->setFechaIngreso($ingreso);
			$c_reservacion->setFechaSalida($salida);
			$c_reservacion->setAdelanto($adelanto);
			$c_reservacion->setEstado($estado);
			$c_reservacion->setFkIdUsuario($id_usuario);
			$c_reservacion->setFkIdHuesped($id_huesped);
			$c_reservacion->setFkIdHabitacion($id_habitacion);

			$reservacion = $a_reservacion -> save($c_reservacion);

			return $reservacion;
		}

		public function update($id_reservacion, $descripcion, $fecha_reser, $ingreso, $salida, $adelanto, $id_usuario, $id_huesped, $id_habitacion)
		{
			$c_reservacion = new CReservacion();
			$a_reservacion = new AReservacion();

			$c_reservacion->setIdReservacion($id_reservacion);
			$c_reservacion->setDescripcion($descripcion);
			$c_reservacion->setFechaReser($fecha_reser);
			$c_reservacion->setFechaIngreso($ingreso);
			$c_reservacion->setFechaSalida($salida);
			$c_reservacion->setAdelanto($adelanto);
			$c_reservacion->setFkIdUsuario($id_usuario);
			$c_reservacion->setFkIdHuesped($id_huesped);
			$c_reservacion->setFkIdHabitacion($id_habitacion);

			$reservacion = $a_reservacion -> update($c_reservacion);

			return $reservacion;
		}

		public function finalizar($id_reservacion, $estado)
		{
			$a_reservacion = new AReservacion();
			$c_reservacion = new CReservacion();

			$c_reservacion->setIdReservacion($id_reservacion);
			$c_reservacion->setEstado($estado);

			$reservacion = $a_reservacion->finalizar($c_reservacion);

			return $reservacion;
		}

	}
