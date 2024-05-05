<?php

namespace App\Enums;

use ReflectionClass;

enum Origin: string{
    case Booking = 'booking';
    case Whatsapp = 'whatsapp';
    case Llamada = 'llamada';
    case Facebook = 'facebook';
    case Calle = 'calle';
    case HostalWorld = 'hostalworld';

    public static function getRandomValue()
    {
        $class = new ReflectionClass(self::class);
        $constants = $class->getConstants();
        $ramdonKey = array_rand($constants);

        return $constants[$ramdonKey];
    }

    public static function getArrayValues(): array
    {
        $class = new ReflectionClass(self::class);
        return $class->getConstants();
    }

}