<?php

namespace Model;
use Core\AbstractModel;
use Helper\DBHelper;

class City extends AbstractModel
{

    private $name;

    protected const TABLE = 'cities';

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __construct($id = null)
    {
        if($id !== null){
            $this->load($id);
        }
    }

    public function load($id)
    {
        $db = new DBHelper();
        $city = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = $city['id'];
        $this->name = $city['name'];
        return $this;
    }

    public static function getCities()
    {
        $db = new DBHelper();
        $data = $db->select()->from('cities')->get();
        $cities = [];
        foreach ($data as $element){
            $city = new City(); // Kreipaimaes v4l nes loadas uzkrauna objekta kiekvienam miestui ir galim naudoti objekto funkcijas
            $city->load($element['id']);
            $cities[] = $city;
        }
        return $cities;
    }
}