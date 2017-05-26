<?php
declare(strict_types=1);

namespace Nastoletni\Code\Domain;

use Nastoletni\Code\Domain\Paste\NotExistsException;

interface PasteRepository
{
    /**
     * Returns a Paste with given id.
     *
     * @param Paste\Id $id
     * @return Paste
     * @throws NotExistsException when there is no paste with given id.
     */
    public function getById(Paste\Id $id): Paste;

    /**
     * Saves given Paste.
     *
     * @param Paste $paste
     * @throws Paste\AlreadyExistsException when Paste's id already exists.
     */
    public function save(Paste $paste): void;
}
