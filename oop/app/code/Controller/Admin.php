<?php

namespace Controller;

use Core\AbstractController;
use Helper\Url;
use Model\Catalog as CatalogModel;
use Model\Manufacturer;
use Model\Type;
use Model\User;
use Helper\FormHelper;
use Model\City;
use Model\Catalog;
use Helper\Validator;
use Model\Model;

class Admin extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->isUserAdmin()) {
            Url::redirect('');
        }
    }

    public function index()
    {
        $this->render('index');
    }

    public function users()
    {
        $this->data['users'] = User::getAllUsers();
        $this->renderAdmin('users/list');
    }

    public function catalogs()
    {
        $this->data['catalogs'] = Catalog::getAllAds();
        $this->renderAdmin('catalogs/list');
    }

    public function userEdit($id)
    {
        if(!$this->isUserAdmin()) {
            Url::redirect('');
        }

        $user = new User();
        $user->load($id);

        $form = new FormHelper('admin/userUpdate', 'POST');

        $form->input([
            'name' => 'id',
            'type' => 'hidden',
            'value' => $user->getId()
        ]);

        $form->input([
            'name' => 'name',
            'type' => 'text',
            'placeholder' => 'Vardas',
            'value' => $user->getName(),
        ]);

        $form->input([
            'name' => 'last_name',
            'type' => 'text',
            'placeholder' => 'Pavarde',
            'value' => $user->getLastName(),
        ]);
        $form->input([
            'name' => 'phone',
            'type' => 'text',
            'placeholder' => '+370',
            'value' => $user->getPhone(),
        ]);
        $form->input([
            'name' => 'email',
            'type' => 'email',
            'placeholder' => 'Email',
            'value' => $user->getEmail(),
        ]);

        $cities = City::getCities();
        $options = [];
        foreach ($cities as $city) {
            $id = $city->getId();
            $options[$id] = $city->getName();
        }
        $form->select([
            'name' => 'city_id',
            'options' => $options,
            'selected' => $user->getCityId()
        ]);

        $form->select([
            'name' => 'is_active',
            'options' => [0 => 'Not active', 1 => 'Active'],
            'selected' => $user->getIsActive()
        ]);

        $form->select([
            'name' => 'role_id',
            'options' => [0 => 'User', 1 => 'Admin'],
            'selected' => $user->getRoleId()
        ]);

        $form->input([
            'name' => 'password',
            'type' => 'password',
            'placeholder' => '*********'
        ]);
        $form->input([
            'name' => 'password2',
            'type' => 'password',
            'placeholder' => '*********'
        ]);

        $form->input([
            'class' => 'submit',
            'name' => 'update',
            'type' => 'submit',
            'value' => 'Update'
        ]);

        $this->data['form'] = $form->getForm();
        $this->renderAdmin('users/edit');
    }

    public function userUpdate()
    {
        $userId = $_POST['id'];
        $user = new User();
        $user->load($userId);
        $user->setName($_POST['name']);
        $user->setLastName($_POST['last_name']);
        $user->setPhone($_POST['phone']);
        $user->setCityId($_POST['city_id']);
        if ($_POST['password'] != '' & Validator::checkPassword($_POST['password'], $_POST['password2'])) {
            $user->setPassword(md5($_POST['password']));
        }
        if ($user->getEmail() != $_POST['email']) {
            if (Validator::checkEmail($_POST['email']) && User::isValueUnique('email', $_POST['email'], 'user')) {
                $user->setEmail($_POST['email']);
            }
        }
        $user->setRoleId($_POST['role_id']);
        $user->setIsActive($_POST['is_active']);

        $user->save();
        Url::redirect('admin/users');
    }

    public function catalogEdit($id)
    {
        $catalog = new CatalogModel();
        $catalog->load($id);

        $form = new FormHelper('admin/catalogUpdate', 'POST');

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
        $this->renderAdmin('catalogs/edit');
    }

    public function catalogUpdate()
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
        $catalog->setColor($_POST['color']);
        $catalog->setMileage($_POST['mileage']);
        $catalog->save();

        Url::redirect('admin/catalogs');
    }

}