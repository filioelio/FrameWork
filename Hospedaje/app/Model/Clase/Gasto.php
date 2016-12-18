<?php namespace App\Model\Clase;

	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	
	class Gasto
	{
		private $id_gasto;
		public function setIdGasto($id_gasto)
		{
			$id_gasto = HS::clean_input($id_gasto);
		
			$this->id_gasto = $id_gasto;
		}
		public function getIdGasto()
		{
			return $this->id_gasto;
		}

		private $recibe;
		public function setRecibe($recibe)
		{
			$recibe = HS::clean_input($recibe);

			$this->recibe = $recibe;
		}
		public function getRecibe()
		{
			return $this->recibe;
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

		private $descripcion;
		public function setDescripcion($descripcion)
		{
			$descripcion = HS::clean_input($descripcion);
		
			$this->descripcion = $descripcion != "" ? $descripcion : "Ausente por Emergencia";
		}
		public function geTDescripcion()
		{
			return $this->descripcion;
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

		private $perfilUsuario;
		
		public function setPerfilUsuario(Usuario $perfilUsuario)
		{
			$this->perfilUsuario = $perfilUsuario != NULL ? $perfilUsuario : NULL;
		}
		public function getPerfilUsuario()
		{
			return $this->perfilUsuario;
		}
	}