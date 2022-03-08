<?php

declare(strict_types=1);

namespace Model;
use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class City extends AbstractModel implements ModelInterfaces
{

    private string $name;

    protected const TABLE = 'cities';

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __construct($id = null)
    {
        if($id !== null){
            $this->load((int)$id);
        }
    }
    public function assignData(): void
    {
        $this->data = [];
    }

    public function load($id): object
    {
        $db = new DBHelper();
        $city = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = (int)$city['id'];
        $this->name = (string)$city['name'];
        return $this;
    }

    public static function getCities(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from('cities')->get();
        $cities = [];
        foreach ($data as $element){
            $city = new City();
            $city->load((int)$element['id']);
            $cities[] = $city;
        }
        return $cities;
    }
}