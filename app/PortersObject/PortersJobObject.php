<?php

namespace App\PortersObject;

class PortersJobObject
{
    public $json;
    protected $fields = [
        'id' => 'Job.P_Id',
        'name' => 'Job.P_JobCategorySummary',
        'position' => 'Job.P_Position',
        'updater_id' => ['Job.P_UpdatedBy', 'User', 'User.P_Id'],
        'updater_name' => ['Job.P_UpdatedBy', 'User', 'User.P_Name'],
    ];

    protected $fieldName = [
        'category' => "Job.U_2D23E4CE9FE3FDB6C65E215A7815BC",
        'location' => "Job.U_9F4A30DAA98509B6DF57793A31EDD1",
    ];

    public function __construct($xml)
    {
        $this->json = json_decode(json_encode($xml));
    }

    public function id()
    {
        return $this->getField('Job.P_Id');
    }

    public function getField($fieldName)
    {
        $ar = (array) $this->json->$fieldName;
        return empty($ar) ? null : $ar[0];
    }
}

