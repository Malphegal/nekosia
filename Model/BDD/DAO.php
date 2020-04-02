<?php
	namespace Model\BDD;

    /**
     * BDD data access abstract class.
     * 
     * @method static connect() Allow to connect to the database.
     * @method static insert() Allow to do INSERT INTO requests.
     * @method static select() Allow to do SELECT requests.
     * @method static update() Allow to do UPDATE requests.
     */
    abstract class DAO{

        private static $host   = 'mysql:host=127.0.0.1;port=3306';
        private static $dbname = 'nekosia';
        private static $dbuser = 'root';
        private static $dbpass = '';

        private static $bdd;

        /**
         * Create only one PDO instance.
         */
        public static function connect(){
            if (self::$bdd !== null)
                return;
            self::$bdd = new \PDO(
                self::$host . ';dbname=' . self::$dbname,
                self::$dbuser,
                self::$dbpass,
                array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                )   
            );
        }
        
        /**
         * Create 'INSERT INTO' requests in the database.
         *
         * @param  mixed $sql The full SQL query.
         * @return int The last index inserted in the database.
         */
        public static function insert($sql){
            try
            {
                $stmt = self::$bdd->prepare($sql);
                $stmt->execute();
                
                $stmt->closeCursor();
                return self::$bdd->lastInsertId();
            }
            catch(\Exception $e)
            {
                echo $e->getMessage(); 
            }
        }

        /**
         * Create 'SELECT' requests in the databse.
         * 
         * @param string $sql The full SQL query.
         * @param mixed $params=null The request arguments.
         * @param bool $multiple=true Return 'true' if the result contains multiple records (default), otherwise 'false'.
         * 
         * @return array|null The record(s) back from the SELECT query using ATTR_DEFAULT_FETCH_MODE::FETCH_ASSOC, or 'null' is none.
         */
        public static function select($sql, $params = null, bool $multiple = true):?array
        {
            try
            {
                $stmt = self::$bdd->prepare($sql);
                $stmt->execute($params);
                
                if ($multiple)
                    $results = $stmt->fetchAll();
                else
                    $results = $stmt->fetch();

                $stmt->closeCursor();
                return !$results ? null : $results;
            }
            catch(\Exception $e)
            {
                echo $e->getMessage();
            }
        }
        
        /**
         * Allow tu update some rows in the database.
         *
         * @param string $sql The full SQL query.
         * @return bool Return 'true' if everything goes well, otherwise 'false'.
         */
        public static function update($sql)
        {
            try
            {
                $stmt = self::$bdd->prepare($sql);
                $stmt->execute();
                
                $stmt->closeCursor();
                return $stmt;
            }
            catch(\Exception $e)
            {
                echo $e->getMessage(); 
            }
        }
    }