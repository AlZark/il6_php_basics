<?php
include 'parts/header.php';

$id = $_GET['id'];

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
$sql = "SELECT ads.title, ads.year, ads.description, ads.price, user.name AS user, cities.name AS city, user.phone, user.email FROM ads 
    JOIN user ON ads.user_id = user.id 
    JOIN cities ON user.city_id = cities.id 
    WHERE ads.id = " . $id;
$rez = $conn->query($sql);
$ads = $rez->fetchAll();


echo '<div class="wrapper">';
foreach($ads as $ad) {
    echo '<div class="ad-box">';
    echo '<h3>' . $ad["title"] .'</h3>';
    echo '<p>Price: '. $ad["price"] .'$</p>';
    echo '<p>Year: '. $ad["year"] .'</p>';
    echo '<p>About: '. $ad["description"] .'</p>';
    echo '<p>City: '. $ad["city"] .'</p>';
    echo '<p>Owner: '. $ad["user"] .'</p>';
    echo '<p>Contact phone: '. $ad["phone"] .'</p>';
    echo '<p>Contact email: '. $ad["email"] .'</p>';
    echo '</div>';
}
echo '</div>';
