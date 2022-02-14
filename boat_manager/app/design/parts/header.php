<html>
<head>
    <title>Boat manager</title>
    <link rel="stylesheet" href="<?php echo $this->Url('css/styles.css'); ?>">
</head>
<body>
<header>
    <nav>
        <ul>
            <li>
                <a href="/">Home page</a>
            </li>
            <li>
                <a href="/boat/all">View all boats</a>
            </li>
            <?php if($this->isUserLoggedIn()): ?>
                <li>
                    <a href="/boat/add">Add new boat</a>
                </li>
                <li>
                    <a href="/user/logout">Logout</a>
                </li>

            <?php else: ?>
                <li>
                    <a href="/user/login">Login</a>
                </li>
                <li>
                    <a href="/user/register">Sign Up</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>