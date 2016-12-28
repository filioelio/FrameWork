<?php namespace App\Controller;

	use App\Core\ControladorBase;
	use App\Model\ReservacionModel as MReservacion;
	use App\Model\HabitacionModel as MHabitacion;
	use App\Model\HospedajeModel as MHospedaje;
	use App\Model\HuespedModel as MHuesped;
	use App\Model\UsuarioModel as MUsuario;
	use App\Model\JornadaModel as MJornada;
	use App\Model\VentaModel as MVenta;
	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	use App\Helpers\Request as HR;
	
	class HospedajeController extends ControladorBase
	{
		public function index()
		{
			$this->redirect('index', 'index');
		}

		public function FinalizarTurno()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			if (HR::is_ajax() && isset($_POST['monto']))
			{ 
				if (MJornada::update($user->getIdUsuario(), $_POST['monto'])) {
					$data = array('exito' => true);
					unset($_SESSION['RGIngresoToday']);
				} else {
					$data = array('exito' => false);
				}

				$data   = json_encode($data);
			    echo $data;	    
			} else {
				$this->redirect();
			}
		}
		
		public function IniciarTurno()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			if (HR::is_ajax())
			{ 
				if (MJornada::save($user->getIdUsuario())) {
					$data = array('exito' => true);
				} else {
					$data = array('exito' => false);
				}

				$data   = json_encode($data);
			    echo $data;	    
			} else {
				$this->redirect();
			}
		}

		public function getJornada()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax())
			{
				$result = MJornada::getIdLast()[0];
				if (isset($result)) {
				 	$data = array(
				 		'exito' 		=> true, 
				 		'fecha_ingreso' => $result->getFechaIngreso(),
				 		'fecha_salida' 	=> $result->getFechaSalida()
				 	);
				} else {
				 	$data = array('exito' => "");
				}

				$data   = json_encode($data);
			    echo $data;	    
			} else {
				$this->redirect();
			}
		}

		public function getHospedajeSelect()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['id_hospedaje'])) 
			{
				$result = MHospedaje::HospedajeSelect($_POST['id_hospedaje'])[0];

				if (isset($result)) {
					$data   = array( 
						"exito"			=>	true,
						"img"			=>	$result->foto,
						"dni"			=>	$result->dni,
						"huesped"		=>	$result->huesped,
						"procedencia"	=>	$result->procedencia,
						"telefono"		=>	$result->telefono,
						"f_ingreso"		=>	HFD::FormatDateTime($result->fecha_ingreso),
						"f_salida"		=>	HFD::FormatDateTime($result->fecha_salida),
						"n_habi"		=>	$result->id_habitacion,
						"tipo"			=>	$result->tipo,
						"cos_habi"		=>	$result->precio,
						"cant_dias"		=>	$result->Cant_Dias,
						"total"			=>	$result->total,
						"adelanto"		=>	$result->adelanto,
						"deuda"			=>	$result->deuda,
						"usuario"		=>	$result->usuario

					);
				}
				else
				{
					$data = array('exito' => "", );
				}				
				$data   = json_encode($data);
			    echo $data;	    
			}
			else
			{
				$this->redirect();
			}
		}

		public function getData()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['id_habitacion'])) 
			{
				$result = MHospedaje::BuscarHuespedId($_POST['id_habitacion'])[0];
				if (isset($result)) {
					$data   = array( 
						"idhospedaje"	=>	$result->id_hospedaje,
						"idhabitacion" 	=>  $result->id_habitacion,
						"huesped"		=>	$result->huesped, 
						"fecha_ingreso"	=>	HFD::FormatDateTime($result->fecha_ingreso),
						"fecha_salida"	=>	HFD::FormatDateTime($result->fecha_salida),
						"deuda"		=>	$result->deuda
					);
				}
				else
				{
					$data = array('idhabitacion' => "", );
				}				
				$data   = json_encode($data);
			    echo $data;	    
			}
			else
			{
				$this->redirect();
			}
		}

		public function AjaxRecibirDNI()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['id_huesped'])) 
			{
				if (isset($_POST['id_huesped'])) 
				{
					$dato = explode("*", $_POST['id_huesped']);

					$dni = $dato[0];
					$adelanto = $dato[1];

					$_SESSION['huesped']['dni']	= $dni;
					$_SESSION['huesped']['adelanto']	= $adelanto;
		
					$data = array('exito' => true);	
				} else {
					$data = array('exito' => false);	
				}
						
				$data   = json_encode($data);
			    echo $data;	    
			}
			else
			{
				$this->redirect();
			}
		}

		public function ingreso()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$fecha = MJornada::getIdLast()[0];

			$data = array(
				'mensaje' 		=> "",
				'class_mensaje' => "error",
				'ingreso'		=> NULL,
				'ingresotoday'	=> MHospedaje::IngresoToday($fecha->getFechaIngreso()),
				'datos_template' => array(
					'usuario' => $user, 
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);

			if(!empty($_POST) && isset($_POST)){
				$data['ingresotoday'] = MHospedaje::SearchHospedaje($_POST['id_habi']);
			}

			$result = MHospedaje::IngresoTotal($fecha->getFechaIngreso())[0];

			$monto1 = $result->hospedaje != NULL ? $result->hospedaje : 0.00 ;
			$monto2 = $result->ventas != NULL ? $result->ventas : 0.00 ;
			$monto3 = $result->reservacion != NULL ? $result->reservacion : 0.00 ;
			$monto4 = $result->gasto != NULL ? $result->gasto : 0.00 ;
			$total = ($monto1+$monto2+$monto3-$monto4);

			$data['total'] = $total;
			$data['ingreso'] = $result;

			$this->view('Hospedaje/Cuenta', $data);
		}

		public function accion($_habi)
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$hospedaje = MHospedaje::getDataHospedaje($_habi)[0];
			$deuda = MVenta::deuda_venta($hospedaje->id_hospedaje)[0];
			$data = array(
				'mensaje' 		=> "",
				'class_mensaje' => "error",
				'hospedaje'		=> $hospedaje,
				'venta_pro'		=> $deuda,
				'datos_template' => array(
					'usuario' => $user, 
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);

			if(!empty($_POST) && isset($_POST))
			{
				if (isset($_POST['deuda_hosp'])) {
					$newmonto = $_POST['deuda_hosp']+$hospedaje->adelanto;
					if (MHospedaje::update($hospedaje->id_hospedaje, $newmonto)) {
						$data['mensaje'] 		= "Fue moodificado Correctamente";
						$data['class_mensaje'] 	= "exito";
						$data['hospedaje']		=  MHospedaje::getDataHospedaje($_habi)[0];
					}
				} elseif (isset($_POST['finalizar'])) {
					if ($hospedaje->deuda == 0.00 && $deuda->deuda == 0.00) {
						if (MHospedaje::update_salida($hospedaje->id_hospedaje,"")) {
							$this->redirect('habitacion','disponible');
						} else {
							$data['mensaje'] = "Ucurrio Un Error Inesperado intentelo luego";
						} 
					} elseif ($hospedaje->deuda > 0.00) {
						$data['mensaje'] = "Tiene Deuda de Hospedaje Cancele Primero";
					}elseif ($deuda->deuda > 0.00) {
						$data['mensaje'] = "Tiene Deuda de Producto Cancele Primero";
					}	
				}
			}

			$this->view('Hospedaje/Acciones', $data);
		}

		public function registro($_nro)
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			
			$data = array(
				'mensaje' 	=> "",
				'class_mensaje' => "error",
				'dni'		=>	"",
				'nombre'	=>	"",
				'apellido'	=>	"",
				'telefono'	=>	"",
				'conducta'	=>	"",
				'origen'	=>	"",
				'motivo'	=>	"",
				'adelanto'	=>	"",
				'nro'		=>	$_nro,
				'room' 		=> 	MHabitacion::getBy($_nro)[0],
				'datos_template' => array(
					'usuario' => $user, 
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);

			if (isset($_SESSION['huesped']['dni'])) 
			{
				$huesped = MHuesped::getBy($_SESSION['huesped']['dni'])[0];
				$data['dni'] 		= $huesped->getIdHuesped();
				$data['nombre']		= $huesped->getNombre() ;
				$data['apellido']	= $huesped->getApellido();
				$data['telefono']	= $huesped->getTelefono() ;
				$data['conducta']	= $huesped->getConducta();
				$data['origen']		= $huesped->getProcedencia() ;
				$data['adelanto']	= $_SESSION['huesped']['adelanto'];

				unset($_SESSION['huesped']);
			}

			if(!empty($_POST) && isset($_POST))
			{
				if (MHuesped::save($_POST['dni'], $_POST['nombre'], $_POST['apellido'], $_POST['origen'], $_POST['telefono'], $_POST['conducta'])) 
				{	
					if (isset($_POST['adelanto']) && $_POST['adelanto'] > 0)
						$saldo = $_POST['saldo'] + $_POST['adelanto'];
					else 
						$saldo = $_POST['saldo'];

					if(MHospedaje::save($_POST['motivo'], "", $_POST['salida'], "", $_POST['new_precio'], $saldo, $user->getIdUsuario(), $_POST['dni'], $_POST['id_habi']))
					{
						$data['mensaje'] 		= "Renta Creado Correctamente";
						$data['class_mensaje'] 	= "exito";
						$data['huespedes'] 		= MHuesped::all();
					}
					else
					{
						$data['mensaje'] 	= "error al registrar hospedaje";
						$data['dni']		= $_POST['dni'];
						$data['nombre']		= $_POST['nombre'];
						$data['apellido']	= $_POST['apellido'];
						$data['telefono']	= $_POST['telefono'];
						$data['conducta']	= $_POST['conducta'];
						$data['origen']		= $_POST['origen'];
						$data['motivo']		= $_POST['motivo'];
						$data['id_habi']	= $_POST['id_habi'];
					}
				}
				else
				{
					if (isset($_POST['adelanto']) && $_POST['adelanto'] > 0)
						$saldo = $_POST['saldo'] + $_POST['adelanto'];
					else 
						$saldo = $_POST['saldo'];

					if(MHospedaje::save($_POST['motivo'], "",  $_POST['salida'], "", $_POST['new_precio'], $saldo, $user->getIdUsuario(), $_POST['dni'], $_POST['id_habi']))
					{
						$data['mensaje'] 		= "Renta Creado Correctamente";
						$data['class_mensaje'] 	= "exito";
					}
					else
					{
						$data['mensaje'] 	= "Verifique que la Habitacion este Disponible";
						$data['dni']		= $_POST['dni'];
						$data['nombre']		= $_POST['nombre'];
						$data['apellido']	= $_POST['apellido'];
						$data['telefono']	= $_POST['telefono'];
						$data['conducta']	= $_POST['conducta'];
						$data['origen']		= $_POST['origen'];
						$data['motivo']		= $_POST['motivo'];
						$data['id_habi']	= $_POST['id_habi'];
					}
				}
			}

			$this->view('Hospedaje/Registro', $data);
		}

		public function historial()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			
			$data = array(
				'mensaje' 		=> "",
				'class_mensaje' => "error",
				'hospedaje'		=> MHospedaje::historial(),
				'datos_template' => array(
					'usuario' => $user, 
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);
			
			$this->view('Hospedaje/Lista', $data);
		}
	}
