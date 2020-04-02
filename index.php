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
    define("CSS_DIR", RELATIVE_DIR . "Public" . DS . "CSS" . DS);
    define("CSS_DIR_FRAG", CSS_DIR . "Fragment" . DS);
    define("AVATAR_DIR", RELATIVE_DIR . "Public" . DS . "Img" . DS . "Avatar" . DS);
    define("DEFAULT_AVATAR", "default_avatar.png");

    // -- Controllers    
    define("DEFAULT_TEMPLATE", "Templates" . DS . "defaultTemplate.php");

    define("CSS_LINK", "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . CSS_DIR);
    define("CSS_LINK_FRAGMENT", "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . CSS_DIR . "Fragment" . DS);

    // -- Autoloader --

    require("App\autoloader.php");

    // -- Session --

    Session::init();
    
    $URI_data = Utils::checkURI();
    
    if ($URI_data != null)
    {
        $controller = new $URI_data[0];
        $method = $URI_data[1];
        $id = $URI_data[2];
        $render = $controller->$method($id);
    }
    else
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