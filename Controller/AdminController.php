<?php
    namespace Controller;

    use App\Session;
    use Model\Managers\ClientManager;

    /**
     * Controller reserved for admins.
     * 
     * @method manageClients() Allow to modify some Clients rights.
     */
    class AdminController{

        // ---- METHODS ----

        /**
         * Allow to modify some Clients rights.
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
    }