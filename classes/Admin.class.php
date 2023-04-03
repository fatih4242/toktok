<?php
include($_SERVER['DOCUMENT_ROOT'] . "/includes/error.inc.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/autoloader.inc.php';
session_start();
ob_start();
class Admin{
    function LoginAdmin($email, $password){
        $db = new Database();

        if($email != "" && $password != ""){
            try{
                $value = $db->Get("admin", null, false, null, null, null, null);
                print_r($value);
                if($email == $value["admin_email"] && md5($password) == $value["admin_password"]){
                    $_SESSION["password"] = md5($password);
                    header("Location: " . base_url . "/admin/index.php");
                }else{
                    $this->RedirectToErrorAdminPage("1");
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }   
        }else{
            $this->RedirectToErrorAdminPage("2");
        }
        echo "success 3";
    }

    private function RedirectToErrorAdminPage($errorMessage){
        header("Location: " . base_url . "/admin/login.php?error=". $errorMessage);
    }

    function CheckIsLogged(){
        try {
            if(isset($_SESSION["password"])){
                $db = new Database();
                try {
                    $value = $db->Get("admin", null, false, "id", "1", null, false);
                    if($value){
                        if ($value["admin_password"] != $_SESSION["password"]) $this->RedirectToErrorAdminPage("11");
                    }
                }catch (PDOException $e){
                    echo $e->getMessage();
                }
            }else $this->RedirectToErrorAdminPage("22");
        }catch (Exception $e){
           echo $e->getMessage();
        }
    }
}



?>