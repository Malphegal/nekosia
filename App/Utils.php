<?php  
    
    namespace App;

    /**
     * Utils class.
     * 
     * @method static newline_to_newp() Convert Windows new line '\r\n' with a '<br />'.
     */
    abstract class Utils{

        // ---- METHODS ----

        /**
         * Convert Windows new line '\r\n' with a '<br />'.
         *
         * @param string $str The string to convert.
         * @return string The new converted string.
         */
        public static function newline_to_newp($str){
            $offset = 0;
            $allPos = [];
            while (($pos = strpos($str, "\r\n", $offset)) !== false){
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
        public static function checkURI(){
            $requestedPage = $_SERVER['REQUEST_URI'];
    
            // Remove root folder name
            $requestedPage = substr($requestedPage, strlen(RELATIVE_DIR));
    
            // Ignore '?' and what follows
            $interMark = strpos($requestedPage, "?");
            if ($interMark !== false)
                $requestedPage = substr($requestedPage, 0, $interMark);
    
            // Remove every '/' at the end. If so, use header to reload without '/'s.
            $finalRequestedPage = preg_replace('{(/)+$}', '', $requestedPage);
            if ($finalRequestedPage != $requestedPage)
            {
                header ("Location: " . RELATIVE_DIR . $finalRequestedPage);
                exit();            
            }
    
            // If the requested page does not exists, return false
            return !($requestedPage != "" && !file_exists($requestedPage));
        }
    }
?>