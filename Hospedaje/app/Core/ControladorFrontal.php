<?php namespace App\Core;
    
    use App\Config\VariablesGlobales;

    class ControladorFrontal 
    {
        /*        FUNCION CARGA CONTRALADOR         */
        
        function cargarControlador($controller)
        {
            $controlador = "App\\Controller\\" . ucwords($controller) . 'Controller';
            
            if( ! class_exists($controlador))
            {
                $controlador = "App\\Controller\\" . ucwords(VariablesGlobales::$controlador_defecto) . 'Controller';   
            }
            

            return new $controlador();
        }
        
        /*    **    */

        /*        CARGAR ACCION         */
        
        function cargarAccion($controllerObj, $action)
        {
            $accion = $action;

            if (isset($_GET['args']))
            {
                $controllerObj->$accion($_GET['args']);
            }
            else
            {
                $controllerObj->$accion();
            }
        }
        
        /*    **    */

        /*        LANZAR ACCTION         */
        
        function lanzarAccion($controllerObj)
        {
            if( isset($_GET["action"]) && method_exists($controllerObj, $_GET["action"]) )
            {
                $this->cargarAccion($controllerObj, $_GET["action"]);
            }
            else
            {
                $this->cargarAccion($controllerObj, VariablesGlobales::$accion_defecto);
            }
        }
        
        /*    **    */
    }

/*        FIN CLASS CONTROLADOR FRONTAL        */
