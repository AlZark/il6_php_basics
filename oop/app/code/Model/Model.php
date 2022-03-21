<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class Model extends AbstractModel implements ModelInterfaces
{

    protected string $name;

    protected int $manufacturerId;

    protected const TABLE = 'model';

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

    public function getManufacturerId(): int
    {
        return $this->manufacturerId;
    }

    function setManufacturerId(int $manufacturerId): void
    {
        $this->manufacturerId = $manufacturerId;
    }

    public function assignData(): void
    {
        $this->data = [
            'name' => $this->name,
            'manufacturer_id' => $this->manufacturerId
        ];
    }

    public function load(int $id): object
    {
        $db = new DBHelper();
        $model = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = (int)$model['id'];
        $this->name = (string)$model['name'];
        $this->manufacturerId = (int)$model['manufacturer_id'];
        return $this;
    }

    public static function getModels(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $models = [];
        foreach ($data as $element){
            $model = new Model();
            $model->load((int)$element['id']);
            $models[] = $model;
        }
        return $models;
    }

    public static function getModelIdByName(string $name, int $manufacturerId)
    {
        $db = new DBHelper();
        $rez = $db->select('id')->from(self::TABLE)->where('name', $name)->getOne();

        if($rez == null){
            $data = new Model();
            $data->setName($name);
            $data->setManufacturerId((int)$manufacturerId);
            $data->save();

            $db = new DBHelper();
            return $db->select('id')->from(self::TABLE)->where('name', $name)->getOne();
        } else {
            return $rez;
        }
    }
}