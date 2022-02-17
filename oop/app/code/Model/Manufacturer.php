<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Manufacturer extends AbstractModel
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
        $manufacturer = $db->select()->from('manufacturer')->where('id', $id)->getOne();
        $this->id = $manufacturer['id'];
        $this->name = $manufacturer['name'];
        return $this;
    }

    public static function getManufacturers()
    {
        $db = new DBHelper();
        $data = $db->select()->from('manufacturer')->get();
        $manufacturers = [];
        foreach ($data as $element){
            $manufacturer = new Manufacturer();
            $manufacturer->load($element['id']);
            $manufacturers[] = $manufacturer;
        }
        return $manufacturers;
    }

}