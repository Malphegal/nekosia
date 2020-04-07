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

            if (isset($_POST['signin-nickname']) && isset($_POST['signin-pw'])){
                $cMan = new ClientManager();
                $client = $cMan->findWithNameAndPw($_POST['signin-nickname'], hash("sha256", $_POST['signin-pw']));
                
                if ($client !== false)
                {
                    if (!$client->getIsBanned())
                    {
                        Session::setCookie(Session::ID_COOKIE, hash("sha256", $client->getId()));
                        Session::createClientWithObject($client, isset($_POST['signin-remember']) ? 1 : 0);
                    }
                    else
                        HomeController::invoke404();
                }

                $headerLocation = "client" . DS . "profil" . ($profilName == null ? "" : "/" . $profilName);
                header("Location: " . RELATIVE_DIR . $headerLocation);
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
                    "pw" => hash("sha256", $_POST['signup-pw']),
                    "signedup" => date("Y-m-d H:i:s"),
                    "avatar" => $avatarPath,
                    "is_banned" => 0,
                    "grade_id" => $this->defaultClientGrade]);

                // Once the newly account created, connect him
                Session::createClientWithId($idNewClient);

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