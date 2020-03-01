<?php
require_once "lib/autoload.php";

global $filename;
$DownloadService = new DownloadService();
$DownloadService->PrintCSVHeader("taken" . date("Y_m_d_His"));


//veldnamenrij
echo implode(";", array("ID", "Datum", "Taak")) . "\r\n" ;

$sql = "SELECT * FROM taak" ;
$data = $container->GetData($sql);

//rijen met data
foreach( $data as $row )
{
    echo implode(";", $row) . "\r\n" ;
}