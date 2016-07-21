<?php namespace App\Core;

    class ModeloBase extends EntidadBase
    {

        /*        CONSTRUCTOR         */
        
        public function __construct($table) 
        {
            $this->table = (string) $table;
            parent::__construct($table);
        }
        
        /*    **    */

        /*        TABLA CON LA QUE TRABAJARA         */
        
        private $table;
        
        /*    **    */
        
        /*        EJECUTA UNA CONSULTA         */
        
        public function runSql($query, $class_name = "stdClass")
        {
            $query = $this
                        ->db()
                        ->query($query);

            if ($query == true)
            {
                if (@$query->num_rows > 1)
                {
                    while ($row = $query->fetch_object($class_name)) 
                    {
                       $resultSet[] = $row;
                    }
                }
                elseif (@$query->num_rows == 1)
                {
                    if ($row = $query->fetch_object($class_name)) 
                    {
                        $resultSet = $row;
                    }
                }
                else
                {
                    $resultSet = true;
                }
            }
            else
            {
                $resultSet = false;
            }
            
            return $resultSet;
        }
        
        /*    **    */  
        
        //Aqui podemos agregar metodos para los modelos de consulta
        
    }

/*        FIN CLASS MODELO BASE        */