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

    private $catalogs;

    private $login_fails;

    private $is_active;

    private $role_id;

    protected const TABLE = 'user';

    public function __construct($id = null)
    {
        if($id !== null){
            $this->load($id);
        }
    }

    protected function assignData()
    {
        $this->data = [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'city_id' => $this->cityId,
            'role_id' => $this->role_id,
            'is_active' => $this->is_active,
        ];
    }

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

    public function getLoginFails()
    {
        return $this->login_fails;
    }

    public function setLoginFails($login_fails)
    {
        $this->login_fails = $login_fails;
    }

    public function getActive()
    {
        return $this->is_active;
    }

    public function setActive($is_active)
    {
        $this->is_active = $is_active;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
    }

    public function getCatalogs($id)
    {
        $db = new DBHelper();
        $data = $db->select('id')->from('ads')->where('user_id', $id)->get();
        return $data;
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->lastName = $data['last_name'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->cityId = $data['city_id'];
        $this->is_active = $data['is_active'];
        $this->role_id = $data['role_id'];

        $city = new City();
        $this->city = $city->load($this->cityId);

        return $this;
    }

    public static function checkLoginCredentials($email, $pass)
    {
        $db = new DBHelper();
        $rez = $db
            ->select('id')
            ->from(self::TABLE)
            ->where('email', $email)
            ->andWhere('password', $pass)
            ->andWhere('is_active', 1)
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
            ->from(self::TABLE)
            ->where('email', $email)
            ->getOne();

        $total_failed = $rez['login_fails'];

        if ($total_failed >= 4) {
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
        $db->update(self::TABLE, $data)->where('email', $email)->exec();
    }

    public static function getAllUsers()
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $users = [];
        foreach ($data as $element) {
            $user = new User();
            $user->load($element['id']);
            $users[] = $user;
        }
        return $users;
    }

    public function disable($id)
    {
        $data = ['is_active' => 0];

        $disable = new DBHelper();
        $disable->update(self::TABLE, $data)->where('id', $id)->exec();
    }

    public function enable($id)
    {
        $data = ['is_active' => 1];

        $disable = new DBHelper();
        $disable->update(self::TABLE, $data)->where('id', $id)->exec();
    }

    public function getFullName()
    {
        $db = new DBHelper();
        $user = $db->select('name, last_name')->from(self::TABLE)->where('id', $this->id)->getOne();
        return $user['name'] . ' ' . $user['last_name'];
    }

}