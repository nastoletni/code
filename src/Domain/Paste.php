<?php

declare(strict_types=1);

namespace Nastoletni\Code\Domain;

use DateTime;

class Paste
{
    /**
     * @var Paste\Id
     */
    private $id;

    /**
     * @var null|string
     */
    private $title;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var File[]
     */
    private $files = [];

    /**
     * Paste constructor.
     *
     * @param Paste\Id    $id
     * @param null|string $title
     * @param DateTime    $createdAt
     */
    public function __construct(Paste\Id $id, ?string $title, DateTime $createdAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->createdAt = $createdAt;
    }

    /**
     * @return Paste\Id
     */
    public function getId(): Paste\Id
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return File[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param File $file
     */
    public function addFile(File $file): void
    {
        $this->files[] = $file;
    }
}
