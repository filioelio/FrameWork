<?php namespace App\Model;

	use App\Model\Clase\Habitacion as CHabitacion;
	use App\Model\Action\Habitacion as AHabitacion;

	class HabitacionModel
	{

		const HABITACION_NAMESPACE = 'App\Model\Clase\Habitacion';

		public function __construct()
		{}
		public function getby($id)
		{
			$a_habitacion = new AHabitacion();
			$habitacion = $a_habitacion->getBy("id_habitacion", $id, self::HABITACION_NAMESPACE);
			if (! isset($habitacion)) return NULL;
			return $habitacion;
		}
		public function all()
		{
			$a_habitacion = new AHabitacion();
			$habitacion = $a_habitacion->getAll(self::HABITACION_NAMESPACE);
			if (! isset($habitacion)) return NULL;
			return $habitacion;
		}

		public function Estado()
		{
			$a_habitacion = new AHabitacion();
			$estado = $a_habitacion->Estado();
			if(isset($estado) && (is_array($estado) || is_object($estado)))
			{
				if(is_object($estado))
				{
					$estado = array($estado);
				}
				$estado = $estado;
			}
			return $estado;
		}

		public function Ocupado()
		{
			$a_habitacion = new AHabitacion();
			$ocupado = $a_habitacion->Ocupado();

			if(isset($ocupado) && (is_array($ocupado) || is_object($ocupado)))
			{
				if(is_object($ocupado))
				{
					$ocupado = array($ocupado);
				}
				$ocupado = $ocupado;
			}
			return $ocupado;
		}

		public function Reservado()
		{
			$a_habitacion = new AHabitacion();
			$reservado = $a_habitacion->Reservado();

			if(isset($reservado) && (is_array($reservado) || is_object($reservado)))
			{
				if(is_object($reservado))
				{
					$reservado = array($reservado);
				}
				$reservado = $reservado;
			}
			return $reservado;
		}


		public function save($id_habitacion, $tipo, $descripcion, $estado, $precio, $foto = NULL)
		{
			$c_habitacion = new CHabitacion();
			$a_habitacion = new AHabitacion();

			$c_habitacion->setIdHabitacion($id_habitacion);
			$c_habitacion->setTipo($tipo);
			$c_habitacion->setDescripcion($descripcion);
			$c_habitacion->setEstado($estado);
			$c_habitacion->setPrecio($precio);
			$c_habitacion->setFoto($foto);

			$habitacion = $a_habitacion->save($c_habitacion);
			return $habitacion;
		}

		public function update_estado($id_habitacion)
		{
			$c_habitacion = new CHabitacion();
			$a_habitacion = new AHabitacion();

			$c_habitacion->setIdHabitacion($id_habitacion);
			$c_habitacion->setEstado('Mantenimiento');

			$habitacion = $a_habitacion->update_estado($c_habitacion);
			return $habitacion;
		}

		public function update($id_habitacion, $tipo, $descripcion, $estado, $precio, $foto = NULL)
		{
			$c_habitacion = new CHabitacion();
			$a_habitacion = new AHabitacion();

			$c_habitacion->setIdHabitacion($id_habitacion);
			$c_habitacion->setTipo($tipo);
			$c_habitacion->setDescripcion($descripcion);
			$c_habitacion->setEstado($estado);
			$c_habitacion->setPrecio($precio);
			$c_habitacion->setFoto($foto);

			$habitacion = $a_habitacion->update($c_habitacion);
			return $habitacion;
		}

	}
