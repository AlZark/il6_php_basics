<?php

namespace Controller;

use Helper\FormHelper;
use Helper\Validator;
use Model\User as UserModel;

class User
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

        echo $form->getForm();
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


}