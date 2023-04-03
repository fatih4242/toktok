<?php
define("base_url", "http://localhost:63342/boykim");
class URL{

    public static function IS_LOCAL(){
        $isLocal = Extension::Stringcontain("localhost", base_url) ? true : false;
        return $isLocal;
    }

    public static function post($param){
        if(isset($_POST[$param])){
            $value = $_POST[$param];
        }else{
            $value = null;
        }
        return $value;
    }

    public static function get($param){
        if(isset($_GET[$param])){
            $value = $_GET[$param];
        }else{
            $value = null;
        }
        return $value;
    }

    public static function file($param){
        if(isset($_FILES[$param])){
            $value = $_FILES[$param];
        }else{
            $value = null;
        }
        return $value;
    }
}
?>
