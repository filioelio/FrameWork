<?php namespace App\Controller;

	use App\Core\ControladorBase;
	use App\Model\ReservacionModel as MReservacion;
	use App\Model\HabitacionModel as MHabitacion;
	use App\Model\HuespedModel as MHuesped;
	use App\Model\UsuarioModel as MUsuario;
	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	use App\Helpers\Request as HR;
	
	class ReservacionController extends ControladorBase
	{
		public function index()
		{
			$this->redirect('index', 'index');
		}

		public function finalizar()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['id_reservacion'])) 
			{
				if (MReservacion::finalizar($_POST['id_reservacion'], "Cancelado")) {
					$data = array('exito' => true);	
				}	else {
					$data = array('exito' => true);		
				}

				$data   = json_encode($data);
			    echo $data;	    
			}
			else
			{
				$this->redirect();
			}
		}

		public function reservado()
		{
			session_start();
			HS::sesion_no_iniciada($this);

			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'usuario'		=> $user,
				'habitaciones'	=>	MHabitacion::Reservado(),
				'datos_template' => array(
					'usuario' 	=> $user,
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);

			$this->view('Habitacion/Reservado', $data);
		}
		
		public function registro($_nro)
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			$data = array(
				'mensaje' 		=> "",
				'class_mensaje' => "error",
				'dni'			=>	"",
				'nombre'		=>	"",
				'apellido'		=>	"",
				'origen'		=>	"",
				'telefono'		=>	"",
				'conducta'		=>	"",
				'descripcion'	=>	"",
				'ingreso'		=>	"",
				'salida'		=>	"",
				'nro'			=>	$_nro,
				'room' 			=> MHabitacion::getBy($_nro)[0],
				'datos_template' => array(
					'usuario' 	=> $user, 
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);

			if (!empty($_POST) && isset($_POST)) 
			{
				if (MHuesped::save($_POST['dni'], $_POST['nombre'], $_POST['apellido'], $_POST['origen'], $_POST['telefono'], $_POST['conducta']))
				{
					if (MReservacion::save($_POST['descripcion'], "", $_POST['ingreso'], $_POST['salida'], $_POST['adelanto'], $user->getIdUsuario(), $_POST['dni'], $_POST['id_habi'])) 
					{
						$data['mensaje'] 		= "Reservacion Creado Correctamente";
						$data['class_mensaje'] 	= "exito";
						$data['huespedes'] 		= MHuesped::all();
					}
					else
					{
						$data['mensaje'] 		= "Existe Usuario / no se concluyo correctamente la Reservacion";
						$data['dni']			= $_POST['dni'];
						$data['nombre']			= $_POST['nombre'];
						$data['apellido']		= $_POST['apellido'];
						$data['telefono']		= $_POST['telefono'];
						$data['conducta']		= $_POST['conducta'];
						$data['descripcion']	= $_POST['descripcion'];
						$data['ingreso']		= $_POST['ingreso'];
						$data['salida']			= $_POST['salida'];
					}
				}
				else
				{
					if (MReservacion::save($_POST['descripcion'], "", $_POST['ingreso'], $_POST['salida'],$_POST['adelanto'], $user->getIdUsuario(), $_POST['dni'], $_POST['id_habi'])) 
					{
						$data['mensaje'] 		= "Reservacio Creado Correctamente";
						$data['class_mensaje'] 	= "exito";
					}
					else
					{
						$data['mensaje'] 		= "Existe Usuario / no se concluyo correctamente la Reservacion";
						$data['dni']			= $_POST['dni'];
						$data['nombre']			= $_POST['nombre'];
						$data['apellido']		= $_POST['apellido'];
						$data['telefono']		= $_POST['telefono'];
						$data['conducta']		= $_POST['conducta'];
						$data['descripcion']	= $_POST['descripcion'];
						$data['ingreso']		= $_POST['ingreso'];
						$data['salida']			= $_POST['salida'];
					}
				}
			}
			$this->view('Reservacion/Registro', $data);
		}

		public function historial()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			$data = array(
				'mensaje' 		=> "",
				'class_mensaje' => "error",
				'datos_template' => array(
					'usuario' 	=> $user, 
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);

			$data['cabezeras'] = array(
				"hab",
				"dni",
				"huesped",
				"descripcion",
				"fecha_reserva",
				"fecha_ingreso",
				"fecha_salida",
				"adelanto",
				"usuario"
			);
			
			$reporte = MReservacion::historial();
			$data['reservacion'] = $reporte;
			

			$this->view('Reservacion/Lista', $data);			
		}
	}