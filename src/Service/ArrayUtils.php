<?php

namespace App\Service;

class ArrayUtils
{
    public function pick(array $arr, array $allowed): array
    {
        return array_intersect_key($arr, array_flip($allowed));
    }
}
