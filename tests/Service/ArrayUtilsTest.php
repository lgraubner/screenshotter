<?php

namespace App\Tests\Service;

use App\Service\ArrayUtils;
use PHPUnit\Framework\TestCase;

class ArrayUtilsTest extends TestCase
{
    /**
     * @dataProvider getSamples
     */
    public function testPick($expected, $input): void
    {
        $arrayUtils = new ArrayUtils();

        $result = $arrayUtils->pick(['a' => 1, 'b' => 2, 'c' => 3], $input);

        $this->assertEquals($expected, $result);
    }

    public function getSamples()
    {
        return [
            'simple' => [['a' => 1], ['a']],
            'everything' => [['a' => 1, 'b' => 2, 'c' => 3], ['a', 'b', 'c']],
            'changed order' => [['a' => 1, 'c' => 3], ['c', 'a']],
            'non existing key' => [[], ['invalid']],
            'non existing key and existing key' => [['b' => 2], ['b', 'invalid']],
            'empty allow list' => [[], []],
        ];
    }
}
