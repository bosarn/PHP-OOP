<?php
require_once "autoload.php";

$User = $_POST;
$logoutService = new LogoutService($User);
$logoutService->LogoutUser();

//session_start();
//$UserService = new UserService();
//$UserService->LogLogoutUser();
//
//session_destroy();
//unset($_SESSION);
//
//session_start();
//session_regenerate_id();
//$MS->AddMessage( "U bent afgemeld!" );
//header("Location: " . $_application_folder . "/login.php");