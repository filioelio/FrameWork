<?php namespace App\Controller;

	use App\Core\ControladorBase;
	use App\Model\ReservacionModel as MReservacion;
	use App\Model\HabitacionModel as MHabitacion;
	use App\Model\HuespedModel as MHuesped;
	use App\Model\UsuarioModel as MUsuario;
	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	use App\Helpers\Request as HR;
	
	class HuespedController extends ControladorBase
	{
		public function index()
		{
			$this->redirect('index', 'index');
		}

		public function getData()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['id_huesped'])) 
			{
				$result = MHuesped::getBy($_POST['id_huesped'])[0];
				if (isset($result)) {
					$data   = array( 
						"dni" 		=>  $result->getIdHuesped(),
						"nombre" 	=>  $result->getNombre(),
						"apellido" 	=>  $result->getApellido(),
						"origen" 	=>  $result->getProcedencia(),
						"telefono"	=>	$result->getTelefono(),
						"conducta"	=>	$result->getConducta()
					);
				}
				else
				{
					$data = array('dni' => "", );
				}
				
				$data   = json_encode($data);
			    echo $data;	    
			}
			else
			{
				$this->redirect();
			}
		}

		public function registro()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			$data = array(
				'mensaje' 		=> 	"",
				'class_mensaje' => 	"error",
				'id'			=> 	"",
				'nombre'		=> 	"",
				'apellido'		=>	"",
				'procedencia'	=>	"",
				'telefono'		=>	"",
				'conducta'		=>	"",
				'huespeds'		=>	MHuesped::all(),
				'datos_template' => array(
					'usuario' 	=> $user, 
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);

			if (! empty($_POST) && isset($_POST)) 
			{
				if (MHuesped::save($_POST['id'], $_POST['nombre'], $_POST['apellido'], $_POST['procedencia'], $_POST['telefono'], $_POST['conducta'])) {
					$data['mensaje']		=	"Se Registro Exitosamente";
					$data['class_mensaje']	=	"exito";
					$data['huespeds']		= 	MHuesped::all();
				}else{
					$data['mensaje']	=	"Error Ya Existe Huesped";
					$data['id']			=	$_POST['id'];
					$data['nombre']		=	$_POST['nombre'];
					$data['apellido']	=	$_POST['apellido'];
					$data['procedencia']	=	$_POST['procedencia'];
					$data['telefono']	=	$_POST['telefono'];
					$data['conducta']	=	$_POST['conducta'];
				}

			}

			$this->view('Huesped/Registro', $data);
		}

		public function update()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			$data = array(
				'mensaje' 		=> 	"",
				'class_mensaje' => 	"error",
				'id'			=> 	"",
				'nombre'		=> 	"",
				'apellido'		=>	"",
				'procedencia'	=>	"",
				'telefono'		=>	"",
				'conducta'		=>	"",
				'huespeds'		=>	MHuesped::all(),
				'datos_template' => array(
					'usuario' 	=> $user, 
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
										'permiso'	=> MReservacion::MSPermiso(HFD::Date())

				)
			);

			if (! empty($_POST) && isset($_POST)) 
			{
				if (MHuesped::update($_POST['id'], $_POST['nombre'], $_POST['apellido'], $_POST['procedencia'], $_POST['telefono'], $_POST['conducta'])) {
					$data['mensaje']		=	"Se Modifico Exitosamente";
					$data['class_mensaje']	=	"exito";
					$data['huespeds']		= 	MHuesped::all();
				}else{
					$data['mensaje']	=	"Error Al Modificar Huesped";
					$data['id']			=	$_POST['id'];
					$data['nombre']		=	$_POST['nombre'];
					$data['apellido']	=	$_POST['apellido'];
					$data['procedencia']	=	$_POST['procedencia'];
					$data['telefono']	=	$_POST['telefono'];
					$data['conducta']	=	$_POST['conducta'];
				}

			}

			$this->view('Huesped/Registro', $data);
		}
	}
