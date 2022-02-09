<?php

namespace Core;
use Helper\DBHelper;

class AbstractModel
{
    private $id;

    public function isActive($table)
    {
        $db = new DBHelper();
        $data = $db->select('id')->from($table)->where('is_active', 1)->get();
        return $data;
    }

}