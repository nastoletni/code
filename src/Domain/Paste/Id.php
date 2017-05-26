<?php
declare(strict_types=1);

namespace Nastoletni\Code\Domain\Paste;

use Nastoletni\Code\Application\Base10And62Converter;

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
        return new static(Base10And62Converter::base62To10($id));
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
        return Base10And62Converter::base10To62($this->id);
    }
}
