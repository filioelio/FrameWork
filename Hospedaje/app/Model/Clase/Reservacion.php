<?php namespace App\Model\Clase;

	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	
	class Reservacion
	{
		private $id_reservacion;
		public function setIdReservacion($id_reservacion)
		{
			$id_reservacion = HS::clean_input($id_reservacion);
		
			$this->id_reservacion = $id_reservacion;
		}
		public function getIdReservacion()
		{
			return $this->id_reservacion;
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

		private $fecha_reser;
		public function setFechaReser($fecha_reser)
		{
			$fecha_reser = HS::clean_input($fecha_reser);

			$this->fecha_reser = $fecha_reser != "" ? $fecha_reser : HFD::DateTime();

		}
		public function getFechaReser()
		{
			return $this->fecha_reser;
		}

		private $fecha_ingreso;
		public function setFechaIngreso($fecha_ingreso)
		{
			$fecha_ingreso = HS::clean_input($fecha_ingreso);

			$this->fecha_ingreso = $fecha_ingreso != "" ? $fecha_ingreso : HFD::Date();
		}
		public function getFechaIngreso()
		{
			return $this->fecha_ingreso;
		}

		private $fecha_salida;
		public function setFechaSalida($fecha_salida)
		{
			$fecha_salida = HS::clean_input($fecha_salida);

			$this->fecha_salida = $fecha_salida != "" ? $fecha_salida : HFD::Date();
		}
		public function getFechaSalida()
		{
			return $this->fecha_salida;
		}

		private $adelanto;
		public function setAdelanto($adelanto)
		{
			$adelanto = HS::clean_input($adelanto);
		
			$this->adelanto = $adelanto ;
		}
		public function getAdelanto()
		{
			return $this->adelanto;
		}

		private $estado;
		public function setEstado($estado)
		{
			$estado = HS::clean_input($estado);
		
			$this->estado = $estado != "" ? $estado : "Activo";
		}
		public function getEstado()
		{
			return $this->estado;
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