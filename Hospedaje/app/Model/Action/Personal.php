<?php namespace app\Model\Action;
	
	use App\Model\Clase\Personal as CPersonal;
	use App\Core\ModeloBase;


	class Personal extends ModeloBase
	{

		public function __construct()
		{
			$table = "personal";
			parent::__construct($table);
		}
		

		public function save(CPersonal $personal)
		{
			$save = $this->runSql(
				"INSERT INTO personal (
					id_personal,
					nombre,
					apellido,
					telefono,
					direccion,
					fecha_inicio,
					labor,
					salario,
					estado,
					fk_id_usuario
	
				) VALUES (
					'" . $personal->getIdPersonal() . "',
					'" . $personal->getNombre() . "',
					'" . $personal->getApellido() . "',
					'" . $personal->getTelefono() . "',			
					'" . $personal->getDireccion() . "',
					'" . $personal->getFechaInicio() . "',
					'" . $personal->getLabor() . "',
					'" . $personal->getSalario() . "',
					'" . $personal->getEstado() . "',
					'" . $personal->getFkIdUsuario() . "'
				)"
			);

			return $save;
		}

		public function update(CPersonal $personal)
		{
			$update = $this->runSql(
				"UPDATE personal SET 
				id_personal 	= '" . $personal->getIdPersonal() . "',
				nombre 			= '" . $personal->getNombre() . "',
				apellido 		= '" . $personal->getApellido() . "',
				telefono 		= '" . $personal->getTelefono() . "',	
				direccion 		= '" . $personal->getDireccion() . "',
				fecha_inicio	= '" . $personal->getFechaInicio() . "',
				labor	 		= '" . $personal->getLabor() . "',
				salario 		= '" . $personal->getSalario() . "',
				estado 			= '" . $personal->getEstado() . "',
				fk_id_usuario	= '" . $personal->getFkIdUsuario() . "'
				WHERE id_personal = '" . $personal->getIdPersonal() . "'"
			);

			return $update;
		}

		public function delete(CPersonal $personal)
		{
			$delete = $this->deleteby("id_personal",$personal->getIdPersonal());

			return $delete;
		}

	}