<?php namespace app\Model\Action;
	
	use App\Model\Clase\Jornada as CJornada;
	use App\Core\ModeloBase;


	class Jornada extends ModeloBase
	{
		
		public function __construct()
		{
			$table = "jornada";
			parent::__construct($table);
		}

		public function save (CJornada $jornada)
		{
			$run = $this->runSql("
				INSERT INTO `jornada`(
					`id_jornada`, 
					`fecha_ingreso`, 
					`fecha_salida`, 
					`monto`, 
					`fk_id_usuario`
					) VALUES (
						'".$jornada->getIdJornada()."',
						'".$jornada->getFechaIngreso()."',
						'".$jornada->getFechaIngreso()."',
						'".$jornada->getMonto()."',
						'".$jornada->getFkIdUsuario()."'
					)
				");
			return $run;
		}

		public function update(CJornada $jornada)
		{
			$run = $this->runSql("
				UPDATE `jornada` SET 
				fecha_salida 		= '" . $jornada->getFechaSalida() . "',
				monto				= '" . $jornada->getMonto() . "'
				WHERE id_jornada 	= '" . $jornada->getIdJornada() . "'
				");
			return $run;
		}
	}