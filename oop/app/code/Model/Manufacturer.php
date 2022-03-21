<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class Manufacturer extends AbstractModel implements ModelInterfaces
{
    protected string $name;

    protected const TABLE = 'manufacturer';

    public function __construct(?int $id = null)
    {
        if($id !== null){
            $this->load($id);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function assignData(): void
    {
        $this->data = [
            'name' => $this->name,
        ];
    }

    public function load(int $id): object
    {
        $db = new DBHelper();
        $manufacturer = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = (int)$manufacturer['id'];
        $this->name = (string)$manufacturer['name'];
        return $this;
    }

    public static function getManufacturers(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $manufacturers = [];
        foreach ($data as $element){
            $manufacturer = new Manufacturer();
            $manufacturer->load((int)$element['id']);
            $manufacturers[] = $manufacturer;
        }
        return $manufacturers;
    }

    public static function getManufacturerIdByName(string $name)
    {
        $db = new DBHelper();
        $rez = $db->select('id')->from(self::TABLE)->where('name', $name)->getOne();

        if($rez == null){
            $data = new Manufacturer();
            $data->setName($name);
            $data->save();

            $db = new DBHelper();
            return $db->select('id')->from(self::TABLE)->where('name', $name)->getOne();
        } else {
            return $rez;
        }
    }

}