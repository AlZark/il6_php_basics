<?php

namespace Helper;

class DBHelper
{
    private $conn;

    private $sql;

    public function __construct()
    {
        $this->sql = '';
        try {
            $this->conn = new \PDO("mysql:host=" . SERVERNAME . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function select($fields = '*')
    {
        $this->sql .= 'SELECT ' . $fields . ' ';
        return $this;
    }

    public function from($table)
    {
        $this->sql .= 'FROM ' . $table . ' ';
        return $this;
    }

    public function update($table)
    {
        $values = "";
        $this->sql .= 'UPDATE ' . $table . ' SET ';
        foreach ($table as $key => $value) {
            $values .= $key . ' = ' . $value . ', ';
        }
        $this->sql .= rtrim(', ', $values);

        return $this;
    }

    public function insert($table, $data)
    {
        $this->sql .= 'INSERT INTO ' . $table .
            ' (' . implode(',', array_keys($data)) . ')
             VALUES ("' . implode('","', $data) . '")';
        return $this;
    }

    public function where($field, $value, $operator = '=')
    {
        $this->sql .= 'WHERE ' . $field . $operator . '"' . $value . '"';
        return $this;
    }

    public function delete()
    {
        $this->sql .= 'DELETE ';
        return $this;
    }

    public function get()
    {
        $rez = $this->conn->query($this->sql);
        return $rez->fetchAll();
    }

    public function exec()
    {
        $this->conn->query($this->sql);
    }

    public function getOne()
    {
        $rez = $this->conn->query($this->sql);
        $data = $rez->fetchAll();
        return $data[0];
    }
}

//3. Showing users boats
//4. Update user creation with city select
//5. Show only active customers
//6. Ability to activate deactivate customers
//7. Ability to edit boat
//8. Ability to delete boat
//9. Build router