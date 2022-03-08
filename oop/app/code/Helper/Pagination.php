<?php

namespace Helper;

class Pagination
{

    public static function pagination(int $total, int $limit = 5, $page = null): array
    {

        $page = $page === null ? 1 : $page;
        $offset = ($page - 1) * $limit;
        $totalPages = ceil($total / $limit);

        $data = [
            'allPages' => $totalPages,
            'offset' => $offset,
            'page' => $page
        ];

        return $data;
    }

}