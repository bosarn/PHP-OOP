<?php

class menu
{
    private $caption;
    private $destination;

    public function __construct($caption, $destination )
    {
        $this->caption = $caption;
        $this->destination = $destination;
    }

    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->destination;
    }
}
