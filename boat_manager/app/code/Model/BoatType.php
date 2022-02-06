<?php

namespace Model;

use Helper\DBHelper;

class BoatType
{
    private $id;

    private $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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

    public function save()
    {
        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    public function create()
    {
        $data = [
            'name' => $this->name
        ];

        $sql = new DBHelper();
        $sql->insert('type', $data)->exec();
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