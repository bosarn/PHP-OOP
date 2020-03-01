<?php
$login_form = true;
require_once "autoload.php";

$User = $_POST;
$UserService = new UserService($User);
$UserService->PushLogin();

