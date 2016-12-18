<?php namespace app\Model\Action;
	
	use App\Model\Clase\Permiso as CPermiso;
	use App\Core\ModeloBase;


	class Permiso extends ModeloBase
	{

		public function __construct()
		{
			$table = "permiso";
			parent::__construct($table);
		}

		public function allPermiso()
		{
			$run = $this->runSql(
				"SELECT id_permiso, concat(pe.nombre,' ',pe.apellido,' => ',p.descripcion) as title, p.fecha_inicio as start, p.fecha_fin as end, p.backgroundColor FROM permiso p INNER JOIN personal pe ON p.fk_id_personal = pe.id_personal WHERE pe.estado = 'Activo'"
			);
			return $run;
		}

		public function save(CPermiso $permiso)
		{
			$save = $this->runSql(
				"INSERT INTO permiso(
					id_permiso, 
					fecha, 
					fecha_inicio, 
					fecha_fin, 
					descripcion,
					backgroundColor, 
					fk_id_personal
				) VALUES (
					'" . $permiso->getIdPermiso() . "',
					'" . $permiso->getFecha() . "',
					'" . $permiso->getFechaInicio() . "',
					'" . $permiso->getFechaFin() . "',
					'" . $permiso->getDescripcion() . "',
					'" . $permiso->getColor() . "',		
					'" . $permiso->getFkIdPersonal() . "'
				)"
			);

			return $save;
		}

		public function update(CPermiso $permiso)
		{
			$update = $this->runSql(
				"UPDATE permiso SET 
				fecha_inicio 	= '" . $permiso->getFechaInicio() . "',
				fecha_fin		= '" . $permiso->getFechaFin() . "'
				WHERE id_permiso = '" . $permiso->getIdPermiso() . "'"
			);

			return $update;
		}

		public function delete(CPermiso $permiso)
		{
			$delete = $this->deleteby("id_permiso",$permiso->getIdPermiso());

			return $delete;
		}

	}