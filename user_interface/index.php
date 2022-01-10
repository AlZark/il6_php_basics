<html>
<head>
    <title>My title</title>
</head>
<body>
<h2>Prisijungtu forma</h2>
<form action="user_interface/login.php" method="post">
    <input type="email" name="email" placeholder="email@email.com">
    <input type="password" name="password" placeholder="**********">
    <input type="submit" value="Prisijungti" name="submit">
</form>
<hr>
<div class="content">
    <h2>Registracijos forma</h2>
    <form action="user_interface/registration.php" method="post">
        <input type="text" name="first_name" placeholder="Vardas"><br>
        <input type="text" name="last_name" placeholder="Pavarde"><br>
        <input type="email" name="email" placeholder="email@email.com"><br>
        <input type="password" name="password1" placeholder="**********"><br>
        <input type="password" name="password2" placeholder="**********"><br>
        <input type="checkbox" name="agree_terms" id="agree_terms">
        <label for="agree_terms">Sutinku su registracijos taisyklemis</label><br>
        <input type="submit" value="Registracija" name="submit">
    </form>
</div>

</body>
</html>