<?php
include 'parts/header.php';
include 'helper.php';

$email = clearEmail($_POST['email']);
$userPassword = hashPassword($_POST['password']);

$servername = "localhost";
$username = "root";
$password = "89FRJ01+algi";
$dbName = "auto_plus";
try {
    $conn = new PDO("mysql:host=$servername;dbname=" . $dbName, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$sql = 'SELECT * FROM user WHERE email ="' . $email . '" AND password ="' . $userPassword . '"';

$rez = $conn->query($sql);
$user = $rez->fetchAll();


if (!empty($user)) {
    echo 'Fuk yeah';
} else {
    echo 'Incorrect login details. Please try again';
}