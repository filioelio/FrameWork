<?php namespace App\Controller;

	use App\Core\ControladorBase;
	use App\Model\ReservacionModel as MReservacion;
	use App\Model\HabitacionModel as MHabitacion;
	use App\Model\UsuarioModel as MUsuario;
	use App\Model\HuespedModel as MHuesped;
	use App\Model\ProductoModel as MProducto; 
	use App\Model\VentaModel as MVenta;
	use App\Helpers\FormatDate as HFD; 
	use App\Helpers\Security as HS;
	use App\Helpers\Request as HR;
	
	class ProductoController extends ControladorBase
	{
		public function index()
		{
			$this->redirect('index', 'index');
		}

		public function getData()
		{
			@session_start();
			if (HR::is_ajax() && isset($_POST['id_producto'])) 
			{
				$result = MProducto::getBy($_POST['id_producto'])[0];
				if (isset($result)) {
					$data   = array( 
						"idproducto" 	=>  $result->getIdProducto(),
						"nombre" 		=>  $result->getNombre(),
						"descripcion" 	=>  $result->getDescripcion(),
						"medida"		=>	$result->getMedida(),
						"precio"		=>  $result->getPrecio(),
						"stock" 		=>  $result->getStock()
					);
				}
				else
				{
					$data = array('idproducto' => "", );
				}
				
				$data   = json_encode($data);
			    echo $data;	 	   
			}
			else
			{
				$this->redirect();
			}
		}
		
		public function lista()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			$data = array(
				'mensaje' 		=> "",
				'class_mensaje' => "error",
				'productos'		=>	MProducto::all(),
				'datos_template' => array(
					'usuario' 	=> $user, 
					'cantidad'	=> MHuesped::contar(),
					'estado' 	=> MHabitacion::Estado()[0],
					'mensaje' 	=> MReservacion::MensajeReservacion(),
					'agenda'	=> MReservacion::MSAgenda(HFD::Date()),
					'permiso'	=> MReservacion::MSPermiso(HFD::Date())
				)
			);
			$this->view('Productos/Lista', $data);
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
				'nombre'		=> "",
				'descripcion'	=>	"",
				'precio'		=>	"",
				'stock'			=>	"",
				'medida'		=>	"",
				'productos'		=>	MProducto::all(),
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
				$foto_bd = NULL;

				if($_FILES['foto']["error"] == 0)
				{
					$mTmpFile = $_FILES['foto']["tmp_name"];
					$mTipo = exif_imagetype($mTmpFile);
							
					$path_destino = getcwd().DIRECTORY_SEPARATOR;
					$type_array   = explode(".", $_FILES['foto']['name']);						
					$name_img     =  $path_destino . 'img/Producto/' . $_POST['nombre'] . '.' . $type_array[count($type_array) - 1];
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
				if (MProducto::save($_POST['nombre'],$_POST['descripcion'], $_POST['medida'], $_POST['precio'], $_POST['stock'], $foto_bd)) 
				{
					$data['class_mensaje']	=	"exito";
					$data['mensaje']		=	"Se Registro correctamente.";
					$data['nombre']			=	"";
					$data['descripcion']	=	"";
					$data['precio']			=	"";
					$data['stock']			=	"";
					$data['productos']		=	MProducto::all();
				}
				else
				{
					$data['mensaje']		=	"Error al registrar Producto.";
					$data['nombre']			=	$_POST['nombre'];
					$data['descripcion']	=	$_POST['descripcion'];
					$data['precio']			=	$_POST['precio'];
					$data['stock']			=	$_POST['stock'];
				}
			}
			$this->view('Productos/Productos', $data);
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
				'nombre'		=> "",
				'descripcion'	=>	"",
				'precio'		=>	"",
				'stock'			=>	"",
				'productos'		=>	MProducto::all(),
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
				$prod = MProducto::getBy($_POST['id_producto'])[0];
				$foto_bd = $prod->getFoto();

				if($_FILES['foto']["error"] == 0)
				{
					$mTmpFile = $_FILES['foto']["tmp_name"];
					$mTipo = exif_imagetype($mTmpFile);
							
					$path_destino = getcwd().DIRECTORY_SEPARATOR;
					$type_array   = explode(".", $_FILES['foto']['name']);						
					$name_img     =  $path_destino . 'img/Producto/' . $_POST['nombre'] . '.' . $type_array[count($type_array) - 1];
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
				if (MProducto::Update($_POST['id_producto'], $_POST['nombre'],$_POST['descripcion'], $_POST['medida'], $_POST['precio'], $_POST['stock'], $foto_bd)) 
				{
					$data['class_mensaje']	=	"exito";
					$data['mensaje']		=	"Se Actualizo Correctamente Producto.";
					$data['nombre']			=	"";
					$data['descripcion']	=	"";
					$data['precio']			=	"";
					$data['stock']			=	"";
					$data['productos']		=	MProducto::all();
				}
				else
				{
					$data['mensaje']		=	"Error al Actualizar Producto.";
					$data['nombre']			=	$_POST['nombre'];
					$data['descripcion']	=	$_POST['descripcion'];
					$data['precio']			=	$_POST['precio'];
					$data['stock']			=	$_POST['stock'];
				}
			}
			$this->view('Productos/Productos', $data);
		}
	}
