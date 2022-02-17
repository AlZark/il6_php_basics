<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Model extends AbstractModel
{
    protected $id;

    protected $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $model = $db->select()->from('model')->where('id', $id)->getOne();
        $this->id = $model['id'];
        $this->name = $model['name'];
        return $this;
    }

    public static function getModels()
    {
        $db = new DBHelper();
        $data = $db->select()->from('model')->get();
        $models = [];
        foreach ($data as $element){
            $model = new Model();
            $model->load($element['id']);
            $models[] = $model;
        }
        return $models;
    }
}