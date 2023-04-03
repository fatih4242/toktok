<?php
include $_SERVER["DOCUMENT_ROOT"] . "/includes/autoloader.inc.php";
$db = new Database();

//For db options, veritabanı ile veri çekmek
$db->Get("formName", "param for specific column", "multi line or not", "where key", "where id", "order by a column", "asc or desc");

//For save db options, veritabanına birşey kayıt ettirmek
$db->Save("formName", [
   "name" => "Fatih",
   "surname" => "Toker",
    "birthday" => date('Y-m-d H:i:s')
]);

//For update db options, veritabanında birşeyi güncellemek için
$db->Update("formName",[
    "name" => "Ahmet",
    "surname" => "Ak",
    "birthday" => 2022-12-12
],[
    //which column you want to update, hangi satırı güncellemek istiyorsunuz
    "id" => 2
]);

//for delete db options, veritabanında birşeyi silmek için
$db->Delete("formName","id", 12);


/* Admin Login (md5)*/
$admin = new Admin();

$admin->LoginAdmin("email", "password");


//check if is logged
$admin->CheckIsLogged();
?>