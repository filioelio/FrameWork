<?php namespace App\Controller;

	use App\Core\ControladorBase;
	use App\Model\ReservacionModel as MReservacion;
	use App\Model\HabitacionModel as MHabitacion;
	use App\Model\HuespedModel as MHuesped;
	use App\Model\UsuarioModel as MUsuario;
	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	use App\Helpers\Request as HR;
	
	class HabitacionController extends ControladorBase
	{
		public function index()
		{
			$this->redirect('index', 'index');
		}

		public function Mantenimiento()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['id_habitacion'])) 
			{
				$result = MHabitacion::update_estado($_POST['id_habitacion']);
				if (isset($result)) {
					$data = array('exito' => true, );
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
				$result = MHabitacion::getBy($_POST['id_habitacion'])[0];
				if (isset($result)) {
					$data   = array( 
						"idhabitacion" 	=>  $result->getIdHabitacion(),
						"tipo" 			=>  $result->getTipo(),
						"descripcion" 	=>  $result->getDescripcion(),
						"estado"		=>	$result->getEstado(),
						"precio"		=>	$result->getPrecio(),
						"foto"			=>	$result->getFoto()
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

		public function ocupado()
		{
			session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'usuario'		=> $user,
				'seleccionado'	=> MHabitacion::Ocupado(),
				'datos_template' => array(
					'usuario' 	=> $user,
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date()),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);

			$this->view('Habitacion/Ocupado', $data);
		}

		public function disponible()
		{
			session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

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

		public function habitacion()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			HS::session_no_iniciada_administrador($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];


			$data = array(
				'mensaje' 		=> "",							
				'class_mensaje' => "error",
				'id'			=>	"",
				'tipo'			=>	"",
				'descripcion'	=>	"",
				'estado'		=>	"",
				'precio'		=>	"",	
				'habitaciones'	=>	MHabitacion::all(),
				'datos_template' => array(
					'usuario' => $user,
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);
			$this->view('Habitacion/Habitacion', $data);
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
				'id'			=>	"",
				'tipo'			=>	"",
				'descripcion'	=>	"",
				'estado'		=>	"",
				'precio'		=>	"",	
				'habitaciones'	=>	MHabitacion::all(),
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

				$foto_bd = NULL;

				if($_FILES['foto']["error"] == 0)
				{
					$mTmpFile = $_FILES['foto']["tmp_name"];
					$mTipo = exif_imagetype($mTmpFile);
							
					$path_destino = getcwd().DIRECTORY_SEPARATOR;
					$type_array   = explode(".", $_FILES['foto']['name']);						
					$name_img     =  $path_destino . 'img/Habitacion/' . $_POST['id'] . '.' . $type_array[count($type_array) - 1];
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
						$foto_bd =  $_POST['id'] . '.' . $type_array[count($type_array) - 1];
					}
				}
			
				if (MHabitacion::save($_POST['id'], $_POST['tipo'], $_POST['descripcion'], $_POST['estado'], $_POST['precio'], $foto_bd)) 
				{
					$data['mensaje']		=	"Habitacion registrada exitosamente";
					$data['class_mensaje']	=	"exito";
					$data['habitaciones']	=	MHabitacion::all();
				}
				else
				{
					$data['mensaje']		=	"Error al Registrar Habitacion";
					$data['class_mensaje']	=	"error";
					$data['id']				=	$_POST['id'];
					$data['tipo']			=	$_POST['tipo'];
					$data['descripcion']	=	$_POST['descripcion'];
					$data['estado']			=	$_POST['estado'];
					$data['precio']			=	$_POST['precio'];	

				}

			}

			$this->view('Habitacion/Habitacion', $data);
		}

		public function update()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			HS::session_no_iniciada_administrador($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];


			$data = array(
				'mensaje' 		=> "",
				'class_mensaje' => "error",
				'id'			=>	"",
				'tipo'			=>	"",
				'descripcion'	=>	"",
				'estado'		=>	"",
				'precio'		=>	"",	
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
			if(!empty($_POST) && isset($_POST))
			{
				$room = MHabitacion::getBy($_POST['id'])[0];

				$foto_bd = $room->getFoto();

				if($_FILES['foto']["error"] == 0)
				{
					$mTmpFile = $_FILES['foto']["tmp_name"];
					$mTipo = exif_imagetype($mTmpFile);
							
					$path_destino = getcwd().DIRECTORY_SEPARATOR;
					$type_array   = explode(".", $_FILES['foto']['name']);						
					$name_img     =  $path_destino . 'img/Habitacion/' . $_POST['id'] . '.' . $type_array[count($type_array) - 1];
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
						$foto_bd =  $_POST['id'] . '.' . $type_array[count($type_array) - 1];
					}
				}
			
				if (MHabitacion::update($_POST['id'], $_POST['tipo'], $_POST['descripcion'], $_POST['estado'], $_POST['precio'], $foto_bd)) 
				{					
					$data['mensaje']		=	"Se Actulizo Correctamente";
					$data['class_mensaje']	=	"exito";
					$data['habitaciones']	=	MHabitacion::all();
				}
				else
				{
					$data['mensaje']		=	"Error al actualizar Habitacion";
					$data['class_mensaje']	=	"error";
					$data['id']				=	$_POST['id'];
					$data['tipo']			=	$_POST['tipo'];
					$data['descripcion']	=	$_POST['descripcion'];
					$data['estado']			=	$_POST['estado'];
					$data['precio']			=	$_POST['precio'];	

				}

			}

			$this->view('Habitacion/Habitacion', $data);
		}
	}