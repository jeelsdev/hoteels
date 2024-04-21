<?php

if (!function_exists('getEnumValues')) {
    function getEnumValues($enum)
    {
        $enum = '\App\Enums\\' . $enum;
        $class = new ReflectionClass($enum);
        return $class->getConstants();
    }
}

if (!function_exists('getEnumValue')) {
    function getEnumValue($enum, $key)
    {
        $enum = '\App\Enums\\' . $enum;
        $class = new ReflectionClass($enum);
        $constants = $class->getConstants();

        return $constants[$key];
    }
}