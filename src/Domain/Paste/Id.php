<?php
declare(strict_types=1);

namespace Nastoletni\Code\Domain\Paste;

/**
 * TODO: Split some of the code to Base10And62Converter
 */
class Id
{
    /**
     * @var int
     */
    private $id;

    /**
     * Id constructor.
     *
     * @param int $id
     */
    private function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Creates Id from ordinary, 10 base number [0-9].
     *
     * @param int $id
     * @return Id
     */
    public static function createFromBase10(int $id): Id
    {
        return new static($id);
    }

    /**
     * Creates Id from base 62 number [0-9a-zA-Z].
     *
     * @param string $id
     * @return Id
     */
    public static function createFromBase62(string $id): Id
    {
        return new static(static::base62ToBase10($id));
    }

    /**
     * @return int
     */
    public function getBase10Id(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBase62Id(): string
    {
        return static::base10ToBase62($this->id);
    }

    /**
     * Converts base 62 number [0-9a-zA-Z] to base 10 [0-9].
     * @see https://stackoverflow.com/a/4964352
     *
     * @internal
     *
     * @param string $number
     * @return int
     */
    public static function base62ToBase10(string $number): int
    {
        $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $limit = strlen($number);
        $result = strpos($alphabet, $number[0]);

        for ($i = 1; $i < $limit; $i++) {
            $result = 62 * $result + strpos($alphabet, $number[$i]);
        }

        return $result;
    }

    /**
     * Converts base 10 [0-9] number to base 62 [0-9a-zA-Z].
     * @see https://stackoverflow.com/a/4964352
     *
     * @internal
     *
     * @param int $number
     * @return string
     */
    public static function base10ToBase62(int $number): string
    {
        $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $r = $number  % 62;
        $result = $alphabet[$r];
        $q = floor($number / 62);

        while ($q) {
            $r = $q % 62;
            $q = floor($q / 62);
            $result = $alphabet[$r] . $result;
        }

        return $result;
    }
}