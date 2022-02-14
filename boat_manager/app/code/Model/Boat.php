<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;
use Helper\FormHelper;

class Boat extends AbstractModel
{

    private $name;

    private $model_id;

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

    public function getModelId()
    {
        return $this->model_id;
    }

    public function setModelId($model_id)
    {
        $this->model_id = $model_id;
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

    public function __construct()
    {
        $this->table = 'boat';
    }

    public function assignData()
    {
        $this->data=[
            'id' => $this->id,
            'name' => $this->name,
            'model_id' => $this->model_id,
            'length' => $this->length,
            'width' => $this->width,
            'depth' => $this->depth,
            'user_id' => $this->user_id
        ];
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from('boat')->where('id', $id)->getOne();
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->model_id = $data['model_id'];
        $this->length = $data['length'];
        $this->width = $data['width'];
        $this->depth = $data['depth'];
        $this->user_id = $data['user_id'];
    }
}