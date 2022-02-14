<?php

namespace Controller;

use Core\AbstractController;
use Helper\FormHelper;
use Helper\Validator;
use Model\User as UserModel;
use Helper\Url;

class User extends AbstractController
{

    public function register()
    {

        $form = new FormHelper('/user/create', 'POST');
        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Name',
        ]);
        $form->input([
            'name' => 'last_name',
            'type' => 'text',
            'placeholder' => 'Last name',
        ]);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email',
        ]);
        $form->input([
            'name' => 'phone',
            'type' => 'text',
            'placeholder' => '+370*******',
        ]);
        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => 'Password',
        ]);
        $form->input([
            'name' => 'password2',
            'type' => 'password',
            'placeholder' => 'Repeat password',
        ]);
        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Create',
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('user/register');
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
            'name' => 'login',
            'type' => 'submit',
            'value' => 'Login'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('user/login');
    }

    public function create()
    {
        $passwordsMatch = Validator::passMatch($_POST['password'], $_POST['password2']);

        if($passwordsMatch){
            $user = new UserModel();
            $user->setName($_POST['name']);
            $user->setLastName($_POST['last_name']);
            $user->setEmail($_POST['email']);
            $user->setPhone($_POST['phone']);
            $user->setPassword(md5($_POST['password']));
            $user->setActiveCustomer(0);
            $user->setCityId(1);

            $user->save();
        }else{
            echo 'Smthn wrong';
        }
    }

    public function check()
    {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $userId = UserModel::checkLoginCredentials($email, $password);
        echo $userId;

        if ($userId) {
            $user = new UserModel();
            $user->load($userId);
            $_SESSION['logged'] = true;
            $_SESSION['user_id'] = $userId;
            $_SESSION['user'] = $user;
            Url::redirect('');
        }
    }


    public function logout()
    {
        session_destroy();
        Url::redirect('user/login');
    }
}