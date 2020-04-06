<?php
    namespace Controller;

    use App\Session;
    use Model\Managers\ClientManager;

    /**
     * Controller reserved for admins.
     * 
     * @method manageClients() Show every Clients.
     * @method ban() Allow to ban a Client
     */
    class AdminController{

        // ---- METHODS ----
        
        /**
         * Show every Clients.
         */
        public function manageClients()
        {
            // Only for admins
            if (!Session::isCurrentAdmin())
                HomeController::invoke404();

            $cMan = new ClientManager();
            $clients = $cMan->findAll();

            return [
                "view" => DEFAULT_TEMPLATE,
                "data" => array("title" => "ADMIN - Gérer les Clients",
                    "content" => "Admins" . DS . "manageClients.php",
                    "args" => $clients,
                    "css" => CSS_LINK . "Admins" . DS . "defaultAdminCSS.css\" />")
            ];
        }
        
        /**
         * Allow to ban a Client.
         *
         * @param string $name The Client name.
         */
        public function ban($name)
        {
            if (!Session::isCurrentAdmin())
                HomeController::invoke404();
            
            $cMan = new ClientManager();
            $client = $cMan->findWithName($name);
            if ($client != null)
                $cMan->update($client->getId(),
                    ["is_banned" => $client->getIsBanned() ? "0" : "1"]);

            header("Location: " . RELATIVE_DIR . "client" . DS . "profil" . DS . $name);
        }
    }