<?php

namespace Controller;

use Helper\FormHelper;
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
        $form->textArea('description');
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
            'name' => 'image',
            'type' => 'text',
            'placeholder' => 'Image'
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

        if (!isset($_SESSION['user_id'])) {
            Url::redirect('user/login');
        }

        $catalog = new CatalogModel();
        $catalog->load($id);
        if ($_SESSION['user_id'] != $catalog->getUserId()) {
            Url::redirect('');
        }

        $form = new FormHelper('catalog/update', 'POST');

        $form->input([
            'name' => 'id',
            'type' => 'hidden',
            'value' => $catalog->getId()
        ]);

        $form->input([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Title',
            'value' => $catalog->getTitle()
        ]);

        $form->input([
            'name' => 'image',
            'type' => 'text',
            'placeholder' => 'Image',
            'value' => $catalog->getImg()
        ]);

        $form->textArea('description', $catalog->getDescription());
        $form->input([
            'name' => 'price',
            'type' => 'number',
            'placeholder' => '20.00EUR',
            'step' => 'any',
            'value' => $catalog->getPrice()
        ]);

        $years = [];
        for ($i = 1970; $i <= date('Y'); $i++) {
            $years[$i] = $i;
        }
        $form->select([
            'name' => 'year',
            'options' => $years,
            'selected' => $catalog->getYear()
        ]);

        $form->input([
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Update'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('catalog/edit');

    }

    public function show($id)
    {
        $catalog = new CatalogModel();
        $catalog->load($id);

        $this->data['catalog'] = $catalog;
        $this->render('catalog/view');

    }

    public function all()
    {
        $this->data['catalog'] = CatalogModel::getAllActiveAds();
        $this->render('catalog/all');
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
        $catalog->setImg($_SESSION['image']);
        $catalog->setIsActive(1);
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
        $catalog->setImg($_SESSION['image']);
        $catalog->setTypeId(1);
        $catalog->save();
    }
}