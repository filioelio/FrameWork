<?php namespace App\Model\Clase;

	use App\Helpers\Security as HS;
	use App\Config\VariablesGlobales;
	
	class Habitacion
	{
		
		public function __construct()
		{}

		/*		CONSTANTE - PATH - IMG 		*/
		
		const PATH = "/img/Habitacion/";
		
		/*	**	*/

		private $id_habitacion;
		public function setIdHabitacion($id_habitacion)
		{
			$id_habitacion = HS::clean_input($id_habitacion);
		
			$this->id_habitacion = $id_habitacion;
		}
		public function getIdHabitacion()
		{
			return $this->id_habitacion;
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

		private $precio;
		public function setPrecio($precio)
		{
			$precio = HS::clean_input($precio);
		
			$this->precio = $precio;
		}
		public function getPrecio()
		{
			return $this->precio;
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

		private $alert;
		public function setAlert($alert)
		{
			$this->alert = $alert != NULL ? $alert : NULL;
		}
		public function getAlert()
		{
			return $this->alert;
		}
	}
