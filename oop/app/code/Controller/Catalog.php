<?php

declare(strict_types=1);

namespace Controller;

use Core\Interfaces\ControllerInterface;
use Helper\FormHelper;
use Helper\Pagination;
use Helper\StringHelper;
use Helper\Url;
use Model\Catalog as CatalogModel;
use Model\Manufacturer;
use Model\Model;
use Model\Type;
use Core\AbstractController;
use Model\Comments;

class Catalog extends AbstractController implements ControllerInterface
{

    public function index(): void
    {
        $adsCount = CatalogModel::totalActiveAds((string)$_GET['search_by']);
        $limit = 5;
        $pagination = Pagination::pagination($adsCount, $limit, $_GET['p']);
        $this->data['p'] = $pagination['page'];
        $this->data['allPages'] = $pagination['allPages'];

        $this->filter();
        if (!isset($_GET['order'])) {
            $this->data['ads'] = CatalogModel::getAllActiveAds($limit, $pagination['offset']);
        } else {
            $this->data['ads'] = CatalogModel::getAllActiveAds($limit, $pagination['offset'], (string)$_GET['order'], (string)$_GET['search_by']);
        }
        $this->render('ads/all');
    }

    public function add(): void
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
            'name' => 'mileage',
            'type' => 'number',
            'placeholder' => 'Mileage '
        ]);

        $form->input([
            'name' => 'color',
            'type' => 'text',
            'maxlength' => '14',
            'placeholder' => 'Color'
        ]);

        $form->input([
            'name' => 'vin',
            'type' => 'text',
            'maxlength' => '17',
            'placeholder' => 'VIN Code'
        ]);

        $form->input([
            'class' => 'submit',
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Create'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('ads/add');
    }

    public function edit(int $id): void
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
            'name' => 'mileage',
            'type' => 'number',
            'placeholder' => 'Mileage',
            'value' => $catalog->getMileage()
        ]);

        $form->input([
            'name' => 'color',
            'type' => 'text',
            'maxlength' => '14',
            'placeholder' => 'Color',
            'value' => $catalog->getColor()
        ]);

        $form->input([
            'name' => 'vin',
            'type' => 'text',
            'maxlength' => '17',
            'placeholder' => 'VIN Code',
            'value' => $catalog->getVin()
        ]);

        $form->input([
            'class' => 'submit',
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Update'
        ]);

        $this->data['form'] = $form->getForm();
        $this->render('ads/edit');
    }

    public function show(string $slug):void
    {
        $ad = new CatalogModel();
        $ad->loadBySlug($slug);
        $newViews = $ad->getViews();
        $ad->setViews($newViews + 1);
        $ad->save();
        $this->data['ads'] = $ad;
        $this->data['title'] = $ad->getTitle();
        $this->data['meta_description'] = $ad->getDescription();

        if ($this->data['ads']) {
            $this->data['related'] = $ad->getRelatedAds($this->data['ads']->getId());
            $this->render('ads/view');
        } else {
            $this->render('parts/errors/error404');
        }
    }

    public function filter(): void
    {
        $form = new FormHelper('catalog/index', 'GET');

        $orderBy = [
            'created_at DESC' => 'Newest to oldest',
            'created_at ASC' => 'Oldest to newest',
            'price ASC' => 'Lowest price',
            'price DESC' => 'Highest price',
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
            'class' => 'submit',
            'name' => 'submit',
            'type' => 'submit',
            'value' => 'Apply'
        ]);

        $this->data['form'] = $form->getForm();
    }

    public function create(): void
    {
        $date = Date("Y-m-d H:i:s");
        $slug = Url::generateSlug($_POST['title']);
        while (!CatalogModel::isValueUnique('slug', $slug)) {
            $slug .= rand(0, 99);
        }
        $catalog = new CatalogModel();
        $catalog->setTitle(StringHelper::censor($_POST['title']));
        $catalog->setDescription(StringHelper::censor($_POST['description']));
        $catalog->setManufacturerId((int)$_POST['manufacturer_id']);
        $catalog->setModelId((int)$_POST['model_id']);
        $catalog->setPrice((float)$_POST['price']);
        $catalog->setYear((int)$_POST['year']);
        $catalog->setTypeId((int)$_POST['type_id']);
        $catalog->setUserId((int)$_SESSION['user_id']);
        $catalog->setImg((string)$_POST['img']);
        $catalog->setActive(1);
        $catalog->setSlug($slug);
        $catalog->setCreatedAt((string)$date);
        $catalog->setVin((string)$_POST['vin']);
        $catalog->setColor((string)$_POST['color']);
        $catalog->setMileage((int)$_POST['mileage']);
        $catalog->setViews(0);
        $catalog->save();

        Url::redirect('catalog');
    }

    public function update(): void
    {
        $catalogId = $_POST['id'];
        $catalog = new CatalogModel();
        $catalog->load((int)$catalogId);
        $catalog->setTitle(StringHelper::censor((string)$_POST['title']));
        $catalog->setDescription(StringHelper::censor((string)$_POST['description']));
        $catalog->setManufacturerId((int)$_POST['manufacturer_id']);
        $catalog->setModelId((int)$_POST['model_id']);
        $catalog->setPrice((float)$_POST['price']);
        $catalog->setYear((int)$_POST['year']);
        $catalog->setImg((string)$_POST['img']);
        $catalog->setTypeId((int)$_POST['type_id']);
        $catalog->setVin((string)$_POST['vin']);
        $catalog->setColor((string)$_POST['color']);
        $catalog->setMileage((int)$_POST['mileage']);
        $catalog->save();

        Url::redirect('catalog');
    }

    public function comment(): void
    {
        if($this->isUserLoggedIn()) {
            if ($_POST['number1'] + $_POST['number2'] == $_POST['answer']) {
                $date = new CatalogModel();
                $catalog = $date->load((int)$_POST['catalog_id']);
                $date = Date("Y-m-d H:i:s");
                $comment = new Comments();
                $comment->setContent((string)$_POST['content']);
                $comment->setUserId((int)$_SESSION['user_id']);
                $comment->setAdId((int)$_POST['catalog_id']);
                $comment->setCreatedAt((string)$date);
                $comment->setIp((string)$_SERVER['REMOTE_ADDR']);
                $comment->save();
                Url::redirect('catalog/show/' . $catalog->getSlug());
            } else {
                Url::redirect('');
            }
        } Url::redirect('user/login');
    }

    public function commentDelete(int $id): void
    {
        if(!$this->isUserLoggedIn()){
            Url::redirect("user/login");
        }

        $comment = new Comments();
        $comment->load($id);
        $commenter = $comment->getUserId();
        $adId = $comment->getAdId();

        $ad = new CatalogModel();
        $ad->load($adId);
        $adOwner = $ad->getUserId();

        if ($_SESSION['user_id'] == $commenter || $_SESSION['user_id'] == $adOwner) {
            $comment->delete();
        } else {
            Url::redirect(""); //TODO redirect back to article
        }

        $comment->delete();
        Url::redirect(''); //TODO later will redirect back to the article
    }
}