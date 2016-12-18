<?php namespace App\Controller;

	use App\Core\ControladorBase;
	use App\Model\ReservacionModel as MReservacion;
	use App\Model\HabitacionModel as MHabitacion;
	use App\Model\UsuarioModel as MUsuario;
	use App\Model\HuespedModel as MHuesped;
	use App\Model\VentaModel as MVenta;
	use App\Helpers\FormatDate as HFD;
	use App\Helpers\Security as HS;
	use App\Helpers\Request as HR;
	
	class VentaController extends ControladorBase
	{
		public function index()
		{
			$this->redirect('index', 'index');
		}

		public function RegistrarVenta()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['total'])) 
			{
				$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
				$array = $_POST['array'];
				
				if (MVenta::save($_POST['total'], '', $_POST['deuda'], $user->getIdUsuario(), $_POST['id_hospedaje'])) {
					$id_venta = MVenta::max_id()[0];					
					$codigo = $id_venta->id;

					if (isset($array)) 
					{	
						foreach ($array as $key => $item) {

							if (MVenta::save_detalle($item[5], $item[6], $codigo, $item[1])) 
							{
								$data = array(
									'codigo' 	=> $codigo,
									'mensaje'	=> 'Se registro correctamente la venta'
								);
							} else {
								$data = array(
									'codigo' 	=> $codigo,
									'mensaje'	=> 'Exito al Registro venta; Error al registrar detalle venta : '
								);
							}					
						}
					}										
				}
				else
				{
					$data = array(
							'codigo' 	=> '',
							'mensaje'	=> 'Error al Registrar Venta :'.$_POST['deuda'].' : '. $_POST['id_hospedaje']
					);
				}

				$data   = json_encode($data);
			    echo $data;	    
			}
			else
			{
				$this->redirect();
			}
		}

		public function getVenta()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['id_venta'])) 
			{
				$result = MVenta::select_venta($_POST['id_venta'])[0];
				if (isset($result)) 
				{
					unset($_SESSION['venta']);
					$data = array(
						'estado' 		=> true,
						'id_venta'		=> $result->id_venta,
						'id_habitacion' => $result->id_habitacion,
						'huesped'		=> $result->huesped,
						'fecha'			=> HFD::FormatDateTime($result->fecha),
						'total'			=> $result->total,
						'deuda' 		=> $result->deuda,
						'usuario'		=> $result->usuario
					 );			
					 $_SESSION['venta']['deuda']	= $result->deuda;		
				}
				else
				{
					$data = array(
						'estado' => false
					 );	
				}
				
				$data   = json_encode($data);
			    echo $data;	    
			}
			else
			{
				$this->redirect();
			}
		}

		public function getDetalleVenta()
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			if (HR::is_ajax() && isset($_POST['id_venta'])) 
			{
				$result = MVenta::allBy($_POST['id_venta']);
				if (isset($result)) 
				{
					$data = array(
						'estado' => true,
						'array'	=> $result
					 );					
				}
				else
				{
					$data = array(
						'estado' => false
					 );	
				}

				$data   = json_encode($data);
			    echo $data;	    
			}
			else
			{
				$this->redirect();
			}
		}

		public function ingreso($id_habitacion = NULL)
		{
			@session_start();
			HS::sesion_no_iniciada($this);
			$user = MUsuario::getEmail($_SESSION['user']['email'])[0];
			if (isset($id_habitacion)) {
				$venta = MVenta::VentaHabitacionId($id_habitacion);
				$_hab = $id_habitacion;
			} else {
				$venta = MVenta::all();
				$_hab = "";
			}
			
			$data = array(
				'mensaje' 		=> "",
				'class_mensaje' => "error",
				'ventas'		=> $venta,
				'_hab'			=> $_hab,
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
				"nombre",
				"descripcion",
				"medida",
				"precio",
				"cantidad",
				"subtotal"
			);

			if (!empty($_POST) && isset($_POST))
			{
				if (isset( $_SESSION['venta']['deuda'])) 
				{
					$newmonto = $_SESSION['venta']['deuda']-$_POST['deuda'];

					if (MVenta::update($_POST['id_venta'], $newmonto )) 
					{
						$data['mensaje'] = 'Se Modidico correctamente';
						$data['class_mensaje'] = 'exito';
						if (isset($id_habitacion)) {
							$venta = MVenta::VentaHabitacionId($id_habitacion);
						} else {
							$venta = MVenta::all();
						}
						$data['ventas'] = $venta;
					}
					else
					{
						$data['mensaje'] = 'error al modificar venta';
					}
				}
			}

			$this->view('Productos/Consumo', $data);
		}
		
	}

