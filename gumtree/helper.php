<?php

function clearEmail($email)
{
    return trim(strtolower($email));
}

function isEmailValid($email)
{
    return strpos($email, '@') !== false;
}

function isPasswordValid($pass1, $pass2)
{
    return $pass1 === $pass2 && strlen($pass1) >= 8;
}

function hashPassword($password)
{
    return md5(md5($password) . 'druska');
}