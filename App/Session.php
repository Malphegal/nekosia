<?php

    namespace App;

    use Model\Managers\ClientManager;

    /**
     * Manager the user session, and cookies.
     * 
     * @method init() The session init.
     * @method setCookie() Create a cookie remaining 50 years.
     * @method destroyCookie() Destroy a cookie.
     * @method destroyCookie() Check if the user is connected.
     */
    abstract class Session{

        // ---- PROPERTIES ----

        private static $cookiesLength;

        // ---- CONSTS ----
        
        const REMEMBER_COOKIE = "remember_me";
        const ID_COOKIE = "user_id";

        const ID_SES = "user_id";
        const NICKNAME_SES = "user_nickname";
        const GRADE_SES = "user_grade";
        const SIGNEDUP_SES = "user_signedup";
        const AVATAR_SES = "user_avatar";
        const EMAIL_SES = "user_email";

        // ---- METHODS ----
                
        /**
         * The session init. Creates the client if there is cookies.
         */
        public static function init()
        {
            self::$cookiesLength = strtotime('+50 year');
            session_start();
            if (isset($_COOKIE[self::REMEMBER_COOKIE]) && isset($_COOKIE[self::ID_COOKIE])){
                if (!self::isConnected() && $_COOKIE[self::REMEMBER_COOKIE] == true)
                    self::createClient($_COOKIE[self::ID_COOKIE]);
            }
        }
        
        /**
         * Create a cookie remaining 50 years.
         *
         * @param string $name A Session const.
         * @param mixed $value The new value of the cookie.
         */
        public static function setCookie($name, $value)
        {
            setcookie($name, $value, self::$cookiesLength, RELATIVE_DIR);
        }
        
        /**
         * Destroy a cookie.
         *
         * @param string $name The cookie name to destroy.
         */
        public static function destroyCookie($name)
        {
            if (isset($_COOKIE[$name]))
            {
                unset($_COOKIE[$name]); 
                setcookie($name, null, time() - 3600, RELATIVE_DIR);
            }
        }

        /**
         * Destroy a session variable.
         *
         * @param string $name The session variable name to destroy.
         */
        public static function destroySessionVariable($name)
        {
            if (isset($_SESSION[$name]))
                unset($_SESSION[$name]); 
        }
        
        /**
         * Check if the user is connected.
         *
         * @return bool Returns 'true' if the user is connected, otherwise 'false'.
         */
        public static function isConnected()
        {
            $res = !empty($_SESSION[self::ID_SES]) && isset($_SESSION[self::ID_SES])
                && !empty($_SESSION[self::NICKNAME_SES]) && isset($_SESSION[self::NICKNAME_SES])
                && !empty($_SESSION[self::GRADE_SES]) && isset($_SESSION[self::GRADE_SES])
                && !empty($_SESSION[self::SIGNEDUP_SES]) && isset($_SESSION[self::SIGNEDUP_SES])
                && !empty($_SESSION[self::AVATAR_SES]) && isset($_SESSION[self::AVATAR_SES])
                && !empty($_SESSION[self::EMAIL_SES]) && isset($_SESSION[self::EMAIL_SES]);
            return $res;
        }
        
        /**
         * Creates the logged in client in session.
         *
         * @param int $id Client id.
         */
        public static function createClient($id, $client = null)
        {
            if ($client == null)
            {
                $cMan = new ClientManager();
                $client = $cMan->findOneById($id);
            }
            if ($client !== false)
            {
                $_SESSION[self::ID_SES] = $client->getId();
                $_SESSION[self::NICKNAME_SES] = $client->getNickname();
                $_SESSION[self::EMAIL_SES] = $client->getEmail();
                $_SESSION[self::SIGNEDUP_SES] = $client->getSignedup();
                $_SESSION[self::AVATAR_SES] = $client->getAvatar();
                $_SESSION[self::GRADE_SES] = $client->getGrade();
            }
            else
                self::destoyClientSession(true);
        }
        
        /**
         * Unset the whole user session, and his cookies.
         */
        public static function destoyClientSession($destroyCookies = false)
        {
            if ($destroyCookies)
            {
                self::destroyCookie(self::REMEMBER_COOKIE);
                self::destroyCookie(self::ID_COOKIE);
            }
            else
            {
                self::setCookie(self::REMEMBER_COOKIE, 0);
            }
            self::destroySessionVariable(self::ID_SES);
            self::destroySessionVariable(self::NICKNAME_SES);
            self::destroySessionVariable(self::EMAIL_SES);
            self::destroySessionVariable(self::SIGNEDUP_SES);
            self::destroySessionVariable(self::AVATAR_SES);
            self::destroySessionVariable(self::GRADE_SES);
        }
    }
?>