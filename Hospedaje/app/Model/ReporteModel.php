<?php namespace App\Model;

	use App\Model\Action\Reporte as AReporte;

	class ReporteModel
	{
		public function VPReporte($fecha)
		{
			$a_reporte = new AReporte();
			$reporte = $a_reporte->VPReporte($fecha);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}

		public function VPReporteHoy($fecha)
		{
			$a_reporte = new AReporte();
			$reporte = $a_reporte->VPReporteHoy($fecha);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}

		public function RFRepote($fecha)
		{
			// "REPORTE DE RESERVACIONES DE UNA FECHA UNICA"
			$a_reporte = new AReporte();
			$reporte = $a_reporte->RFRepote($fecha);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}


		public function RDFRepote($fecha_inicio, $fecha_fin)
		{
			// "REPORTE ENTRE DOS FECHAS DE RESERVACIONES";
			$a_reporte = new AReporte();
			$reporte = $a_reporte->RDFRepote($fecha);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}

		public function RGRepote()
		{
			// "REPORTE GENERAL DE RESERVACIONES";
			$a_reporte = new AReporte();
			$reporte = $a_reporte->RGRepote($fecha);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}

		public function HFReporte($fecha)
		{
			// "REPORTE DE HOSPEDAJE DE UNA SOLA FECHA"
			$a_reporte = new AReporte();
			$reporte = $a_reporte->HFReporte($fecha);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}

		public function HUReporte($id_hueped, $fecha_inicio, $fecha_fin)
		{
			// "REPORTE DE HOSPEDAJE DE UN USUARIO ENTRE DOS FECHAS"
			$a_reporte = new AReporte();
			$reporte = $a_reporte->HUReporte($id_hueped, $fecha_inicio, $fecha_fin);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}

		public function HReporte($fecha_inicio, $fecha_fin)
		{
			// "REPORTE DE HOSPEDAJE ENTRE DOS FECHAS"
			$a_reporte = new AReporte();
			$reporte = $a_reporte->HReporte($fecha_inicio, $fecha_fin);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}

		public function PUReporte($id_hueped, $fecha_inicio, $fecha_fin)
		{
			// "REPORTE DE VENTA DE PRODUCTO CON USUARIO ENTRE DOS FECHAS"
			$a_reporte = new AReporte();
			$reporte = $a_reporte->PUReporte($id_hueped, $fecha_inicio, $fecha_fin);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}

		public function PReporte($fecha_inicio, $fecha_fin)
		{
			// "REPORTE DE VENTE DE PRODUCTO ENTRE DOS FECHAS"
			$a_reporte = new AReporte();
			$reporte = $a_reporte->PReporte($fecha_inicio, $fecha_fin);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;

		}

		public function PUDVReporte($id_hueped, $fecha_inicio, $fecha_fin)
		{
			// "REPORTE DE DETALLE VENTA DE UN USUARIO ENTRE DOS FECHAS"
			$a_reporte = new AReporte();
			$reporte = $a_reporte->PUDVReporte($id_hueped, $fecha_inicio, $fecha_fin);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;

		}

		public function PDVReporte($fecha_inicio, $fecha_fin)
		{
			// "REPORTE DE DETALLE VENTA ENTRE DOS FECHAS"
			$a_reporte = new AReporte();
			$reporte = $a_reporte->PDVReporte($fecha_inicio, $fecha_fin);
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}

		public function HGReporte()
		{
			// "REPORTE GENERAL FE HOSPEDAJE"
			$a_reporte = new AReporte();
			$reporte = $a_reporte->HGReporte();
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}

		public function VGReporte()
		{
			// "REPORTE GENERAL DE VENTA DE PRODUCTO"
			$a_reporte = new AReporte();
			$reporte = $a_reporte->VGReporte();
			if(isset($reporte) && (is_array($reporte) || is_object($reporte)))
			{
				if(is_object($reporte))
				{
					$reporte = array($reporte);
				}
				$reporte = $reporte;
			}
			return $reporte;
		}
	}
