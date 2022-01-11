<?php
include 'helper.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$user_name = $_POST['user_name'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$agree_terms = $_POST['agree_terms'];

$email = clearEmail($email);
$user_name = trim($user_name);

if (registrationValidation($first_name, $last_name, $email, $user_name, $password1, $password2, $agree_terms) === true) {
    $data = [];
    $data[] = [$first_name, $last_name, $email, hashPassword($password1), isUsernameUnique($user_name), $agree_terms];
    writeToCsv($data, 'users.csv');
}

