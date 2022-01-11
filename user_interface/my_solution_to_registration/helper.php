<?php

function registrationValidation($first_name, $last_name, $email, $user_name, $password1, $password2, $agree_terms)
{
    if (checkRequiredFields($first_name, $last_name, $user_name, $agree_terms) === true) {
        if (isEmailValid($email) === true) {
            if (isEmailUnique($email) === true) {
                if (isPasswordValid($password1, $password2) === true) {
                    return true;
                } else {
                    echo "Invalid password";
                    return false;
                }
            } else {
                echo "Email already in use";
                return false;
            }
        } else {
            echo "Email is not valid";
            return false;
        }
    } else {
        echo "Please make sure that all fields are filled out and that terms are accepted";
        return false;
    }
}

function checkRequiredFields($first_name, $last_name, $user_name, $agree_terms)
{
    return strlen($first_name) > 0 && strlen($last_name) > 0 && strlen($user_name) > 0 && $agree_terms === "accepted";
}

function clearEmail($email)
{
    return trim(strtolower($email));
}

function isEmailValid($email)
{
    return strpos($email, '@') !== false;
}

function isEmailUnique($email)
{
    $unique_email = true;
    $users = readFromCsv('users.csv');
    foreach ($users as $user) {
        if ($email === $user[2]) {
            $unique_email = false;
            break;
        }
    }
    return $unique_email;
}

function isUsernameUnique($user_name)
{
    $users = readFromCsv('users.csv');
    foreach ($users as $user) {
        if ($user_name === $user[4]) {
            $user_name = $user_name . rand(0, 5);
        }
    }
    return $user_name;
}

function isPasswordValid($pass1, $pass2)
{
    return $pass1 === $pass2 && strlen($pass1) > 8;
}

function hashPassword($password)
{
    return md5(md5($password) . 'druska');
}

function writeToCsv($data, $fileName)
{
    $file = fopen($fileName, 'a');
    foreach ($data as $element) {
        fputcsv($file, $element);
    }
    fclose($file);
}

function readFromCsv($fileName)
{
    $data = [];
    $file = fopen($fileName, "r");
    while (!feof($file)) {
        $line = fgetcsv($file);
        if (!empty($line)) {
            $data[] = $line;
        }
    }
    fclose($file);
    return $data;
}

//function debug($data)
//{
//    echo '<pre>';
//    var_dump($data);
//    die();
//}