<?php namespace App\Controller;

	use App\Core\ControladorBase;
	use App\Model\ReservacionModel as MReservacion;
	use App\Model\HabitacionModel as MHabitacion;
	use App\Model\PersonalModel as MPersonal;
	use App\Model\HuespedModel as MHuesped;
	use App\Model\UsuarioModel as MUsuario;
	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	use App\Helpers\Request as HR;
	
	class PersonalController extends ControladorBase
	{
		public function index()
		{
			$this->redirect('index', 'index');
		}

		public function getDataPermiso()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax()) {
				$result = MPersonal::allPermiso();
				if (isset($result)){
					$data = array(
						'exito' =>true,
						'result' => $result
					);
				} else {
					$data = array('exito' => false, );
				}
				$data   = json_encode($data);
			    echo $data;	   
			} else {
				$this->redirect();
			}
		}
		public function getDataEvento()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax()) {
				$result = MPersonal::allEvento();
				if (isset($result)){
					$data = array(
						'exito' =>true,
						'result' => $result
					);
				} else {
					$data = array('exito' => false, );
				}
				$data   = json_encode($data);
			    echo $data;	   
			} else {
				$this->redirect();
			}
		}

		public function getDataSalario()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax()) {
				$result = MPersonal::allSalario();
				if (isset($result)){
					$data = array(
						'exito' =>true,
						'result' => $result
					);
				} else {
					$data = array('exito' => false, );
				}
				$data   = json_encode($data);
			    echo $data;	   
			} else {
				$this->redirect();
			}
		}
		public function setUpdatePermiso()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['id_permiso'], $_POST['f_ini'], $_POST['f_fin'])) {
				$result = MPersonal::UpdatePermiso($_POST['id_permiso'], $_POST['f_ini'], $_POST['f_fin']);
				if (isset($result)){
					$data = array('exito' =>true);
				} else {
					$data = array('exito' => false);
				}
				$data   = json_encode($data);
			    echo $data;	   
			} else {
				$this->redirect();
			}
		}


		public function setUpdateFechaSalario()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['id_salario'], $_POST['fecha'])) {
				$result = MPersonal::UpdateSalario($_POST['id_salario'], $_POST['fecha']);
				if (isset($result)){
					$data = array('exito' =>true);
				} else {
					$data = array('exito' => false);
				}
				$data   = json_encode($data);
			    echo $data;	   
			} else {
				$this->redirect();
			}
		}

		public function prueba()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			if (HR::is_ajax() && isset($_POST['title'], $_POST['f_inicio'], $_POST['f_fin'], $_POST['color'], $_POST['user'])) 
			{
				if (MPersonal::SaveEventos($_POST['title'], $_POST['f_inicio'], $_POST['f_fin'], $_POST['color'], $_POST['user'], $user->getIdUsuario())) {
					$data = array('exito' => true, );
				} else {
					$data = array('exito' => false, );
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
			if (HR::is_ajax() && isset($_POST['id_personal'])) 
			{

				$result = MPersonal::getByPersonal($_POST['id_personal'])[0];
				if (isset($result)) {
					
					$data   = array( 
						"dni" 		=>  $result->getIdPersonal(),
						"nombre" 	=>  $result->getNombre(),
						"apellido" 	=>  $result->getApellido(),
						"celular"	=>	$result->getTelefono(),
						"direccion"	=>  $result->getDireccion(),
						"labor"		=>	$result->getLabor(),
						"salario"	=>	$result->getSalario(),
						"estado"	=>	$result->getEstado(),
						"fecha"		=>	$result->getFechaInicio()
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
			session_start();
			HS::sesion_no_iniciada($this);
			HS::session_no_iniciada_administrador($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'dni'			=> "",
				'nombre'		=> "",
				'apellido'		=> "",
				'celular'		=> "",
				'direccion'		=> "",
				'labor'			=> "",
				'salario'		=> "",
				'estado'		=> "",
				'fecha'			=> "",
				'personal'		=> MPersonal::AllPersonal(),
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
				if (MPersonal::SavePersonal($_POST['dni'], $_POST['nombre'], $_POST['apellido'], $_POST['celular'], $_POST['direccion'], $_POST['fecha'], $_POST['labor'], $_POST['salario'], $_POST['estado'], $user->getIdUsuario()))
				{
					$data['mensaje'] 		= "Se Registro Correctamente";
					$data['class_mensaje'] 	= "exito";
					$data['personal']		= MPersonal::AllPersonal();
				}
				else {
					$data['mensaje'] 	= "Error al Registrar Personal";
					$data['dni'] 		= $_POST['dni'];
					$data['nombre'] 	= $_POST['nombre'];
					$data['apellido'] 	= $_POST['apellido'];
					$data['celular'] 	= $_POST['celular'];
					$data['direccion'] 	= $_POST['direccion'];
					$data['labor'] 		= $_POST['labor'];
					$data['salario'] 	= $_POST['salario'];
					$data['estado'] 	= $_POST['estado'];
					$data['fecha'] 		= $_POST['fecha'];

				}
			}

			$this->view('Personal/Registro', $data);
		}

		public function eventos()
		{
			session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'datos_template' => array(
					'usuario' 	=> $user,
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);

			$this->view('Personal/Eventos', $data);
		}

		public function pago()
		{
			session_start();
			HS::sesion_no_iniciada($this);
			HS::session_no_iniciada_administrador($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'ListPersonal'	=> MPersonal::AllPersonal(),
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
				if (isset($_POST['color'])) 
					$color = $_POST['color'];
				else
					$color = "#3c8dbc";
				if (MPersonal::SaveSalario("", $_POST['monto'],$_POST['tipo'], $color, $_POST['id_personal'])) 
				{
					$data['mensaje'] 		= "Se registro correctamente";
					$data['class_mensaje'] 	= "exito";
				} else {
					$data['mensaje'] 		= "Error al Registar";
				}
			}

			$this->view('Personal/Pago', $data);
		}

		public function permiso()
		{
			session_start();
			HS::sesion_no_iniciada($this);
			HS::session_no_iniciada_administrador($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'ListPersonal'	=> MPersonal::AllPersonal(),
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
				if (isset($_POST['color'])) 
					$color = $_POST['color'];
				else
					$color = "#3c8dbc";
				$dato = explode("-", $_POST['fecha_fin']);

				$anio	= $dato[0];
				$mes 	= $dato[1];
				$dia 	= $dato[2]+1;
				$newfin = $anio.'-'.$mes.'-'.$dia;
				
				if (MPersonal::SavePermiso("", $_POST['fecha_inicio'], $newfin, $_POST['descripcion'], $color, $_POST['id_personal'])) 
				{
					$data['mensaje'] 		= "Se Registro Correctamente";
					$data['class_mensaje'] 	= "exito";
				} else {
					$data['mensaje'] 		= "Error al Registro Permiso";
				}
				
			}

			$this->view('Personal/Permiso', $data);
		}

		public function update()
		{
			session_start();
			HS::sesion_no_iniciada($this);
			HS::session_no_iniciada_administrador($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'dni'			=> "",
				'nombre'		=> "",
				'apellido'		=> "",
				'celular'		=> "",
				'direccion'		=> "",
				'labor'			=> "",
				'salario'		=> "",
				'estado'		=> "",
				'fecha'			=> "",
				'personal'		=> MPersonal::AllPersonal(),
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
				if (MPersonal::UpdatePersonal($_POST['dni'], $_POST['nombre'], $_POST['apellido'], $_POST['celular'], $_POST['direccion'], $_POST['fecha'], $_POST['labor'], $_POST['salario'], $_POST['estado'], $user->getIdUsuario()))
				{
					$data['mensaje'] 		= "Se Modifico Correctamente";
					$data['class_mensaje'] 	= "exito";
					$data['personal']		= MPersonal::AllPersonal();
				}
				else {
					$data['mensaje'] 	= "Error al Modificar Personal";
					$data['dni'] 		= $_POST['dni'];
					$data['nombre'] 	= $_POST['nombre'];
					$data['apellido'] 	= $_POST['apellido'];
					$data['celular'] 	= $_POST['celular'];
					$data['direccion'] 	= $_POST['direccion'];
					$data['labor'] 		= $_POST['labor'];
					$data['salario'] 	= $_POST['salario'];
					$data['estado'] 	= $_POST['estado'];
					$data['fecha'] 		= $_POST['fecha'];

				}
			}

			$this->view('Personal/Registro', $data);
		}

	}