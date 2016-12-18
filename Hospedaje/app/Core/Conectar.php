<?php namespace App\Core;

    use App\Config\DataBase;
    use Mysqli;

    class Conectar
    {

        /*        DRIVER CONEXION         */
        
        private $driver;
        
        /*    **    */

        /*      HOST        */
            
        private $host;
        
        /*  **  */
        
        /*      USUARIO BD      */
        
        private $user;
        
        /*  **  */
        
        /*      CONTRASEÑA BD       */
        
        private $pass;
        
        /*  **  */
        
        /*      NOMBRE DE LA BD         */
        
        private $database;
        
        /*  **  */
        
        /*      CHARSET         */
        
        private $charset;
        
        /*  **  */
        
        /*        CONSTRUCTOR         */
        
        public function __construct() 
        {
            $this->driver   = DataBase::$driver;
            $this->host     = DataBase::$host;
            $this->user     = DataBase::$user;
            $this->pass     = DataBase::$pass;
            $this->database = DataBase::$database;
            $this->charset  = DataBase::$charset;
        }
        
        /*    **    */
        
        
        /*        CONEXION         */
        
        public function conexion()
        {
            
            if( $this->driver == "mysql" || $this->driver == null )
            {
                $con = new Mysqli(
                        $this->host, 
                        $this->user, 
                        $this->pass, 
                        $this->database
                    );

                $con->query("SET NAMES '" . $this->charset . "'");
            }
            
            return $con;
        }
        
        /*    **    */
        
    }
    /*        FIN CLASS CONECTAR        */
