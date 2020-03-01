<?php

$_application_folder = "/PHP-OOP/testremote_new";
$_root_folder = $_SERVER['DOCUMENT_ROOT'] . "$_application_folder";

//load Models
require_once $_root_folder . "/Model/City.php";
require_once $_root_folder . "/Model/User.php";
require_once $_root_folder . "/Model/Menu.php";
require_once $_root_folder . "/Model/Taken.php";



//load Services
require_once $_root_folder . "/Service/CityLoader.php";
require_once $_root_folder . "/Service/Container.php";
require_once $_root_folder . "/Service/ViewService.php";
require_once $_root_folder . "/Service/MessageService.php";
require_once $_root_folder . "/Service/UserService.php";
require_once $_root_folder . "/Service/TemplateLoader.php";
require_once $_root_folder . "/Service/CityPusher.php";
require_once $_root_folder . "/Service/MenuLoader.php";
require_once $_root_folder . "/Service/PrintHead.php";
require_once $_root_folder . "/Service/UploadService.php";
require_once $_root_folder . "/Service/DownloadService.php";

session_start();
$_SESSION["head_printed"] = false;

$MS = new MessageService();
$UserService = new UserService();
$TemplateLoader = new TemplateLoader();
$ReplaceContent = new ViewService();

require_once $_root_folder . "/lib/passwd.php";
require_once $_root_folder . "/lib/pdo.php";                 //database functies
require_once $_root_folder . "/lib/view_functions.php";      //basic_head, load_template, replacecontent...

//redirect naar NO ACCESS pagina als de gebruiker niet ingelogd is en niet naar
//de loginpagina gaat
if (!isset($_SESSION['usr']) AND !$login_form AND !$register_form AND !$no_access) {
    header("Location: " . $_application_folder . "/no_access.php");
}