<?php

namespace Core;

use Helper\DBHelper;

class AbstractModel
{

    protected $id;

    protected $table;

    protected $data;

    public function getId()
    {
        return $this->id;
    }

    public function save()
    {
        $this->assignData();
        if(!isset($this->id)){
            $this->create();
        }else{
            $this->update();
        }
    }

    protected function create()
    {
        $db = new DBHelper();
        $db->insert($this->table, $this->data)->exec();
    }

    public function update()
    {
        $db = new DBHelper();
        $db->update($this->table, $this->data)->where('id', $this->id)->exec();
    }

    protected function assignData()
    {
        $this->data = [];
    }

}