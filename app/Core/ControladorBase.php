<?php namespace App\Core;

    use App\Config\VariablesGlobales;
 

    class ControladorBase
    {

        /*        CONSTRUCTOR         */
        
        public function __construct() 
        {
            
        }
        
        /*    **    */

        /*        MONTAR LA VISTA         */
        
        public function view($vista, $datos = array())
        {
            foreach ($datos as $id_assoc => $valor) 
            {
                ${$id_assoc} = $valor; 
            }

            $helper = new HelpersView();
            
            require_once '../app/View/' . $vista . 'View.php';
        }       
        
        /*    **    */

        /*        REDIRECCIONAMIENTO DINAMICO         */
        
        public function redirect($controlador = "", $accion = "", $args = NULL)
        {
            $controlador = $controlador == "" ? VariablesGlobales::$controlador_defecto : $controlador;
            $accion      = $accion == "" ?VariablesGlobales::$accion_defecto : $accion;

            if ( ! isset($args))
            {
                header("Location:" . VariablesGlobales::$base_url . $controlador . "/" . $accion);
            }
            else
            {
                header("Location:" . VariablesGlobales::$base_url . $controlador . "/" . $accion . "/" . $args);
            }
        }
        
        /*    **    */
        
        //Métodos para los controladores

    }
/*        FIN CLASS CONTROLADOR BASE        */