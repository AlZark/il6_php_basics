<?php

namespace Controller;

use Helper\FormHelper;
use Helper\Url;
use Model\Catalog as CatalogModel;
use Core\AbstractController;

class Catalog extends AbstractController
{

    public function index()
    {
        $this->filter();
        if (!isset($_GET['submit'])) {
            $this->data['catalog'] = CatalogModel::getAllActiveAds();
        } else {
            $this->data['catalog'] = CatalogModel::getAllActiveAds($_GET['order'], $_GET['search_by']);
        }
        $this->render('catalog/all');
    }

    public function add()
    {
        //TODO add type_id, manudacturer_id, model_id

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
            'name' => 'vin',
            'type' => 'text',
            'maxlength' => '17',
            'placeholder' => 'VIN Code'
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
        //TODO add type_id, manudacturer_id, model_id
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
        $form->input([
            'name' => 'vin',
            'type' => 'text',
            'maxlength' => '17',
            'placeholder' => 'VIN Code',
            'value' => $catalog->getVin()
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

    public function show($slug)
    {
        $catalog = new CatalogModel();

        $this->data['catalog'] = $catalog->loadBySlug($slug);
        if ($this->data['catalog']) {
            $this->data['related'] = $catalog->getRelatedAds($this->data['catalog']->getId(), $this->data['catalog']->getModelId(), $this->data['catalog']->getTitle());
            $this->render('catalog/view');
        } else {
            $this->render('parts/404');
        }
    }

    public function filter()
    {
        $form = new FormHelper('catalog/all', 'GET');

        $orderBy = [
            'created_at ASC' => 'Creation date asc',
            'created_at DESC' => 'Creation date desc',
            'price ASC' => 'Price asc',
            'price DESC' => 'Price desc',
            'title ASC' => 'Name A-Z',
            'title DESC' => 'Name Z-A',
        ];//TODO fix this fucking mess

        $form->input([
            'name' => 'search_by',
            'type' => 'text',
            'placeholder' => 'Search',
            'value' => $_GET['search_by']
        ]);

        $form->select([
            'name' => 'order',
            'options' => $orderBy,
            'selected' => $_GET['order'],
        ]);
        $form->input([
            'name' => 'submit',
            'type' => 'submit',
            'value' => 'Apply'
        ]);

        $this->data['form'] = $form->getForm();
    }

    public function create()
    {
        $date = Date("Y-m-d H:i:s");
        $slug = Url::generateSlug($_POST['title']);
        while (!CatalogModel::isValueUnique('slug', $slug, 'ads')) {
            $slug .= rand(0, 99);
        }
        $catalog = new CatalogModel();
        $catalog->setTitle($_POST['title']);
        $catalog->setDescription($_POST['description']);
        $catalog->setManufacturerId(1);
        $catalog->setModelId(1);
        $catalog->setPrice($_POST['price']);
        $catalog->setYear($_POST['year']);
        $catalog->setTypeId(1);
        $catalog->setUserId($_SESSION['user_id']);
        $catalog->setImg($_POST['image']);
        $catalog->setIsActive(1);
        $catalog->setSlug($slug);
        $catalog->setCreatedAt($date);
        $catalog->setVin($_POST['vin']);
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
        $catalog->setVin($_POST['vin']);
        $catalog->save();
    }

    public function newestAds()
    {
        $this->data['catalog'] = CatalogModel::getFiveAds('created_at');
        $this->render('parts/home');
    }

    public function mostViews() //TODO merge with newestAds function
    {
        $this->data['catalog'] = CatalogModel::getFiveAds('views');
        $this->render('parts/home');
    }

}