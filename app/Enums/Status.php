<?php

namespace App\Enums;

use ReflectionClass;

enum Status: string {
    case Espera = 'waiting';
    case Pendiente = 'pending';
    case Confirmado = 'confirmed';
    case Cancelado = 'canceled';

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