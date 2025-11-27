<?php

class FormValidator
{
    public static function isRequired($value): bool
    {
        return !empty(trim((string)$value));
    }

    public static function isEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function minLength(string $value, int $min): bool
    {
        return iconv_strlen($value) >= $min;
    }

    public static function maxLength(string $value, int $max): bool
    {
        return iconv_strlen($value) <= $max;
    }
}
