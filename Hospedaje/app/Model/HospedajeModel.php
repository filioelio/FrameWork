<?php namespace App\Model;

	use App\Model\Clase\Hospedaje as CHospedaje;
	use App\Model\Action\Hospedaje as AHospedaje;

	class HospedajeModel
	{

		const HOSPEDAJE_NAMESPACE = 'App\Model\Clase\Hospedaje';

		public function __construct()
		{}

		public function IngresoTotal($fecha)
		{
			$a_hospedaje = new AHospedaje();
			$hospedaje = $a_hospedaje->IngresoTotal($fecha);
			if(isset($hospedaje) && (is_array($hospedaje) || is_object($hospedaje)))
			{
				if(is_object($hospedaje))
				{
					$hospedaje = array($hospedaje);
				}
				$hospedaje = $hospedaje;
			}
			return $hospedaje;
		}

		public function IngresoToday($fecha)
		{
			$a_hospedaje = new AHospedaje();
			$hospedaje = $a_hospedaje->IngresoToday($fecha);
			if(isset($hospedaje) && (is_array($hospedaje) || is_object($hospedaje)))
			{
				if(is_object($hospedaje))
				{
					$hospedaje = array($hospedaje);
				}
				$hospedaje = $hospedaje;
			}
			return $hospedaje;
		}

		function HospedajeSelect($id_hospedaje)
		{
			$a_hospedaje = new AHospedaje();
			$hospedaje = $a_hospedaje->HospedajeSelect($id_hospedaje);
			if(isset($hospedaje) && (is_array($hospedaje) || is_object($hospedaje)))
			{
				if(is_object($hospedaje))
				{
					$hospedaje = array($hospedaje);
				}
				$hospedaje = $hospedaje;
			}
			return $hospedaje;
		}

		public function getDataHospedaje($id_habitacion)
		{
			$a_hospedaje = new AHospedaje();
			$hospedaje = $a_hospedaje->getDataHospedaje($id_habitacion);
			if(isset($hospedaje) && (is_array($hospedaje) || is_object($hospedaje)))
			{
				if(is_object($hospedaje))
				{
					$hospedaje = array($hospedaje);
				}
				$hospedaje = $hospedaje;
			}
			return $hospedaje;
		}

		public function BuscarHuespedId($id_habitacion)
		{
			$a_hospedaje = new AHospedaje();
			$hospedaje = $a_hospedaje->BuscarHuespedId($id_habitacion);
			if(isset($hospedaje) && (is_array($hospedaje) || is_object($hospedaje)))
			{
				if(is_object($hospedaje))
				{
					$hospedaje = array($hospedaje);
				}
				$hospedaje = $hospedaje;
			}
			return $hospedaje;
		}

		public function historial()
		{
			$a_historial = new AHospedaje();

			$historial = $a_historial->historial();

			if(isset($historial) && (is_array($historial) || is_object($historial)))
			{
				if(is_object($historial))
				{
					$historial = array($historial);
				}
				$historial = $historial;
			}
			return $historial;

		}

		public function getBy($id_habitacion)
		{
			$a_hospedaje = new AHospedaje();
			$hospedaje = $a_hospedaje->getBy("fk_id_habitacion",$id_habitacion ,self::HOSPEDAJE_NAMESPACE);
			if (!isset($hospedaje)) return NULL;
			return $hospedaje;
		}

		public function all()
		{
			$a_hospedaje = new AHospedaje();
			$hospedaje = $a_hospedaje->getAll(self::HOSPEDAJE_NAMESPACE);
			if (!isset($hospedaje)) return NULL;
			return $hospedaje;
		}

		public function save($motivo, $ingreso, $salida, $estado, $precio ,$total, $id_usuario, $id_huesped, $id_habitacion)
		{
			$c_hospedaje = new CHospedaje();
			$a_hospedaje = new AHospedaje();

			$c_hospedaje->setMotivoVisita($motivo);
			$c_hospedaje->setFechaIngreso($ingreso);
			$c_hospedaje->setFechaSalida($salida);
			$c_hospedaje->setEstado($estado);
			$c_hospedaje->setPrecio($precio);
			$c_hospedaje->setCostoTotal($total);
			$c_hospedaje->setFkIdUsuario($id_usuario);
			$c_hospedaje->setFkIdHuesped($id_huesped);
			$c_hospedaje->setFkIdHabitacion($id_habitacion);

			$hospedaje = $a_hospedaje->save($c_hospedaje);
			return $hospedaje;
		}

		public function update_salida($id_hospedaje, $salida)
		{
			$c_hospedaje = new CHospedaje();
			$a_hospedaje = new AHospedaje();

			$c_hospedaje->setIdHospedaje($id_hospedaje);
			$c_hospedaje->setFechaSalida($salida);
			$c_hospedaje->setEstado('Finalizado');

			$hospedaje = $a_hospedaje->update_salida($c_hospedaje);
			return $hospedaje;
		}

		public function update($id_hospedaje, $total)
		{
			$a_hospedaje = new AHospedaje();
			$c_hospedaje = new CHospedaje();

			$c_hospedaje->setIdHospedaje($id_hospedaje);
			$c_hospedaje->setCostoTotal($total);

			$hospedaje = $a_hospedaje->update($c_hospedaje);
			return $hospedaje;
		}

	}