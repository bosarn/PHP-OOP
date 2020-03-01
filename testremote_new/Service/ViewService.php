<?php


class ViewService
{
    function ReplaceContent( $data, $template_html )
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

    public function ReplaceCities( $cities, $template_html )
    {
        $returnval = "";

        foreach ( $cities as $city )
        {
            $content = $template_html;
            $content = str_replace("@@img_id@@", $city->getId(), $content);
            $content = str_replace("@@img_title@@", $city->getTitle(), $content);
            $content = str_replace("@@img_filename@@", $city->getFileName(), $content);
            $content = str_replace("@@img_width@@", $city->getWidth(), $content);
            $content = str_replace("@@img_height@@", $city->getHeight(), $content);

            $returnval .= $content;
        }

        return $returnval;
    }
}