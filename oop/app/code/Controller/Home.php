<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Model\Catalog;

class Home extends AbstractController implements ControllerInterface
{
    public function index()
    {
        $this->data['populars']= Catalog::getPopularAds(5);
        $this->data['latest']= Catalog::getLatestAds(5);
        $this->render('parts/home');
    }
}
