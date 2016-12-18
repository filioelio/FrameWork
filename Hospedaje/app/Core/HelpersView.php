<?php namespace App\Core;
	
	use App\Config\VariablesGlobales;
    use App\Helpers\FormatDate; 

    class HelpersView extends FormatDate
    {
        
        /*		BRINDA EL URL PARA LAS VISTAS 		*/
        
        public  function url($controlador = "", $accion = "", $param = "")
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

            return '<link rel="shortcut icon" href="' . $host_protocol . '/favicon.ico" />
            <link rel="icon" type="image/png" href="' . $host_protocol . '/img/logo.png" />
            <link rel="shortcut icon" href="' . VariablesGlobales::$base_url . '/favicon.ico" />
            <link rel="icon" type="image/png" href="' . VariablesGlobales::$base_url . '/img/logo.png" />';
        }
        
        /*    **    */
        public function color() {
          $frases = array (
            "orange","maroon","navy","olive","purple","aqua","green","red","blue"
          );         
          return $frases[rand(0, count($frases)-1)];
        }

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

        /*   dirname — Devuelve la ruta de un directorio padre */
        public function img_url()
        {
            $path = dirname(__FILE__);
            $url = dirname ($path,2 );
            $url = $url.'\public\img';
            return $url;
        }

        /*  **  */
        
        /*    **    */

        public function Disponible($_nro)
        {
            return "<section id='menu_lista'>
                        <ul>
                            <li>
                                <a href='".$this->url('hospedaje', 'registro',$_nro)."' class='icon-carrito espacio'>
                                    <span class='hasta-movil'>Alquilar</span>
                                    <span class='desde-tablet'>Alquilar</span>
                                </a>
                            </li>
                            <li>
                                <a href='".$this->url('reservacion', 'registro',$_nro)."' class='icon-portafolio espacio'>
                                    <span class='hasta-movil'>Reservar</span>
                                    <span class='desde-tablet'>Reservar</span>
                                </a>
                            </li>
                            <li>
                                <a data-id = '".$_nro."' class='hab_mantemiento icon-aceptar espacio'>
                                    <span class='hasta-movil'>Mantenimiento</span>
                                    <span class='desde-tablet'>Mantenimiento</span>
                                </a>
                            </li>
                        </ul>
                    </section> ";
        }

        public function Ocupado($_nro)
        {
            return "<section id='menu_lista'>
                        <ul>
                            <li>
                                <a href='".$this->url('hospedaje', 'accion',$_nro)."' class='icon-carrito espacio'>
                                    <span class='hasta-movil'>Cuenta</span>
                                    <span class='desde-tablet'>Cuenta</span>
                                </a>
                            </li>
                            <li>
                                <a href='".$this->url('venta', 'ingreso',$_nro)."' class='icon-portafolio espacio'>
                                    <span class='hasta-movil'>Consumo</span>
                                    <span class='desde-tablet'>Consumo</span>
                                </a>
                            </li>".
                            // <li>
                            //     <a href='".$this->url('hospedaje', 'cuenta')."' class='icon-aceptar espacio'>
                            //         <span class='hasta-movil'>Cuenta</span>
                            //         <span class='desde-tablet'>Cuenta</span>
                            //     </a>
                            // </li>
                            "
                            <li>
                                <a href='".$this->url('reservacion', 'registro', $_nro)."' class='icon-portafolio espacio'>
                                    <span class='hasta-movil'>Reservar</span>
                                    <span class='desde-tablet'>Reservar</span>
                                </a>
                            </li>
                        </ul>
                    </section> ";
        }

        public function Reservado($_nro, $_dni,  $id_reservacion)
        {
            return "<section id='menu_lista'>
                        <ul>
                            <li class = 'link_formalizar' data-id='".$_dni."'>
                                <a  href='".$this->url('hospedaje', 'registro',$_nro)."' class='espacio'>
                                    <span class='hasta-movil'>Formalizar</span>
                                    <span class='desde-tablet'>Formalizar</span>
                                </a>
                            </li>
                            <li>
                                <a href='".$this->url('reservacion', 'registro',$_nro)."' class='icon-portafolio espacio'>
                                    <span class='hasta-movil'>Reservar</span>
                                    <span class='desde-tablet'>Reservar</span>
                                </a>
                            </li>
                            <li class = 'link_finalizar' data-id='".$id_reservacion."'>
                                <a class='icon-cerrar espacio'>
                                    <span class='hasta-movil'>Cancelar</span>
                                    <span class='desde-tablet'>Cancelar</span>
                                </a>
                            </li>
                        </ul>
                    </section> ";
        }

        //Helpers para las vistas
    }

/*		FIN CLASS HELPERS PARA LA VISTA		*/
