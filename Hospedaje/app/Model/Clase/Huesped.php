<?php namespace App\Model\Clase;

	use App\Helpers\Security as HS;
	
	class Huesped
	{
		private $id_huesped;
		public function setIdHuesped($id_huesped)
		{
			$id_huesped = HS::clean_input($id_huesped);
		
			$this->id_huesped = $id_huesped;
		}
		public function getIdHuesped()
		{
			return $this->id_huesped;
		}

		private $nombre;
		public function setNombre($nombre)
		{
			$nombre = HS::clean_input($nombre);
		
			$this->nombre = $nombre;
		}
		public function getNombre()
		{
			return $this->nombre;
		}

		private $apellido;
		public function setApellido($apellido)
		{
			$apellido = HS::clean_input($apellido);
		
			$this->apellido = $apellido;
		}
		public function getApellido()
		{
			return $this->apellido;
		}
		private $procedencia;
		public function setProcedencia($procedencia)
		{
			$procedencia = HS::clean_input($procedencia);
		
			$this->procedencia = $procedencia;
		}
		public function getProcedencia()
		{
			return $this->procedencia;
		}

		private $telefono;
		public function setTelefono($telefono)
		{
			$telefono = HS::clean_input($telefono);
		
			$this->telefono = $telefono;
		}
		public function getTelefono()
		{
			return $this->telefono;
		}

		private $conducta;
		public function setConducta($conducta)
		{
			$conducta = HS::clean_input($conducta);
		
			$this->conducta = $conducta;
		}
		public function getConducta()
		{
			return $this->conducta;
		}

	}