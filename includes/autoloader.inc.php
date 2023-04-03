<?php
//include $_SERVER['DOCUMENT_ROOT'] . "/includes/error.inc.php";
spl_autoload_register("myAutoLoader");

function myAutoLoader($className){
    $path = $_SERVER['DOCUMENT_ROOT'] . "/classes/";
    $extension = ".class.php";
    $fullPath = $path . $className . $extension;
    if (!file_exists($fullPath)) {
        return false;
    }
    include_once $fullPath;
}

?>