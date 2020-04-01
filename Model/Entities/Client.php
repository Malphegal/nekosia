<?php
	namespace Model\Entities;

    use App\Entity;

    /**
     * Represent one row in the Client database table.
     * 
     * @method getId() Get the value of id.
     * @method setId() Set the value of id.
     * 
     * @method getNickname() Get the value of nickname.
     * @method setNickname() Set the value of nickname.
     * 
     * @method getEmail() Get the value of email.
     * @method setEmail() Set the value of email.
     * 
     * @method getPw() Get the value of pw.
     * @method setPw() Set the value of pw.
     * 
     * @method getSignedup() Get the value of signedup.
     * @method setSignedup() Set the value of signedup.
     * 
     * @method getGrade() Get the value of grade.
     * @method setGrade() Set the value of grade.
     * 
     * @method getAvatar() Get the value of avatar.
     * @method setAvatar() Set the value of avatar.
     * 
     * @method __toString() ToString override : get the nickname.
     */
    final class Client extends Entity{

        // ---- FIELDS ----

        private $id;
        private $nickname;
        private $email;
        private $pw;
        private $signedup;
        private $avatar;
        private $grade;

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
         * Get the value of nickname.
         */ 
        public function getNickname()
        {
            return $this->nickname;
        }

        /**
         * Set the value of nickname.
         *
         * @param string $nickname The new nickname value.
         */ 
        public function setNickname($nickname)
        {
            $this->nickname = $nickname;
        }
        
        /**
         * Get the value of email.
         */ 
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * Set the value of email.
         *
         * @param string $email The new email value.
         */ 
        public function setEmail($email)
        {
            $this->email = $email;
        }
        
        /** 
         * Get the value of pw.
         */ 
        public function getPw()
        {
            return $this->pw;
        }

        /**
         * Set the value of pw.
         *
         * @param string $pw The new pw value.
         */ 
        public function setPw($pw)
        {
            $this->pw = $pw;
        }

        /**
         * Get the value of signedup.
         */ 
        public function getSignedup()
        {
            return $this->signedup;
        }

        /**
         * Set the value of signedup.
         * 
         * @param string $signedup The new signedup value.
         */ 
        public function setSignedup($signedup)
        {
            $this->signedup = new \DateTime($signedup);
        }

        /**
         * Get the value of grade.
         */ 
        public function getGrade()
        {
            return $this->grade;
        }

        /**
         * Set the value of grade.
         * 
         * @param Grade $grade The new grade value.
         */ 
        public function setGrade($grade)
        {
            $this->grade = $grade;
        }
        
        /**
         * Get the value of avatar.
         */
        public function getAvatar()
        {
            return $this->avatar;
        }

        /**
         * Set the value of avatar.
         * 
         * @param string $avatar The new avatar value.
         */ 
        public function setAvatar($avatar)
        {
            $this->avatar = $avatar;
        }
        
        /**
         * ToString override : get the nickname.
         *
         * @return string Object representation as a string.
         */
        public function __toString()
        {
            return $this->nickname;
        }
    }
