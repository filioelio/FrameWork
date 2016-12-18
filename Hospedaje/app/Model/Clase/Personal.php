<?php namespace App\Model\Clase;

	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	
	class Personal
	{

		private $id_personal;
		public function setIdPersonal($id_personal)
		{
			$id_personal = HS::clean_input($id_personal);
		
			$this->id_personal = $id_personal;
		}
		public function getIdPersonal()
		{
			return $this->id_personal;
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

		private $direccion;
		public function setDireccion($direccion)
		{
			$direccion = HS::clean_input($direccion);
		
			$this->direccion = $direccion;
		}
		public function getDireccion()
		{
			return $this->direccion;
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

		private $labor;
		public function setLabor($labor)
		{
			$labor = HS::clean_input($labor);
		
			$this->labor = $labor != "" ? $labor : "Personal de Limpieza";
		}
		public function getLabor()
		{
			return $this->labor;
		}

		private $salario;
		public function setSalario($salario)
		{
			$salario = HS::clean_input($salario);
		
			$this->salario = $salario;
		}
		public function getSalario()
		{
			return $this->salario;
		}

		private $estado;
		public function setEstado($estado)
		{
			$estado = HS::clean_input($estado);
		
			$this->estado = $estado;
		}
		public function getEstado()
		{
			return $this->estado;
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
	