<?php namespace App\Model\Clase;

	use App\Helpers\Security as HS;

	class DetalleVenta
	{
		private $id_detalle_venta;
		public function setIdDetalleVenta($id_detalle_venta)
		{
			$id_detalle_venta = HS::clean_input($id_detalle_venta);
		
			$this->id_detalle_venta = $id_detalle_venta;
		}
		public function getIdDetalleVenta()
		{
			return $this->id_detalle_venta;
		}

		private $cantidad;
		public function setCantidad($cantidad)
		{
			$cantidad = HS::clean_input($cantidad);
		
			$this->cantidad = $cantidad;
		}
		public function getCantidad()
		{
			return $this->cantidad;
		}

		private $subtotal;
		public function setSubtotal($subtotal)
		{
			$subtotal = HS::clean_input($subtotal);
		
			$this->subtotal = $subtotal;
		}
		public function getSubtotal()
		{
			return $this->subtotal;
		}

		private $fk_id_venta;
		public function setFkIdVenta($fk_id_venta)
		{
			$fk_id_venta = HS::clean_input($fk_id_venta);
		
			$this->fk_id_venta = $fk_id_venta;
		}
		public function getFkIdVenta()
		{
			return $this->fk_id_venta;
		}

		private $fk_id_producto;
		public function setFkIdProducto($fk_id_producto)
		{
			$fk_id_producto = HS::clean_input($fk_id_producto);
		
			$this->fk_id_producto = $fk_id_producto;
		}
		public function getFkIdProducto()
		{
			return $this->fk_id_producto;
		}
	}
		