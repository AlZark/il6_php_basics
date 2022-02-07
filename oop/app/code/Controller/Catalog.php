<?php

namespace Controller;

use Helper\DBHelper;
use Helper\FormHelper;
use Helper\Validator;
use Helper\Url;
use Model\Catalog as CatalogModel;
use Core\AbstractController;

class Catalog extends AbstractController
{

    public function add()
    {

        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

        $form = new FormHelper('catalog/create', 'POST');

        $form->input([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Title'
        ]);
        $form->textArea([
            'name' => 'description',
            'placeholder' => 'Description'
        ]);
        $form->input([
            'name' => 'price',
            'type' => 'number',
            'placeholder' => '20.00EUR',
            'step' => 'any'
        ]);

        $years = [];
        for ($i = 1970; $i <= date('Y'); $i++) {
            $years[$i] = $i;
        }
        $form->select([
            'name' => 'year',
            'options' => $years
        ]);

        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Create'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('catalog/add');

    }

    public function edit($id)
    {
        $catalog = new CatalogModel();
        $catalog->load($id);

        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

        $form = new FormHelper('catalog/update', 'POST');

        $form->input([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Title',
            'value' => $this->getTitle()
        ]);

        $form->input([

        ]);

        $form->textArea([
            'name' => 'description',
            'placeholder' => 'Description',
            'value' => $this->getDescritpion()
        ]);
        $form->input([
            'name' => 'price',
            'type' => 'number',
            'placeholder' => '20.00EUR',
            'step' => 'any',
            'value' => $this->getPrice()
        ]);

        $years = [];
        for ($i = 1970; $i <= date('Y'); $i++) {
            $years[$i] = $i;
        }
        $form->select([
            'name' => 'year',
            'options' => $years
        ]);

        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Update'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('catalog/edit');

    }

    public function show($id = null)
    {
        if ($id !== null) {
            echo 'Catalog controller ID' . $id;
        }
    }

    public function all($id)
    {
        $this->render('catalog/list');
    }

    public function create()
    {
        $catalog = new CatalogModel();
        $catalog->setTitle($_POST['title']);
        $catalog->setDescription($_POST['description']);
        $catalog->setManufacturerId(1);
        $catalog->setModelId(1);
        $catalog->setPrice($_POST['price']);
        $catalog->setYear($_POST['year']);
        $catalog->setTypeId(1);
        $catalog->setUserId($_SESSION['user_id']);
        $catalog->save();
    }

    public function update()
    {
        $catalogId = $_POST['id'];

        $catalog = new CatalogModel();
        $catalog->load($catalogId);
        $catalog->setTitle($_POST['title']);
        $catalog->setDescription($_POST['description']);
        $catalog->setManufacturerId(1);
        $catalog->setModelId(1);
        $catalog->setPrice($_POST['price']);
        $catalog->setYear($_POST['year']);
        $catalog->setTypeId(1);
        $catalog->save();
    }
}