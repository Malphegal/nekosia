<?php
    namespace Model\Managers;
    
    use App\Manager;
    
    /**
     * Manager of Theme.
     * 
     * @method findAll() Get all records of the database table Theme.
     */
    class ThemeManager extends Manager{

        // ---- FIELDS ----

        protected $className = "Theme";
        protected $tableName = "theme";

        // ---- CONSTRUCTORS ----

        public function __construct()
        {
            parent::connect();
        }
    }