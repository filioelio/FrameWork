<?php namespace app\Model\Action;
	
	use App\Model\Clase\Huesped as CHuesped;
	use App\Core\ModeloBase;


	class Huesped extends ModeloBase
	{

		public function __construct()
		{
			$table = "huesped";
			parent::__construct($table);
		}

		public function Contar()
		{
			$run = $this->runSql(
				"SELECT count(*) as cantidad FROM huesped"
				);
			return $run;
		}


		public function save(CHuesped $huesped)
		{
			$save = $this->runSql(
				"INSERT INTO huesped (
					id_huesped,
					nombre,
					apellido,
					procedencia,
					telefono,
					conducta
	
				) VALUES (
					'" . $huesped->getIdHuesped() . "',
					'" . $huesped->getNombre() . "',
					'" . $huesped->getApellido() . "',
					'" . $huesped->getProcedencia() . "',
					'" . $huesped->getTelefono() . "',		
					'" . $huesped->getConducta() . "'
				)"
			);

			return $save;
		}

		public function update(CHuesped $huesped)
		{
			$update = $this->runSql(
				"UPDATE huesped SET 
				id_huesped 		= '" . $huesped->getIdHuesped() . "',
				nombre 			= '" . $huesped->getNombre() . "',
				apellido 		= '" . $huesped->getApellido() . "',
				procedencia 	= '" . $huesped->getProcedencia() . "',
				telefono 		= '" . $huesped->getTelefono() . "',
				conducta 		= '" . $huesped->getConducta() . "'
				WHERE id_huesped = '" . $huesped->getIdHuesped() . "'"
			);

			return $update;
		}

		public function delete(Chuesped $huesped)
		{
			$delete = $this->deleteby("id_huesped",$huesped->getIdHuesped());

			return $delete;
		}

	}