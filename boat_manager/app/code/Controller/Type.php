<?php

namespace Controller;

use Core\AbstractController;
use Model\BoatType;
use Helper\Validator;
use Helper\FormHelper;
use Helper\Url;

class Type extends AbstractController
{

    public function add()
    {

        if (!$this->isUserLoggedIn()) {
            Url::redirect('user/login');
        }

        $form = new FormHelper('type/create', 'POST');

        $form->input([
            'type' => 'text',
            'name' => 'boat_type',
            'placeholder' => 'Type name'
        ]);

        $form->submit('Add new type', 'create');

        $this->data['form'] = $form->getForm();
        $this->render('type/add');
    }

    public function create()
    {
        if (Validator::isFilledOut($_POST['boat_type'])) {
            $boat_type = new BoatType();
            $boat_type->setName($_POST['boat_type']);
            $boat_type->save();
        }
    }
}