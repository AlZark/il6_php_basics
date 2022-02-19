<?php

namespace Controller;

use Helper\FormHelper;
use Helper\Url;
use Model\Catalog as CatalogModel;
use Model\Manufacturer;
use Model\Model;
use Model\Type;
use Core\AbstractController;

class Catalog extends AbstractController
{

    public function index()
    {
        $db = new CatalogModel();
        $adsCount = $db->totalAds($_GET['search_by']);

        $limit = 2;
        if (!isset ($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        $offset = ($page - 1) * $limit;
        $totalAds = $adsCount[0][0];
        $totalPages = ceil($totalAds / $limit);

        $this->data['page'] = $page;
        $this->data['allPages'] = $totalPages;

        $this->filter();
        if (!isset($_GET['submit'])) {
            $this->data['catalog'] = CatalogModel::getAllActiveAds($limit, $offset);
        } else {
            $this->data['catalog'] = CatalogModel::getAllActiveAds($limit, $offset, $_GET['order'], $_GET['search_by']);
        }
        $this->render('catalog/all');
    }

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

        $manufacturers = Manufacturer::getManufacturers();
        $options = [];
        foreach ($manufacturers as $manufacturer) {
            $id = $manufacturer->getId();
            $options[$id] = $manufacturer->getName();
        }

        $form->select([
            'name' => 'manufacturer_id',
            'options' => $options
        ]);

        $models = Model::getModels();
        $options = [];
        foreach ($models as $model) {
            $id = $model->getId();
            $options[$id] = $model->getName();
        }

        $form->select([
            'name' => 'model_id',
            'options' => $options
        ]);

        $types = Type::getTypes();
        $options = [];
        foreach ($types as $type) {
            $id = $type->getId();
            $options[$id] = $type->getName();
        }

        $form->select([
            'name' => 'type_id',
            'options' => $options
        ]);

        $form->input([
            'name' => 'img',
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

        $manufacturers = Manufacturer::getManufacturers();
        $options = [];
        foreach ($manufacturers as $manufacturer) {
            $id = $manufacturer->getId();
            $options[$id] = $manufacturer->getName();
        }

        $form->select([
            'name' => 'manufacturer_id',
            'options' => $options,
            'selected' => $catalog->getManufacturerId()
        ]);

        $models = Model::getModels();
        $options = [];
        foreach ($models as $model) {
            $id = $model->getId();
            $options[$id] = $model->getName();
        }

        $form->select([
            'name' => 'model_id',
            'options' => $options,
            'selected' => $catalog->getModelId()
        ]);

        $types = Type::getTypes();
        $options = [];
        foreach ($types as $type) {
            $id = $type->getId();
            $options[$id] = $type->getName();
        }

        $form->select([
            'name' => 'type_id',
            'options' => $options,
            'selected' => $catalog->getTypeId()
        ]);

        $form->input([
            'name' => 'img',
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
        $catalog->loadBySlug($slug);
        $newViews = (int)$catalog->getViews();
        $catalog->setViews($newViews);
        $catalog->save();
        $this->data['catalog'] = $catalog;
        $this->data['title'] = $catalog->getTitle();
        $this->data['meta_description'] = $catalog->getDescription();





        $manufacturers = Manufacturer::getManufacturers();
        $options = [];
        foreach ($manufacturers as $manufacturer) {
            $id = $manufacturer->getId();
            $options[$id] = $manufacturer->getName();
        }
        $this->data['manufacturer'] = Manufacturer::getManufacturers();






        if ($this->data['catalog']) {
            $this->data['related'] = $catalog->getRelatedAds($this->data['catalog']->getId(), $this->data['catalog']->getModelId(), $this->data['catalog']->getTitle());
            $this->render('catalog/view');
        } else {
            $this->render('parts/errors/error404');
        }
    }

    public function filter()
    {
        $form = new FormHelper('catalog/index', 'GET');

        $orderBy = [
            'created_at ASC' => 'Creation date asc',
            'created_at DESC' => 'Creation date desc',
            'price ASC' => 'Price asc',
            'price DESC' => 'Price desc',
            'title ASC' => 'Name A-Z',
            'title DESC' => 'Name Z-A',
        ];

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
        $catalog->setManufacturerId($_POST['manufacturer_id']);
        $catalog->setModelId($_POST['model_id']);
        $catalog->setPrice($_POST['price']);
        $catalog->setYear($_POST['year']);
        $catalog->setTypeId($_POST['type_id']);
        $catalog->setUserId($_SESSION['user_id']);
        $catalog->setImg($_POST['img']);
        $catalog->setIsActive(1);
        $catalog->setSlug($slug);
        $catalog->setCreatedAt($date);
        $catalog->setVin($_POST['vin']);
        $catalog->setViews(0);
        $catalog->save();
    }

    public function update()
    {
        $catalogId = $_POST['id'];
        $catalog = new CatalogModel();
        $catalog->load($catalogId);
        $catalog->setTitle($_POST['title']);
        $catalog->setDescription($_POST['description']);
        $catalog->setManufacturerId($_POST['manufacturer_id']);
        $catalog->setModelId($_POST['model_id']);
        $catalog->setPrice($_POST['price']);
        $catalog->setYear($_POST['year']);
        $catalog->setImg($_POST['img']);
        $catalog->setTypeId($_POST['type_id']);
        $catalog->setVin($_POST['vin']);
        $catalog->save();
    }

}