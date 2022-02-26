<?php

namespace Controller;

use Core\AbstractController;
use Helper\Validator;
use Model\Model AS BoatModelModel;
use Helper\FormHelper;
use Model\BoatType;
use Helper\Url;

class Model extends AbstractController
{
    public function add()
    {

        if (!$this->isUserLoggedIn()) {
            Url::redirect('user/login');
        }

        $form = new FormHelper('model/create', 'POST');

        $form->input([
            'type' => 'text',
            'name' => 'model_name',
            'placeholder' => 'Model name'
        ]);

        $types = BoatType::getTypes();
        $options = [];
        foreach ($types as $value) {
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

        $this->data['form'] = $form->getForm();
        $this->render('model/add');
    }

    public function create()
    {
        if (Validator::isFilledOut($_POST['model_name'])) {
            $boat_model = new BoatModelModel();
            $boat_model->setName($_POST['model_name']);
            $boat_model->setTypeId($_POST['type']);
            $boat_model->setYear($_POST['year']);
            $boat_model->save();
        } else {
            echo 'Not all required fields filled out';
        }
    }

}