<?php
$register_form = true;
require_once "autoload.php";

$User = $_POST;
$RegisterPusher = new RegisterPusher($User);
$RegisterPusher->PushRegister();

//$formname = $_POST["formname"];
//$tablename = $_POST["tablename"];
//$pkey = $_POST["pkey"];
//
//if ( $formname == "registration_form" AND $_POST['register-but'] == "Register" )
//{
//    $UserService = new UserService();
//    $User = new User();
//    $UserService->ValidatePostedUserData($User);
//    $UserService->RegisterUser($User);
//}
