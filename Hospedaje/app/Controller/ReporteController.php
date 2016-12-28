<?php namespace App\Controller;

	use App\Core\ControladorBase;
	use App\Model\ReservacionModel as MReservacion;
	use App\Model\HabitacionModel as MHabitacion;
	use App\Model\UsuarioModel as MUsuario;
	use App\Model\HuespedModel as MHuesped;
	use App\Model\ReporteModel as MReporte;
	use App\Model\JornadaModel as MJornada;
	use App\Model\GastosModel as MGastos;
	use App\Helpers\FormatDate as HFD;
	use App\Model\PDFModel as MPDF;
	use App\Helpers\Security as HS;
	
	class ReporteController extends ControladorBase
	{
		public function index()
		{
			$this->redirect('index', 'index');
		}

		public function RIngresoToday ($patron = NULL)
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$jornada = MJornada::getIdLast()[0];
			$fecha = $jornada->getFechaIngreso();
			
			$data = array(
				'titulo_view' => "Reporte de Venta Hostal Encanto",
				'titulo_page' => "",
				'colspan'	=> 5,
			);

			$data['cabezeras'] = array(
				"hab",
				"dni",
				"huesped",
				"fecha",
				"monto",
				"usuario"
			);
			$data['cabezeras_venta'] = array(
				"habi",
				"huesped",
				"fecha",
				"nombre",
				"cant",
				"precio",
				"subtotal",
				"usuario"
			);
			$data['cabezeras_reser'] = array(
				"habi",
				"huesped",
				"fecha_reser",
				"fecha_ingreso",
				"descripcion",
				"adelanto",
				"nombre"
			);

			$data['cabezeras_gasto'] = array(
				"Nº",
				"recibe",
				"monto",
				"descripcion",
				"fecha",
				"usuario"
			);


			if ($patron == 'general') {
				$data['reportetodaycompleto'] = true;
				$tipo = "Reporte General de Ingreso del";
				$data['titulo_page'] = "Reporte General de Ingreso del".HFD::FormatDate($fecha);
				$data['titulo_pages'] = HFD::FormatDate($fecha);
				$data['reporte'] = MReporte::HFReporte($fecha);
				$data['ventas'] = MReporte::VPReporteHoy($fecha);
				$data['reservaciones'] = MReporte::RFRepote($fecha);
				$gasto = MGastos::allMajorDate($fecha);
				$gatostoday = 0;
				if (isset($gasto)) {
					foreach ($gasto as $key => $item) {
						$gatostoday += $item->getMonto();
					}
				}
				$data['gatostoday'] = $gatostoday;
				$data['gastos']	= $gasto;
			} elseif ($patron == "hospedaje") {
				$tipo = "Reporte de Hospedaje del";
				$data['titulo_page'] = "Reporte de Hospedaje del".HFD::FormatDate($fecha);
				$data['reporte'] = MReporte::HFReporte($fecha);
			} elseif ($patron == "ventas") {
				$tipo = "Reporte de Ventas del";
				$data['titulo_pages'] = HFD::FormatDate($fecha);
				$data['ventas'] = MReporte::VPReporteHoy($fecha);
			} elseif ($patron == "reservacion") {
				$tipo = "Reporte de reservaciones del";
				$data['titulo_pages'] = HFD::FormatDate($fecha);
				$data['reservaciones'] = MReporte::RFRepote($fecha);
			} elseif ($patron == "gastos") {
				$tipo = "Reporte de Gastos del";
				$data['titulo_pages'] = HFD::FormatDate($fecha);
				$gatostoday = 0;
				$gasto = MGastos::allMajorDate($fecha);
				if (isset($gasto)) {
					foreach ($gasto as $key => $item) {
						$gatostoday += $item->getMonto();
					}
				}
				$data['gatostoday'] = $gatostoday;
				$data['gastos']	= $gasto;
			}

			$dataPdf = $this->renderView('Reportes/PDFReporte', $data);
			MPDF::generar($tipo." ".$fecha, $dataPdf);
		}

		public function RPVenta()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$data = array(
				'titulo_view' => "Reporte de Venta Hostal Encanto",
				'titulo_page' => "",
				'colspan'	  => 3
			);
			$data['cabezeras'] = array(
				"habi",
				"huesped",
				"fecha",
				"nombre",
				"cant",
				"precio",
				"subtotal",
				"usuario"
			);

			if (!empty($_POST) && isset($_POST)) 
			{
				$data['titulo_page'] = "Reporte de Venta Personalizado del ".HFD::FormatDate($_POST['fecha_reporte']);
				$fecha = $_POST['fecha_reporte'];
				$data['reporte'] = MReporte::VPReporte($_POST['fecha_reporte']); 	
			} else 	{
				$date = HFD::Date();
				$data['titulo_page'] = "Reporte del dia ". HFD::FDToday();
				$fecha = $date;
				$data['reporte'] = MReporte::VPReporte($date);
			}

			$dataPdf = $this->renderView('Reportes/PDFReporte', $data);
			MPDF::generar("Reporte de Venta del ".$fecha, $dataPdf);
		}

		public function RGenral($opcion)
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			$data = array(
				'titulo_view' => "Reporte Hostal Encanto",
				'titulo_page' => ""
			);
			
			if ($opcion == 'Hospedaje') 
			{
				$data['cabezeras'] = array(
					"hab",
					"huesped",
					"fecha_ingreso",
					"fecha_salida",
					"dias",
					"precio",
					"costo",
					"usuario"
				);
				$data['colspan'] = 7;
				$data['titulo_page'] = "Reporte General de Hospedaje";
				$data['reporte'] = MReporte::HGReporte(); 				
			}
			elseif ($opcion == 'venta') 
			{
				$data['cabezeras'] = array(
					"habi",
					"huesped",
					"fecha",
					"nombre",
					"cant",
					"precio",
					"subtotal",
					"usuario"
				);
				$data['colspan'] = 7;
				$data['titulo_page'] = "Reporte General de Venta de Productos";
				$data['reporte'] = MReporte::VGReporte(); 
			}

			$dataPdf = $this->renderView('Reportes/PDFReporte', $data);
			MPDF::generar("Reporte General De ". $opcion, $dataPdf);
		}

		public function reporte()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			HS::session_no_iniciada_administrador($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			
			$data = array(
				'mensaje' 		=> "",
				'class_mensaje' => "error",
				'reporte'		=> NULL,
				'usuarios'		=> MUsuario::all(),
				'datos_template' => array(
					'usuario' => $user,
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
				"total",
				"deuda",
				"email"
			);

			if(!empty($_POST) && isset($_POST))
			{
				if ($_POST['opcion']=='hostal') 
				{
					if (isset($_POST['usuario']) && $_POST['usuario'] != "") 
					{
						if (!isset($_POST['inicio']) || !isset($_POST['fin']))
						{
							$data['mensaje'] = "ingrese fecha de inicio y fecha final";
						} else {
							$data['cabezeras'] = array(
								"hab",
								"huesped",
								"fecha_ingreso",
								"fecha_salida",
								"dias",
								"precio",
								"costo",
								"usuario"
							);
							unset($_SESSION['reporte']);
							$data['class_mensaje'] = "exito";
							$data['mensaje'] = "Se Genero Correctamente el Reporte";
							$data['reporte'] = MReporte::HUReporte($_POST['usuario'], $_POST['inicio'], $_POST['fin']); 
							$_SESSION['reporte']['opcion'] = $_POST['opcion'];
							$_SESSION['reporte']['usuario'] = $_POST['usuario'];
							$_SESSION['reporte']['fecha_ini'] = $_POST['inicio'];
							$_SESSION['reporte']['fecha_fin'] = $_POST['fin'];


						}

					} else {

						if (!isset($_POST['inicio']) || !isset($_POST['fin']))
						{
							$data['mensaje'] = "ingrese fecha de inicio y fecha final";
						} else {

							$data['cabezeras'] = array(
								"hab",
								"huesped",
								"fecha_ingreso",
								"fecha_salida",
								"dias",
								"precio",
								"costo",
								"usuario"
							);
							unset($_SESSION['reporte']);
							$data['class_mensaje'] = "exito";
							$data['mensaje'] = "Se Genero Correctamente el Reporte";
							$data['reporte'] = MReporte::HReporte($_POST['inicio'], $_POST['fin']);
							$_SESSION['reporte']['opcion'] = $_POST['opcion'];
							$_SESSION['reporte']['usuario'] = NULL;
							$_SESSION['reporte']['fecha_ini'] = $_POST['inicio'];
							$_SESSION['reporte']['fecha_fin'] = $_POST['fin'];
						}

					}
				}
				elseif ($_POST['opcion']=='productos' ) 
				{
					if (isset($_POST['usuario']) && $_POST['usuario'] != "") 
					{
						if (!isset($_POST['inicio']) || !isset($_POST['fin']))
						{
							$data['mensaje'] = "ingrese fecha de inicio y fecha final";
						} else {
							$data['cabezeras'] = array(
								"habi",
								"huesped",
								"fecha",
								"nombre",
								"cant",
								"precio",
								"subtotal",
								"usuario"

							);
							unset($_SESSION['reporte']);
							$data['class_mensaje'] = "exito";
							$data['mensaje'] = "Se Genero Correctamente el Reporte";
							$data['reporte'] = MReporte::PUReporte($_POST['usuario'], $_POST['inicio'], $_POST['fin']);
							$_SESSION['reporte']['opcion'] = $_POST['opcion'];
							$_SESSION['reporte']['usuario'] = $_POST['usuario'];
							$_SESSION['reporte']['fecha_ini'] = $_POST['inicio'];
							$_SESSION['reporte']['fecha_fin'] = $_POST['fin'];
						}
					} else {
						
						if (!isset($_POST['inicio']) || !isset($_POST['fin']))
						{
							$data['mensaje'] = "ingrese fecha de inicio y fecha final";
						} else {
							$data['cabezeras'] = array(
								"habi",
								"huesped",
								"fecha",
								"nombre",
								"cant",
								"precio",
								"subtotal",
								"usuario"
							);
							unset($_SESSION['reporte']);
							$data['colspan'] = 2;
							$data['class_mensaje'] = "exito";
							$data['mensaje'] = "Se Genero Correctamente el Reporte";
							$data['reporte'] = MReporte::PReporte($_POST['inicio'], $_POST['fin']);
							$_SESSION['reporte']['opcion'] = $_POST['opcion'];
							$_SESSION['reporte']['usuario'] = NULL;
							$_SESSION['reporte']['fecha_ini'] = $_POST['inicio'];
							$_SESSION['reporte']['fecha_fin'] = $_POST['fin'];
						}
					}
				}
				elseif ($_POST['opcion']=='dventa' ) 
				{
					if (isset($_POST['usuario']) && $_POST['usuario'] != "") 
					{
						if (!isset($_POST['inicio']) || !isset($_POST['fin']))
						{
							$data['mensaje'] = "ingrese fecha de inicio y fecha final";
						} else {
							$data['cabezeras'] = array(
								"habi",
								"huesped",
								"fecha",
								"nombre",
								"cant",
								"precio",
								"subtotal",
								"usuario"
							);
							unset($_SESSION['reporte']);
							$data['class_mensaje'] = "exito";
							$data['mensaje'] = "Se Genero Correctamente el Reporte";
							$data['reporte'] = MReporte::PUDVReporte($_POST['usuario'], $_POST['inicio'], $_POST['fin']);
							$_SESSION['reporte']['opcion'] = $_POST['opcion'];
							$_SESSION['reporte']['usuario'] = $_POST['usuario'];
							$_SESSION['reporte']['fecha_ini'] = $_POST['inicio'];
							$_SESSION['reporte']['fecha_fin'] = $_POST['fin'];
						}
					} else {
						
						if (!isset($_POST['inicio']) || !isset($_POST['fin']))
						{
							$data['mensaje'] = "ingrese fecha de inicio y fecha final";
						} else {
							$data['cabezeras'] = array(
								"habi",
								"huesped",
								"fecha",
								"nombre",
								"cant",
								"precio",
								"subtotal",
								"usuario"
							);
							unset($_SESSION['reporte']);
							$data['class_mensaje'] = "exito";
							$data['mensaje'] = "Se Genero Correctamente el Reporte";
							$data['reporte'] = MReporte::PDVReporte($_POST['inicio'], $_POST['fin']);
							$_SESSION['reporte']['opcion'] = $_POST['opcion'];
							$_SESSION['reporte']['usuario'] = NULL;
							$_SESSION['reporte']['fecha_ini'] = $_POST['inicio'];
							$_SESSION['reporte']['fecha_fin'] = $_POST['fin'];
						}
					}
				}
			}
			
			$this->view('Reportes/Reporte', $data);
		}

		public function renderPDF()
		{
			@session_start();

			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];

			if(! isset($_SESSION['reporte']['opcion']) && !isset($_SESSION['reporte']['fecha_ini']) && !isset($_SESSION['reporte']['fecha_fin'])) $this->redirect('index', 'index');			
							
			$tipo = $_SESSION['reporte']['opcion'];
			$usuario = $_SESSION['reporte']['usuario'];
			$fecha_ini = $_SESSION['reporte']['fecha_ini'];
			$fecha_fin = $_SESSION['reporte']['fecha_fin'];

			$data = array(
				'titulo_view' => "Reporte Hostal Encanto",
				'titulo_page' => ""
			);

			if ($tipo =='hostal') 
			{
				if (isset($usuario) && $usuario != "") 
				{
					if (isset($fecha_ini) && isset($fecha_fin))
					{
						$data['cabezeras'] = array(
							"hab",
							"huesped",
							"fecha_ingreso",
							"fecha_salida",
							"dias",
							"precio",
							"costo",
							"usuario"
						);
						$data['colspan'] = 7;
						$data['titulo_page'] = "Reporte de Hospedaje del ".$fecha_ini." al ".$fecha_fin;
						$data['reporte'] = MReporte::HUReporte($usuario, $fecha_ini, $fecha_fin); 
					}

				} else {

					if (isset($fecha_ini) && isset($fecha_fin))
					{
						$data['cabezeras'] = array(
							"hab",
							"huesped",
							"fecha_ingreso",
							"fecha_salida",
							"dias",
							"precio",
							"costo",
							"usuario"
						);
						$data['colspan'] = 7;
						$data['titulo_page'] = "Reporte de Hospedaje del ".$fecha_ini." al ".$fecha_fin;
						$data['reporte'] = MReporte::HReporte($fecha_ini, $fecha_fin);
					}
				}
			}
			elseif ($tipo=='productos' ) 
			{
				if (isset($usuario) && $usuario != "") 
				{
					if (isset($fecha_ini) && isset($fecha_fin))
					{
						$data['cabezeras'] = array(
							"habi",
							"huesped",
							"fecha",
							"nombre",
							"cant",
							"precio",
							"subtotal",
							"usuario"
						);
						$data['colspan'] = 3;
						$data['titulo_page'] ="Reporte de Venta de Productos del ".$fecha_ini." al ".$fecha_fin;
						$data['reporte'] = MReporte::PUReporte($usuario, $fecha_ini, $fecha_fin);
					}
				} else {
						
					if (isset($fecha_ini) && isset($fecha_fin))
					{						
						$data['cabezeras'] = array(
							"habi",
							"huesped",
							"fecha",
							"nombre",
							"cant",
							"precio",
							"subtotal",
							"usuario"
						);
						$data['colspan'] = 3;
						$data['titulo_page'] ="Reporte de Venta de Productos del ".$fecha_ini." al ".$fecha_fin;
						$data['reporte'] = MReporte::PReporte($fecha_ini, $fecha_fin);
					}
				}
			}
			elseif ($tipo=='dventa' )   
			{
				if (isset($usuario) && $usuario != "") 
				{
					if (isset($fecha_ini) && isset($fecha_fin))
					{
						$data['cabezeras'] = array(
							"habi",
							"huesped",
							"fecha",
							"nombre",
							"cant",
							"precio",
							"subtotal",
							"usuario"
						);
						$data['colspan'] = 7;
						$data['titulo_page'] ="Reporte de Detalle Venta del ".$fecha_ini." al ".$fecha_fin;
						$data['reporte'] = MReporte::PUDVReporte($usuario, $fecha_ini, $fecha_fin);
					}
				} else {
						
					if (isset($fecha_ini) && isset($fecha_fin))
					{						
						$data['cabezeras'] = array(
							"habi",
							"huesped",
							"fecha",
							"nombre",
							"cant",
							"precio",
							"subtotal",
							"usuario"
						);
						$data['colspan'] = 7;
						$data['titulo_page'] ="Reporte de Venta de Productos del ".$fecha_ini." al ".$fecha_fin;
						$data['reporte'] = MReporte::PDVReporte($fecha_ini, $fecha_fin);
					}
				}
			}

			$dataPdf = $this->renderView('Reportes/PDFReporte', $data);
			MPDF::generar("Reporte De ". $tipo . " Del " . $fecha_ini . " Al " . $fecha_fin, $dataPdf);
		}
	}