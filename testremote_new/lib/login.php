<?php
$login_form = true;
require_once "autoload.php";

$User = $_POST;
$loginPusher = new LoginPusher($User);
$loginPusher->PushLogin();

//$formname = $_POST["formname"];
//$buttonvalue = $_POST['loginbutton'];
//
//if ( $formname == "login_form" AND $buttonvalue == "Log in" )
//{
//    $UserService = new UserService();
//    $User = new User();
//    $User->setLogin($_POST['usr_login']);
//    $User->setPaswd($_POST['usr_paswd']);
//
//
//    if ( $UserService->CheckLogin($User) )
//    {
//        $MS->AddMessage( "Welkom, " . $User->getVoornaam() . "!" );
//        header("Location: " . $_application_folder . "/steden.php");
//    }
//    else
//    {
//        $MS->AddMessage( "Sorry! Verkeerde login of wachtwoord!", "error" );
//        header("Location: " . $_application_folder . "/login.php");
//
//    }
//}
//else
//{
//    $MS->AddMessage( "Foute formname of buttonvalue", "error" );
//
//}
