<?php

declare(strict_types=1);

namespace Helper;

class Url
{
    public static function redirect(string $route): void
    {
        header('Location: ' . BASE_URL . $route);
        exit;
    }

    public static function link(string $path, ?string $parm = null): string
    {
        $link = BASE_URL . $path;
        if ($parm !== null) {
            $link .= '/' . $parm;
        }
        return $link;
    }

    public static function generateSlug(string $string): string
    {
        $string = strtolower($string);
        $string = str_replace(' ', '-', $string);
        return $string;
    }
}
