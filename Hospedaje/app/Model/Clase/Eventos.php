<?php namespace App\Model\Clase;

	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	
	class Eventos
	{

		private $id_evento;
		public function setIdEvento($id_evento)
		{
			$id_evento = HS::clean_input($id_evento);
		
			$this->id_evento = $id_evento;
		}
		public function getIdEvento()
		{
			return $this->id_evento;
		}

		private $title;
		public function setTitle($title)
		{
			$title = HS::clean_input($title);

			$this->title = $title;
		}
		public function getTitle()
		{
			return $this->title;
		}

		private $start;
		public function setStart($start)
		{
			$start = HS::clean_input($start);

			$this->start = $start != "" ? $start : HFD::Date();
		}
		public function getStart()
		{
			return $this->start;
		}

		private $ennd;
		public function setEnd($ennd)
		{
			$ennd = HS::clean_input($ennd);

			$this->ennd = $ennd != "" ? $ennd : HFD::Date();
		}
		public function getEnd()
		{
			return $this->ennd;
		}

		private $background;
		public function setBackground($background)
		{
			$background = HS::clean_input($background);
		
			$this->background = $background;
		}
		public function getBackground()
		{
			return $this->background;
		}

		private $datos;
		public function setDatos($datos)
		{
			$datos = HS::clean_input($datos);
		
			$this->datos = $datos;
		}
		public function getDatos()
		{
			return $this->datos;
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
	