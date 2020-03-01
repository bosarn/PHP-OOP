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
        global $container;
        //navbar items ophalen
        $data = $container->GetData("select * from menu order by men_order");

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
        $ViewService = new ViewService();
        $template_navbar_item = $TemplateLoader->LoadTemplate("navbar_item");
        $navbar_items = $ViewService->ReplaceContent($data, $template_navbar_item);

        //navbar template samenvoegen met resultaat ($navbar_items)
        $data = array( "navbar_items" => $navbar_items ) ;

        $template_navbar = $TemplateLoader->LoadTemplate("navbar");
        print $ViewService->ReplaceContentOneRow($data, $template_navbar);
    }




}