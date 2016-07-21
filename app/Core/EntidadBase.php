<?php namespace App\Core;
    
    use App\Core\Conectar;

    class EntidadBase
    {

        /*        CONSTRUCTOR         */
        
        public function __construct($table) 
        {
            $this->table    = (string) $table;
            
            $this->conectar = new Conectar();
            $this->db       = $this->conectar->conexion();
        }
        
        /*    **    */

        /*        TABLA CON LA QUE TRABAJARA         */
        
        private $table;

        public function table()
        {
            return $this->table;
        }
        
        /*    **    */

        /*        BASE DE DATOS A LA QUE SE CONECTARA         */
        
        private $db;

        public function db()
        {
            return $this->db;
        }
        
        /*    **    */

        /*        CONEXION & CONECTAR         */
        
        private $conectar;

        public function getConectar()
        {
            return $this->conectar;
        }
        
        /*    **    */
        
        

        /*        OBTIENE TODOS LOS ELEMENTOS         */
            
        public function getAll($class_name = "stdClass")
        {
            $query = $this
                        ->db
                        ->query("SELECT * FROM $this->table ORDER BY id_$this->table DESC");

            while ($row = $query->fetch_object($class_name)) 
            {
               $resultSet[] = $row;
            }
            return @$resultSet;
        }    
            
        /*    **    */    
        
        /*        OBTIENE UN ELEMENTO POR SU ID         */
        
        public function getById($id, $class_name = "stdClass")
        {
            $query = $this
                        ->db
                        ->query("SELECT * FROM $this->table WHERE id_$this->table = ('$id')");

            if($row = $query->fetch_object($class_name)) 
            {
               $resultSet = $row;
            }
            
            return @$resultSet;
        }
        
        /*    **    */
        
        
        /*        OBTIENE UN ELEMENTO POR SU COLUMNA Y VALOR         */
        
        public function getBy($column, $value, $class_name = "stdClass")
        {
            $query = $this
                        ->db
                        ->query("SELECT * FROM $this->table WHERE $column='$value'");

            while($row = $query->fetch_object($class_name)) 
            {
               $resultSet[] = $row;
            }
            
            return @$resultSet;
        }
        
        /*    **    */
        
        /*        ELIMINA UN ELEMENTO POR SU ID         */
        
        public function deleteById($id){
            $query = $this
                        ->db
                        ->query("DELETE FROM $this->table WHERE id_$this->table=$id"); 
            return $query;
        }
        
        /*    **    */
        
        /*        ELIMINA UN ELEMENTO POR SU COLUMNA Y VALOR         */
        
        public function deleteBy($column, $value)
        {
            $query = $this
                        ->db
                        ->query("DELETE FROM $this->table WHERE $column='$value'"); 
            return $query;
        }
        
        /*    **    */
        

        /*
         * Aqui podemos montarnos un monton de métodos que nos ayuden
         * a hacer operaciones con la base de datos de la entidad
         */
        
    }
/*        FIN CLASS ENTIDAD BASE        */
