<?php
    namespace Model\Managers;
    
    use Model\BDD\DAO;
    use App\Manager;
    
    /**
     * Manager of Post.
     * 
     * @method findAll() Get all records of the database table Post.
     * @method findAllByThreadId() Find all posts filtered by a thread id.
     */
    class PostManager extends Manager{

        // ---- FIELDS ----

        protected $className = "Post";
        protected $tableName = "post";

        // ---- CONSTRUCTORS ----

        public function __construct()
        {
            parent::connect();
        }

        // ---- METHODS ----
        
        /**
         * Find all posts filtered by a thread id.
         *
         * @param int $id The thread id.
         * @return array An array of the newly created objects.
         */
        public function findAllByThreadId($id)
        {
            $sql = "SELECT *
                    FROM " . $this->tableName . " a
                    WHERE thread_id = :id";

            return $this->getMultipleResults(
                DAO::select($sql, ["id" => $id]),
                $this->className
            );
        }
    }