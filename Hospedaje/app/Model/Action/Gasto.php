<?php namespace app\Model\Action;
	
	use App\Model\Clase\Gasto as CGasto;
	use App\Core\ModeloBase;


	class Gasto extends ModeloBase
	{

		public function __construct()
		{
			$table = "gasto";
			parent::__construct($table);
		}

		public function save(CGasto $gasto)
		{
			$save = $this->runSql(
				"INSERT INTO gasto (
					id_gasto,
					recibe,
					fecha,
					monto,
					descripcion,
					fk_id_usuario
	
				) VALUES (
					'" . $gasto->getIdGasto() . "',
					'" . $gasto->getRecibe() . "',
					'" . $gasto->getFecha() . "',
					'" . $gasto->getMonto() . "',
					'" . $gasto->getDescripcion() . "',			
					'" . $gasto->getFkIdUsuario() . "'
				)"
			);

			return $save;
		}

		public function update(CGasto $gasto)
		{
			$update = $this->runSql(
				"UPDATE gasto SET 
				id_gasto 		= '" . $gasto->getIdGasto() . "',
				recibe 			= '" . $gasto->getRecibe() . "',
				monto 			= '" . $gasto->getMonto() . "',
				descripcion 	= '" . $gasto->getdescripcion() . "',	
				fk_id_usuario	= '" . $gasto->getFkIdUsuario() . "'
				WHERE id_gasto = '" . $gasto->getIdGasto() . "'"
			);

			return $update;
		}

		public function delete(CGasto $gasto)
		{
			$delete = $this->deleteby("id_gasto",$gasto->getIdGasto());

			return $delete;
		}

	}