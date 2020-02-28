<?php

class cityPusher
{
    private $city;

    public function __construct($city)
    {
        $this->city = $city;
    }

    public function PushCities()
    {
        if ( $this->city["savebutton"] == "Save" )
        {
            $id = $this->city["img_id"];
            $title = $this->city["img_title"];
            $width = $this->city["img_width"];
            $height = $this->city["img_height"];
            $filename = $this->city["img_filename"];
            $afterinsert = $this->city["afterinsert"];

            $sql ="update  images set img_title  = '$title', img_width = $width, img_height = $height, img_filename = '$filename' where img_id = $id";

            if ( ExecuteSQL($sql) ) $new_url =  "/PHP_OOP/testremote_new/$afterinsert?insertOK=true" ;
            header("Location: $new_url");

        }
    }
}

