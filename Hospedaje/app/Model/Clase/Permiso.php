<?php namespace App\Model\Clase;

	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	
	class Permiso
	{
		private $id_permiso;
		public function setIdPermiso($id_permiso)
		{
			$id_permiso = HS::clean_input($id_permiso);
		
			$this->id_permiso = $id_permiso;
		}
		public function getIdPermiso()
		{
			return $this->id_permiso;
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

		private $fecha_inicio;
		public function setFechaInicio($fecha_inicio)
		{
			$fecha_inicio = HS::clean_input($fecha_inicio);

			$this->fecha_inicio = $fecha_inicio != "" ? $fecha_inicio : HFD::Date();
		}
		public function getFechaInicio()
		{
			return $this->fecha_inicio;
		}

		private $fecha_fin;
		public function setFechaFin($fecha_fin)
		{
			$fecha_fin = HS::clean_input($fecha_fin);

			$this->fecha_fin = $fecha_fin != "" ? $fecha_fin : HFD::Date();
		}
		public function getFechaFin()
		{
			return $this->fecha_fin;
		}

		private $descripcion;
		public function setDescripcion($descripcion)
		{
			$descripcion = HS::clean_input($descripcion);
		
			$this->descripcion = $descripcion;
		}
		public function getDescripcion()
		{
			return $this->descripcion;
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