<?php
	namespace Model\Entities;
    
    use App\Interfaces\Comparable;
    use App\Entity;

    /**
     * Represent one row in the Thread database table.
     * 
     * @method getId() Get the value of id.
     * @method setId() Get the value of id.
     * 
     * @method getTitle() Get the value of title.
     * @method setTitle() Set the value of title.
     * 
     * @method getCreation() Get the value of creation.
     * @method setCreation() Set the value of creation.
     * 
     * @method getLattestEdit() Get the value of lattestEdit.
     * @method setLattestEdit() Get the value of lattestEdit.
     * 
     * @method getLocked() Get the value of locked.
     * @method setLocked() Set the value of locked.
     * 
     * @method getTheme() Get the value of theme.
     * @method setTheme() Set the value of theme.
     * 
     * @method getClient() Get the value of client.
     * @method setClient() Get the value of client.
     */
    final class Thread extends Entity implements Comparable{

        // ---- FIELDS ----

        private $id;
        private $title;
        private $creation;
        private $lattestEdit;
        private $locked;
        private $theme;
        private $client;

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
         * Get the value of title.
         */ 
        public function getTitle()
        {
            return $this->title;
        }

        /**
         * Set the value of title.
         *
         * @param string $title The new title value.
         */ 
        public function setTitle($title)
        {
            $this->title = $title;
        }

        /**
         * Get the value of creation.
         */ 
        public function getCreation()
        {
            return $this->creation;
        }

        /**
         * Set the value of creation.
         *
         * @param string $creation The new creation value, as a string.
         */ 
        public function setCreation($creation)
        {
            $this->creation = new \DateTime($creation);
        }

        /**
         * Get the value of lattestEdit.
         */ 
        public function getLattestEdit()
        {
            return $this->lattestEdit;
        }

        /**
         * Set the value of lattestEdit.
         *
         * @param string $lattestEdit The new lattestEdit value, as a string.
         */ 
        public function setLattestEdit($lattestEdit)
        {
            $this->lattestEdit = new \DateTime($lattestEdit);
        }

        /**
         * Get the value of locked.
         */ 
        public function getLocked()
        {
            return $this->locked;
        }

        /**
         * Set the value of locked.
         *
         * @param int $locked The new locked value.
         */ 
        public function setLocked($locked)
        {
            $this->locked = $locked;
        }

        /**
         * Get the value of theme.
         */ 
        public function getTheme()
        {
            return $this->theme;
        }
        
        /**
         * Set the value of theme.
         *
         * @param Theme $theme The new theme value.
         */ 
        public function setTheme($theme)
        {
            $this->theme = $theme;
        }
        
        /**
         * Get the value of client.
         */ 
        public function getClient()
        {
            return $this->client;
        }

        /**
         * Set the value of client.
         *
         * @param Client $client The new client value.
         */ 
        public function setClient($client)
        {
            $this->client = $client;
        }
        
        /**
         * ToString override : get the title.
         *
         * @return string Object representation as a string.
         */
        public function __toString()
        {
            return $this->title;
        }
        
        // -- Implements --
        
        /**
         * Allow to compare 2 objects of type Thread. They will be antichronological sorted.
         *
         * @param Thread $t1 The first Thread to compare.
         * @param Thread $t2 The second Thread to compare.
         * @return int A sort method int value.
         */
        public static function compare($t1, $t2)
        {
            return $t1->creation < $t2->creation;
        }
    }