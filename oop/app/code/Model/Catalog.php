<?php

namespace Model;

use Controller\Model;
use Core\AbstractModel;
use Helper\DBHelper;

class Catalog extends AbstractModel
{

    private $title;

    private $description;

    private $manufacturer_id;

    private $model_id;

    private $price;

    private $year;

    private $type_id;

    private $user_id;

    private $img;

    private $is_active;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getManufacturerId()
    {
        return $this->manufacturer_id;
    }

    /**
     * @param mixed $manufacturer_id
     */
    public function setManufacturerId($manufacturer_id)
    {
        $this->manufacturer_id = $manufacturer_id;
    }

    /**
     * @return mixed
     */
    public function getModelId()
    {
        return $this->model_id;
    }

    /**
     * @param mixed $model_id
     */
    public function setModelId($model_id)
    {
        $this->model_id = $model_id;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @param mixed $type_id
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }

    public function save()
    {
        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    private function create()
    {
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturer_id,
            'model_id' => $this->model_id,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->type_id,
            'user_id' => $this->user_id,
            'is_active' => $this->is_active
        ];

        $db = new DBHelper();
        $db->insert('ads', $data)->exec();
    }

    private function update()
    {
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturer_id,
            'model_id' => $this->model_id,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->type_id,
            'user_id' => $this->user_id,
        ];

        $db = new DBHelper();
        $db->update('ads', $data)->where('id', $this->id)->exec();
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from('ads')->where('id', $id)->getOne();
        if(!empty($data)) {
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->description = $data['description'];
            $this->manufacturer_id = $data['manufacturer_id'];
            $this->model_id = $data['model_id'];
            $this->price = $data['price'];
            $this->year = $data['year'];
            $this->type_id = $data['type_id'];
            $this->is_active = $data['is_active'];
            $this->user_id = $data['user_id'];
            $this->img = $data['img'];
        }
        return $this;
    }

    public function getAd($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from('ads')->where('id', $id)->get();
        $ads = [];
        foreach ($data as $element){
            $ad = new Catalog(); // Kreipaimaes v4l nes loadas uzkrauna objekta kiekvienam miestui ir galim naudoti objekto funkcijas
            $ad->load($element['id']);
            $ads[] = $ad;
        }
        return $ads;
    }

    public static function getAllActiveAds()
    {
        $data = new Catalog();
        $ids = $data->isActive('ads');
        $ads = [];

        foreach ($ids as $id){
            $ad = new Catalog();
            $ad->load($id['id']);
            $ads[] = $ad;
        }
        return $ads;
    }

}