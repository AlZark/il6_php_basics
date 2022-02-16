<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class BoatModel extends AbstractModel
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
        $data = new DBHelper();
        $data->select()->from('model')->where('id', $id)->getOne();
        $this->id = $data['id'];
        $this->id = $data['name'];

    }

    public static function getAllModels()
    {
        $data = new DBHelper();
        $rez = $data->select('id')->from('model')->get();
        foreach ($rez as $id){
            $id =
        }

    }

    //Create update
}