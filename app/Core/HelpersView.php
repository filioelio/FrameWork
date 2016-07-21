<?php namespace App\Core;
	
	use App\Config\VariablesGlobales;

    class HelpersView
    {
        
        /*		BRINDA EL URL PARA LAS VISTAS 		*/
        
        public function url($controlador = "", $accion = "", $param = "")
        {
            $controlador = $controlador == "" ? VariablesGlobales::$controlador_defecto : $controlador;
            $accion      = $accion == "" ?VariablesGlobales::$accion_defecto : $accion;
            
            $urlString   = VariablesGlobales::$base_url . "/" . $controlador . "/" . $accion . "/" . $param;
            return $urlString;
        }
        
        public function base_url() 
        {
            return VariablesGlobales::$base_url;
        }

        /*	**	*/

        /*        BJ FAVICON         */
        
        public function favicon()
        {
            $protocol      = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $domainName    = $_SERVER['HTTP_HOST'].'/';
            $host_protocol = $protocol.$domainName;

            return '<link rel="shortcut icon" href="' . $host_protocol . 'favicon.ico" />
            <link rel="icon" type="image/png" href="' . $host_protocol . 'img/logo.png" />
            <link rel="shortcut icon" href="' . VariablesGlobales::$base_url . 'favicon.ico" />
            <link rel="icon" type="image/png" href="' . VariablesGlobales::$base_url . 'img/logo.png" />';
        }
        
        /*    **    */
        

        /*        LINKER CSS         */
        
        public function css($css_name)
        {
            return "<link rel='stylesheet' href='" . VariablesGlobales::$base_url . "/css/$css_name.css'>";
        }
        
        /*    **    */
        /*        LINKER JS         */
        
        public function js($js_name)
        {
            return "<script src='" . VariablesGlobales::$base_url . "/js/$js_name.js'></script>";
        }
        
        /*    **    */

        /*        CONVERT FECHA AMIGABLE         */
        
        public function fecha_amigable($fecha)
        {
            $meses = array( 
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
            //intval
            $date_time = explode(" ", $fecha);
            $date      = explode('-', $date_time[0]);
            $time      = explode(':', $date_time[1]);
            
            return $date[2] . ' de ' . $meses[intval($date[1])] . ' del ' . $date[0] . ' ' . $time[0] . ':' . $time[1];
        }
        
        /*    **    */

        //Helpers para las vistas
    }

/*		FIN CLASS HELPERS PARA LA VISTA		*/
