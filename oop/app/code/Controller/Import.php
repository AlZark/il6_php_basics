<?php

namespace Controller;

use Model\Catalog;
use Model\Manufacturer;
use Model\Model;
use Model\Type;
use Core\AbstractController;
use Helper\Url;

class Import extends AbstractController
{

    public const TITLE = 0;

    public const DESCRIPTION = 1;

    public const MANUFACTURER = 2;

    public const MODEL = 3;

    public const PRICE = 4;

    public const YEAR = 5;

    public const TYPE = 6;

    public const IMG = 7;

    public const VIN = 8;

    public const MILEAGE = 9;

    public const COLOR = 10;

    public function read()
    {
        if (($open = fopen("../app/code/Import/import.csv", "r", true)) !== FALSE) {
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $array[] = $data;
            }
            fclose($open);
        }
        return $array;
    }

    public function execute(): void
    {
        if ($this->isUserLoggedIn()) {
            $date = Date("Y-m-d H:i:s");
            $import = new Import();
            $data = $import->read();
            if ($data[0][0] != NULL) {
                foreach ($data as $element) {
                    $catalog = new Catalog();
                    $catalog->setTitle($element[self::TITLE]);
                    $catalog->setDescription($element[self::DESCRIPTION]);

                    $manufacturer = Manufacturer::getManufacturerIdByName($element[self::MANUFACTURER]);
                    $catalog->setManufacturerId((int)$manufacturer);

                    $model = Model::getModelIdByName($element[self::MODEL], (int)$manufacturer);
                    $catalog->setModelId((int)$model);

                    $catalog->setPrice($element[self::PRICE]);
                    $catalog->setYear($element[self::YEAR]);

                    $type = Type::getTypeIdByName($element[self::TYPE]);
                    $catalog->setTypeId((int)$type);

                    $catalog->setImg($element[self::IMG]);
                    $catalog->setVin($element[self::VIN]);
                    $catalog->setMileage((int)$element[self::MILEAGE]);
                    $catalog->setColor($element[self::COLOR]);
                    $catalog->setUserId((int)$_SESSION['user_id']);
                    $catalog->setActive(1);

                    $slug = Url::generateSlug($element[self::TITLE]);
                    while (!Catalog::isValueUnique('slug', $slug)) {
                        $slug .= rand(0, 99);
                    }
                    $catalog->setSlug($slug);
                    $catalog->setCreatedAt((string)$date);
                    $catalog->setViews(0);
                    $catalog->save();
                }
                $_SESSION['success'] = "Ads imported successfully";
            } else {
                $_SESSION['fail'] = "Import file is empty";
            }
            Url::redirect('catalog/my');
        } else {
            Url::redirect('user/login');
        }
    }
}