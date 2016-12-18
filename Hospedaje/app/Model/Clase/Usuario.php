<?php namespace App\Model\Clase;

	use App\Helpers\Security as HS;
	use App\Config\VariablesGlobales;
	
	class Usuario
	{
		
		public function __construct()
		{}


		/*		CONSTANTE - PATH - IMG 		*/
		
		const PATH = "/img/users/";
		
		/*	**	*/

		private $id_usuario;
		public function setIdUsuario($id_usuario)
		{
			$id_usuario = HS::clean_input($id_usuario);
		
			$this->id_usuario = $id_usuario;
		}
		public function getIdUsuario()
		{
			return $this->id_usuario;
		}

		private $email;
		public function setEmail($email)
		{
			$email = HS::clean_input($email);
		
			$this->email = $email;
		}
		public function getEmail()
		{
			return $this->email;
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

		private $contrasena;
		public function setContrasena($contrasena)
		{
			$contrasena = HS::clean_input($contrasena);
		
			$this->contrasena = $contrasena;
		}
		public function getContrasena()
		{
			return $this->contrasena;
		}

		private $foto;
		
		public function setFoto($foto)
		{
			$foto = HS::clean_input($foto);

			$this->foto = $foto != "" ? $foto : NULL ;
		}
		public function getFoto($path = false)
		{
			if ($this->foto == NULL) return NULL;
			
			if($path) return VariablesGlobales::$base_url . self::PATH . $this->foto;

			return $this->foto;
		}

		private $tipo;
		public function setTipo($tipo)
		{
			$tipo = HS::clean_input($tipo);
		
			$this->tipo = $tipo;
		}
		public function getTipo()
		{
			return $this->tipo;
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
	}