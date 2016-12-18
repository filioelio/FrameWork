<?php namespace App\Controller;

	use App\Core\ControladorBase;
	use App\Model\ReservacionModel as MReservacion;
	use App\Model\HabitacionModel as MHabitacion;
	use App\Model\UsuarioModel as MUsuario;
	use App\Model\HuespedModel as MHuesped;
	use App\Model\GastosModel as MGastos;
	use App\Helpers\FormatDate as HFD;
	use App\Model\PDFModel as MPDF;
	use App\Helpers\Security as HS;
	use App\Helpers\Request as HR;
	
	class GastosController extends ControladorBase
	{
		public function index()
		{
			$this->redirect('index', 'index');
		}

		public function getData()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['id_gasto'])) 
			{
				$result = MGastos::getId($_POST['id_gasto']);
				if (isset($result)) {
					$data   = array( 
						'exito'		=> true,
						'recibe'	=> $result->getRecibe(),
						'monto'		=> $result->getMonto(),
						'descri'	=> $result->geTDescripcion()
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

		public function nuevo()
		{
			session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'recibe'		=> "",
				'monto'			=> "",
				'descripcion'	=> "",
				'gastos'		=> MGastos::all(),
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
				if (MGastos::save($_POST['recibe'],"", $_POST['monto'], $_POST['descripcion'], $user->getIdUsuario())) 
				{
					$data['class_mensaje'] 	= "exito";
					$data['mensaje'] 		= "Se Registro Correctamente";
					$data['gastos']			= MGastos::all();
				}
				else
				{
					$data['mensaje']		= "Error al Registrar Gasto";
					$data['recibe']			= $_POST['recibe'];
					$data['monto']			= $_POST['monto'];
					$data['descripcion'] 	= $_POST['descripcion'];
				}
			}

			$this->view('Gastos/Registro', $data);
		}

		public function update($id)
		{
			session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			$data = array(
				'mensaje'		=>"",
				'class_mensaje'	=> "error", //exito o error
				'recibe'		=> "",
				'monto'			=> "",
				'descripcion'	=> "",
				'gastos'		=> MGastos::all(),
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
				if (MGastos::update($id, $_POST['recibe'], $_POST['monto'], $_POST['descripcion'], $user->getIdUsuario())) 
				{
					$data['class_mensaje'] 	= "exito";
					$data['mensaje'] 		= "Se Modifico Correctamente";
					$data['gastos']			= MGastos::all();
				}
				else
				{
					$data['mensaje']		= "Error al Modificar Gasto";
					$data['recibe']			= $_POST['recibe'];
					$data['monto']			= $_POST['monto'];
					$data['descripcion'] 	= $_POST['descripcion'];
				}
			}

			$this->view('Gastos/Registro', $data);
		}

		public function ReportDay($pdfTotal = NULL)
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			$data = array(
				'titulo_view' => "Reporte Hostal Encanto",
				'titulo_page' => "",
			);
			
			$data['cabezeras_gasto'] = array(
				"Nº",
				"recibe",
				"monto",
				"descripcion",
				"fecha",
				"usuario"
			);
			if(!empty($_POST) && isset($_POST))
			{
				$nombre = "Reporte de Gastos del ".HFD::FormatDate($_POST['fecha']);
				$data['titulo_page'] = HFD::FormatDate($_POST['fecha']);
				$gasto = MGastos::allFecha($_POST['fecha']); 
				$gatostoday = 0;
				foreach ($gasto as $key => $item) {
					$gatostoday += $item->getMonto();
				}
				$data['gatostoday'] = $gatostoday;
				$data['gastos']	= $gasto;	
							
			} elseif (isset($pdfTotal)) {
				$nombre = "Reporte General de Gastos";
				$data['titulo_page'] = "- Reporte  General de Gastos";
				$gasto = MGastos::all(); 
				$gatostoday = 0;
				foreach ($gasto as $key => $item) {
					$gatostoday += $item->getMonto();
				}
				$data['gatostoday'] = $gatostoday;
				$data['gastos']	= $gasto;
			
			} else {
				$nombre = "Reporte de Gastos del ".HFD::FDToday();
				$data['titulo_page'] = HFD::FDToday();
				$gasto = MGastos::allFecha(HFD::Date()); 
				$gatostoday = 0;
				foreach ($gasto as $key => $item) {
					$gatostoday += $item->getMonto();
				}
				$data['gatostoday'] = $gatostoday;
				$data['gastos']	= $gasto;
			}

			$dataPdf = $this->renderView('Reportes/PDFReporte', $data);
			MPDF::generar($nombre, $dataPdf);
		}
	}