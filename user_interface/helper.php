<?php

const EMAIL_FIELD_KEY = 2;
const NICKNAME_FIELD_KEY = 3;
const PASSWORD_FIELD_KEY = 4;

function clearEmail($email)
{
    return trim(strtolower($email));
}

function isEmailValid($email)
{
    return strpos($email, '@') !== false;
}

function isValueUnique($value, $key)
{
    $users = readFromCsv('users.csv');
    foreach ($users as $user) {
        if ($user[$key] === $value) {
            return false;
        }
    }
    return true;
}

function generateNickName($firstName, $lastName)
{
    return strtolower(substr($firstName, 0, 3) . substr($lastName, 0, 3));
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