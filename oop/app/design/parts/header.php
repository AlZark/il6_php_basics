<html>
    <head>
        <title>Cars Cars Cars, I'm looking for some good time</title>
        <link rel="stylesheet" href="<?php echo BASE_URL.'css/styles.css'; ?>">
    </head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="/">Home page</a>
                </li>
                <li>
                    <a href="/catalog/all">View all ads</a>
                </li>
                <?php if($this->isUserLoggedIn()): ?>
                    <li>
                        <a href="/catalog/add">Add new ad</a>
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