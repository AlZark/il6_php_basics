<?php

namespace Core;

use Helper\DBHelper;

class AbstractModel
{
    protected $data;

    protected $table;

    protected $id;

    protected const TABLE = '';

    public function getId()
    {
        return $this->id;
    }

    public function save()
    {
        $this->assignData();

        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    protected function create()
    {
        $db = new DBHelper();
        $db->insert(static::TABLE, $this->data)->exec();
    }

    protected function update()
    {
        $db = new DBHelper();
        $db->update(static::TABLE, $this->data)->where('id', $this->id)->exec();
    }

    protected function assignData()
    {
        $this->data = [];
    }

    public function delete()
    {
        $db = new DBHelper();
        $db->delete()->from(static::TABLE)->where('id', $this->id)->exec();
    }

    public static function isValueUnique($column, $value)
    {
        $db = new DBHelper();
        $rez = $db->select()->from(static::TABLE)->where($column, $value)->get();
        return empty($rez);
    }

    //Use pagination below, but rewrite it so that filters work as well
//    public function count()
//    {
//            $db = new DBHelper();
//            $rez = $db->select('COUNT(id)')->from(static::TABLE)->where('active', 1)->get();
//            $data = $rez->fetchAll();
//            print_r($data);
//            return $rez;
//    }

}