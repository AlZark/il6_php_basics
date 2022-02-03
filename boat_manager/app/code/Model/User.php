<?php

namespace Model;

use Helper\DBHelper;

class User
{
    private $id;

    private $name;

    private $lastName;

    private $email;

    private $phone;

    private $password;

    private $activeCustomer;

    private $cityId;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getActiveCustomer()
    {
        return $this->activeCustomer;
    }

    public function setActiveCustomer($activeCustomer)
    {
        $this->activeCustomer = $activeCustomer;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function setCityId($cityId)
    {
        $this->cityId = $cityId;
    }

    public function save()
    {
        $data = [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'active_customer' => $this->activeCustomer,
            'city_id' => $this->cityId
        ];

        $db = new DBHelper();
        $db->insert('user', $data)->exec();
    }

    public static function getUsers()
    {
        $db = new DBHelper();
        $rez = $db->select('id, name, last_name')->from('user')->get();
        return $rez;
    }
}