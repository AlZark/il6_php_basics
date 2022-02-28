<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\Url;
use Model\Catalog;
use Model\User;
use Model\Manufacturer;
use Model\Type;
use Helper\FormHelper;
use Model\City;
use Helper\Validator;
use Model\Model;

class Admin extends AbstractController implements ControllerInterface
{

    public const ACTIVE = 1;

    public const NOT_ACTIVE = 0;

    public const DELETE = 2;

    public function __construct()
    {
        parent::__construct();
        if (!$this->isUserAdmin()) {
            Url::redirect('');
        }
    }

    public function index()
    {
        $this->render('admin/index');
    }

    public function users()
    {
        $this->data['users'] = User::getAllUsers();
        $this->renderAdmin('users/list');
    }

    public function catalogs()
    {
        $this->data['ads'] = Catalog::getAllAds();
        $this->renderAdmin('ads/list');
    }

    public function userEdit($id)
    {
        if (!$this->isUserAdmin()) {
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
            'selected' => $user->GetActive()
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
        $user->setActive($_POST['is_active']);

        $user->save();
        Url::redirect('admin/users');
    }

    public function userDelete($id)
    {
        $user = new User($id);
        $user->delete();
        Url::redirect('admin/users');
    }

    public function adEdit($id)
    {
        $ad = new Catalog();
        $ad->load($id);

        $form = new FormHelper('admin/adUpdate', 'POST');

        $form->input([
            'name' => 'id',
            'type' => 'hidden',
            'value' => $ad->getId()
        ]);

        $form->input([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Title',
            'value' => $ad->getTitle()
        ]);

        $form->textArea('description', $ad->getDescription());
        $form->input([
            'name' => 'price',
            'type' => 'number',
            'placeholder' => '20.00EUR',
            'step' => 'any',
            'value' => $ad->getPrice()
        ]);

        $years = [];
        for ($i = 1970; $i <= date('Y'); $i++) {
            $years[$i] = $i;
        }
        $form->select([
            'name' => 'year',
            'options' => $years,
            'selected' => $ad->getYear()
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
            'selected' => $ad->getManufacturerId()
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
            'selected' => $ad->getModelId()
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
            'selected' => $ad->getTypeId()
        ]);

        $form->input([
            'name' => 'img',
            'type' => 'text',
            'placeholder' => 'Image',
            'value' => $ad->getImg()
        ]);

        $form->input([
            'name' => 'mileage',
            'type' => 'number',
            'placeholder' => 'Mileage',
            'value' => $ad->getMileage()
        ]);

        $form->input([
            'name' => 'color',
            'type' => 'text',
            'maxlength' => '14',
            'placeholder' => 'Color',
            'value' => $ad->getColor()
        ]);

        $form->input([
            'name' => 'vin',
            'type' => 'text',
            'maxlength' => '17',
            'placeholder' => 'VIN Code',
            'value' => $ad->getVin()
        ]);

        $form->select([
            'name' => 'is_active',
            'options' => [0 => 'Not active', 1 => 'Active'],
            'selected' => $ad->getActive()
        ]);

        $form->input([
            'class' => 'submit',
            'name' => 'create',
            'type' => 'submit',
            'value' => 'Update'
        ]);

        $this->data['form'] = $form->getForm();
        $this->renderAdmin('ads/edit');
    }

    public function adUpdate()
    {
        $adId = $_POST['id'];
        $ad = new Catalog();
        $ad->load($adId);
        $ad->setTitle($_POST['title']);
        $ad->setDescription($_POST['description']);
        $ad->setManufacturerId($_POST['manufacturer_id']);
        $ad->setModelId($_POST['model_id']);
        $ad->setPrice($_POST['price']);
        $ad->setYear($_POST['year']);
        $ad->setImg($_POST['img']);
        $ad->setTypeId($_POST['type_id']);
        $ad->setVin($_POST['vin']);
        $ad->setColor($_POST['color']);
        $ad->setMileage($_POST['mileage']);
        $ad->setActive($_POST['is_active']);
        $ad->save();

        Url::redirect('admin/catalogs');
    }

    public function adDelete($id)
    {
        $ad = new Catalog($id);
        $ad->delete();
        Url::redirect('admin/catalogs');
    }

    public function massAdActions()
    {
        $action = $_POST['action'];
        $ids = $_POST['ad_id'];
        if ($action == self::ACTIVE || $action == self::NOT_ACTIVE) {
            foreach ($ids as $id){
                $ad = new Catalog($id);
                $ad->setActive($action);
                $ad->save();
            }

        }elseif ($action == self::DELETE){
            foreach ($ids as $id){
                $ad = new Catalog($id);
                $ad->delete($action);
            }
        }
        Url::redirect('admin/catalogs');
    }

    public function massUserActions()
    {
        $action = $_POST['action'];
        $ids = $_POST['user_id'];
        if ($action == self::ACTIVE || $action == self::NOT_ACTIVE) {
            foreach ($ids as $id){
                $ad = new User($id);
                $ad->setActive($action);
                $ad->save();
            }

        }elseif ($action == self::DELETE){
            foreach ($ids as $id){
                $ad = new User($id);
                $ad->delete();
            }
        }
        Url::redirect('admin/users');
    }
}