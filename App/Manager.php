<?php
    namespace App;
    
    use Model\BDD\DAO;
    
    define("ENTITY_NS", "Model\Entities\\");
   
    /**
     * Base abstract class for all Managers classes.
     * 
     * @method connect() Allow to connect to the database.
     * @method findAll() Get all records of a database table.
     * @method findOneById() Get one record based on `id_<tableName>` field.
     * @method add() Perform one 'INSERT INTO' query.
     * @method getMultipleResults() Convert raw SQL response to an array of objects.
     * @method getOneOrNullResult() Convert raw SQL response to one object.
     */
    abstract class Manager{
        
        // ---- METHODS ----
        
        /**
         * Connect to the database.
         */
        protected function connect()
        {
            DAO::connect();
        }
                
        /**
         * Get all records of a database table.
         *
         * @return array|null All records, or 'null' if none.
         */
        public function findAll()
        {
            $sql = "SELECT *
                    FROM " . $this->tableName . " a";

            return $this->getMultipleResults(
                DAO::select($sql),
                $this->className
            );
        }
        
        /**
         * Get one record based on id_'tableName' field.
         *
         * @param mixed $id The requested ID.
         * @return class An object of a type based on the name of the table, or 'false' if there is no record.
         */
        public function findOneById($id)
        {
            $sql = "SELECT *
                    FROM " . $this->tableName . " a
                    WHERE a.id_" . $this->tableName . " = :id";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['id' => $id], false), 
                $this->className
            );
        }
        
        /**
         * Perform an 'INSERT INTO' query based on $data.
         *
         * @param array $data Data of the new record.
         * @return int The number of affected rows in the database.
         */
        public function add($data)
        {
            $keys = array_keys($data);
            $values = array_values($data);
            $sql = "INSERT INTO " . $this->tableName . "
                    (" . implode(',', $keys) . ")
                    VALUES
                    ('" . implode("','", $values) . "')";
                    
            return DAO::insert($sql);
        }
                
        /**
         * Convert raw SQL response to an array of objects.
         *
         * @param mixed $rows Raw database response.
         * @param mixed $class The class name of the new objects.
         * @return array An array of the newly created objects.
         */
        protected function getMultipleResults($rows, $class)
        {
            if ($rows == null)
                return null;
            $res = [];
            foreach($rows as $row)
            {
				$classNamespace = ENTITY_NS . $class;
                $res[] = new $classNamespace($row);
            }
            return $res;
        }
        
        /**
         * Convert raw SQL response to one object.
         *
         * @param mixed $row Raw database response.
         * @param mixed $class The class name of the new object.
         * @return object|false The newly created object, or 'false' if there is no raw row.
         */
        protected function getOneOrNullResult($row, $class)
        {
            if($row != null)
            {
				$classWithNamespace = ENTITY_NS . $class;
                return new $classWithNamespace($row);
            }
            return false;
        }
    }