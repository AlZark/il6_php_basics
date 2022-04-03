<?php

namespace Controller;

use Model\Catalog;
use Model\Manufacturer;
use Model\Model;
use Model\Type;
use Core\AbstractController;
use Helper\Url;
use Helper\CsvParser;

class Import extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->isUserLoggedIn()) {
            Url::redirect('user/login');
        }
    }

    public function execute(): void
    {
        $csvPath = PROJECT_ROOT_DIR . "/var/Import/import.csv";
        $adsArray = CsvParser::parseCsv($csvPath);
        if ($adsArray !== FALSE) {
            foreach ($adsArray as $element) {
                $catalog = new Catalog();
                $manufacturer = Manufacturer::getManufacturerIdByName($element['manufacturer']);
                $model = Model::getModelIdByName($element['model'], (int)$manufacturer);
                $type = Type::getTypeIdByName($element['type']);
                $slug = Url::generateSlug($element['title']);
                while (!Catalog::isValueUnique('slug', $slug)) {
                    $slug .= rand(0, 99);
                }
                $date = Date("Y-m-d H:i:s");

                $catalog->setTitle($element['title']);
                $catalog->setDescription($element['description']);
                $catalog->setManufacturerId((int)$manufacturer);
                $catalog->setModelId((int)$model);
                $catalog->setPrice($element['price']);
                $catalog->setYear($element['year']);
                $catalog->setTypeId((int)$type);
                $catalog->setImg($element['img']);
                $catalog->setVin($element['vin']);
                $catalog->setMileage((int)$element['mileage']);
                $catalog->setColor($element['color']);
                $catalog->setUserId((int)$_SESSION['user_id']);
                $catalog->setActive(1);
                $catalog->setSlug($slug);
                $catalog->setCreatedAt((string)$date);
                $catalog->setViews(0);
                $catalog->save();
            }
            $_SESSION['success'] = "Ads imported successfully";
        } else {
            $_SESSION['fail'] = "Import file is empty";
        }
        unlink('../app/code/Import/import.csv');
        Url::redirect('catalog/my');
    }
}
