<?php namespace App\Model\Clase;

	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;


	class Jornada
	{
		private $id_jornada;
		public function setIdJornada($id_jornada)
		{
			$id_jornada = HS::clean_input($id_jornada);
		
			$this->id_jornada = $id_jornada;
		}
		public function getIdJornada()
		{
			return $this->id_jornada;
		}

		private $fecha_ingreso;
		public function setFechaIngreso($fecha_ingreso)
		{
			$fecha_ingreso = HS::clean_input($fecha_ingreso);

			$this->fecha_ingreso = $fecha_ingreso != "" ? $fecha_ingreso : HFD::DateTime();
		}
		public function getFechaIngreso()
		{
			return $this->fecha_ingreso;
		}

		private $fecha_salida;
		public function setFechaSalida($fecha_salida)
		{
			$fecha_salida = HS::clean_input($fecha_salida);

			$this->fecha_salida = $fecha_salida != "" ? $fecha_salida : HFD::DateTime();
		}
		public function getFechaSalida()
		{
			return $this->fecha_salida;
		}

		private $monto;
		public function setMonto($monto)
		{
			$monto = HS::clean_input($monto);
		
			$this->monto = $monto != "" ? $monto : '0.00';
		}
		public function getMonto()
		{
			return $this->monto;
		}

		private $fk_id_usuario;
		public function setFkIdUsuario($fk_id_usuario)
		{
			$fk_id_usuario = HS::clean_input($fk_id_usuario);
		
			$this->fk_id_usuario = $fk_id_usuario;
		}
		public function getFkIdUsuario()
		{
			return $this->fk_id_usuario;
		}
	}