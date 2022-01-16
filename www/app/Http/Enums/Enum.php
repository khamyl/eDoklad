<?php

// Supports localization

namespace App\Http\Enums;

class Enum{
    public static function label($typeValue) {
        return isset(static::$typeLabels[$typeValue]) ? trans(static::$typeLabels[$typeValue]) : '';
    }

    public static function labels() {
        return array_map(function ($label) {
            return trans($label);
        }, static::$typeLabels);
    }

    public static function values() {
        return array_keys(static::$typeLabels);
    }
}