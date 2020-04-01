<?php

    namespace App;

	spl_autoload_register(function($typeName){
		$file = $typeName . '.php';
		if (file_exists($file))
            include $file;
    });
    
?>