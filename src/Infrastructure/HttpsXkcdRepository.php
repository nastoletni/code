<?php

declare(strict_types=1);

namespace Nastoletni\Code\Infrastructure;

use Nastoletni\Code\Domain\Xkcd;
use Nastoletni\Code\Domain\XkcdRepository;

class HttpsXkcdRepository implements XkcdRepository
{
    private const XKCD_URL = 'https://xkcd.com/%d/';
    private const XKCD_JSON_URL = 'https://xkcd.com/%d/info.0.json';

    /**
     * {@inheritdoc}
     */
    public function getRandom(): Xkcd
    {
        // 1851th is the last xkcd's comic available at the time of writing this.
        $number = random_int(1, 1851);

        $response = file_get_contents(sprintf(self::XKCD_JSON_URL, $number));
        $xkcd = json_decode($response, true);

        return new Xkcd(
            sprintf(self::XKCD_URL, $number),
            $xkcd['img'],
            $xkcd['alt']
        );
    }
}
