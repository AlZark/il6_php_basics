<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class User extends AbstractModel
{

    private $name;

    private $lastName;

    private $email;

    private $password;

    private $phone;

    private $cityId;

    private $city;

    private $login_fails;

    private $is_active;

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

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function setCityId($id)
    {
        $this->cityId = $id;
    }

    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getLoginFails()
    {
        return $this->login_fails;
    }

    /**
     * @param mixed $login_fails
     */
    public function setLoginFails($login_fails)
    {
        $this->login_fails = $login_fails;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }


    public function save()
    {
        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    private function create()
    {
        $data = [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'city_id' => $this->cityId,
            'is_active' => $this->is_active,
        ];

        $db = new DBHelper();
        $db->insert('user', $data)->exec();
    }

    private function update()
    {
        $data = [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'city_id' => $this->cityId
        ];

        $db = new DBHelper();
        $db->update('user', $data)->where('id', $this->id)->exec();
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
        $city = new City();
        $this->city = $city->load($this->cityId);
        return $this;
    }

    public function delete()
    {
        $db = new DBHelper();
        $db->delete()->from('user')->where('id', $this->id)->exec();
    }

    public static function emailUnic($email)
    {
        $db = new DBHelper();
        $rez = $db->select()->from('user')->where('email', $email)->get();
        return empty($rez);
    }

    public static function checkLoginCredentials($email, $pass)
    {
        $db = new DBHelper();
        $rez = $db
            ->select('id')
            ->from('user')
            ->where('email', $email)
            ->andWhere('password', $pass)
            ->getOne();

        if (isset($rez['id'])) {
            return $rez['id'];
        } else {
            return false;
        }
        //return isset($rez['id']) ? $rez['id'] : false;
    }

    public static function logLoginFail($email)
    {
        $db = new DBHelper();
        $rez = $db
            ->select('login_fails')
            ->from('user')
            ->where('email', $email)
            ->getOne();

        $total_failed = $rez['login_fails'];

        if($total_failed >= 4){
            $data = [
                'login_fails' => 5,
                'is_active' => 0
                ];
        } else {
            $total_failed++;
            $data = [
                'login_fails' => $total_failed
            ];
        }
        $db = new DBHelper();
        $db->update('user', $data)->where('email', $email)->exec();
    }

    public static function getAllUsers()
    {
        $db = new DBHelper();
        $data = $db->select()->from('user')->get();
        $users = [];
        foreach ($data as $element){
            $user = new User();
            $user->load($element['id']);
            $users[] = $user;
        }
        return $users;
    }

}