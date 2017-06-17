<?php

namespace Nastoletni\Code\Domain;

use PHPUnit\Framework\TestCase;

class XkcdTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $xkcd = new Xkcd('url', 'image', 'alternate');

        $this->assertEquals('url', $xkcd->getUrl());
        $this->assertEquals('image', $xkcd->getImageUrl());
        $this->assertEquals('alternate', $xkcd->getAlternateText());
    }
}
