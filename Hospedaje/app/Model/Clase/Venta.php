<?php namespace App\Model\Clase;

	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;

	class Venta
	{
		private $id_venta;
		public function setIdVenta($id_venta)
		{
			$id_venta = HS::clean_input($id_venta);
		
			$this->id_venta = $id_venta;
		}
		public function getIdVenta()
		{
			return $this->id_venta;
		}

		private $total;
		public function setTotal($total)
		{
			$total = HS::clean_input($total);
		
			$this->total = $total;
		}
		public function getTotal()
		{
			return $this->total;
		}



		private $fecha;
		public function setFechaVenta($fecha)
		{
			$fecha = HS::clean_input($fecha);
			
			$this->fecha = $fecha != "" ? $fecha : HFD::DateTime();
		}
		public function getFechaVenta()
		{
			return $this->fecha;
		}

		private $deuda;
		public function setDeuda($deuda)
		{
			$deuda = HS::clean_input($deuda);
		
			$this->deuda = $deuda !="" ? $deuda : "0.00";
		}
		public function getDeuda()
		{
			return $this->deuda;
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

		private $fk_id_hospedaje;
		public function setFkIdHospedaje($fk_id_hospedaje)
		{
			$fk_id_hospedaje = HS::clean_input($fk_id_hospedaje);
		
			$this->fk_id_hospedaje = $fk_id_hospedaje != '' ? $fk_id_hospedaje : NULL;
		}
		public function getFkIdHospedaje()
		{
			return $this->fk_id_hospedaje;
		}
	}
		