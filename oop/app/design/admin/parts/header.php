<html>
<head>
    <title><?= $this->data['title']?></title>
    <meta name="description" content="<?= $this->data['meta_description']?>">
    <link rel="stylesheet" href="<?php echo $this->Url('/css/admin.css'); ?>">
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
                    <a class="menu" href="<?php echo $this->Url('admin/users')?>">Users</a>
                </li>
                <li>
                    <a class="menu" href="<?php echo $this->Url('admins/ads')?>">Ads</a>
                </li>
                <li>
                    <a class="menu" href="<?php echo $this->Url('user/login')?>">Login</a>
                </li>
                <li>
                    <a class="menu" href="<?php echo $this->Url('user/logout')?>">Logout</a>
                </li>
        </ul>
    </nav>
</header>