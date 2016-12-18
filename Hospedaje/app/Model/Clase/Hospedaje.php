<?php namespace App\Model\Clase;

	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	
	class Hospedaje
	{
		
		public function __construct()
		{}
		
		private $id_hospedaje;
		public function setIdHospedaje($id_hospedaje)
		{
			$id_hospedaje = HS::clean_input($id_hospedaje);
		
			$this->id_hospedaje = $id_hospedaje;
		}
		public function getIdHospedaje()
		{
			return $this->id_hospedaje;
		}


		private $motivo_visita;
		public function setMotivoVisita($motivo_visita)
		{
			$motivo_visita = HS::clean_input($motivo_visita);
		
			$this->motivo_visita = $motivo_visita;
		}
		public function getMotivoVisita()
		{
			return $this->motivo_visita;
		}

		private $fecha_ingreso;
		public function setFechaIngreso($fecha_ingreso)
		{
			$fecha_ingreso = HS::clean_input($fecha_ingreso);

			$this->fecha_ingreso = $fecha_ingreso != "" ? $fecha_ingreso : HFD::DateTime();
		}
		public function getFechaIngreso()
		{
			return $this->fecha_ingreso;
		}

		private $fecha_salida;
		public function setFechaSalida($fecha_salida)
		{
			$fecha_salida = HS::clean_input($fecha_salida);

			$this->fecha_salida = $fecha_salida != "" ? $fecha_salida : HFD::DateTime();
		}
		public function getFechaSalida()
		{
			return $this->fecha_salida;
		}

		private $estado;
		public function setEstado($estado)
		{
			$estado = HS::clean_input($estado);
		
			$this->estado = $estado != "" ? $estado : 'Activo';
		}
		public function getEstado()
		{
			return $this->estado;
		}

		private $precio;
		public function setPrecio($precio)
		{
			$precio = HS::clean_input($precio);
		
			$this->precio = $precio != "" ? $precio : '0.00';
		}
		public function getPrecio()
		{
			return $this->precio;
		}

		private $costo_total;
		public function setCostoTotal($costo_total)
		{
			$costo_total = HS::clean_input($costo_total);
		
			$this->costo_total = $costo_total != "" ? $costo_total : '0.00';
		}
		public function getCostoTotal()
		{
			return $this->costo_total;
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

		private $fk_id_huesped;
		public function setFkIdHuesped($fk_id_huesped)
		{
			$fk_id_huesped = HS::clean_input($fk_id_huesped);
		
			$this->fk_id_huesped = $fk_id_huesped;
		}
		public function getFkIdHuesped()
		{
			return $this->fk_id_huesped;
		}
		private $fk_id_habitacion;
		public function setFkIdHabitacion($fk_id_habitacion)
		{
			$fk_id_habitacion = HS::clean_input($fk_id_habitacion);
		
			$this->fk_id_habitacion = $fk_id_habitacion;
		}
		public function getFkIdHabitacion()
		{
			return $this->fk_id_habitacion;
		}

	}
