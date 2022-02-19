<?php

namespace Core;

use Helper\Url;

class AbstractController
{
    protected $data;

    public function __construct()
    {
        $this->data = [];
        $this->data['title'] = 'MazasKoteletas.lt';
        $this->data['meta_description'] = 'MazasKoteletas.lt';
    }

    protected function render($template)
    {
        include_once PROJECT_ROOT_DIR . '/app/design/parts/header.php';
        include_once PROJECT_ROOT_DIR . '/app/design/' . $template . '.php';
        include_once PROJECT_ROOT_DIR . '/app/design/parts/footer.php';
    }

    protected function isUserLoggedIn()
    {
        return ($_SESSION['user_id']);
    }

    public function url($path, $param = null)
    {
        return Url::link($path, $param);
    }
}