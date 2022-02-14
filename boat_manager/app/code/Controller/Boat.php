<?php

namespace Controller;

use Core\AbstractController;
use Helper\FormHelper;
use Helper\Validator;
use Model\Boat AS BoatModel;
use Model\User;
use Helper\Url;
class Boat extends AbstractController
{
    public function add()
    {

        if (!$this->isUserLoggedIn()) {
            Url::redirect('user/login');
        }

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

        $this->data['form'] = $form->getForm();
        $this->render('boat/add');
    }

    public function edit($id)
    {

        if (!$this->isUserLoggedIn()) {
            Url::redirect('user/login');
        }

        $form = new FormHelper('/boat/update', 'POST');

        $data = new BoatModel();
        $data->load($id);

        $form->input([
            'name' => 'id',
            'type' => 'hidden',
            'value' => $data->getId()
        ]);
        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Boat name',
            'value' => $data->getName()
        ]);
        $form->input([
            'name' => 'model',
            'type' => 'text',
            'placeholder' => 'Boat model',
            'value' => $data->getModelId()
        ]);
        $form->input([
            'name' => 'length',
            'type' => 'number',
            'step' => 'any',
            'placeholder' => 'Length',
            'value' => $data->getLength()
        ]);
        $form->input([
            'name' => 'width',
            'type' => 'number',
            'step' => 'any',
            'placeholder' => 'Width',
            'value' => $data->getWidth()
        ]);
        $form->input([
            'name' => 'depth',
            'type' => 'number',
            'step' => 'any',
            'placeholder' => 'Depth',
            'value' => $data->getDepth()
        ]);

        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Update',
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('boat/edit');
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
            $boat->setModelId($_POST['model']);
            $boat->setlength($_POST['length']);
            $boat->setWidth($_POST['width']);
            $boat->setDepth($_POST['depth']);
            $boat->setUserId($_POST['users']);

            $boat->save();
        } else {
            echo "Not all required fields are filled out";
        }
    }

    public function update()
    {
        $boatName = Validator::isFilledOut($_POST['name']);
        $boatModel = Validator::isFilledOut($_POST['model']);
        $boatLength = Validator::isFilledOut($_POST['length']);
        $boatWidth = Validator::isFilledOut($_POST['width']);
        $boatDepth = Validator::isFilledOut($_POST['depth']);

        if($boatName && $boatModel && $boatLength && $boatWidth && $boatDepth){
            $boatId = $_POST['id'];
            $boat = new BoatModel();
            $boat->load($boatId);
            $boat->setName($_POST['name']);
            $boat->setModelId($_POST['model']);
            $boat->setlength($_POST['length']);
            $boat->setWidth($_POST['width']);
            $boat->setDepth($_POST['depth']);

            $boat->save();
        } else {
            echo "Not all required fields are filled out";
        }
    }
}