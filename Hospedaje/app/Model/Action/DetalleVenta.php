<?php namespace app\Model\Action;
	
	use App\Model\Clase\DetalleVenta as CDetalleVenta;
	use App\Core\ModeloBase;


	class DetalleVenta extends ModeloBase
	{

		public function __construct()
		{
			$table = "detalle_venta";
			parent::__construct($table);
		}

		public function Detalle_Venta($id_venta)
		{
			$run = $this->runProcedure("DetalleVentaGetId($id_venta)");

			return $run;
		}

		public function save(CDetalleVenta $dtventa)
		{
			$save = $this->runSql(
				"INSERT INTO detalle_venta (
					id_detalle_venta,
					cantidad,
					subtotal,
					fk_id_venta,
					fk_id_producto					
	
				) VALUES (
					'" . $dtventa->getIdDetalleVenta() . "',
					'" . $dtventa->getCantidad() . "',
					'" . $dtventa->getSubtotal() . "',
					'" . $dtventa->getFkIdVenta() . "',	
					'" . $dtventa->getFkIdProducto() . "'
				)"
			);
			return $save;
		}

		public function update(CDetalleVenta $dtventa)
		{
			$update = $this->runSql(
				"UPDATE detalle_venta SET 
				id_detalle_venta 	= '" . $dtventa->getIdDetalleVenta() . "',
				cantidad 			= '" . $dtventa->getCantidad() . "',
				subtotal 			= '" . $dtventa->getSubtotal() . "',
				fk_id_venta 		= '" . $dtventa->getFkIdVenta() . "',
				fk_id_producto 		= '" . $dtventa->getFkIdProducto() . "'				
				WHERE id_detalle_venta 	= '" . $dtventa->getIdDetalleVenta() . "'"
			);

			return $update;
		}

		public function delete(CDetalleVenta $dtventa)
		{
			$delete = $this->deleteId($dtventa->getIdDetalleVenta());

			return $delete;
		}

	}