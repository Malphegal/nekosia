<?php
	namespace Model\Managers;
    
    use App\Manager;
    use Model\BDD\DAO;

    /**
     * Manager of Client.
     * 
     * @method findAll() Get all records of the database table Client.
     * @method findWithNameAndPw() Find a client based on his nickname and password. Required for log-in.
     * @method findWithNameAndPw() Does a client named '$nickname' exist ?
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
         * Does a client named '$nickname' exist ?
         *
         * @param string $nickname The nickname.
         * @return bool Return 'true' if the client exist, otherwise 'false'.
         */
        public function findWithName($nickname)
        {
            $sql = "SELECT *
                FROM " . $this->tableName . "
                WHERE nickname = :nickname";

            $client = $this->getOneOrNullResult(
                DAO::select($sql, ["nickname" => $nickname], false),
                $this->className
            );
            return $client !== false;
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