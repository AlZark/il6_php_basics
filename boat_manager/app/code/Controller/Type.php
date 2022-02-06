<?php

namespace Controller;

use Model\BoatType;
use Helper\Validator;
use Helper\FormHelper;

class Type
{

    public function add()
    {
        $form = new FormHelper('type/create', 'POST');

        $form->input([
            'type' => 'text',
            'name' => 'boat_type',
            'placeholder' => 'Type name'
        ]);

        $form->submit('Add new type', 'create');

        echo $form->getForm();
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