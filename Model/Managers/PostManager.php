<?php
    namespace Model\Managers;
    
    use Model\BDD\DAO;
    use App\Manager;
    
    /**
     * Manager of Post.
     * 
     * @method findAll() Get all records of the database table Post.
     * @method findAllByThreadId() Find all posts filtered by a thread id.
     * @method isOneAfterDate() Check whether or not one post has been created after a specific date.
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
        
        /**
         * Check whether or not one post has been created after a specific date.
         *
         * @param Post[] $posts The posts.
         * @param Datetime $date The date.
         * @return bool Return 'true' if there is at least one post created after the date, otherwise 'false'.
         */
        public function isOneAfterDate($posts, $date)
        {
            foreach ($posts as $p)
                if ($p->getCreation() > $date)
                    return true;
            return false;
        }
    }