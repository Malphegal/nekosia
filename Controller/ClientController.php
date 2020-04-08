<?php
    namespace Controller;

    use App\Session;
    use Model\Managers\ClientManager;

    /**
     * Controller to manager Clients.
     * 
     * @method profil() Invoke the profil page.
     * @method logout() Disconnect the client, removing all cookies.
     * @method signup() Get to the sign-up page.
     */
    class ClientController{

        // ---- FIELDS ----

        private $defaultClientGrade;

        // ---- CONSTRUCTORS ----

        public function __construct()
        {
            $this->defaultClientGrade = 2;
        }

        // ---- METHODS ----

        /**
         * Show the current logged-in client, or the sign-in page.
         */
        public function profil($profilName)
        {
            $title = "Connexion";
            $page = "login.php";
            $client = null;

            // Check for a log-in
            if (isset($_POST["signin-nickname"]) && isset($_POST["signin-pw"]))
            {
                $cMan = new ClientManager();
                $client = $cMan->findWithName($_POST["signin-nickname"]);
                
                if ($client !== false)
                {
                    if ($client->getIsBanned())
                        HomeController::invoke404();
                    if (password_verify($_POST["signin-pw"], $cMan->getPw($client->getId())))
                    {
                        Session::setCookie(Session::ID_COOKIE, password_hash($client->getId(), PASSWORD_ARGON2I));
                        if (isset($_POST["signin-remember"]) && $_POST["signin-remember"])
                            Session::setCookie(Session::REMEMBER_COOKIE, 1);
                        Session::createClientWithObject($client);
                    }
                }

                $headerLocation = "client" . DS . "profil" . ($profilName == null ? "" : "/" . $profilName);
                header("Location: " . RELATIVE_DIR . $headerLocation);
                die();
            }

            // Check update about
            if (isset($_POST["update-about"]))
            {
                $cMan = new ClientManager();
                $client = $cMan->findWithName($_SESSION[Session::NICKNAME_SES]);

                // If the Client exists, and not banned
                if ($client !== false)
                {
                    if (!$client->getIsBanned())
                        $a = $cMan->update($client->getId(), ["about" => str_replace("'", "''", $_POST["update-about"])]);
                    else
                    {
                        Session::destroyClientSession();
                        HomeController::invoke404();
                    }
                }
                // If the Client does not exist, destroy whole session
                else
                    HomeController::invoke404();

                header("Location: " . RELATIVE_DIR . "client" . DS . "profil");
                die();
            }

            // Check update signature
            if (isset($_POST["update-signature"]))
            {
                $cMan = new ClientManager();
                $client = $cMan->findWithName($_SESSION[Session::NICKNAME_SES]);

                // If the Client exists, and not banned
                if ($client !== false)
                {
                    if (!$client->getIsBanned())
                        $cMan->update($client->getId(), ["signature" => str_replace("'", "''", $_POST["update-signature"])]);
                    else
                    {
                        Session::destroyClientSession();
                        HomeController::invoke404();
                    }
                }
                // If the Client does not exist, destroy whole session
                else
                    HomeController::invoke404();

                header("Location: " . RELATIVE_DIR . "client" . DS . "profil");
                die();
            }

            // Does not allow to show profils while disconnected
            if (Session::isConnected())
            {
                $profilName = $profilName == null ? strtolower($_SESSION[Session::NICKNAME_SES]) : $profilName;
    
                // Looking for the Client in the database
                $cMan = new ClientManager();
                $client = $cMan->findWithName($profilName);
    
                // If the Client does not exist, invoke 404.php
                if ($client == false)
                    HomeController::invoke404();
    
                // Otherwise get its information
                $page = "userProfil.php";
                $title = ucfirst($profilName);
            }

            return [
                "view" => DEFAULT_TEMPLATE,
                "data" => array("title" => $title,
                    "content" => "Clients" . DS . $page,
                    "args" => $client,
                    "css" => CSS_LINK . "Clients" . DS . "profil.css\" />")
            ];
        }
        
        /**
         * Disconnect the client, removing the session's values.
         */
        public function logout()
        {
            Session::destroyClientSession();
            header("Location: " . RELATIVE_DIR);
            die();
        }
        
        /**
         * Get to the sign-up page.
         */
        public function signup()
        {
            if (Session::isConnected())
            {
                header("Location: " . RELATIVE_DIR);
                die();
            }

            //filter_input(INPUT_POST, "signup-nickname", FILTER_SANITIZE_SPECIAL_CHARS);

            if (isset($_POST["signup-nickname"]) && !empty($_POST["signup-nickname"])
                && isset($_POST["signup-pw"]) && !empty($_POST["signup-pw"])
                && isset($_POST["signup-email"]) && !empty($_POST["signup-email"])
                && isset($_FILES["signup-avatar"]) && !empty($_FILES["signup-avatar"]))
            {
                // -- Check if the Client already exists

                $cMan = new ClientManager();
                $exist = $cMan->findWithNameOrEmail($_POST["signup-nickname"], $_POST["signup-email"]) != null;
                if ($exist)
                {
                    header("Location: " . RELATIVE_DIR . "client" . DS . "signup");
                    die();
                }
                
                // -- If he does not exist, add a new Client, if the avatar is valid

                $avatarPath = null;

                // If the user uploaded an image
                if (!empty($_FILES["signup-avatar"]["name"]))
                {
                    // TODO: The file name should be randomized and unique!
                    $type = $_FILES["signup-avatar"]["type"];
                    $type = substr($type, strpos($type, "/") + 1);
                    $avatarPath = AVATAR_DIR . strtolower($_POST["signup-nickname"]) . "." . $type;
                    
                    // If the image is NOT valid or does exist already, abort
                    if (file_exists($avatarPath) || !move_uploaded_file($_FILES["signup-avatar"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $avatarPath))
                    {
                        header("Location: " . RELATIVE_DIR . "client" . DS . "signup");
                        die();
                    }
                    
                    // For SQL, escape '\'
                    $avatarPath = str_replace("\\", "\\\\", $avatarPath);
                }
                else
                    $avatarPath = str_replace("\\", "\\\\", AVATAR_DIR . "default_avatar.png");

                $idNewClient = $cMan->add(["nickname" => $_POST['signup-nickname'],
                    "email" => $_POST['signup-email'],
                    "pw" => password_hash($_POST["signup-pw"], PASSWORD_ARGON2I),
                    "signedup" => date("Y-m-d H:i:s"),
                    "avatar" => $avatarPath,
                    "is_banned" => 0,
                    "grade_id" => $this->defaultClientGrade]);

                // Once the newly account created, connect him
                $newClient = $cMan->findOneById($idNewClient);
                Session::setCookie(Session::ID_COOKIE, password_hash($newClient->getId(), PASSWORD_ARGON2I));
                Session::createClientWithObject($newClient, true);

                header("Location: " . RELATIVE_DIR . "client" . DS . "profil");
                die();
            }

            return [
                "view" => DEFAULT_TEMPLATE,
                "data" => array("title" => "Nous rejoindre",
                    "content" => "Clients" . DS . "signup.php",
                    "args" => null,
                    "css" => CSS_LINK . "Clients" . DS . "signup.css\" />")
            ];
        }
    }
?>