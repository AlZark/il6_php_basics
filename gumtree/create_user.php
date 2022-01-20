<?php

include 'helper.php';

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

if (isset($_POST["create"])) {
    $name = $_POST["name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password1"];
    $password_2 = $_POST["password2"];
    $phone = $_POST["phone"];
    $city = $_POST["city"];

    $email = clearEmail($email);

    if (isEmailValid($email) && isPasswordValid($password, $password_2) && $name > "" && $last_name > "") {

        $sql = 'INSERT INTO user (name, last_name, email, password, phone, city_id, created_at) 
                 VALUES ("' . $name . '", "' . $last_name . '", "' . $email . '", "' . hashPassword($password) . '", 
                 "' . $phone . '","' . $city . '", "' . date("Y-m-d h:m:s") . '")';


        $conn->query($sql);
    } else {
        echo "Incorrect registration details";
    }
}


