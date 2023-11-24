<?php

namespace App\Domains\Helpers;

use Illuminate\Support\Str;

/**
 * Todo: rename into NumberCodeHelper. Means: Code like CR/SJBS/23/10/020 is called as NumberCode. The last part is called sequence (020)
 */
class NumberCodeHelper
{
    const NUMBER_CODE_FORMAT_START = -4;

    private static $numberCodeSequence;

    public static function extract($numberCode)
    {
        $parts = explode('-', $numberCode);
        static::$numberCodeSequence = end($parts);

        return new self;
    }

    public static function get()
    {
        if (empty(static::$numberCodeSequence)) {
            return '';
        }

        return static::$numberCodeSequence;
    }

    public static function clean()
    {
        if (empty(static::$numberCodeSequence)) {
            return '';
        }

        $numericPart = self::$numberCodeSequence;
        $length = strlen($numericPart);
        $index = 0;
        for (; $index < $length; $index++) {
            if ($numericPart[$index] != '0') {
                break;
            }
        }

        return substr($numericPart, $index);
    }

    public static function getNumberCodeFormat(string $numberCode): string
    {
        return Str::of($numberCode)->substr(0, self::NUMBER_CODE_FORMAT_START);
    }

    public static function nextSequence($numberCode)
    {
        if (is_bool($numberCode) && !$numberCode) {
            return 1;
        }

        // Define the regular expression pattern to capture the components
        $pattern = '/([^\/]+)\/([^\/]+)\/(\d{2})\/(\d{2})\/(\d{3})/';

        // Use preg_match to find the components
        if (preg_match($pattern, $numberCode, $matches)) {
            static::$numberCodeSequence = $matches[5];

            return (int) self::clean() + 1;
        }

        return 0;
    }
}
