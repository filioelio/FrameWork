<?php namespace App\Model\Clase;

	use App\Helpers\Security as HS;
	use App\Config\VariablesGlobales;
	
	class Producto
	{
		/*		CONSTANTE - PATH - IMG 		*/
		
		const PATH = "/img/Producto/";
		
		/*	**	*/

		private $id_producto;
		public function setIdProducto($id_producto)
		{
			$id_producto = HS::clean_input($id_producto);
		
			$this->id_producto = $id_producto;
		}
		public function getIdProducto()
		{
			return $this->id_producto;
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

		private $medida;
		public function setMedida($medida)
		{
			$medida = HS::clean_input($medida);
		
			$this->medida = $medida;
		}
		public function getMedida()
		{
			return $this->medida;
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


		private $stock;
		public function setStock($stock)
		{
			$stock = HS::clean_input($stock);
		
			$this->stock = $stock;
		}
		public function getStock()
		{
			return $this->stock;
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


	}
