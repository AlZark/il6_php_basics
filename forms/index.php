<html>
<head>
    <title>My title</title>
</head>
<body>
<div class="header">
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About us</a></li>
        <li><a href="#">Pricing</a></li>
        <li><a href="#">Log in</a></li>
    </ul>
</div>
<div class="content">
    <h1>Our title</h1>
    <p>Registracijos forma</p>
<!--    laukeliai: <br>-->
<!--    Vardas-->
<!--    Pavarde-->
<!--    Emailas-->
<!--    Pass-->
<!--    Repeat-->

    <form action="functions.php" method="post">

        <p>Name:</p>
        <input type="text" name="name">
        <p>Lastname:</p>
        <input type="text" name="lastname">
        <p>Email:</p>
        <input type="text" name="email" placeholder="email@email.com">
        <p>Password:</p>
        <input type="password" name="password">
        <p>Repeat Passwrod:</p>
        <input type="password" name="password2">
        <input type="submit" value="OK" name="submit">
    </form>
</div>

<!--<div class="task">-->
<!--    <h1>Our title</h1>-->
<!--    <p>Lorem ipsum...</p>-->
<!--    <form action="functions.php" method="post">-->
<!--        <input type="number" name="number_a">-->
<!--        <input type="number" name="number_b">-->
<!--        <select name="action" id="action">-->
<!--            <option value="add">Add</option>-->
<!--            <option value="multiply">Multiply</option>-->
<!--            <option value="deduct">Deduct</option>-->
<!--            <option value="divide">Divide</option>-->
<!--        </select>-->
<!--        <input type="submit" value="OK" name="submit">-->
<!--    </form>-->
<!--</div>-->
</body>
</html>

