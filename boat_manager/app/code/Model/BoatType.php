<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class BoatType extends AbstractModel
{
    private $name;

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

    public function __construct()
    {
        $this->table = 'type';
    }

    protected function assignData()
    {
        $this->data = [
            'name' => $this->name
        ];
    }

    public static function getTypes()
    {
        $rez = new DBHelper();
        $data = $rez->select()->from('type')->get();

        $types = [];
        foreach ($data as $element){
            $type = new boatType();
            $type->load($element['id']); //nx kreiptis kiekviena karta???
            $types[] = $type;
        }
        return $types;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $type = $db->select()->from('type')->where('id', $id)->getOne();
        $this->id = $type['id'];
        $this->name = $type['name'];
        return $this;
    }

}