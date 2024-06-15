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

        if (array_key_exists($key, $constants)) {
            return $constants[$key];
        }
        foreach ($constants as $constant) {
            if ($constant->value == $key) {
                return $constant->name;
            }
            if($constant->name == $key){
                return $constant->value;
            }
        }
        return null;
    }
}

if (!function_exists('getFormattedDate')) {
    function getFormattedDate($date, $format = 'Y-m-d')
    {
        return date($format, strtotime($date));
    }
}