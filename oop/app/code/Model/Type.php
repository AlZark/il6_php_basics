<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class Type extends AbstractModel implements ModelInterfaces
{

    protected string $name;

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    protected const TABLE = 'type';

    public function __construct(?int $id = null)
    {
        if($id !== null){
            $this->load($id);
        }
    }

    public function assignData(): void
    {
        $this->data = [
            'title' => $this->name,
        ];
    }

    public function load(int $id): object
    {
        $db = new DBHelper();
        $model = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = (int)$model['id'];
        $this->name = (string)$model['name'];
        return $this;
    }

    public static function getTypes(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $types = [];
        foreach ($data as $element){
            $type = new Type();
            $type->load((int)$element['id']);
            $types[] = $type;
        }
        return $types;
    }
}