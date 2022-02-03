<?php

namespace Controller;

use Helper\FormHelper;
use Helper\Validator;
use Model\Boat AS BoatModel;
use Model\User;
class Boat
{
    public function add()
    {
        $form = new FormHelper('/boat/create', 'POST');
        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Boat name',
        ]);
        $form->input([
            'name' => 'model',
            'type' => 'text',
            'placeholder' => 'Boat model',
        ]);
        $form->input([
            'name' => 'length',
            'type' => 'number',
            'step' => 'any',
            'placeholder' => 'Length',
        ]);
        $form->input([
            'name' => 'width',
            'type' => 'number',
            'step' => 'any',
            'placeholder' => 'Width',
        ]);
        $form->input([
            'name' => 'depth',
            'type' => 'number',
            'step' => 'any',
            'placeholder' => 'Depth',
        ]);

        $users = User::getUsers();
        $userList = [];
        foreach ($users as $user){
            $userList[$user['id']] = $user['name'] . ' ' . $user['last_name'];
        }
        $form->select($userList, 'users');

        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Create',
        ]);

        echo $form->getForm();

    }

    public function editForm()
    {

    }

    public function create()
    {
        $boatName = Validator::isFilledOut($_POST['name']);
        $boatModel = Validator::isFilledOut($_POST['model']);
        $boatLength = Validator::isFilledOut($_POST['length']);
        $boatWidth = Validator::isFilledOut($_POST['width']);
        $boatDepth = Validator::isFilledOut($_POST['depth']);

        if($boatName && $boatModel && $boatLength && $boatWidth && $boatDepth){
            $boat = new BoatModel();
            $boat->setName($_POST['name']);
            $boat->setModel($_POST['model']);
            $boat->setlength($_POST['length']);
            $boat->setWidth($_POST['width']);
            $boat->setDepth($_POST['depth']);
            $boat->setUserId($_POST['users']);

            $boat->addBoat();
        } else {
            echo "Not all required fields are filled out";
        }
    }
}