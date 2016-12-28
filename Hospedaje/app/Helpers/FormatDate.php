<?php namespace App\Helpers;
	
    use App\Model\Clase\Habitacion as CHabitacion;
    
	class FormatDate 
	{
        function __construct()
        {}

        static $meses = array( 
            1  => 'Enero',
            2  => 'Febrero',
            3  => 'Marzo',
            4  => 'Abril',
            5  => 'Mayo',
            6  => 'Junio',
            7  => 'Julio',
            8  => 'Agosto',
            9  => 'Setiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        );

		/*		FECHA  DATE		*/
		
		public static function Date() 
		{
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
			return $date;
		}
		
		/*	**	*/

        /*      DATE TIME       */
        
        public static function DateTime() 
        {
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d H:i:s');
            return $date;
        }
        
        /*  **  */

		/*	SOLO FORMATO FECHA	*/
		public function FormatDate($fecha)
        {
            
            $date_time = explode(" ", $fecha);
            $date      = explode('-', $date_time[0]);
            
            return $date[2] . ' de ' . self::$meses[intval($date[1])] . ' del ' . $date[0];
        }
		
		/*	**	*/

		/* FORMATODO FECHA  Y HORA	*/
		public function FormatDateTime($fecha)
        {

            $date_time = explode(" ", $fecha);
            $date      = explode('-', $date_time[0]);
            $time      = explode(':', $date_time[1]);
            
            return $date[2] . ' de ' . self::$meses[intval($date[1])] . ' del ' . $date[0] . ' ' . $time[0] . ':' . $time[1];
        }
		
		/*	**	*/

        /*  SOLO FORMATO FECHA  */
        public function FDToday()
        {
            $date_time = explode(" ", self::Date());
            $date      = explode('-', $date_time[0]);
            
            return $date[2] . ' de ' . self::$meses[intval($date[1])] . ' del ' . $date[0];
        }
        
        /*  **  */

        /* FORMATODO FECHA  Y HORA  */
        public function FDTToday()
        {

            $date_time = explode(" ", self::DateTime());
            $date      = explode('-', $date_time[0]);
            $time      = explode(':', $date_time[1]);
            
            return $date[2].' de '.self::$meses[intval($date[1])].' del '.$date[0].' '.$time[0]. ':'. $time[1];
        }
        
        /*  **  */

        public function EstadoHospedaje($id_hos, $f_salida)
        {
            $date_time = explode(" ", $f_salida);
            $date      = explode('-', $date_time[0]);
            $time      = explode(':', $date_time[1]);

            if ($time[0]== 00) 
            {
                return "<td data-id='".$id_hos."' class='tools LinkVerH' data-toggle='modal' data-target='.DatosHuesped'>
                            <i class='fa fa-edit text-green'> Activo</i>
                        </td>" ;
            } else {
                return "<td data-id='".$id_hos."' class='tools LinkVerH' data-toggle='modal' data-target='.DatosHuesped'>
                            <i class='fa fa-edit text-blue'> Ver</i>
                        </td>" ; 
            }
        }

        function foto($foto)
        {
            $c_habitacion = new CHabitacion();
            $c_habitacion->setFoto($foto);
            return $c_habitacion->getFoto(true);
        }
    }