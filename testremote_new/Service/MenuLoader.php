<?php


class menuLoader
{
//    private function getMenu(){
//        $menu = array();
//        $data = GetData("select * from menu order by men_order");
//
//        foreach ($data as $row)
//        {
//            $caption =  $row["men_caption"];
//            $destination =  $row["men_destination"];
//            $item = new menu($caption, $destination);
//            $menu[] = $item;
//        }
//
//        return $menu;
//    }
//
//    private function replaceNavItem($data, $template)
//    {
//        $returnval = array();
//
//        foreach ( $data as $item )
//        {
//            $content = $template;
//            $content = str_replace("@@men_caption@@", $item->getCaption(), $content);
//            $content = str_replace("@@men_destination@@", $item->getDestination(), $content);
//
//
//            $returnval[] = $content;
//        }
//
//        return $returnval;
//    }
//
//    public function printNav()
//    {
//        $data = $this->getMenu();
//
//        //template voor 1 item samenvoegen met data voor items
//        $TemplateLoader = new TemplateLoader();
//        $template_navbar_item = $TemplateLoader->LoadTemplate("navbar_item");
//        $navbar_items = $this->replaceNavItem($data, $template_navbar_item);
//
//        //navbar template samenvoegen met resultaat ($navbar_items)
//        $template_navbar = $TemplateLoader->LoadTemplate("navbar");
//
//
//        foreach ( $navbar_items as $item => $value)
//        {
//            $content = str_replace("@@navbar_items@@", $value, $template_navbar);
//            print $content;
//        }
//
//    }

    public function PrintNav()
    {
        //navbar items ophalen
        $data = GetData("select * from menu order by men_order");

        $laatste_deel_url = basename($_SERVER['SCRIPT_NAME']);

        //aan de juiste datarij, de sleutels 'active' en 'sr-only' toevoegen
        foreach( $data as $r => $row )
        {
            if ( $laatste_deel_url == $data[$r]['men_destination'] )
            {
                $data[$r]['active'] = 'active';
                $data[$r]['sr_only'] = '<span class="sr-only">(current)</span>';
            }
            else
            {
                $data[$r]['active'] = '';
                $data[$r]['sr_only'] = '';
            }
        }


        //template voor 1 item samenvoegen met data voor items
        $TemplateLoader = new TemplateLoader();
        $template_navbar_item = $TemplateLoader->LoadTemplate("navbar_item");
        $navbar_items = $this->ReplaceContent($data, $template_navbar_item);

        //navbar template samenvoegen met resultaat ($navbar_items)
        $data = array( "navbar_items" => $navbar_items ) ;

        $template_navbar = $TemplateLoader->LoadTemplate("navbar");
        print $this->ReplaceContentOneRow($data, $template_navbar);
    }


    /* Deze functie voegt data en template samen en print het resultaat */
    public function ReplaceContent($data, $template_html )
    {
        $returnval = "";

        foreach ( $data as $row )
        {
            //replace fields with values in template
            $content = $template_html;
            foreach($row as $field => $value)
            {
                $content = str_replace("@@$field@@", $value, $content);
            }

            $returnval .= $content;
        }

        return $returnval;
    }



    /* Deze functie voegt data en template samen en print het resultaat */
    function ReplaceContentOneRow( $row, $template_html )
    {
        //replace fields with values in template
        $content = $template_html;
        foreach($row as $field => $value)
        {
            $content = str_replace("@@$field@@", $value, $content);
        }

        return $content;
    }
}