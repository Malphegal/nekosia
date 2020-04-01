<?php

    use App\Utils;
    use App\Session;
    use Controller\HomeController;

    // -- Defines --

    // -- General
    define("FORUM_TITLE", "Nekosia");
    define("TAB_TITLE", FORUM_TITLE . " - ");

    define("DS", DIRECTORY_SEPARATOR);
    
    // -- Directories
    define("RELATIVE_DIR", DS . "forum" . DS);
    define("BASE_DIR", __DIR__ . DS);
    define("VIEW_DIR", BASE_DIR . "view" . DS);
    define("FRAGMENT_DIR", VIEW_DIR . "Fragment" . DS);

    // -- Public
    define("CSS_DIR", "Public" . DS . "CSS" . DS);
    define("CSS_DIR_FRAG", CSS_DIR . "Fragment" . DS);
    define("AVATAR_DIR", "Public" . DS . "Img" . DS . "Avatar" . DS);
    define("DEFAULT_AVATAR", "default_avatar.png");

    // -- Controllers    
    define("DEFAULT_TEMPLATE", "Templates" . DS . "defaultTemplate.php");

    define("CSS_LINK", "<link rel=\"stylesheet\" type=\"text/css\" href=\"Public" . DS . "CSS" . DS);
    define("CSS_LINK_FRAGMENT", "<link rel=\"stylesheet\" type=\"text/css\" href=\"Public" . DS . "CSS" . DS . "Fragment" . DS);

    // -- Autoloader --

    require("App\autoloader.php");

    // -- Session --

    Session::init();
    
    // -- Controllers --

    if (isset($_GET['ctrl']))
        $ctrl = $_GET['ctrl'];
    else
        $ctrl = "home";
    
    $ctrl = "Controller\\" . ucfirst($ctrl) . "Controller";

    // Check if controller exists
    if (!file_exists($ctrl . ".php"))
        HomeController::invoke404();
    
    $controller = new $ctrl();

    // -- Action --

    if (isset($_GET['action']))
        $action = $_GET['action'];
    else
        $action = "index";

    if (isset($_GET['id']) && is_numeric($_GET['id']))
        $id = $_GET['id'];
    else
        $id = null;

    // Check if action exists
    $actionExists = method_exists(get_class($controller), $action);
    if ($actionExists)
        $render = $controller->$action($id);
    else
        HomeController::invoke404();

    // If $action == 'ajax_...', it's a AJAX request
    if (substr($action, 0, 4) == "ajax")
    {
        echo $render;
    }
    // Otherwise it's a full webpage request
    else
    {
        // If the URI is not valid
        if (file_exists(VIEW_DIR . $render['view']) && !Utils::checkURI())
            HomeController::invoke404();

        $data = $render["data"];
        $args_content = $data["args"];
        
        ob_start();

        require (VIEW_DIR . "Content" . DS . $data["content"]);
        $page_content = ob_get_contents();
        ob_clean();
        
        require (FRAGMENT_DIR . "header.php");
        $page_header = ob_get_contents();
        ob_end_clean();

        require (VIEW_DIR . $render["view"]);
    }