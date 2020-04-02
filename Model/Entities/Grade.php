<?php
	namespace Model\Entities;

    use App\Entity;

    /**
     * Represent one row in the Client database table.
     * 
     * @method getId() Get the value of id.
     * @method setId() Set the value of id.
     * 
     * @method getLabel() Get the value of label.
     * @method setLabel() Set the value of label.
     * 
     * @method getCanLock() Get the value of canlock.
     * @method setCanLock() Set the value of canlock.
     * 
     * @method getCanBan() Set the value of canBan.
     * @method setCanBan() Set the value of canBan.
     * 
     * @method __toString() ToString override : get the label.
     */
    final class Grade extends Entity{

        // ---- FIELDS ----

        private $id;
        private $label;
        private $canLock;
        private $canBan;

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
         * @param string $id The new id value.
         */ 
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * Get the value of label.
         */ 
        public function getLabel()
        {
            return $this->label;
        }

        /**
         * Set the value of label.
         *
         * @param string $label The new label value.
         */ 
        public function setLabel($label)
        {
            $this->label = $label;
        }
        
        /**
         * Get the value of canLock.
         */ 
        public function getCanLock()
        {
            return $this->canLock;
        }

        /**
         * Set the value of canLock.
         *
         * @param int $canLock The new canLock value.
         */ 
        public function setCanLock($canLock)
        {
            $this->canLock = $canLock;
        }

        /**
         * Get the value of canBan.
         */ 
        public function getCanBan()
        {
            return $this->canBan;
        }

        /**
         * Set the value of canBan.
         * 
         * @param int $canBan The new canBan value.
         */ 
        public function setCanBan($canBan)
        {
            $this->canBan = $canBan;
        }
        
        /**
         * ToString override : get the label.
         *
         * @return string Object representation as a string.
         */
        public function __toString()
        {
            return $this->label;
        }
    }
