<?php

namespace Controller;

use Helper\DBHelper;
use Helper\FormHelper;
use Helper\Validator;
use Helper\Url;
use Model\Catalog as CatalogModel;

class Catalog
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

        echo $form->getForm();
    }

    public function show($id = null)
    {
        if ($id !== null) {
            echo 'Catalog controller ID' . $id;
        }
    }

    public function all($id)
    {
        for ($i = 0; $i < 10; $i++) {
            echo '<a href="http://localhost:8000/oop/index.php/catalog/show/' . $i . '">Read more';
            echo '<br>';
        }
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
}