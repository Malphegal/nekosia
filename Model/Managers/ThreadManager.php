<?php
    namespace Model\Managers;
    
    use App\Manager;
    use Model\BDD\DAO;
    
    /**
     * Manager of Thread.
     * 
     * @method findAll() Get all records of the database table Thread.
     */
    class ThreadManager extends Manager{

        // ---- FIELDS ----

        protected $className = "Thread";
        protected $tableName = "thread";

        // ---- CONSTRUCTORS ----

        public function __construct()
        {
            parent::connect();
        }
    }