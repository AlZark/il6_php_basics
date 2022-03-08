<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class Model extends AbstractModel implements ModelInterfaces
{

    protected string $name;

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

    public function assignData(): void
    {
        $this->data = [];
    }

    public function load(int $id): object
    {
        $db = new DBHelper();
        $model = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = (int)$model['id'];
        $this->name = (string)$model['name'];
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
}