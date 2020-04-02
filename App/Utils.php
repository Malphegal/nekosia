<?php  
    
    namespace App;

    /**
     * Utils class.
     * 
     * @method static newline_to_newp() Convert Windows new line '\r\n' with a '<br />'.
     * @method static checkURI() Check if the current requested URI is valid.
     */
    abstract class Utils{

        // ---- METHODS ----

        /**
         * Convert Windows new line '\r\n' with a '<br />'.
         *
         * @param string $str The string to convert.
         * @return string The new converted string.
         */
        public static function newline_to_newp($str)
        {
            $offset = 0;
            $allPos = [];
            while (($pos = strpos($str, "\r\n", $offset)) !== false)
            {
                $offset = $pos + 1;
                $allPos[] = $pos;
            }
            $allPos = array_reverse($allPos);
            foreach($allPos as $pos)
                $str = substr_replace($str, "</p><p>", $pos, 2);
            return $str;
        }
        
        /**
         * Check if the current requested URI is valid.
         *
         * @return bool Returns 'true' if the requested URI is valid, otherwise 'false'.
         */
        public static function checkURI()
        {
            $requestedPage = $_SERVER['REQUEST_URI'];
            
            // Remove root folder name
            $requestedPage = substr($requestedPage, strlen(RELATIVE_DIR));

            // Ignore '?' and what follows
            $interMark = strpos($requestedPage, "?");
            if ($interMark !== false)
                $requestedPage = substr($requestedPage, 0, $interMark);

            // Remove every '/' at the end.
            $requestedPage = preg_replace('/(\/+)$/', '', $requestedPage);
            $requestedPage = preg_replace('/(\/+)/', '/', $requestedPage);

            $splits = explode('/', $requestedPage);
 
            if ($splits[0] == "" || $splits[0] == "index.php")
                $splits[0] = "home";

            // -- Check empty
            
            if (count($splits) == 1)
            {
                if ($splits[0] == "home")
                    return ["Controller\\HomeController", "index", null];
                else
                    return null;
            }
 
            // -- Check too much args

            if (count($splits) > 3)
                return null;
                
            // -- Check Controller
            
            $controller = "Controller\\" . ucfirst($splits[0]) . "Controller";
            if (!class_exists($controller))
                return null;

            // -- Check Action

            // Only if there is no 'index()' in each Controller
            if (!isset($splits[1]))
                return null;
            
            $action = $splits[1];
            if (method_exists($controller, $action))
                return [$controller, $action, isset($splits[2]) ? $splits[2] : null];
            return null;
        }
    }
?>