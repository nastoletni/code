<?php

declare(strict_types=1);

namespace Nastoletni\Code\Application\Generator;

use Nastoletni\Code\Domain\Paste;

class RandomIdGenerator
{
    /**
     * Returns cryptographically unique Id consisting of five digits.
     *
     * @return Paste\Id
     */
    public static function nextId(): Paste\Id
    {
        //                                           10000     ZZZZZ
        return Paste\Id::createFromBase10(random_int(14776336, 916132831));
    }
}
