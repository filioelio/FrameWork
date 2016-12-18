<?php namespace App\Model;

	use App\Model\Clase\Producto as CProducto;
	use App\Model\Action\Producto as AProducto;

	class ProductoModel
	{

		const PRODUCTO_NAMESPACE = 'App\Model\Clase\Producto';

		public function __construct()
		{}

		public function all()
		{
			$a_producto = new AProducto();
			$productos =$a_producto->getAll(self::PRODUCTO_NAMESPACE);
			if (!isset($productos)) return NULL;
			return $productos;
		}

		public function getBy($id)
		{
			$a_producto = new AProducto();
			$producto =$a_producto->getBy("id_producto", $id, self::PRODUCTO_NAMESPACE);
			if (!isset($producto)) return NULL;
			return $producto;
		}

		public function save($nombre, $descripcion, $medida, $precio, $stock, $foto = NULL)
		{
			$c_producto = new CProducto();
			$a_producto = new AProducto();

			$c_producto->setNombre($nombre);
			$c_producto->setDescripcion($descripcion);
			$c_producto->setMedida($medida);
			$c_producto->setPrecio($precio);
			$c_producto->setStock($stock);
			$c_producto->setFoto($foto);

			$producto = $a_producto -> save($c_producto);

			return $producto;
		}

		public function update($id_producto, $nombre, $descripcion, $medida, $precio, $stock, $foto = NULL)
		{
			$c_producto = new CProducto();
			$a_producto = new AProducto();

			$c_producto->setIdProducto($id_producto);
			$c_producto->setNombre($nombre);
			$c_producto->setDescripcion($descripcion);
			$c_producto->setMedida($medida);
			$c_producto->setPrecio($precio);
			$c_producto->setStock($stock);
			$c_producto->setFoto($foto);

			$producto = $a_producto -> update($c_producto);

			return $producto;
		}

	}