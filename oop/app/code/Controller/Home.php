<?php

declare(strict_types=1);

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Model\Catalog;

class Home extends AbstractController implements ControllerInterface
{
    public function index(): void
    {
        $this->data['populars']= Catalog::getPopularAds(5);
        $this->data['latest']= Catalog::getLatestAds(5);
        $this->render('parts/home');
    }
}
