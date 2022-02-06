<?php

namespace Model;

use Helper\DBHelper;

class BoatModel
{

    private $id;

    private $name;

    private $type_id;

    private $year;

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
            'name' => $this->name,
            'type_id' => $this->type_id,
            'year' => $this->year
        ];

        $sql = new DBHelper();
        $sql->insert('model', $data)->exec();
    }

    public static function getModels()
    {

    }

    public function load($id)
    {

    }

    //Create update
}