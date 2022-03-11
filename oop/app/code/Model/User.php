<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterfaces;
use Helper\DBHelper;

class User extends AbstractModel implements ModelInterfaces
{
    private string $name;

    private string $lastName;

    private string $email;

    private string $password;

    private string $phone;

    private int $cityId;

    private object $city;

    private int $login_fails;

    private int $active;

    private int $role_id;

    protected const TABLE = 'user';

    public function __construct(?int $id = null)
    {
        if($id !== null){
            $this->load($id);
        }
    }

    public function assignData(): void
    {
        $this->data = [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'city_id' => $this->cityId,
            'role_id' => $this->role_id,
            'active' => $this->active,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    public function getCityId(): int
    {
        return $this->cityId;
    }

    public function setCityId(int $id): void
    {
        $this->cityId = $id;
    }

    public function getCity(): object
    {
        return $this->city;
    }

    public function getLoginFails(): int
    {
        return $this->login_fails;
    }

    public function setLoginFails(int $login_fails): void
    {
        $this->login_fails = $login_fails;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function setRoleId(int $role_id): void
    {
        $this->role_id = $role_id;
    }

    public function getCatalogs(int $id): array
    {
        $db = new DBHelper();
        $data = $db->select('id')->from('ads')->where('user_id', $id)->get();
        return $data;
    }

    public function load(int $id): object
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where('id', $id)->getOne();
        $this->id = (int)$data['id'];
        $this->name = (string)$data['name'];
        $this->lastName = (string)$data['last_name'];
        $this->phone = (string)$data['phone'];
        $this->email = (string)$data['email'];
        $this->password = (string)$data['password'];
        $this->cityId = (int)$data['city_id'];
        $this->active = (int)$data['active'];
        $this->role_id = (int)$data['role_id'];

        $city = new City();
        $this->city = $city->load($this->cityId);

        return $this;
    }

    public static function checkLoginCredentials(string $email, string $pass)
    {
        $db = new DBHelper();
        $rez = $db
            ->select('id')
            ->from(self::TABLE)
            ->where('email', $email)
            ->andWhere('password', $pass)
            ->andWhere('active', 1)
            ->getOne();

        if (isset($rez['id'])) {
            return (int)$rez['id'];
        } else {
            return false;
        }
    }

    public static function logLoginFail(string $email): void
    {
        $db = new DBHelper();
        $rez = $db
            ->select('login_fails')
            ->from(self::TABLE)
            ->where('email', $email)
            ->getOne();

        $total = $rez['login_fails'];

        if ($total >= 4) {
            $data = [
                'login_fails' => 5,
                'active' => 0
            ];
        } else {
            $total++;
            $data = [
                'login_fails' => $total
            ];
        }
        $db = new DBHelper();
        $db->update(self::TABLE, $data)->where('email', $email)->exec();
    }

    public static function getAllUsers(): array
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();
        $users = [];
        foreach ($data as $element) {
            $user = new User();
            $user->load((int)$element['id']);
            $users[] = $user;
        }
        return $users;
    }

    public function getFullName(): string
    {
        $db = new DBHelper();
        $user = $db->select('name, last_name')->from(self::TABLE)->where('id', $this->id)->getOne();
        return $user['name'] . ' ' . $user['last_name'];
    }

    public static function totalUsers(): int
    {
        $total = new DBHelper();
        $rez = $total
            ->select('COUNT(id)')
            ->from(self::TABLE)
            ->get();

        return (int)$rez[0][0];
    }

    public static function totalActiveUsers(): int
    {
        $total = new DBHelper();
        $rez = $total
            ->select('COUNT(id)')
            ->from(self::TABLE)
            ->where('active', '1')
            ->get();

        return (int)$rez[0][0];
    }

    public static function totalNewUsers(): int
    {
        $date = Date("Y-m-d H:i:s");
        $date = strtotime($date);
        $date = date("Y-m-d H:i:s", strtotime("-7 day", $date));

        $total = new DBHelper();
        $rez = $total
            ->select('COUNT(id)')
            ->from(self::TABLE)
            ->where('created_at', $date, '>=')
            ->get();

        return (int)$rez[0][0];
    }

}