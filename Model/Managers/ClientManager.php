<?php
	namespace Model\Managers;
    
    use App\Manager;
    use Model\BDD\DAO;

    /**
     * Manager of Client.
     * 
     * @method findAll() Get all records of the database table Client.
     * @method findWithName() Find a client named '$nickname'.
     * @method findWithNameAndPw() Find a client based on his nickname and password. Required for log-in.
     */
    class ClientManager extends Manager{

        // ---- FIELDS ----

        protected $className = "Client";
        protected $tableName = "client";

        // ---- CONSTRUCTORS ----

        public function __construct()
        {
            parent::connect();
        }

        // ---- METHODS ----
        
        /**
         * Find a client named '$nickname'.
         *
         * @param string $nickname The Client nickname.
         */
        public function findWithName($nickname)
        {
            $sql = "SELECT *
                FROM " . $this->tableName . "
                WHERE nickname = :nickname";

            return $this->getOneOrNullResult(
                DAO::select($sql, ["nickname" => $nickname], false),
                $this->className
            );
        }

        /**
         * Find a client based on his nickname and password. Required for log-in.
         *
         * @param string $nickname The user nickname.
         * @param string $pw The user password.
         */
        public function findWithNameAndPw($nickname, $pw)
        {
            $sql = "SELECT *
                    FROM " . $this->tableName . "
                    WHERE nickname = :nickname
                    AND pw = :pw";

            return $this->getOneOrNullResult(
                DAO::select($sql, ["nickname" => $nickname, "pw" => $pw], false),
                $this->className
            );
        }
    }