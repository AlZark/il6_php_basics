<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class User extends AbstractModel
{

    private $name;

    private $lastName;

    private $email;

    private $phone;

    private $password;

    private $activeCustomer;

    private $cityId;

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

    public function __construct()
    {
        $this->table = 'user';
    }

    protected function assignData()
    {
        $this->data = [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'active_customer' => $this->activeCustomer,
            'city_id' => $this->cityId
        ];
    }

    public static function getUsers()
    {
        $db = new DBHelper();
        $rez = $db->select('id, name, last_name')->from('user')->get();
        return $rez;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from('user')->where('id', $id)->getOne();
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->lastName = $data['last_name'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->cityId = $data['city_id'];
        $this->is_active = $data['is_active'];
//        $city = new City();
//        $this->city = $city->load($this->cityId);
        return $this;
    }

    public static function checkLoginCredentials($email, $password)
    {
        $db = new DBHelper();
        $rez = $db->select('id')->from('user')->where('email', $email)->andWhere('password', $password)->getOne();

        if (isset($rez['id'])){
            return $rez['id'];
        }else{
            return false;
        }
    }

}