<html>
<head>
    <title><?= $this->data['title'] ?></title>
    <meta name="description" content="<?= $this->data['meta_description'] ?>">
    <link rel="stylesheet" href="<?= $this->Url('css/styles.css'); ?>">
    <script src="https://kit.fontawesome.com/8e3f90e04f.js" crossorigin="anonymous"></script>
</head>
<body>
<header>
    <nav>
        <ul>
            <li>
                <a href="<?= $this->Url('') ?>">
                    <img src="https://dewey.tailorbrands.com/production/brand_version_mockup_image/389/6851750389_56f29e86-7e83-47f7-ae62-5f379660b182.png"
                         height="25">
                </a>
            </li>
            <li>
                <a class="menu" href="<?= $this->Url('catalog') ?>">View all</a>
            </li>
            <?php if ($this->isUserLoggedIn()): ?>
                <li>
                    <a class="menu" href="<?= $this->Url('catalog/add') ?>">New ad</a>
                </li>
                <li>
                    <a class="menu" href="<?= $this->Url('catalog/my') ?>">My ads</a>
                </li>
                <li>
                    <a class="menu" href="<?= $this->Url('catalog/favoriteList') ?>">Favorites</a>
                </li>
                <li>
                    <a class="menu" href="<?= $this->Url('inbox') ?>">Inbox(<?= $this->data['new_messages'] ?>)</a>
                </li>
                <li>
                    <a class="menu" href="<?= $this->Url('user/logout') ?>">Logout</a>
                </li>

            <?php else: ?>
                <li>
                    <a class="menu" href="<?= $this->Url('user/login') ?>">Login</a>
                </li>
                <li>
                    <a class="menu" href="<?= $this->Url('user/register') ?>">Sign Up</a>
                </li>
            <?php endif; ?>
            <?php if ($this->isUserAdmin()): ?>
                <li>
                    <a class="menu" href="<?= $this->Url('admin/index') ?>">ADMIN</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <?php if ($_SESSION['fail'] != "" || $_SESSION['success']): ?>
        <div class="notification-container">
            <div class="error-notification">
                <h3><?= $_SESSION['fail']; ?></h3>
            </div>
            <div class="success-notification">
                <h3><?= $_SESSION['success']; ?></h3>
            </div>
        </div>
        <?php
        $_SESSION['fail'] = "";
        $_SESSION['success'] = "";
    endif; ?>
</header>