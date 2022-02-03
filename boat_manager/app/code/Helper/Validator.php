<?php

namespace Helper;

class Validator
{
    public static function isFilledOut($field)
    {
        return !empty($field);
    }

    public static function passMatch($pass, $pass2)
    {
        return $pass === $pass2 && strlen($pass) >= 8;
    }
}