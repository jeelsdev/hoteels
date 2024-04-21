<?php

namespace App\Enums;

use ReflectionClass;

class RoomType
{
    const S = 'simple';
    const D = 'doble';
    const T = 'triple';
    const M = 'matrimonial';

    public static function getRandomValue()
    {
        $class = new ReflectionClass(self::class);
        $constants = $class->getConstants();
        $ramdonKey = array_rand($constants);

        return $constants[$ramdonKey];
    }
}