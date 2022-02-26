<html>
    <head>
        <title><?= $this->data['title']?></title>
        <meta name="description" content="<?= $this->data['meta_description']?>">
        <link rel="stylesheet" href="<?php echo $this->Url('css/styles.css'); ?>">
        <script src="https://kit.fontawesome.com/8e3f90e04f.js" crossorigin="anonymous"></script>
    </head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="<?php echo $this->Url('')?>">
                        <img src="https://dewey.tailorbrands.com/production/brand_version_mockup_image/389/6851750389_56f29e86-7e83-47f7-ae62-5f379660b182.png", height="25">
                    </a>
                </li>
                <li>
                    <a class="menu" href="<?php echo $this->Url('catalog')?>">View all ads</a>
                </li>
                <?php if($this->isUserLoggedIn()): ?>
                    <li>
                        <a class="menu" href="<?php echo $this->Url('ads/add')?>">Add new ad</a>
                    </li>
                    <li>
                        <a class="menu" href="<?php echo $this->Url('user/logout')?>">Logout</a>
                    </li>

                <?php else: ?>
                <li>
                    <a class="menu" href="<?php echo $this->Url('user/login')?>">Login</a>
                </li>
                <li>
                    <a class="menu" href="<?php echo $this->Url('user/register')?>">Sign Up</a>
                </li>
                <?php endif; ?>
                <?php if($this->isUserAdmin()): ?>
                    <li>
                        <a class="menu" href="<?php echo $this->Url('admin/index')?>">ADMIN</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>