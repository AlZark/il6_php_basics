<?php

namespace Model;

use Helper\DBHelper;
use Helper\FormHelper;

class Boat
{
    private $id;

    private $name;

    private $model;

    private $length;

    private $width;

    private $depth;

    private $user_id;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getDepth()
    {
        return $this->depth;
    }

    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }


    public function addBoat()
    {
        $data = [
            'name' => $this->name,
            'model' => $this->model,
            'length' => $this->length,
            'width' => $this->width,
            'depth' => $this->depth,
            'user_id' => $this->user_id
        ];

        $db = new DBHelper();
        $db->insert('boat', $data)->exec();
    }


}