<?php

    namespace App;

    use Model\Managers\ClientManager;
    use Controller\HomeController;

    /**
     * Manager the user session, and cookies.
     * 
     * @method init() The session init.
     * @method setCookie() Create a cookie remaining 1 year.
     * @method destroyCookie() Destroy a cookie.
     * @method destroySessionVariable() Destroy a session variable.
     * @method isConnected() Check if the user is connected.
     * @method isCurrentClient() Check whether or not the connected Client is the same as $client.
     * @method isCurrentAdmin() Check whether or not the connected Client is an admin.
     * @method createClientWithId() Creates the logged in client in session, based on id.
     * @method destroyClientSession() Unset the whole user session, and his cookies.
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
            self::$cookiesLength = strtotime('+1 year');
            session_start();
            if (isset($_COOKIE[self::REMEMBER_COOKIE]) && isset($_COOKIE[self::ID_COOKIE]))
            {
                if (!self::isConnected() && $_COOKIE[self::REMEMBER_COOKIE] == true)
                    self::createClientWithId($_COOKIE[self::ID_COOKIE], $_COOKIE[self::REMEMBER_COOKIE]);
            }
            // Check if the user has been banned since the last refresh
            if (self::isConnected())
            {
                $cMan = new ClientManager();
                $client = $cMan->findOneById($_SESSION[self::ID_SES]);
                if ($client->getIsBanned())
                {
                    self::destroyClientSession(true);
                    HomeController::invoke404();
                }
            }
        }
        
        /**
         * Create a cookie remaining 1 year.
         *
         * @param string $name A Session const.
         * @param mixed $value The new value of the cookie.
         */
        public static function setCookie($name, $value)
        {
            setcookie($name, $value, self::$cookiesLength, "/");
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
                setcookie($name, null, time() - 3600, "/");
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
         * Check whether or not the connected Client is the same as $client.
         *
         * @param Client|string $client The tested client.
         * @return bool Return 'true' if the $client is the same as the connected one, otherwise 'false'.
         */
        public static function isCurrentClient($client)
        {
            return self::isConnected() && $client == $_SESSION[self::NICKNAME_SES];
        }
        
        /**
         * Check whether or not the connected Client is an admin.
         *
         * @return bool Return 'true' if the current Client is an admin, otherwise 'false'.
         */
        public static function isCurrentAdmin()
        {
            return self::isConnected() && $_SESSION[self::GRADE_SES] == "Admin";
        }

        /**
         * Creates the logged in client in session, based on id.
         *
         * @param int $id Hashed Client id.
         * @param int $rememberMe=null Int value that represents a bool, will the client stay connected after closing the browser ?
         */
        public static function createClientWithId($id, $rememberMe = null)
        {
            // Reset the cookies timer
            self::setCookie(self::ID_COOKIE, $id);
            if (isset($_COOKIE[self::REMEMBER_COOKIE]) && $_COOKIE[self::ID_COOKIE] == 1)
                self::setCookie(self::REMEMBER_COOKIE, 1);

            $cMan = new ClientManager();
            $client = $cMan->findOneById($id);
            if ($client !== false)
                self::createClientWithObject($client, $rememberMe);
            else
                self::destroyClientSession(true);
        }
        
        /**
         * Creates the logged in client in session, based on its object.
         *
         * @param Client $client Full client object.
         * @param int $rememberMe=null Int value that represents a bool, will the client stay connected after closing the browser ?
         */
        public static function createClientWithObject($client, $rememberMe = null)
        {
            if ($client !== false)
            {
                if ($rememberMe != null)
                    self::setCookie(self::REMEMBER_COOKIE, $rememberMe);
                $_SESSION[self::ID_SES] = $client->getId();
                $_SESSION[self::NICKNAME_SES] = $client->getNickname();
                $_SESSION[self::EMAIL_SES] = $client->getEmail();
                $_SESSION[self::SIGNEDUP_SES] = $client->getSignedup();
                $_SESSION[self::AVATAR_SES] = $client->getAvatar();
                $_SESSION[self::GRADE_SES] = $client->getGrade();
            }
            else
                self::destroyClientSession(true);
        }
        
        /**
         * Unset the whole user session, and his cookies.
         */
        public static function destroyClientSession($destroyCookies = false)
        {
            if ($destroyCookies)
            {
                self::destroyCookie(self::REMEMBER_COOKIE);
                self::destroyCookie(self::ID_COOKIE);
            }
            else
            {
                if (isset($_COOKIE[self::REMEMBER_COOKIE]))
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