<?php namespace App\Model;

	use App\Model\Clase\Venta as CVenta;
	use App\Model\Action\Venta as AVenta;
	use App\Model\Clase\DetalleVenta as CDetalleVenta;
	use App\Model\Action\DetalleVenta as ADetalleVenta;

	class VentaModel
	{

		const VENTA_NAMESPACE = 'App\Model\Clase\Venta';
		const DETALLEVENTA_NAMESPACE = 'App\Model\Clase\DetalleVenta';

		public function __construct()
		{}

		public function VentaHabitacionId($id_habitacion)
		{
			$a_venta = new AVenta();
			$venta = $a_venta->VentaHabitacionId($id_habitacion);
			if(isset($venta) && (is_array($venta) || is_object($venta)))
			{
				if(is_object($venta))
				{
					$venta = array($venta);
				}
				$venta = $venta;
			}
			return $venta;
		}

		public function deuda_venta($id)
		{
			$a_venta = new AVenta();

			$venta = $a_venta->deuda_venta($id);

			if(isset($venta) && (is_array($venta) || is_object($venta)))
			{
				if(is_object($venta))
				{
					$venta = array($venta);
				}
				$venta = $venta;
			}
			return $venta;
		}

		public function select_venta($id)
		{
			$a_venta = new AVenta();

			$venta = $a_venta->select_venta($id);

			if(isset($venta) && (is_array($venta) || is_object($venta)))
			{
				if(is_object($venta))
				{
					$venta = array($venta);
				}
				$venta = $venta;
			}
			return $venta;
		}

		public function max_id()
		{
			$a_venta = new AVenta();
			$max_id = $a_venta->max_id();

			if(isset($max_id) && (is_array($max_id) || is_object($max_id)))
			{
				if(is_object($max_id))
				{
					$max_id = array($max_id);
				}
				$max_id = $max_id;
			}
			return $max_id;
		}

		public function all()
		{
			$a_venta = new AVenta();

			$venta = $a_venta->Ventas();

			if(isset($venta) && (is_array($venta) || is_object($venta)))
			{
				if(is_object($venta))
				{
					$venta = array($venta);
				}
				$venta = $venta;
			}			

			return $venta;
			
		}

		public function allBy($id_venta)
		{
			$a_detalle_venta = new ADetalleVenta();

			$detalle_venta = $a_detalle_venta->Detalle_Venta($id_venta);

			if(isset($detalle_venta) && (is_array($detalle_venta) || is_object($detalle_venta)))
			{
				if(is_object($detalle_venta))
				{
					$detalle_venta = array($detalle_venta);
				}
				$detalle_venta = $detalle_venta;
			}			

			return $detalle_venta;
		}

		public function save($total, $fecha, $deuda, $fk_id_usuario, $fk_id_hospedaje )
		{

			$a_venta = new AVenta();
			$c_venta = new CVenta();

			$c_venta->setTotal($total);
			$c_venta->setFechaVenta($fecha);
			$c_venta->setDeuda($deuda);
			$c_venta->setFkIdUsuario($fk_id_usuario);
			$c_venta->setFkIdHospedaje($fk_id_hospedaje);

			$venta = $a_venta->save($c_venta);
			return $venta;
		}

		public function save_detalle($cantidad, $subtotal, $fk_id_venta, $fk_id_producto)
		{
			$a_detalleventa = new ADetalleVenta();
			$c_detalleventa = new CDetalleVenta();

			$c_detalleventa-> setCantidad($cantidad);
			$c_detalleventa-> setSubtotal($subtotal);
			$c_detalleventa-> setFkIdVenta($fk_id_venta);
			$c_detalleventa-> setFkIdProducto($fk_id_producto);

			$detalleventa = $a_detalleventa->save($c_detalleventa);
			return $detalleventa;
		}

		public function Update($id_venta, $deuda)
		{
			$a_venta = new AVenta();
			$c_venta = new CVenta();

			$c_venta->setIdVenta($id_venta);
			$c_venta->setDeuda($deuda);

			$venta = $a_venta->update($c_venta);
			return $venta;
		}

		public function update_detalle($id_detalle_venta, $cantidad, $subtotal, $fk_id_venta, $fk_id_producto)
		{
			$a_detalleventa = new ADetalleVenta();
			$c_detalleventa = new CDetalleVenta();

			$c_detalleventa->setIdDetalleVenta($id_detalle_venta);
			$c_detalleventa->setCantidad($cantidad);
			$c_detalleventa->setSubtotal($subtotal);
			$c_detalleventa->setFkIdVenta($fk_id_venta);
			$c_detalleventa->setFkIdProducto($fk_id_producto);

			$detalleventa = $a_detalleventa->update($c_detalleventa);
			return $detalleventa;

		}

		public function delete($id_venta)
		{
			$a_venta = new AVenta();
			$c_venta = new CVenta();

			$c_venta -> setIdVenta($id_venta);

			$venta = $a_venta->delete($c_venta);
			return $venta;
		}


	}
