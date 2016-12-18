<?php namespace App\Controller;

	use App\Core\ControladorBase;
	use App\Model\ReservacionModel as MReservacion;
	use App\Model\HabitacionModel as MHabitacion;
	use App\Model\UsuarioModel as MUsuario;
	use App\Model\HuespedModel as MHuesped;
	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	
	class IndexController extends ControladorBase
	{
		
		/*		INDEX 		*/
		
		public function index()
		{
			session_start();

			HS::sesion_iniciada($this,'index','home');
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'email'			=>""
			);
			$this->view('Index', $data);
		}		
		/*	**	*/

		public function login()
		{
			session_start();

			HS::sesion_iniciada($this);

			$data = array(
				'mensaje'		=>"",				
				'class_mensaje'	=> "error", //exito o error
				'email'			=>""
			);

			if(!empty($_POST) && isset($_POST))
			{
				if(MUsuario::login($_POST['email'], $_POST['contrasena']))
				{
					$this->redirect('index', 'home');
				}
				else
				{
					$data['email']   = $_POST['email'];
					$data['mensaje'] = "Email o Contraseña incorrecto";
				}
			}

			$this->view('Index', $data);

		}

		public function logout()
		{
			MUsuario::logout();
			$this->redirect();
		}

		public function home()
		{
			session_start();
			
			HS::sesion_no_iniciada($this);
			HS::sesion_iniciada_inactivo($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			if ($user->getTipo() == "Admin") $this->redirect('index', 'admin');
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'usuario'		=> $user,
				'habitaciones'	=>	MHabitacion::all(),
				'datos_template' => array(
					'usuario' 	=> $user,
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);

			$this->view('Habitacion/Disponible', $data);
		}
		public function admin()
		{
			session_start();
			HS::sesion_no_iniciada($this);
			HS::sesion_iniciada_inactivo($this);
			HS::session_no_iniciada_administrador($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'usuario'		=> $user,
				'usuarios'		=> MUsuario::all(),
				'datos_template' => array(
					'usuario'	=> $user,
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())

				)
			);

			$this->view('Home', $data);
		}
	}