<?php include 'parts/header.php';

$servername = "localhost";
$username = "root";
$password = "89FRJ01+algi";
$dbName = "auto_plus";

try {
    $conn = new PDO("mysql:host=$servername;dbname=" . $dbName, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
    $sql = "SELECT * FROM cities";
    $rez = $conn->query($sql);
    $cities = $rez->fetchAll();


?>

    <form action="create_user.php" method="post">
        <input type="text" name="name" placeholder="Name"><br>
        <input type="text" name="last_name" placeholder="Last Name"><br>
        <input type="email" name="email" placeholder="email@harba.co"><br>
        <input type="tel" name="phone" placeholder="+370"><br>
        <select name="city">
            <?php foreach($cities as $city) {
                echo '<option value="' . $city["id"] . '">' . $city["name"] . '</option>';
            } ?>
        </select><br>
        <input type="password" name="password1" placeholder="********"><br>
        <input type="password" name="password2" placeholder="********"><br>
        <input type="submit" value="Register" name="create">
    </form>
<?php include 'parts/footer.php'; ?>