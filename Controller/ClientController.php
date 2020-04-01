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
        public function profil()
        {
            $title = "Connexion";
            $page = "login.php";

            if (isset($_POST['signin-nickname']) && isset($_POST['signin-pw'])){
                $cMan = new ClientManager();
                $client = $cMan->findWithNameAndPw($_POST['signin-nickname'], $_POST['signin-pw']);
                
                if ($client !== false)
                {
                    Session::setCookie(Session::ID_COOKIE, $client->getId());
                    Session::createClientWithObject($client, isset($_POST['signin-remember']) ? 1 : 0);
                }

                header("Location: index.php?ctrl=client&action=profil");
                die();
            }

            if (Session::isConnected())
            {
                $title = "Profil " . $_SESSION[Session::NICKNAME_SES];
                $page = "userProfil.php";
            }

            return [
                "view" => DEFAULT_TEMPLATE,
                "data" => array("title" => $title,
                    "content" => "Clients" . DS . $page,
                    "args" => null,
                    "css" => CSS_LINK . "Clients" . DS . "profil.css\" />")
            ];
        }
        
        /**
         * Disconnect the client, removing the session's values.
         */
        public function logout()
        {
            Session::destoyClientSession();
            header("Location: " . RELATIVE_DIR);
        }
        
        /**
         * Get to the sign-up page.
         */
        public function signup()
        {
            if (Session::isConnected())
                header("Location: " . RELATIVE_DIR);
            
            if (isset($_POST["signup-nickname"]) && isset($_POST["signup-pw"]) && isset($_POST["signup-email"]))
            {
                // -- Check if the Client already exists

                $cMan = new ClientManager();
                $exist = $cMan->findWithName($_POST["signup-nickname"]);
                if ($exist)
                {
                    header("Location: index.php?ctrl=client&action=signup");
                    die();
                }

                // -- If he does not exist, add a new Client, if the avatar is valid

                $avatarPath = null;
                
                // If the user uploaded an image
                if (isset($_FILES["signup-avatar"]))
                {
                    // TODO: The file name should be randomized and unique!
                    $type = $_FILES["signup-avatar"]["type"];
                    $type = substr($type, strpos($type, "/") + 1);
                    $avatarPath = AVATAR_DIR . strtolower($_POST["signup-nickname"]) . "." . $type;
                    
                    // If the image is NOT valid or does exist already, abort
                    if (file_exists($avatarPath) || !move_uploaded_file($_FILES["signup-avatar"]["tmp_name"], $avatarPath))
                    {
                        header("Location: index.php?ctrl=client&action=signup");
                        die();
                    }
                    
                    // For SQL, escape '\'
                    $avatarPath = str_replace("\\", "\\\\", $avatarPath);
                }

                $idNewClient = $cMan->add(["nickname" => $_POST['signup-nickname'],
                    "email" => $_POST['signup-email'],
                    "pw" => $_POST['signup-pw'],
                    "signedup" => date("Y-m-d H:i:s"),
                    "avatar" => $avatarPath != null ? $avatarPath : AVATAR_DIR . "default_avatar.png",
                    "grade_id" => $this->defaultClientGrade]);

                // Once the newly account created, connect him
                Session::createClientWithId($idNewClient);

                header("Location: index.php?ctrl=client&action=profil");
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