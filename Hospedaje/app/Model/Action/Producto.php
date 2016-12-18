<?php namespace app\Model\Action;
	
	use App\Model\Clase\Producto as CProducto;
	use App\Core\ModeloBase;


	class Producto extends ModeloBase
	{

		public function __construct()
		{
			$table = "producto";
			parent::__construct($table);
		}

		public function save(CProducto $producto)
		{
			$foto = ($producto->getFoto() == NULL) ? "NULL" : "'" . $producto->getFoto() . "'";
			$save = $this->runSql(
				"INSERT INTO producto (
					id_producto,
					nombre,
					descripcion,
					medida,
					precio,
					stock,
					foto
				
	
				) VALUES (
					'" . $producto->getIdProducto() . "',
					'" . $producto->getNombre() . "',
					'" . $producto->getDescripcion() . "',
					'" . $producto->getMedida() . "',
					'" . $producto->getPrecio() . "',			
					'" . $producto->getStock() . "',
					$foto
				)"
			);

			return $save;
		}

		public function update(CProducto $producto)
		{
			$foto = ($producto->getFoto() == NULL) ? "NULL" : "'" . $producto->getFoto() . "'";
			$update = $this->runSql(
				"UPDATE producto SET 
				id_producto 	= '" . $producto->getIdProducto() ."',
				nombre 			= '" . $producto->getNombre() ."',
				descripcion 	= '" . $producto->getDescripcion() ."',
				medida 			= '" . $producto->getMedida() ."',
				precio 			= '" . $producto->getPrecio() ."',				
				stock 			= '" . $producto->getStock() ."',
				foto 			= $foto
				WHERE id_producto = '" . $producto->getIdProducto() . "'"
			);

			return $update;
		}

		public function delete(CProducto $producto)
		{
			$delete = $this->deleteId($producto->getIdProducto());

			return $delete;
		}

	}