<?php

namespace Controller;

use Core\AbstractController;
use Model\Catalog;

class Home extends AbstractController
{
    public function index()
    {
        $this->data['populars']= Catalog::getPopularAds(5);
        $this->data['latest']= Catalog::getLatestAds(5);
        $this->render('parts/home');
    }
}
