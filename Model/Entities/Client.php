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
     * @method getSignedup() Get the value of signedup.
     * @method setSignedup() Set the value of signedup.
     * 
     * @method getAvatar() Get the value of avatar.
     * @method setAvatar() Set the value of avatar.
     * 
     * @method getAvatarEnd() Only get the file name of avatar.
     * 
     * @method getIsBanned() Get the value of isBanned.
     * @method setIsBanned() Set the value of isBanned.
     * 
     * @method getSignature() Get the value of signature.
     * @method setSignature() Set the value of signature.
     * 
     * @method getAbout() Get the value of about.
     * @method setAbout() Set the value of about.
     * 
     * @method getGrade() Get the value of grade.
     * @method setGrade() Set the value of grade.
     * 
     * @method getLatestVisit() Get the value of latestVist.
     * @method setLatestVisit() Set the value of latestVist.
     * 
     * @method __toString() ToString override : get the nickname.
     */
    final class Client extends Entity{

        // ---- FIELDS ----

        private $id;
        private $nickname;
        private $email;
        private $signedup;
        private $avatar;
        private $isBanned;
        private $signature;
        private $about;
        private $grade;
        private $latestVisit;

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
         * Only get the file name of avatar.
         */
        public function getAvatarEnd()
        {
            $name = explode(DS, $this->avatar);
            return end($name);
        }

        /**
         * Get the value of isBanned.
         */ 
        public function getIsBanned()
        {
            return $this->isBanned;
        }

        /**
         * Set the value of isBanned.
         * 
         * @param int $isBanned The new isBanned value.
         */ 
        public function setIsBanned($isBanned)
        {
            $this->isBanned = $isBanned;
        }

        /**
         * Get the value of signature.
         */ 
        public function getSignature()
        {
            return htmlspecialchars($this->signature);
        }

        /**
         * Set the value of signature.
         * 
         * @param string $signature The new signature value.
         */ 
        public function setSignature($signature)
        {
            $this->signature = $signature;
        }

        /**
         * Get the value of about.
         */ 
        public function getAbout()
        {
            return htmlspecialchars($this->about);
        }

        /**
         * Set the value of about.
         * 
         * @param string $about The new about value.
         */ 
        public function setAbout($about)
        {
            $this->about = $about;
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
