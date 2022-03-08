<?php

declare(strict_types=1);

namespace Core;

use Helper\Url;
use Model\User;

class AbstractController
{
    protected array $data;

    public function __construct()
    {
        $this->data = [];
        $this->data['title'] = 'CarsCarsCars.com';
        $this->data['meta_description'] = 'CarsCarsCars.com';
    }

    protected function render(string $template): void
    {
        include_once PROJECT_ROOT_DIR . '/app/design/parts/header.php';
        include_once PROJECT_ROOT_DIR . '/app/design/' . $template . '.php';
        include_once PROJECT_ROOT_DIR . '/app/design/parts/footer.php';
    }

    protected function renderAdmin(string $template): void
    {
        include_once PROJECT_ROOT_DIR . '/app/design/admin/parts/header.php';
        include_once PROJECT_ROOT_DIR . '/app/design/admin/' . $template . '.php';
        include_once PROJECT_ROOT_DIR . '/app/design/admin/parts/footer.php';
    }

    protected function isUserLoggedIn(): ?string
    {
        return ($_SESSION['user_id']);
    }

    protected function isUserAdmin(): bool
    {
        if($this->isUserLoggedIn()){
            $user = new User();
            $user->load((int)$_SESSION['user_id']);
            if($user->getRoleId() == 1){
                return true;
            }
        }
        return false;
    }

    public function url(string $path, ?string $param = null): string
    {
        return Url::link($path, $param);
    }

}