<?php namespace app\Model\Action;
	
	use App\Model\Clase\Salario as CSalario;
	use App\Core\ModeloBase;


	class Salario extends ModeloBase
	{

		public function __construct()
		{
			$table = "salario";
			parent::__construct($table);
		}

		public function allSalario()
		{
			$run = $this->runSql(
				"SELECT sa.id_salario, concat(pe.nombre,' ',sa.tipo,'  s/',sa.monto) as title, sa.fecha as start, sa.backgroundColor FROM salario sa INNER JOIN personal pe ON sa.fk_id_personal = pe.id_personal"
			);
			return $run;
		}

		public function save(CSalario $salario)
		{
			$save = $this->runSql(
				"INSERT INTO salario (
					id_salario,
					fecha,
					monto,
					tipo,
					backgroundColor,
					fk_id_personal
	
				) VALUES (
					'" . $salario->getIdSalario() . "',
					'" . $salario->getFecha() . "',
					'" . $salario->getMonto() . "',
					'" . $salario->getTipo() . "',			
					'" . $salario->getColor() . "',	
					'" . $salario->getFkIdPersonal() . "'
				)"
			);

			return $save;
		}

		public function update(CSalario $salario)
		{
			$update = $this->runSql("
					UPDATE `salario` SET 
					`fecha` = '".$salario->getFecha()."' 
					WHERE `salario`.`id_salario` = '".$salario->getIdSalario()."';
				");
			return $update;
			
		}

		public function delete(CSalario $salario)
		{
			$delete = $this->deleteby("id_salario",$salario->getIdSalario());

			return $delete;
		}

	}