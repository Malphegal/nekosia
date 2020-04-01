<?php
    namespace Model\Managers;
    
    use App\Manager;
    
    /**
     * Manager of Grade.
     * 
     * @method findAll() Get all records of the database table Grade.
     */
    class GradeManager extends Manager{

        // ---- FIELDS ----

        protected $className = "Grade";
        protected $tableName = "grade";

        // ---- CONSTRUCTORS ----

        public function __construct()
        {
            parent::connect();
        }
    }