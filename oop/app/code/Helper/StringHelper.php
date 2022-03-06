<?php

namespace Helper;

class StringHelper
{
    private const RESTRICTED_WORDS = [
        "fuck", "fucking", "shit", "dick", "ass", "corn", "bitch", "cunt", "choad", "wanker", "twat", "pizda", "kurva"
    ];

    public static function censor($string)
    {
        foreach (self::RESTRICTED_WORDS as $word){
            $length = strlen($word);
            $string = trim(str_ireplace($word, str_repeat("*",$length), $string));
        }
        return $string;
    }
}