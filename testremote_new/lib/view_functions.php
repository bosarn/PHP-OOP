<?php

function PrintNavBar()
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

    $template_navbar_item = $TemplateLoader->LoadTemplate("navbar_item");
    $navbar_items = ReplaceContent($data, $template_navbar_item);

    //navbar template samenvoegen met resultaat ($navbar_items)
    $data = array( "navbar_items" => $navbar_items ) ;
    $template_navbar = $TemplateLoader->LoadTemplate("navbar");
    print ReplaceContentOneRow($data, $template_navbar);
}





/* Deze functie voegt data en template samen en print het resultaat */
