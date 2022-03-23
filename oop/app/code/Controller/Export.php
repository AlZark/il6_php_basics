<?php

namespace Controller;

use Helper\Url;
use Model\Catalog;
use Core\AbstractController;
use Model\Manufacturer;
use Model\Model;
use Model\Type;

class Export extends AbstractController
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
        $userAds = Catalog::getAllUserAds($_SESSION['user_id']);
        $csvPath = PROJECT_ROOT_DIR."/var/Export/adExport.csv";
        $f = fopen($csvPath, 'w', true);
        if ($f === false) {
            $_SESSION['Fail'] = "Failed to export ads";
            Url::redirect('catalog/my');
        }

        $firstRow = ['title', 'description', 'manufacturer', 'model', 'price', 'year', 'type', 'img', 'vin', 'mileage',
            'color'
        ];
        fputcsv($f, $firstRow);

        foreach ($userAds as $ad) {
            $manufacturer = new Manufacturer();
            $manufacturer->load($ad->getManufacturerId());
            $manufacturerName = $manufacturer->getName();

            $model = new Model();
            $model->load($ad->getModelId());
            $modelName = $model->getName();

            $type = new Type();
            $type->load($ad->getTypeId());
            $typeName = $type->getName();

            $row = [
                'title' => $ad->getTitle(),
                'description' => $ad->getDescription(),
                'manufacturer' => $manufacturerName,
                'model' => $modelName,
                'price' => $ad->getPrice(),
                'year' => $ad->getYear(),
                'type' => $typeName,
                'img' => $ad->getImg(),
                'vin' => $ad->getVin(),
                'mileage' => $ad->getMileage(),
                'color' => $ad->getColor()
            ];
            fputcsv($f, $row);
        }
        fclose($f);
        $_SESSION['success'] = "Ads exported successfully";
        Url::redirect('catalog/my');
    }
}