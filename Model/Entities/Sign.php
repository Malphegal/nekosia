<?php
	namespace Model\Entities;

    use App\Entity;

    /**
     * Represent one row in the Sign database table.
     * 
     * @method getClient() Get the value of client.
     * @method setClient() Set the value of client.
     * 
     * @method getThread() Get the value of thread.
     * @method setThread() Set the value of thread.
     * 
     * @method getLatestVisit() Get the value of latestVisit.
     * @method setLatestVisit() Set the value of latestVisit.
     * 
     */
    final class Sign extends Entity{

        // ---- FIELDS ----

        private $client;
        private $thread;
        private $latestVisit;

        // ---- CONSTRUCTORS ----

        public function __construct($data)
        {         
            $this->hydrate($data);
        }

        // ---- METHODS ----

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
         * Get the value of latestVisit.
         */ 
        public function getLatestVisit()
        {
            return $this->latestVisit;
        }

        /**
         * Set the value of latestVisit.
         *
         * @param string $latestVisit The new latestVisit value.
         */ 
        public function setLatestVisit($latestVisit)
        {
            $this->latestVisit = new \DateTime($latestVisit);
        }
    }
