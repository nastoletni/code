<?php

declare(strict_types=1);

namespace Nastoletni\Code\Domain;

class Xkcd
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @var string
     */
    private $alternateText;

    /**
     * Xkcd constructor.
     *
     * @param string $url
     * @param string $imageUrl
     * @param string $alternateText
     */
    public function __construct(string $url, string $imageUrl, string $alternateText)
    {
        $this->url = $url;
        $this->imageUrl = $imageUrl;
        $this->alternateText = $alternateText;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @return string
     */
    public function getAlternateText(): string
    {
        return $this->alternateText;
    }
}
