<?php
	namespace Model\Managers;
    
    use App\Manager;
    use Model\BDD\DAO;

    /**
     * Manager of Client.
     * 
     * @method findAll() Get all records of the database table Client.
     * @method findWithName() Find a client named '$nickname'.
     * @method findWithNameAndEmail() Find a client based on his nickname or email. Required for sign-up.
     * @method findByHashedId() Get one record based on the hashed cookie id_client field.
     * @method getPw() Get one hashed password.
     * @method ban() Ban a Client.
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
         * Get one record based on the hashed cookie id_client field.
         *
         * @param string $id The requested hashed ID.
         * @return Client|false An object of a type Client, or 'false' if there is no record.
         */
        public function findByHashedId($hashedId)
        {
            $sql = "SELECT c.id_" . $this->tableName . "
                    FROM " . $this->tableName . " c";
            
            $rows = DAO::select($sql);
            foreach ($rows as $r)
                if (password_verify($r["id_client"], $hashedId))
                    return $this->findOneById($r["id_client"]);
            return false;
        }
        
        /**
         * Get one hashed password.
         *
         * @param int $id The Client id.
         * @return string|null Return the hashed password, or null if the Client does not exist.
         */
        public function getPw($id)
        {
            $sql = "SELECT pw
                    FROM " . $this->tableName . " c
                    WHERE c.id_" . $this->tableName . " = :id";
            $res = DAO::select($sql, ["id" => $id], false);
            if (!$res)
                return null;
            return current($res);
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