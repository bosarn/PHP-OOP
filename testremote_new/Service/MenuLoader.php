<?php


class menuLoader
{
    public function getMenu(){
        $menu = array();
        $data = GetData("select * from menu order by men_order");

        foreach ($data as $row)
        {
            $caption =  $row["men_caption"];
            $destination =  $row["men_destination"];
            $item = new menu($caption, $destination);
            $menu[] = $item;
        }

        return $menu;
    }
}