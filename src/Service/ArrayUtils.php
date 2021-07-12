<?php

namespace App\Service;

class ArrayUtils
{
    /**
     * Returns new array with items specified by allow list.
     */
    public function pick(array $arr, array $allowed): array
    {
        return array_filter($arr, function ($key) use ($allowed) {
            return in_array($key, $allowed);
        }, ARRAY_FILTER_USE_KEY);
    }
}
