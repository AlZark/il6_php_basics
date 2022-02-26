<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Type extends AbstractModel
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

    protected const TABLE = 'type';

    public function __construct($id = null)
    {
        if($id !== null){
            $this->load($id);
        }
    }

    protected function assignData()
    {
        $this->data = [
            'title' => $this->name,
        ];
    }

    public function load($id)
    {
        $db = new DBHelper();
        $model = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = $model['id'];
        $this->name = $model['name'];
        return $this;
    }

    public static function getTypes()
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $types = [];
        foreach ($data as $element){
            $type = new Type();
            $type->load($element['id']);
            $types[] = $type;
        }
        return $types;
    }
}