<?php

class printHead
{
    public function __construct($css = "")
    {
        global $_application_folder;

        $str_stylesheets = "";
        if ( is_array($css))
        {
            foreach( $css as $stylesheet )
            {
                $str_stylesheets .= '<link rel="stylesheet" href="' . $_application_folder . '/css/' . $stylesheet . '">' ;
            }
        }

        $data = array("stylesheets" => $str_stylesheets );
        $TemplateLoader = new TemplateLoader();
        $template = $TemplateLoader->LoadTemplate("basic_head");
        $ViewService= new ViewService();
        print $ViewService->ReplaceContentOneRow($data, $template);

        $_SESSION["head_printed"] = true;
    }
}