<?php
    namespace Model\Managers;
    
    use App\Manager;
    use Model\BDD\DAO;
    
    /**
     * Manager of Theme.
     * 
     * @method findAll() Get all records of the database table Sign.
     * @method findOneByIds() Get one record based on thread_id and client_id fields.
     * @method update() Update one Sign table date.
     * @method delete() Delete one Sign row.
     */
    class SignManager extends Manager{

        // ---- FIELDS ----

        protected $className = "Sign";
        protected $tableName = "sign";

        // ---- CONSTRUCTORS ----

        public function __construct()
        {
            parent::connect();
        }

        // ---- METHODS ----
        
        /**
         * Get one record based on thread_id and client_id fields.
         *
         * @param int $threadId The requested thread ID.
         * @param int $clientId The requested client ID.
         * @return class An object of a type based on the name of the table, or 'false' if there is no record.
         */
        public function findOneByIds($threadId, $clientId)
        {
            $sql = "SELECT *
                    FROM " . $this->tableName . " a
                    WHERE a.thread_id = :threadId
                    AND a.client_id = :clientId";

            return $this->getOneOrNullResult(
                DAO::select($sql, ["threadId" => $threadId, "clientId" => $clientId], false), 
                $this->className
            );
        }

        /**
         * Update one Sign table date.
         *
         * @param int[2] $ids The Thread id, the Client id.
         * @param string $date The new date value.
         * @return bool Return 'true' if everything goes well, otherwhise 'false'.
         */
        public function update($ids, $date)
        {
            $sql = "UPDATE " . $this->tableName . " SET latest_visit = '$date'
                    WHERE thread_id = " . $ids[0] . "
                    AND client_id = " . $ids[1];

            return DAO::update($sql);
        }
        
        /**
         * Delete one Sign row.
         *
         * @param int $threadId The Thread id.
         * @param int $clientId The Client id.
         * @return bool Return 'true' if everything goes well, otherwhise 'false'.
         */
        public function delete($threadId, $clientId)
        {
            $sql = "DELETE FROM " . $this->tableName . "
                    WHERE thread_id = $threadId
                    AND client_id = $clientId";

            return DAO::delete($sql);
        }
    }