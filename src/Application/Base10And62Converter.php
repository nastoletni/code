<?php
declare(strict_types=1);

namespace Nastoletni\Code\Application;

/**
 * @see https://stackoverflow.com/a/4964352
 */
class Base10And62Converter
{
    private const ALPHABET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Converts base 10 [0-9] number to base 62 [0-9a-zA-Z].
     *
     * @param int $number
     * @return string
     */
    public static function base10To62(int $number): string
    {
        $r = $number  % 62;
        $result = static::ALPHABET[$r];
        $q = floor($number / 62);

        while ($q) {
            $r = $q % 62;
            $q = floor($q / 62);
            $result = static::ALPHABET[$r] . $result;
        }

        return $result;
    }

    /**
     * Converts base 62 number [0-9a-zA-Z] to base 10 [0-9].
     *
     * @param string $number
     * @return int
     */
    public static function base62To10(string $number): int
    {
        $limit = strlen($number);
        $result = strpos(static::ALPHABET, $number[0]);

        for ($i = 1; $i < $limit; $i++) {
            $result = 62 * $result + strpos(static::ALPHABET, $number[$i]);
        }

        return $result;
    }
}