<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Model extends AbstractModel
{

    private $name;

    private $type_id;

    private $year;

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

    /**
     * @return mixed
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @param mixed $type_id
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    public function __construct()
    {
        $this->table = 'model';
    }

    protected function assignData()
    {
        $this->data = [
            'name' => $this->name,
            'type_id' => $this->type_id,
            'year' => $this->year
        ];
    }

    public static function getModels()
    {

    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from('model')->where('id', $id)->getOne();
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->type_id = $data['type_id'];
        $this->year = $data['year'];
        return $this;
    }

    public static function getAllModels()
    {
        $data = new DBHelper();
        $rez = $data->select('id')->from('model')->get();
        $models = [];
        foreach ($rez as $element){
            $model = new Model();
            $model->load($element['id']);
            $models[] = $model;
        }
        return $models;
    }

    //Create update
}