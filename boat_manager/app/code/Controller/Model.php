<?php

namespace Controller;

use Helper\Validator;
use Model\BoatModel;
use Helper\FormHelper;
use Model\BoatType;

class Model
{
    public function add()
    {
        $form = new FormHelper('model/create', 'POST');

        $form->input([
            'type' => 'text',
            'name' => 'model_name',
            'placeholder' => 'Model name'
        ]);

        $types = BoatType::getTypes();
        $options = [];
        foreach ($types as $value){
            $id = $value->getId();
            $options[$id] = $value->getName();
        }
        $form->select($options, 'type');

        $years = [];
        for ($i = 1970; $i <= date('Y'); $i++) {
            $years[$i] = $i;
        }
        $form->select($years, 'year');

        $form->submit('Create', 'create');

        echo $form->getForm();
    }

    public function create()
    {
        if (Validator::isFilledOut($_POST['model_name'])) {
            $boat_model = new BoatModel();
            $boat_model->setName($_POST['model_name']);
            $boat_model->setTypeId($_POST['type']);
            $boat_model->setYear($_POST['year']);
            $boat_model->save();
        } else {
            echo 'Not all required fields filled out';
        }
    }

}