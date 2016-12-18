<?php namespace App\Model\Clase;

	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	
	class Salario
	{
		private $id_salario;
		public function setIdSalario($id_salario)
		{
			$id_salario = HS::clean_input($id_salario);
		
			$this->id_salario = $id_salario;
		}
		public function getIdSalario()
		{
			return $this->id_salario;
		}

		private $fecha;
		public function setFecha($fecha)
		{
			$fecha = HS::clean_input($fecha);

			$this->fecha = $fecha != "" ? $fecha : HFD::DateTime();
		}
		public function getFecha()
		{
			return $this->fecha;
		}

		private $monto;
		public function setMonto($monto)
		{
			$monto = HS::clean_input($monto);
		
			$this->monto = $monto;
		}
		public function getMonto()
		{
			return $this->monto;
		}

		private $tipo;
		public function setTipo($tipo)
		{
			$tipo = HS::clean_input($tipo);
		
			$this->tipo = $tipo != "" ? $tipo : "Pago";
		}
		public function geTtipo()
		{
			return $this->tipo;
		}

		private $backgroundColor;
		public function setColor($backgroundColor)
		{
			$backgroundColor = HS::clean_input($backgroundColor);
		
			$this->backgroundColor = $backgroundColor;
		}
		public function getColor()
		{
			return $this->backgroundColor;
		}

		private $fk_id_personal;
		public function setFkIdPersonal($fk_id_personal)
		{
			$fk_id_personal = HS::clean_input($fk_id_personal);
		
			$this->fk_id_personal = $fk_id_personal;
		}
		public function getFkIdPersonal()
		{
			return $this->fk_id_personal;
		}
	}