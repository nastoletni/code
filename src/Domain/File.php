<?php

declare(strict_types=1);

namespace Nastoletni\Code\Domain;

class File
{
    /**
     * @var null|string
     */
    private $filename;

    /**
     * @var string
     */
    private $content;

    /**
     * File constructor.
     *
     * @param null|string $filename
     * @param string      $content
     */
    public function __construct(?string $filename, string $content)
    {
        $this->filename = $filename;
        $this->content = $content;
    }

    /**
     * @return null|string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param null|string $filename
     */
    public function setFilename($filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
