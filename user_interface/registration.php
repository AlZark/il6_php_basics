<?php
include 'helper.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$agree_terms = $_POST['agree_terms'];

$email = clearEmail($email);

if (
    isPasswordValid($password1, $password2) &&
    isEmailValid($email) &&
    isValueUnique($email, EMAIL_FIELD_KEY) &&
    isset($_POST['agree_terms'])
)
{
    $nick = generateNickName($first_name, $last_name);
    while (!isValueUnique($nick, NICKNAME_FIELD_KEY)) {
        $nick = $nick . rand(0, 100);
    }
    $data = [];
    $password1 = hashPassword($password1);

    $data[] = [$first_name, $last_name, $email, $nick, $password1];
    writeToCsv($data, 'users.csv');
} else {
    echo 'Patikrinkite duomenis ir bandykite dar karta.';
}