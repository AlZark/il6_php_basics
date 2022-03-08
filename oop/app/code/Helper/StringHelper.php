<?php

declare(strict_types=1);

namespace Helper;

class StringHelper
{
    private const RESTRICTED_WORDS = [
        "fuck", "fucking", "shit", "dick", "ass", "corn", "bitch", "cunt", "choad", "wanker", "twat", "pizda", "kurva"
    ];

    public static function censor(string $string): string
    {
        foreach (self::RESTRICTED_WORDS as $word){
            $length = strlen($word);
            $string = trim(str_ireplace($word, str_repeat("*",$length), $string));
        }
        return $string;
    }
}