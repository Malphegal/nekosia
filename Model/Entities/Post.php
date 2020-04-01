<?php
	namespace Model\Entities;
    
    use App\Entity;
    use app\Interfaces\Comparable;

    /**
     * Represent one row in the Post database table.
     * 
     * @method getId() Get the value of id.
     * @method setId() Set the value of id.
     * 
     * @method getBody() Get the value of body.
     * @method setBody() Set the value of body.
     * 
     * @method getCreation() Get the value of creation.
     * @method setCreation() Set the value of creation.
     * 
     * @method getLattestEdit() Get the value of lattestEdit.
     * @method setLattestEdit() Set the value of lattestEdit.
     * 
     * @method getThread() Get the value of thread.
     * @method setThread() Set the value of thread.
     * 
     * @method getClient() Get the value of client.
     * @method setClient() Set the value of client.
     */
    final class Post extends Entity implements Comparable{

        // ---- FIELDS ----

        private $id;
        private $body;
        private $creation;
        private $lattestEdit;
        private $thread;
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
         * @param string $id The new id value.
         */ 
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * Get the value of body.
         */ 
        public function getBody()
        {
            return $this->body;
        }

        /**
         * Set the value of body.
         *
         * @param string $body The new body value.
         */ 
        public function setBody($body)
        {
            $this->body = $body;
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
         * Get the value of thread.
         */ 
        public function getThread()
        {
            return $this->thread;
        }

        /**
         * Set the value of thread.
         *
         * @param Thread $thread The new thread value.
         */ 
        public function setThread($thread)
        {
            $this->thread = $thread;
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
        
        // -- Implements --

        /**
         * Allow to compare 2 objects of type Post. They will be chronological sorted.
         *
         * @param Post $p1 The first Post to compare.
         * @param Post $p2 The second Post to compare.
         * @return int A sort method int value.
         */
        public static function compare($p1, $p2)
        {
            return $p1->creation > $p2->creation;
        }
    }