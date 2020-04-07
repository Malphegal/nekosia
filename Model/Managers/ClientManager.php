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

        /**
         * Find a client based on his nickname or email. Required for sign-up.
         *
         * @param string $nickname The user nickname.
         * @param string $email The user email.
         */
        public function findWithNameOrEmail($nickname, $email)
        {
            $sql = "SELECT *
                    FROM " . $this->tableName . "
                    WHERE nickname = :nickname
                    OR email = :email";

            return $this->getOneOrNullResult(
                DAO::select($sql, ["nickname" => $nickname, "email" => $email], false),
                $this->className
            );
        }
        
        /**
         * Get one record based on sha256 hashed id_client field.
         *
         * @param int|string $id The requested id, or hashed ID.
         * @return Client|false An object of a type Client, or 'false' if there is no record.
         */
        public function findOneById($id)
        {
            if (strlen(strval($id)) < 64)
                $id = hash("sha256", $id);
            $sql = "SELECT *
                    FROM " . $this->tableName . " c
                    WHERE SHA2(c.id_" . $this->tableName . ", 256) = :id";

            return $this->getOneOrNullResult(
                DAO::select($sql, ['id' => $id], false), 
                $this->className
            );
        }
        
        /**
         * Ban a Client.
         *
         * @param Client $client A Client object.
         */
        public function ban($client)
        {
            return $this->update($client->getId(),
                ["is_banned" => 1]);
        }
    }