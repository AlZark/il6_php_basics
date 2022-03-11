<?php

declare(strict_types=1);

namespace Core;

use Helper\DBHelper;

class AbstractModel
{
    protected array $data;

    protected string $table;

    protected int $id;

    protected const TABLE = '';

    public function getId(): int
    {
        return $this->id;
    }

    public function save(): void
    {
        $this->assignData();

        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    protected function create(): void
    {
        $db = new DBHelper();
        $db->insert(static::TABLE, $this->data)->exec();
    }

    protected function update(): void
    {
        $db = new DBHelper();
        $db->update(static::TABLE, $this->data)->where('id', $this->id)->exec();
    }

    protected function assignData(): void
    {
        $this->data = [];
    }

    public function delete(): void
    {
        $db = new DBHelper();
        $db->delete()->from(static::TABLE)->where('id', $this->id)->exec();
    }

    public static function isValueUnique(string $column, string $value): bool
    {
        $db = new DBHelper();
        $rez = $db->select()->from(static::TABLE)->where($column, $value)->get();
        return empty($rez);
    }

}