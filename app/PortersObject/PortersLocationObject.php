<?php

namespace App\PortersObject;

class PortersLocationObject extends PortersOptionObject
{
    function url()
    {
        return "/area/{$this->id()}";
    }
}
