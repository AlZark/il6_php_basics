<html>
    <head>
        <title>Cars Cars Cars, I'm looking for some good time</title>
        <link rel="stylesheet" href="<?php echo $this->Url('css/styles.css'); ?>">
    </head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="<?php echo $this->Url('catalog/newestAds')?>">Home page</a>
                </li>
                <li>
                    <a href="<?php echo $this->Url('catalog/all')?>">View all ads</a>
                </li>
                <?php if($this->isUserLoggedIn()): ?>
                    <li>
                        <a href="<?php echo $this->Url('catalog/add')?>">Add new ad</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Url('user/logout')?>">Logout</a>
                    </li>

                <?php else: ?>
                <li>
                    <a href="<?php echo $this->Url('user/login')?>">Login</a>
                </li>
                <li>
                    <a href="<?php echo $this->Url('user/register')?>">Sign Up</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>