<?php

    namespace App;

    use Model\Managers\ClientManager;
    use Controller\HomeController;

    /**
     * This class is intended for uploading files.
     */
    abstract class FileUploader{

        // ---- METHODS ----

        public static function uploadFile($fileName, $newFileName, $redirectPath)
        {
            $type = $_FILES[$fileName]["type"];
            $type = substr($type, strpos($type, "/") + 1);
            $avatarPath = AVATAR_DIR . $newFileName . "." . $type;
            
            // If the image is NOT valid or does exist already, abort
            if (file_exists($avatarPath) || !move_uploaded_file($_FILES[$fileName]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . $avatarPath))
            {
                header("Location: " . $redirectPath);
                die();
            }
            
            // For SQL, escape '\'
            $avatarPath = str_replace("\\", "\\\\", $avatarPath);
            
            return $avatarPath;
        }

        public static function removeAvatar($avatarPath)
        {
            $path = $_SERVER["DOCUMENT_ROOT"] . $avatarPath;
            if (file_exists($path))
                unlink($path);
        }
    }

?>