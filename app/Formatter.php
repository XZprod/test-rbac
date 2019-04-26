<?php
namespace App;
class Formatter {
    public static function phone($phone)
    {
        return '+7 (' . mb_substr($phone, 0, 3) . ') ' . mb_substr($phone, 3, 3) .
            '-'.mb_substr($phone, 6, 2) . '-'.mb_substr($phone, 8, 2);
    }

    public static function time($timestamp)
    {
        return date('H:i', $timestamp);
    }

    public static function string($str)
    {
        return htmlspecialchars($str);
    }
    public static function int($str)
    {
        return (int) $str;
    }
}