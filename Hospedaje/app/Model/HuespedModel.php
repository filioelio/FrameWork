<?php namespace App\Model;

	use App\Model\Clase\Huesped as CHuesped;
	use App\Model\Action\Huesped as AHuesped;

	class HuespedModel
	{

		const HUESPED_NAMESPACE = 'App\Model\Clase\Huesped';

		public function __construct()
		{}

		public function contar()
		{
			$a_huesped = new AHuesped();
			$contar = $a_huesped->Contar();

			if(isset($contar) && (is_array($contar) || is_object($contar)))
			{
				if(is_object($contar))
				{
					$contar = array($contar);
				}
				$contar = $contar;
			}
			return $contar;
		}

		public function all()
		{
			$a_huesped = new AHuesped();
			$huespedes = $a_huesped->getAll(self::HUESPED_NAMESPACE);
			if (!isset($huespedes)) return null;
			return$huespedes;
		}	

		public function getBy($id)
		{
			$a_huesped = new AHuesped();
			$huesped = $a_huesped->getBy('id_huesped', $id, self::HUESPED_NAMESPACE);
			if (! isset($huesped)) return null;
			return $huesped;
		}

		public function save($dni, $nombre, $apellido, $procedencia, $telefono, $conducta)
		{
			$c_huesped = new CHuesped();
			$a_huesped = new AHuesped();

			$c_huesped -> setIdHuesped($dni);
			$c_huesped -> setNombre($nombre);
			$c_huesped -> setApellido($apellido);
			$c_huesped -> setProcedencia($procedencia);
			$c_huesped -> setTelefono($telefono);
			$c_huesped -> setConducta($conducta);

			$huesped = $a_huesped -> save($c_huesped);

			return $huesped;
		}

		public function update($dni, $nombre, $apellido, $procedencia, $telefono, $conducta)
		{
			$c_huesped = new CHuesped();
			$a_huesped = new AHuesped();

			$c_huesped -> setIdHuesped($dni);
			$c_huesped -> setNombre($nombre);
			$c_huesped -> setApellido($apellido);
			$c_huesped -> setProcedencia($procedencia);
			$c_huesped -> setTelefono($telefono);
			$c_huesped -> setConducta($conducta);

			$huesped = $a_huesped->update($c_huesped);

			return $huesped;
		}

	}