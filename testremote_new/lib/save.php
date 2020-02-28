<?php
require_once "autoload.php";

$city = $_POST;
$cityPusher = new cityPusher($city);
$cityPusher->PushCities();

?>