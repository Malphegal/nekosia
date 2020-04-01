<?php
	namespace Model\Entities;

    use App\Entity;

    /**
     * Represent one row in the Theme database table.
     * 
     * @method getId() Get the value of id.
     * @method setId() Set the value of id.
     * 
     * @method getName() Get the value of name.
     * @method setName() Set the value of name.
     * 
     * @method __toString() ToString override : get the name.
     */
    final class Theme extends Entity{

        // ---- FIELDS ----

        private $id;
        private $name;

        // ---- CONSTRUCTORS ----

        public function __construct($data)
        {         
            $this->hydrate($data);
        }

        // ---- METHODS ----

        /** 
         * Get the value of id.
         */ 
        public function getId()
        {
            return $this->id;
        }

        /**
         * Set the value of id.
         *
         * @param int $id The new id value.
         */ 
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * Get the value of name.
         */ 
        public function getName()
        {
            return $this->name;
        }

        /**
         * Set the value of name.
         *
         * @param string $name The new name value.
         */ 
        public function setName($name)
        {
            $this->name = $name;
        }
        
        /**
         * ToString override : get the name.
         *
         * @return string Object representation as a string.
         */
        public function __toString()
        {
            return $this->name;
        }
    }
