<?php namespace App\Controller;

	use App\Core\ControladorBase;
	use App\Model\ReservacionModel as MReservacion;
	use App\Model\HabitacionModel as MHabitacion;
	use App\Model\UsuarioModel as MUsuario;
	use App\Model\HuespedModel as MHuesped;
	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	use App\Helpers\Request as HR;
	
	class UsuarioController extends ControladorBase
	{
		public function index()
		{
			$this->redirect('index', 'index');
		}

		public function getData()
		{
			@session_start();

			if (HR::is_ajax() && isset($_POST['id_us'])) 
			{
				$result = MUsuario::getBy($_POST['id_us'])[0];
				if (isset($result)) {
					$data   = array( 
						"dni" 		=>  $result->getIdUsuario(),
						"nombre" 	=>  $result->getNombre(),
						"apellido" 	=>  $result->getApellido(),
						"telefono"	=>	$result->getTelefono(),
						"email"		=>  $result->getEmail(),
						"password" 	=>  $result->getContrasena(),
						"tipo" 		=>  $result->getTipo(),
						"estado"	=>	$result->getEstado()
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
		
		public function update()
		{
			@session_start();

			HS::sesion_no_iniciada($this);
			HS::session_no_iniciada_administrador($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			$data = array(
				'class_mensaje' =>"error", 
				'mensaje' 		=> '',
				'dni' 			=> '',
				'email' 		=> '',
				'nombre' 		=> '',
				'apellido' 		=> '',
				'telefono' 		=> '',
				'user_foto' 	=> '',
				'cantidad'		=>	MUsuario::contar(),
				'datos_template' => array(
					'usuario'	 => $user,
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);
			if(!empty($_POST) && isset($_POST))
			{
				$user_up = MUsuario::getBy($_POST['dni'])[0];
				$foto_bd = $user_up->getFoto();

				if($_FILES['foto']["error"] == 0)
				{
					$mTmpFile = $_FILES['foto']["tmp_name"];
					$mTipo = exif_imagetype($mTmpFile);
							
					$path_destino = getcwd().DIRECTORY_SEPARATOR;
					$type_array   = explode(".", $_FILES['foto']['name']);						
					$name_img     =  $path_destino . 'img/users/' . $_POST['nombre'] . '.' . $type_array[count($type_array) - 1];
					$foto         = $_FILES['foto']['tmp_name'];

					if(($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG))
					{
						$data['mensaje'] = "El formato de imagen no es correcto";
					}
					elseif(! move_uploaded_file($foto, $name_img))
					{
						$data['mensaje'] = "No se pudo subir el archivo";
					}
					else
					{
						$foto_bd              =  $_POST['nombre'] . '.' . $type_array[count($type_array) - 1];
						$data['usuario_foto'] = "/img/users/" . $foto_bd;
					}
				}
				if(MUsuario::updateadmin($_POST['dni'], $_POST['email'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['password'], $foto_bd, $_POST['tipo'], $_POST['estado']))
				{

					$data['usuarios']   	= MUsuario::all();
					$data['class_mensaje']  = "exito";
					$data['mensaje'] 		= "Se Actualizo correctamente.";
				}
				else
				{
					$data['class_mensaje']  = "error";
					$data['mensaje'] 		= "Error al Actualizar Usuario.";
					$data['dni'] 			= $_POST['dni'];
					$data['email'] 			= $_POST['email'];
					$data['nombre'] 		= $_POST['nombre'];
					$data['apellido'] 		= $_POST['apellido'];
					$data['telefono'] 		= $_POST['telefono'];
				}
			}
			$this->view('Usuario/Usuario', $data);
		}

		public function usuario(){
			@session_start();
			HS::sesion_no_iniciada($this);
			HS::session_no_iniciada_administrador($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			$data = array(
				'mensaje' 		=> "",
				'class_mensaje' => "error",
				'dni'			=>	"",
				'nombre'		=>	"",
				'apellido'		=>	"",
				'telefono'		=>	"",
				'email'			=>	"",
				'cantidad'		=>	MUsuario::contar(),
				'usuarios'		=>	MUsuario::all(),
				'datos_template' => array(
					'usuario' 	=> $user, 
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);

			$this->view('Usuario/Usuario', $data);
		}

		public function registro()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			HS::session_no_iniciada_administrador($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			$data = array(
				'mensaje' 		=> "",
				'class_mensaje' => "error",
				'dni'			=>	"",
				'nombre'		=>	"",
				'apellido'		=>	"",
				'telefono'		=>	"",
				'email'			=>	"",
				'cantidad'		=>	MUsuario::contar(),
				'usuarios'		=>	MUsuario::all(),
				'datos_template' => array(
					'usuario' 	=> $user, 
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);
			if(!empty($_POST) && isset($_POST))
			{
				$foto_bd = $user->getFoto();

				if($_FILES['foto']["error"] == 0)
				{
					$mTmpFile = $_FILES['foto']["tmp_name"];
					$mTipo = exif_imagetype($mTmpFile);
							
					$path_destino = getcwd().DIRECTORY_SEPARATOR;
					$type_array   = explode(".", $_FILES['foto']['name']);						
					$name_img     =  $path_destino . 'img/users/' . $_POST['nombre'] . '.' . $type_array[count($type_array) - 1];
					$foto         = $_FILES['foto']['tmp_name'];

					if(($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG))
					{
						$data['mensaje'] = "El formato de imagen no es correcto";
					}
					elseif(! move_uploaded_file($foto, $name_img))
					{
						$data['mensaje'] = "No se pudo subir el archivo";
					}
					else
					{
						$foto_bd  =  $_POST['nombre'] . '.' . $type_array[count($type_array) - 1];
					}
				}
				if (MUsuario::save($_POST['dni'], $_POST['email'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['password'], $foto_bd, $_POST['tipo'], $_POST['estado'])) 
				{
					$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
					
					$data['class_mensaje']   = "exito";
					$data['mensaje'] 		= "Se Registro correctamente.";
					$data['usuarios']		=	MUsuario::all();
					$data['datos_template'] = array('usuario' => $user );
				}
				else
				{
					$data['class_mensaje']   = "error";
					$data['mensaje'] 		= "Error al registrar Usuario.";
					$data['dni'] 			= $_POST['dni'];
					$data['email'] 			= $_POST['email'];
					$data['nombre'] 		= $_POST['nombre'];
					$data['apellido'] 		= $_POST['apellido'];
					$data['telefono'] 		= $_POST['telefono'];
				}

			}
			$this->view('Usuario/Usuario', $data);
		}

		public function editar()
		{
			@session_start();

			HS::sesion_no_iniciada($this);

			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			$data = array(
				'class_mensaje' =>"error", 
				'mensaje' 		=> '',
				'dni' 			=> $user->getIdUsuario(),
				'email' 		=> $user->getEmail(),
				'nombre' 		=> $user->getNombre(),
				'apellido' 		=> $user->getApellido(),
				'telefono' 		=> $user->getTelefono(),
				'user_foto' 	=> $user->getFoto(true),
				'datos_template' => array(
					'usuario' 	=> $user,
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);
			if(!empty($_POST) && isset($_POST))
			{
				$foto_bd = $user->getFoto();

				if($_FILES['foto']["error"] == 0)
				{
					$mTmpFile = $_FILES['foto']["tmp_name"];
					$mTipo = exif_imagetype($mTmpFile);
							
					$path_destino = getcwd().DIRECTORY_SEPARATOR;
					$type_array   = explode(".", $_FILES['foto']['name']);						
					$name_img     =  $path_destino . 'img/users/' . $_POST['nombre'] . '.' . $type_array[count($type_array) - 1];
					$foto         = $_FILES['foto']['tmp_name'];

					if(($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG))
					{
						$data['mensaje'] = "El formato de imagen no es correcto";
					}
					elseif(! move_uploaded_file($foto, $name_img))
					{
						$data['mensaje'] = "No se pudo subir el archivo";
					}
					else
					{
						$foto_bd              =  $_POST['nombre'] . '.' . $type_array[count($type_array) - 1];
						$data['usuario_foto'] = "/img/users/" . $foto_bd;
					}
				}
				if(md5($_POST['password']) != $user->getContrasena())
				{
					$data['nombre']    	= $_POST['nombre'];
					$data['apellido'] 	= $_POST['apellido'];
					$data['telefono'] 	= $_POST['telefono'];
					$data['mensaje']  	= "La contraseña es incorrecta";
				}
				elseif(MUsuario::update($user->getIdUsuario(),$user->getEmail(), $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['password'], $foto_bd, $user->getTipo(), $user->getEstado()))
				{
					$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

					$data['nombre']   		= $user->getNombre();
					$data['apellido']   	= $user->getApellido();
					$data['telefono']   	= $user->getTelefono();
					$data['user_foto'] 		= $user->getFoto(true);
					$data['datos_template']  = array(
						'usuario' => $user ,
						'cantidad'	=> MHuesped::contar(),
						'estado' 	=> MHabitacion::Estado()[0],
						'mensaje' 	=> MReservacion::MensajeReservacion(),
						'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())

					);
					$data['class_mensaje']   = "exito";
					$data['mensaje'] 		= "Se Actualizo correctamente.";
				}
				else
				{
					$data['nombre']   	= $_POST['nombre'];
					$data['apellido']   = $_POST['apellido'];
					$data['telefono']   = $_POST['telefono'];
					$data['mensaje'] 	= "Error al Actualizar datos ". $foto_bd;
				}
			}
			$this->view('Usuario/Editar', $data);
		}

		public function password()
		{
			@session_start();

			HS::sesion_no_iniciada($this);

			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$data = array(
				'mensaje' 		=>"",
				'class_mensaje' =>"error",
				'dni' 			=> $user->getIdUsuario(),
				'email' 		=> $user->getEmail(),
				'nombre' 		=> $user->getNombre(),
				'apellido' 		=> $user->getApellido(),
				'telefono' 		=> $user->getTelefono(),
				'user_foto' 	=> $user->getFoto(true),
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
				if ($user->getContrasena() != md5($_POST['pass_act'])) 
				{
					$data['mensaje_pass']	=	"La Contraseña es incorrecta";
					$data['class_mensaje']	=	"error";
				}
				elseif ($_POST['pass_new'] != $_POST['pass_new_conf']) 
				{
					$data['mensaje_pass']	=	"Las Contraseñas no Coinciden";
					$data['class_mensaje']	=	"error";
				}
				elseif (MUsuario::Update($user->getIdUsuario(), $user->getEmail(), $user->getNombre(), $user->getApellido(),$user->getTelefono(), $_POST['pass_new'], $user->getFoto(), $user->getTipo(), $user->getEstado())) 
				{
					$data['mensaje_pass']	=	"La Contraseña se Actualizo Correctamente";
					$data['class_mensaje']	=	"exito";
				}
				else
				{
					$data['mensaje_pass']	=	"Ocurrio un oroblema, Itentelo mas Tarde";
					$data['class_mensaje']	=	"error";
				}
			}

			$this->view('Usuario/Editar', $data);
		}
	}