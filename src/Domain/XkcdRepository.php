<?php

declare(strict_types=1);

namespace Nastoletni\Code\Domain;

interface XkcdRepository
{
    /**
     * Returns random Xkcd comic.
     *
     * @return Xkcd
     */
    public function getRandom(): Xkcd;
}
