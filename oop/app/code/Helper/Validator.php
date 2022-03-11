<?php

declare(strict_types=1);

namespace Helper;

class Validator
{
    public static function checkPassword(string $pass,string $pass2): bool
    {
        return $pass === $pass2;
    }

    public static function checkEmail(string $email): bool
    {
        return strpos($email, '@') !== false;
    }
}