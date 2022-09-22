<?php

namespace App\PortersObject;

class PortersOptionObject
{
    public $json;
    protected $fields = [
        'id' => 'Option.P_Id',
        'name' => 'Option.P_Name',
        'parent_id' => 'Option.P_ParentId',
        'position' => 'Option.P_Order',
    ];

    public $parentOptionId;
    public $children = [];

    function __construct($json)
    {
        $this->json = json_decode(json_encode($json));
    }

    function isParent()
    {
        return empty($this->parentOptionId);
    }

    function id()
    {
        return $this->getField('Option.P_Id');
    }

    function name()
    {
        return $this->getField('Option.P_Name');
    }

    function alias()
    {
        return $this->getField('Option.P_Alias');
    }

    function position()
    {
        return $this->getField('Option.P_Order');
    }

    function url()
    {
        return "";
    }

    function getField($field)
    {
        return (string)$this->json->$field;
    }
}
