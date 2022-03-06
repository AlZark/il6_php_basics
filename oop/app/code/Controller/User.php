<?php

namespace Controller;

use Core\Interfaces\ControllerInterface;
use Helper\FormHelper;
use Helper\Validator;
use Helper\Url;
use Model\User as UserModel;
use Model\City;
use Core\AbstractController;

class User extends AbstractController implements ControllerInterface
{

    public function index()
    {
        $this->data['users'] = UserModel::getAllUsers();
        $this->render('user/list');
    }

    public function show($id)
    {
        echo 'User controller ID: ' . $id;
    }

    public function register()
    {

        $form = new FormHelper('user/create', 'POST');

        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Vardas'
        ]);
        $form->input([
            'name' => 'last_name',
            'type' => 'text',
            'placeholder' => 'Pavarde'
        ]);
        $form->input([
            'name' => 'phone',
            'type' => 'text',
            'placeholder' => '+370'
        ]);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email'
        ]);

        $cities = City::getCities();
        $options = [];
        foreach ($cities as $city) {
            $id = $city->getId();
            $options[$id] = $city->getName();
        }
        $form->select([
            'name' => 'city_id',
            'options' => $options
        ]);

        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => '*********'
        ]);
        $form->input([
            'name' => 'password2',
            'type' => 'password',
            'placeholder' => '*********'
        ]);
        $form->input([
            'class' => 'submit',
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Register'
        ]);

        $this->data['form'] = $form->getForm(); //naujas array i kuri sukeliam Formos $form info kuria apsiraseme virsuje. Data originaliai sukurta AbstractController klaseje
        $this->render('user/register'); //dabar ta array paduodam render mothode kuris aprasytas AbstractController klaseje
    }

    public function login()
    {
        $form = new FormHelper('user/check', 'POST');
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email'
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => '********'
        ]);
        $form->input([
            'class' => 'submit',
            'name' => 'login',
            'type' => 'submit',
            'value' => 'Login'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('user/login');
    }

    public function edit()
    {
        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

        $userId = $_SESSION['user_id'];
        $user = new UserModel();
        $user->load($userId);

        $form = new FormHelper('user/update', 'POST');

        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Vardas',
            'value' => $user->getName(),
        ]);
        $form->input([
            'name' => 'last_name',
            'type' => 'text',
            'placeholder' => 'Pavarde',
            'value' => $user->getLastName(),
        ]);
        $form->input([
            'name' => 'phone',
            'type' => 'text',
            'placeholder' => '+370',
            'value' => $user->getPhone(),
        ]);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email',
            'value' => $user->getEmail(),
        ]);

        $cities = City::getCities();
        $options = [];
        foreach ($cities as $city) {
            $id = $city->getId();
            $options[$id] = $city->getName();
        }
        $form->select([
            'name' => 'city_id',
            'options' => $options,
            'selected' => $user->getCityId()
        ]);

        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => '*********'
        ]);

        $form->input([
            'name' => 'password2',
            'type' => 'password',
            'placeholder' => '*********'
        ]);

        $form->input([
            'class' => 'submit',
            'name' => 'update',
            'type' => 'submit',
            'value' => 'Update'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('user/edit');
    }

    public function create()
    {
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $isEmailValid = Validator::checkEmail($_POST['email']);
        $isEmailUnic = UserModel::isValueUnique('email', $_POST['email'], 'user');
        if ($passMatch && $isEmailValid && $isEmailUnic) {
            $user = new UserModel();
            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setPhone($_POST['phone']);
            $user->setPassword(md5($_POST['password']));
            $user->setEmail($_POST['email']);
            $user->setCityId($_POST['city_id']);
            $user->setActive(1);
            $user->setRoleId(0);
            $user->save();
            $_SESSION['success'] = "Registered successfully";
            Url::redirect('user/login');

        } else {
            $_SESSION['fail'] = "There were errors in the form, please try again";
            Url::redirect('user/register');
        }
    }

    public function update()
    {
        $userId = $_SESSION['user_id'];
        $user = new UserModel();
        $user->load($userId);
        $user->setName($_POST['name']);
        $user->setLastName($_POST['last_name']);
        $user->setPhone($_POST['phone']);
        $user->setCityId($_POST['city_id']);
        if ($_POST['password'] != '' & Validator::checkPassword($_POST['password'], $_POST['password2'])) {
            $user->setPassword(md5($_POST['password']));
        }

        if ($user->getEmail() != $_POST['email']) {
            if (Validator::checkEmail($_POST['email']) && UserModel::isValueUnique('email', $_POST['email'])) {
                $user->setEmail($_POST['email']);
            }
        }
        $user->save();
        Url::redirect('user/edit');
    }

    public function check()
    {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $userId = UserModel::checkLoginCredentials($email, $password);
        if ($userId) {
            $user = new UserModel();
            $user->load($userId);
            $_SESSION['logged'] = true;
            $_SESSION['user_id'] = $userId;
            $_SESSION['user'] = $user;
            $_SESSION['success'] = "Login successful, welcome!";
            Url::redirect('');
        } else {
            UserModel::logLoginFail($email);
            $_SESSION['fail'] = "User email or password incorrect";
            Url::redirect('user/login');
        }
    }

    public function logout()
    {
        session_destroy();
        Url::redirect('user/login');
    }
}