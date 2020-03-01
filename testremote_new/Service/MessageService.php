<?php

class MessageService
{

    public function AddMessage( $msg, $type = "info" )
    {
        $_SESSION["$type"][] = $msg ;
    }

    /**
     * @param ViewService
     */
    public function ShowMessages()
    {
        if ( ! $_SESSION["head_printed"] ) BasicHead();

        //weergeven 2 soorten messages: errors en infos
        foreach( array("error", "info") as $type )
        {
            if ( key_exists("$type", $_SESSION) AND is_array($_SESSION["$type"]) AND count($_SESSION["$type"]) > 0 )
            {
                foreach( $_SESSION["$type"] as $message )
                {
                    $row = array( "message" => $message );
                    $TemplateLoader = new TemplateLoader();
                    $viewservice = new ViewService();
                    $templ = $TemplateLoader->LoadTemplate("$type" . "s");   // errors.html en infos.html
                     print $viewservice->ReplaceContentOneRow( $row, $templ );
                }
//
                unset($_SESSION["$type"]);
            }
        }

    }

}